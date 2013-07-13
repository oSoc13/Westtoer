<?php

class WeatherController extends \BaseController {

    private $ttl = 1800;
    private $screen;


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $this->screen = Screen::find($id);
        if ($weather = Cache::section('screen_weather')->get($id))
        {
            return $weather;
        } 
        else
        {
            $weather = $this->screen->weather()->get();
            $parsed_weather = array();
            foreach ($weather as $key => $item) {
                $latlong = $item->lat . ',' . $item->long;
                $parsed_item = WeatherHub::get($item->lat,$item->long);
                array_push($parsed_weather, $parsed_item);
            }

            Cache::section('screen_weather')->put($id, $parsed_weather, 60);
            return $parsed_weather;
        }
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