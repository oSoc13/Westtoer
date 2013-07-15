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
		$this->layout->title = 'Dashboard';


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