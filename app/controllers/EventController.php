<?php

class EventController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // http://westtoer.be/voc/provider
        $provider = "UITDB"; // "WIN";

        if ($events = Cache::section('hub')->get($provider .'events_parsed'))
        {
            return $events;
        } else
        {
            $raw_events = Hub::get($provider."/Events.json");

            foreach ($raw_events as $key => $raw_event) {
                $event               = new Event();
                //$event->identifier = $this->retrieve_value($raw_event,'http://purl.org/dc/terms/identifier');
                $event->name         = $this->retrieve_value($raw_event,'http://schema.org/name');
                $event->image        = $this->retrieve_value($raw_event,'http://schema.org/image');
                $event->location     = $this->retrieve_value($raw_event,'http://schema.org/location');
                $event->startDate    = $this->retrieve_value($raw_event,'http://schema.org/startDate');
                $event->endDate      = $this->retrieve_value($raw_event,'http://schema.org/endDate');
                $event->provider     = $provider; // http://westtoer.be/voc/provider
                $event->addressLocality = " ";

                // Check cache first for reverse geo
                // http://schema.org/addressLocality -> include in datahub?

                // $location = explode('/', $event->location);
                // $location = array_pop($location);
                // if ($addressLocality = Cache::section('geo')->get($location))
                // {
                //     $event->addressLocality = $addressLocality;
                // } else
                // {
                //     $geo = explode(',', $location);
                    
                //     $adapter  = new \Geocoder\HttpAdapter\GuzzleHttpAdapter();
                //     $geocoder = new \Geocoder\Geocoder();
                //     $geocoder->registerProviders(array(
                //          new \Geocoder\Provider\OpenStreetMapsProvider($adapter)
                //      ));

                //     try {
                //      $geo_result = $geocoder->reverse($geo[0], $geo[1]);
                //      $formatter = new \Geocoder\Formatter\Formatter($geo_result);
                //      $event->addressLocality = $formatter->format('%S %n, %z %L');
                   //      // Cache reverse geo forever
                   //      Cache::section('geo')->forever($location, $event->addressLocality);
                //     } catch (Exception $e) {
                //      $event->addressLocality = " ";
                //     }
                    
                // }
                if( $this->is_event($event) ){
                    // use 'unique' events based on name
                    $eventlist[$event->name] = $event;
                }
            }

            foreach( $eventlist as $key => $value) {
                $events[] = $value;
            }

            Cache::section('hub')->put($provider . 'events_parsed', $events, 60*15);

            return $events;
        }
    }

    private function retrieve_value($array, $key){
        /* Checks if value is set and returns the value, if value is not set, return null.
         * @param array
         * @param key
         * @return value if set, null if not set.
         */

        return isset($array[$key]) ? $array[$key][0]['value'] : null;
    }

    private  function is_event($event){
        // if event has no values, returns false to drop it. 
        // Allowed number of null values can be set through base_score.
        $base_score = 0; 
        $score = 0;
        foreach ($event as $key => $value) {
            if( $value == null )
                $score--;
        }
        return $score >= $base_score;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

}