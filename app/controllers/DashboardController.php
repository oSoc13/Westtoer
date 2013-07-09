<?php

class DashboardController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Default Dashboard Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |   Route::get('/', 'DashboardController@showHome');
    |
    */

    protected $layout = 'layouts.dashboard.home';

    public function showHome($id)
    {
        $screen = Screen::find($id);
        $title  = "Dashboard - " . $screen->location;


        $this->layout->head         = View::make('components.head')->with('title', $title);

        $this->layout->navbar       = View::make('components.navbar');

        /**
         * Building breadcrumbs
         */
        $breadcrumbs = array(
            'bread_title' =>  $screen->name,
            'bread_items' => array(
                array('name' => 'Username', 'uri' => '/ui'),
                array('name' => 'Screens', 'uri' => '/ui/screen/' . $id )
            )
        ); 
        $this->layout->breadcrumbs   = View::make('components.breadcrumbs', $breadcrumbs);
        
        /**
         * Building settings
         */
        $settings = array(
            'location' => $screen->location,
            'name'     => $screen->name,
            'radius'   => $screen->radius
        );
        $this->layout->settings  = View::make('components.screen.settings', $settings);
        
        $this->layout->weather   = View::make('components.screen.weather');
        $this->layout->albums    = View::make('components.screen.albums');
        $this->layout->tags      = View::make('components.screen.tags');
        
        /**
         * Building list
         */

        $events  = $this->getEvents();
        $filters = $this->getFilters($screen);

        $list = array(
            'events'  => $events,
            'filters' => $filters
        );

        //die('<pre>'.json_encode($list).'</pre>');

        $this->layout->list      = View::make('components.screen.list', $list);
    }

    private function getFilters($screen){
        $filters = EventFilter::find($screen);
        return $filters;
    }

    private function getEvents($resource = 'WIN/Events.json', $limit = -1)
    {

        if ($events = Cache::section('hub')->get($resource.'_parsed'))
        {
            return $events;
        } 
        else
        {
            $raw_events = Hub::get();

            foreach ($raw_events as $key => $raw_event) {
                $event               = new Event();
                $event->identifier   = $this->retrieve_value($raw_event,'http://purl.org/dc/terms/identifier');
                $event->name         = $this->retrieve_value($raw_event,'http://schema.org/name');
                $event->image        = $this->retrieve_value($raw_event,'http://schema.org/image');
                $event->location     = $this->retrieve_value($raw_event,'http://schema.org/location');
                $event->startDate    = $this->retrieve_value($raw_event,'http://schema.org/startDate');
                $event->endDate      = $this->retrieve_value($raw_event,'http://schema.org/endDate');
                

                // Check cache first for reverse geo
                if ($place = Cache::section('geo')->get($event->location))
                {
                    $event->place = $place;
                }
                else
                {
                    $location = explode('/', $event->location);
                    $geo = explode(',', array_pop($location));
                    
                    $adapter  = new \Geocoder\HttpAdapter\GuzzleHttpAdapter();
                    $geocoder = new \Geocoder\Geocoder();
                    $geocoder->registerProviders(array(
                         new \Geocoder\Provider\OpenStreetMapsProvider($adapter)
                     ));
                    
                    $geo_result = $geocoder->reverse($geo[0], $geo[1]);

                    $formatter = new \Geocoder\Formatter\Formatter($geo_result);
                    $event->place = $formatter->format('%S %n, %z %L');


                    // Cache reverse geo forever
                    Cache::section('geo')->forever($event->location, $event->place);
                }


                if( $this->is_event($event) ){
                    // use 'unique' events based on name
                    $eventlist[$event->name] = $event;
                }
            }

            foreach( $eventlist as $key => $value) {
                $events[] = $value;
            }

            Cache::section('hub')->put($resource.'_parsed', $events, 5);

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

}