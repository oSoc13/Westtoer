<?php

class EventController extends \BaseController {

    private $ttl = 1800;
    private $screen;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
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
        $this->screen = Screen::find($id);

        $events = $this->sortList($this->getList());


        return $events;
    }

    private function sortList($events){

        usort($events, function($a, $b)
            {
                if ($a->score == $b->score)
                {
                    return 0;
                }
                else if ($a->score > $b->score)
                {
                    return -1;
                }
                else {              
                    return 1;
                }
            }
        );


        return $events;
    }

    private function getList(){
        //TODO: remove providers, only one getEvent needed.
        $win_events     = $this->getEvents('WIN');
        $uitdb_events   = $this->getEvents('UITDB');
        $events         = array_merge($win_events, $uitdb_events);
        $matched_events = $this->matchFilters($events);
        Cache::section('matched_events')->put($this->screen->id, $matched_events, 60);
        return $matched_events;
    }

    //TODO: remove provider when datahub is completed
    private function getEvents($provider = 'WIN', $limit = -1) // UITDB or WIN
    {
        if ($events = Cache::section('origin')->get('events_parsed'))
        {
            return $events;
        } 
        else
        {
            $raw_events = Hub::get($provider."/Events.json");

            $events = EventParser::getEvents($raw_events);
            Cache::section('origin')->put('events_parsed', $events, $this->ttl);

            return $events;
        }
    }


    private function matchFilters($events){
        $filters = $this->screen->filters();
        $matched_events;

        // for each event, find corresponding filter.
        foreach ($events as $key => $event) {
            $found = false;
            if($filter = $this->screen->filters()->where('item_id', $event->name)->first()){
                $event->score = $filter->score;
            } else {
                $event->score =0;
            }
            if($event->score > -1){
                $matched_events[$event->name] = $event;
            }
        }
        return $matched_events;
    }

}