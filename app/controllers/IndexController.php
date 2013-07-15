<?php

class IndexController extends \BaseController {

	protected $layout = 'layouts.dashboard.index';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$title = 'Dashboard';
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