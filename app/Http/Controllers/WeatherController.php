<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\BadResponseException;
use App\Helpers\Weather;

class WeatherController extends Controller
{

    public function ajaxRequestPost(Request $request)
    {
        $input = $request->all();
        if (!$this->validateInputs($input)) {

            // Send error message if fields (field) empty
            return response()->json(['success' => false, 'result' => 'Please fill all fields!']);
        } else {

            // Send answer from API request
            return response()->json($this->sendRequest($input));
        }
    }

    private function sendRequest($input)
    {
        // Make client for API request
        $client = new \GuzzleHttp\Client();

        // Create URI
        $uri = sprintf("http://api.openweathermap.org/data/2.5/weather?q=%s&APPID=%s", $input['city'], $input['apikey']);

        // Try to get answer
        try {
            $request = $client->get($uri);

            $weather = new Weather($request->getBody());
            $result = $weather->parseRequest();
            return array('success' => true, 'result' => $result);
        }
        // If error get error message
        catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = \GuzzleHttp\json_decode($response->getBody()->getContents());
            return array('success' => false, 'result' => $responseBodyAsString->message);
        }
    }

    // Validate empty or not inputs
    private function validateInputs($input)
    {
        foreach ($input AS $key => $value) {
            if (empty($value)) return false;
        }
        return true;
    }


}
