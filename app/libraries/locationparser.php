<?php 
/**
 * Wrapper for geocoder - for Laravel Framework
 *
 * @author Ah-Lun Tang (tang@ahlun.be)
 * @copyright 2013 by OKFN Belgium
 *
 */

class LocationParser {
    /**
     * Sets all options for geocoder. Catches exception and returns empty value.
     * 
     * @param limit amount of triplets to fetch. Use -1 for no limit.
     * @param resource location of info to fetch.
     * 
     * @return info as json.
     */

    public static function createGeocoder(){

        $geocoder = new \Geocoder\Geocoder();
        $adapter  = new \Geocoder\HttpAdapter\GuzzleHttpAdapter();
        $chain    = new \Geocoder\Provider\OpenStreetMapsProvider($adapter);
        $geocoder->registerProvider($chain);
        return $geocoder;

    }

    public static function getGeocode($location){
        if ($result = Cache::section('geocodes')->get($location)){
            return $result;
        } else {
            $geocoder= LocationParser::createGeocoder();
            try {
                $geocode = $geocoder->geocode($location);
                $lat     = $geocode->getLatitude();
                $lon     = $geocode->getLongitude();
                $result  = array('lat' => $lat, 'lon' => $lon);
                Cache::section('geocodes')->forever($location, $result);
            } catch (Exception $e) {
                $lat = null;
                $lon = null;
            }
            return array('lat' => $lat, 'lon' => $lon);
        }
    }


    public static function getLocation($lat, $lon){
        $latlon = $lat. ',' . $lon;
        if ($result = Cache::section('location')->get($latlon)){
            return $result;
        } else {
            $geocoder= LocationParser::createGeocoder();
            try {
                $result = $geocoder->reverse($lat, $lon);

                // $result is an instance of ResultInterface
                $formatter = new \Geocoder\Formatter\Formatter($result);

                $location = $formatter->format('%S %n %L');
                Cache::section('locations')->forever($latlon, $location);
            } catch (Exception $e) {
                $location = '';
            }
            return $location;
        }
    }
}