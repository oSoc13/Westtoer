<?php

class APIController extends \BaseController {

	protected $layout = 'layouts.api.index';

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
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
    {
        $title = 'API';
        $this->layout->head         = View::make('components.head')->with('title', $title);

        $this->layout->navbar       = View::make('components.navbar');

        /**
         * Building breadcrumbs
         */
        $breadcrumbs = array(
            'bread_title' =>  $title,
            'bread_items' => array(
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
    }

}