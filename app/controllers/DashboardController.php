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
    private $screen;
    private $errors   = array();
    private $alerts   = array();


    public function addError($title, $details){

        $message = array('title'   => $title,
                         'details' => $details);
        
        array_push($this->errors , $message);
    }

    public function addAlert($title, $details){
        $message = array('title'   => $title,
                         'details' => $details);
        
        array_push($this->alerts , $message);
    }

    public function buildDashboard($id)
    {
        $this->screen = Screen::find($id);
        $title  = "Dashboard - " . $this->screen->location;


        $this->layout->head         = View::make('components.head')->with('title', $title);

        $this->layout->navbar       = View::make('components.navbar');

        /**
         * Building breadcrumbs
         */
        $breadcrumbs = array(
            'bread_title' =>  $this->screen->name,
            'bread_items' => array(
                array('name' => 'Username', 'uri' => '/ui'),
                array('name' => 'Screens', 'uri' => '/ui/screen/' . $id )
            )
        ); 
        $this->layout->breadcrumbs   = View::make('components.breadcrumbs', $breadcrumbs);
        
        /**
         * Building messages
         */

        $messages = array(
            'errors' => $this->errors,
            'alerts' => $this->alerts
        );

        $this->layout->messages  = View::make('components.messages', $messages);

        /**
         * Building settings
         */
        $settings = array(
            'screen_id' => $this->screen->id,
            'location' => $this->screen->location,
            'name'     => $this->screen->name,
            'radius'   => $this->screen->radius
        );

        $this->layout->settings  = View::make('components.screen.settings', $settings);

        /**
         * Building weather
         */
        $this->layout->weather   = View::make('components.screen.weather');

        /**
         * Building albums
         */
        $this->layout->albums    = View::make('components.screen.albums');

        /**
         * Building tags
         */
        $this->layout->tags      = View::make('components.screen.tags');
        
        /**
         * Building list
         */

        $win_events  = $this->getEvents('WIN');
        $uitdb_events  = $this->getEvents('UITDB');
        $events = array_merge ($win_events, $uitdb_events);
        $matched_events = $this->matchFilters($events);
        $list = array(
            'screen_id' => $this->screen->id,
            'events'  => $matched_events
        );

        $this->layout->list = View::make('components.screen.list', $list);
    }

    public function postSettings()
    {
        $this->screen = Screen::find(Input::get('screen_id'));
        $this->screen->location = Input::get('location');
        $this->screen->radius = Input::get('radius');
        $this->screen->save();

        $message  = '<ul>';
        $message .= '<li> Location: '. $this->screen->location .'</li>';
        $message .= '<li> Radius: '. $this->screen->radius .'</li>';
        $message .= '<ul>';
        $this->addAlert('Screen settings saved', $message);


        $this->buildDashboard($screen->id);
    }

    private function matchFilters($events){
        $filters = $this->screen->filters();
        $matched_events = array();
        foreach ($events as $key => $event) {
            $found = false;
            foreach ($filters as $key => $filter) {
                if($event->name == $filter->item_id){
                    //$event->score = $filter->score;
                    $found = true;
                    break; // yes @pietercolpaert, it's a break!
                }
            }
            if(!$found){
                /* create all dem stuff
                   for testing purposes only.

                $filter = new EventFilter(
                    array( 'item_id' => $event->name,
                           'screen_id' => $this->screen->id,
                           'score' => 0
                    )
                );

                $filter->save();
                $event->score = $filter->score;
            
                */
                $event->score = 0;
            }
            array_push($matched_events, $event);
        }
        return $matched_events;
    }


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
            Cache::section('origin')->put('events_parsed', $events, 60);

            return $events;
        }
        return $events;
    }

}