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
        $events = $this->getEvents();
        $title  = "Dashboard - " . $screen->location;


        $this->layout->head         = View::make('components.head')->with('title', $title);
        $this->layout->navbar       = View::make('components.navbar');
        $this->layout->breadcrumbs   = View::make('components.breadcrumbs');

        $settings = array(
            'location' => $screen->location,
            'name'   => $screen->name,
            'radius'   => $screen->radius
        );
        $this->layout->settings  = View::make('components.screen.settings', $settings);
        $this->layout->weather   = View::make('components.screen.weather');
        $this->layout->albums    = View::make('components.screen.albums');
        $this->layout->tags      = View::make('components.screen.tags');
        $this->layout->list      = View::make('components.screen.list');
    }

    private function getEvents()
    {

        $raw_events = Hub::get();

        foreach ($raw_events as $key => $raw_event) {
            $event               = new Event();
            $event->name         = $this->retrieve_value($raw_event,'http://schema.org/name');
            $event->image        = $this->retrieve_value($raw_event,'http://schema.org/image');
            $event->location     = $this->retrieve_value($raw_event,'http://schema.org/location');
            $event->startDate    = $this->retrieve_value($raw_event,'http://schema.org/startDate');
            $event->endDate      = $this->retrieve_value($raw_event,'http://schema.org/endDate');

            if( $this->is_event($event) ){
                // use 'unique' events based on name
                $eventlist[$event->name] = $event;
            }
        }

        foreach( $eventlist as $key => $value) {
            $events[] = $value;
        }

        return $events;
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