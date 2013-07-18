<?php 
/**
 * Weather - for Laravel Framework
 *
 * @author Ah-Lun Tang (tang@ahlun.be)
 * @copyright 2013 by OKFN Belgium
 *
 */

use Guzzle\Http\Client;

class WeatherHub {
    /**
     * Retrieves weather info from Weather Underground, caches where possible.
     * requires API key (set in config.)
     * 
     * @param latitude
     * @param longitude
     * 
     * @return info as json.
     */
    public static function get($latitude, $longitude)
    { 
        $latlong = $latitude . ',' . $longitude;
        $api_key   = Config::get('weather.api_key');
        $cache_ttl   = Config::get('weather.cache_ttl');
        if ($weatherinfo = Cache::section('weather')->get($latlong))
        {
            return $weatherinfo;
        }
        else
        {
            $base_url = 'http://api.wunderground.com';
            $call_url = '/api/'
                        . $api_key 
                        .'/hourly/q/'
                        . $latlong 
                        .'.json';

            $client = new Client($base_url);

            $raw_weather = $client->get($call_url)->send();

            if($raw_weather->isSuccessful() && $raw_weather)
            {
                //$weather = json_decode($raw_weather->json());
                //$weather = $raw_weather['hourly_forecast'];
                //$weather = json_encode($weather);
                Cache::section('weather')->put($latlong, $raw_weather->json(), $cache_ttl);
                return $raw_weather->json();
            }
        }

    }

}