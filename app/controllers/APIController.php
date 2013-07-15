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
        
    }

}