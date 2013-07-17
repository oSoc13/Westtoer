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

    public function buildWithMessage($id, $title, $message) {
        $this->addAlert($title,$message);
        $this->buildDashboard($id);
    }

    public function buildDashboard($id) {
        $this->setScreen($id);
        
        $this->layout->title  = "Dashboard - " . $this->screen->location;


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
        $weather_items = $this->screen->weather()->get();
        $weather = array(
            'screen_id' => $this->screen->id,
            'locations' => $weather_items
        );
        $this->layout->weather   = View::make('components.screen.weather', $weather);

        /**
         * Building albums
         */

        $albums = array(
            'screen_id' => $this->screen->id
        );
        $this->layout->albums    = View::make('components.screen.albums', $albums);

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

    private function setScreen($screen_id) {
        try {
            $this->screen = Screen::findOrFail($screen_id);
        } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $message = 'Screen not found!';
            App::abort(404, $message);
        }
    }

    public function postSettings() {
        $this->setScreen(Input::get('screen_id'));

        // Validate input.
        $validated = true;

        $validate_location = Validator::make(
            array('location' => Input::get('location')),
            array('location' => array('required', 'min:2'))
        );
        if($validate_location->fails()){
            $validated = false;
            $this->addError('Location not correct.', 'Should be at least 2 characters.');
        } else {
            $this->screen->location = Input::get('location');
        }


        $validate_radius = Validator::make(
            array('radius' => Input::get('radius')),
            array('radius' => array('required', 'between:1,50', 'numeric'))
        );
        if($validate_radius->fails()){
            $validated = false;
            $this->addError('Radius not correct.', 'Should be between 1 km and 50 km.');    
        } else {
            $this->screen->radius = Input::get('radius');
        }

        if($validated) {
            try {
                // save screen.
                $this->screen->save();

                $message  = 'Screen settings changed to '. $this->screen->location . ' ';
                $message .= 'with radius '. $this->screen->radius .'.';
                $this->addAlert('Screen settings saved.', $message);
            } catch (Exception $e) {
                $this->addError('Could not save screen settings.', 'Check your input, if this problem persists, contact Westtoer.');
            } 
        }

        $this->buildDashboard($this->screen->id);
    }

    public function addWeather($screen_id) {

        $this->setScreen($screen_id);

        $location = Input::get('weather_location');


        $geocoder = new \Geocoder\Geocoder();
        $adapter  = new \Geocoder\HttpAdapter\GuzzleHttpAdapter();
        $chain    = new \Geocoder\Provider\OpenStreetMapsProvider($adapter);
        $geocoder->registerProvider($chain);

        $weather = null;

        // retrieve the geolocation.
        $latlon = LocationParser::getGeocode($location);
        $lat = $latlon['lat'];
        $lon = $latlon['lon'];
        if (isset($lat) && isset($lon)){
            $weather = new Weather(
                array( 'screen_id' => $this->screen->id,
                       'location' => $location,
                       'lat' => $lat,
                       'long' => $lon)
            );
        } else {
            $this->addError('Weather location not added! Could not retrieve geolocation for '. $location, 'Please check the location name.');
        }

        // if $weather is still null, the geo retriever failed to retrieve the location
        if($weather) {
            try {
                $weather->save();

                $message  = 'Location '. $location;
                $message .= ' ('. $lat.','. $lon .') added to weather locations.';

                $this->addAlert('Weather location added.',$message);

            } catch (Exception $e) {
                $this->addError('Weather location not added!', 'Are you trying to add the same location twice?');
            }
        }

        $this->buildDashboard($this->screen->id);

    }


    public function removeWeather($screen_id, $weather_id) {
        $this->setScreen($screen_id);
        try {
            $item = Weather::findOrFail($weather_id);
            if($screen_id == $item->screen_id){
                $item->delete();

                $this->addAlert('Weather location removed.','');
            } else {
                $this->addError('Wrong screen.', 'This weather item does not belong to the given screen.');
            }
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $this->addError('Weather location does not exist.', 'Trying to delete something that does not exist huh?');
        } catch (Exception $e) {
            $this->addError('Weather location could not be deleted', 'Please try again. If this problem persists, contact Westtoer.');
        }

        $this->buildDashboard($screen_id);

    }

    private function getList() {
        if (! $matched_events = Cache::section('matched_events')->get($this->screen->id)){
            $events         = $this->getEvents();
            $matched_events = $this->matchFilters($events);
            Cache::section('matched_events')->put($this->screen->id, $matched_events, $this->ttl);
        }
        return $matched_events;
    }

    private function matchFilters($events) {
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

    private function setScore($screen_id, $event_name, $score) {
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
        Cache::section('matched_events')->put($screen_id, $matched_events, $this->ttl);
        $message = $event_name . ' is now ';
        switch ($score) {
            case -1:
                $message .= 'excluded from this screen.';
                break;
            case -0.5:
                $message .= 'marked as less important for this screen.';
                break;
            case 1:
                $message .= 'marked as important for this screen.';
                break;
        }
        $title = $event_name.' modified!';
        $alert = array('title' => $title, 'message' => $message);
        $this->addAlert($title, $message);
        $this->buildDashboard($screen_id);
    }

    private function getEvents() {
        if ($events = Cache::section('origin')->get('events_parsed')) {
            return $events;
        } 
        else {
            $raw_events = Hub::get();

            $events = EventParser::getEvents($raw_events);
            Cache::section('origin')->put('events_parsed', $events, $this->ttl);

            return $events;
        }
    }

    public function thumbsUp($screen_id, $event_name) {
        $this->setScore($screen_id, $event_name, 1);
    }
    public function thumbsDown($screen_id, $event_name) {
        $this->setScore($screen_id, $event_name, -0.5);
    }
    public function remove($screen_id, $event_name) {
        $this->setScore($screen_id, $event_name, -1);
    }

}