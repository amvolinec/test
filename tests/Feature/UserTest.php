<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Helpers\Weather;


class UserTest extends TestCase
{

    // Test is working router
    public function testBasicTest()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    // Test is valid API key
    public function testOpenWeatherKey()
    {
        $client = new \GuzzleHttp\Client();
        $request = $client->get('http://api.openweathermap.org/data/2.5/weather?q=Vilnius&APPID=e6b56f52a5dc6a80de1c43b5b957b5b5');
        $this->assertEquals(200, $request->getStatusCode());
    }

    //  Test is working Helper
    public function testHelper(){
        $json = json_encode(array('name' => 'Vilnius'));
        $weather = new Weather($json);
        $main = $weather->parseRequest();
        $this->assertEquals($main['name'], 'Vilnius');
    }

    // Test is Json Answer converted to Array successfully
    public function testJsonAnswer(){
        $client = new \GuzzleHttp\Client();
        $request = $client->get('http://api.openweathermap.org/data/2.5/weather?q=Vilnius&APPID=e6b56f52a5dc6a80de1c43b5b957b5b5');
        $json = $request->getBody();
        $weather = new Weather($json);
        $main = $weather->parseRequest();
        $this->assertEquals($main['name'], 'Vilnius');
        $this->assertTrue(isset($main['speed']));
        $this->assertTrue(isset($main['temp']));
        $this->assertTrue(isset($main['temp_min']));
        $this->assertTrue(isset($main['temp_max']));
        $this->assertTrue(isset($main['all']));
        $this->assertTrue(isset($main['country']));
        $this->assertTrue(isset($main['humidity']));
    }

}
