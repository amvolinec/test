<?php namespace App\Helpers;

use \RecursiveIteratorIterator;
use \RecursiveArrayIterator;

class Weather
{
    private $json;
    private $main;

    function __construct($json)
    {
        $this->json = $json;
    }

//    Parse Answer To Simple Array
    public function parseRequest()
    {
        $jsonIterator = new RecursiveIteratorIterator(
            new RecursiveArrayIterator(json_decode($this->json, TRUE)),
            RecursiveIteratorIterator::SELF_FIRST);

        foreach ($jsonIterator as $key => $val) {
            if (!is_array($val))
                $this->main[$key] = $val;
        }

        $this->removeSpaces();
        $this->kalvinToCelsius('temp');
        $this->kalvinToCelsius('temp_min');
        $this->kalvinToCelsius('temp_max');

        return $this->main;
    }

    // Make valid Id (slug)
    private function removeSpaces()
    {
        if (isset($this->main['name'])){
            $this->main['slug'] = preg_replace('/[^a-zA-Z0-9\']/', '_', $this->main['name']);
            $this->main['slug'] = str_replace("'", '', $this->main['slug']);
        }
    }

    // Convert Kalvin To Celsius
    private function kalvinToCelsius($key)
    {
        if (!isset($this->main[$key]))
            return false;

        if (is_string($this->main[$key]))
            $this->main[$key] = floatval($this->main[$key]);

        $this->main[$key] = round(($this->main[$key] - 273.15));

    }
}