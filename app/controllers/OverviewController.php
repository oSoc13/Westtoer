<?php

class OverviewController extends \BaseController {


	protected $layout = 'layouts.dashboard.overview';
	private $errors = array();
	private $alerts = array();



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

	/**
	 * 
	 *
	 * @return Response
	 */
	public function getOverview()
	{

		$title = 'Overview';
        $this->layout->head         = View::make('components.head')->with('title', $title);

        $this->layout->navbar       = View::make('components.navbar');

        /**
         * Building breadcrumbs
         */
        $breadcrumbs = array(
            'bread_title' =>  $title,
            'bread_items' => array(
                array('name' => 'Dashboard', 'uri' => '/ui' )
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
         * Building screens
         */

        $screens = Screen::all();

		$this->layout->screens   = View::make('components.overview.screens', array('screens' => $screens));
		$this->layout->newscreen   = View::make('components.overview.newscreen');
	}

	public function createScreen(){


        try {

            $name = Input::get('name');
            $location = Input::get('location');
            $radius = Input::get('radius');
            if ( strlen($name) === 0 ){
                throw new Exception('No name entered.');
            }

            $geocoder = new \Geocoder\Geocoder();
            $adapter  = new \Geocoder\HttpAdapter\GuzzleHttpAdapter();
            $chain    = new \Geocoder\Provider\OpenStreetMapsProvider($adapter);
            $geocoder->registerProvider($chain);

		    $geocode = $geocoder->geocode($location);
	        $screen = new Screen(array(
	        	'name' => $name,
	        	'location' => $location,
	        	'radius' => $radius,
	        	'lat' => $geocode->getLatitude(),
	        	'long' => $geocode->getLongitude()
	        ));
	        $screen->save();

	        $message  = '<ul>';
	        $message .= '<li> Name: '. $screen->name .'</li>';
	        $message .= '<li> Location: '. $screen->location .'<small>('. $screen->lat.','. $screen->long .')</small></li>';
	        $message .= '<li> Radius: '. $screen->radius .'</li>';
	        $message .= '<ul>';

			$this->addAlert('Screen created',$message);
		} catch (Exception $e) {
			$this->addError('Could not create screen '. $location,$e->getMessage());
		}


		$this->getOverview();
	}


}