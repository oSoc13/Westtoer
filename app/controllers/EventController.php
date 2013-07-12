<?php

class EventController extends \BaseController {

    private $ttl = 1800;
    private $screen;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {
        $this->screen = Screen::find($id);

        // http://westtoer.be/voc/provider
        // TODO: remove $provider -> in hub settings set mixed feed.
        $provider = "UITDB"; // "WIN";

        if ($events = Cache::section('parsed')->get('events_parsed'))
        {
            return $events; //array_slice($events , 0, 10);
        } else
        {
            $raw_events = Hub::get($provider."/Events.json");

            $events = EventParser::getEvents($raw_events);

            Cache::section('parsed')->put('events_parsed', $events, 60);

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