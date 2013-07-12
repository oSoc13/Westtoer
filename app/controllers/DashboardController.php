<?php

class DashboardController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Default Dashboard Controller
    |--------------------------------------------------------------------------
    |
    */

    protected $layout = 'layouts.dashboard.home';

    private $ttl = 1800;
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

    public function buildWithMessage($id, $title, $message){
        $this->addAlert($title,$message);
        $this->buildDashboard($id);
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
                array('name' => 'Dashboard', 'uri' => '/ui'),
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

        $matched_events = $this->getList();

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

    private function getList(){
        //TODO: remove providers, only one getEvent needed.
        $win_events     = $this->getEvents('WIN');
        $uitdb_events   = $this->getEvents('UITDB');
        $events         = array_merge($win_events, $uitdb_events);
        $matched_events = $this->matchFilters($events);
        Cache::section('matched_events')->put($this->screen->id, $matched_events, 60);
        return $matched_events;
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
            $matched_events[$event->name] = $event;
        }
        return $matched_events;
    }

    private function setScore($screen_id, $event_name, $score){
        $event_name = urldecode($event_name);
        if (! $matched_events = Cache::section('matched_events')->get($screen_id))
        {
            $matched_events = $this->getList();
        }
        $event = $matched_events[$event_name];
        $event->score = $score;

        $this->screen = Screen::find($screen_id);
        if($filter = $this->screen->filters()->where('item_id', $event_name)->first()){
            $filter->score = $score;
            $filter->save();
        } else {
            $filter = new ItemFilter(
                    array( 'item_id' => $event_name,
                           'screen_id' => $screen_id,
                           'score' => $score
                    )
                );
             $filter->save();
        }
        Cache::section('matched_events')->put($screen_id, $matched_events, 60);
        $message = '<strong>' . $event_name . '</strong> is now ';
        switch ($score) {
            case -1:
                $message .= 'excluded from this screen';
                break;
            case -0.5:
                $message .= 'marked as less important for this screen';
                break;
            case 1:
                $message .= 'marked as important for this screen';
                break;
        }
        $title = $event_name.' modified!';
        $alert = array('title' => $title, 'message' => $message);
        $this->addAlert($title, $message);
        $this->buildDashboard($screen_id);
        //return Redirect::to('screen');
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

    public function thumbsUp($screen_id, $event_name)
    {
        $this->setScore($screen_id, $event_name, 1);
    }
    public function thumbsDown($screen_id, $event_name)
    {
        $this->setScore($screen_id, $event_name, -0.5);
    }
    public function remove($screen_id, $event_name)
    {
        $this->setScore($screen_id, $event_name, -1);
    }

}