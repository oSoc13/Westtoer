<?php

class BaseController extends Controller {

	
	protected $errors = array();
	protected $alerts = array();

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */

    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
        	$messages = array(
        		'errors', $this->errors,
        		'alerts', $this->alerts
        		);
            $this->layout = View::make($this->layout, $messages);
        }
    }


    public function addError($title, $details){

        $message = array('title'   => $title,
                         'details' => $details);
        
        array_push($this->errors , $message);

        $this->layout->errors = $this->errors;

    }

    public function addAlert($title, $details){
        $message = array('title'   => $title,
                         'details' => $details);
        
        array_push($this->alerts , $message);

        $this->layout->alerts = $this->alerts;

    }


}