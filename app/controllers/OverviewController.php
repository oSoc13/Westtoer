<?php

class OverviewController extends \BaseController {


	protected $layout = 'layouts.dashboard.overview';

	/**
	 * 
	 *
	 * @return Response
	 */
	public function getOverview()
	{

		$this->layout->title = 'Overview';


        /**
         * Building breadcrumbs
         */
        $breadcrumbs = array(
            'bread_title' =>  $this->layout->title,
            'bread_items' => array(
                array('name' => 'Dashboard', 'uri' => '/ui' )
            )
        ); 
        $this->layout->breadcrumbs   = View::make('components.breadcrumbs', $breadcrumbs);
        
        /**
         * Building screens
         */

        $screens = Screen::all();

		$this->layout->screens   = View::make('components.overview.screens', array('screens' => $screens));
		$this->layout->newscreen   = View::make('components.overview.newscreen');
	}


    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            
            $this->layout = View::make($this->layout)
                                  ->with('errors', $this->errors)
                                  ->with('alerts', $this->alerts);
        }
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