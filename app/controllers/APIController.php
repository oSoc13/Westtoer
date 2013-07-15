<?php

class APIController extends \BaseController {

	protected $layout = 'layouts.api.index';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
    {
        $this->layout->title = 'API';


        /**
         * Building breadcrumbs
         */
        $breadcrumbs = array(
            'bread_title' =>  $this->layout->title,
            'bread_items' => array(
            )
        ); 
        $this->layout->breadcrumbs   = View::make('components.breadcrumbs', $breadcrumbs);
        
    }

}