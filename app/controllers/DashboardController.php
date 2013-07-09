<?php

class DashboardController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Default Dashboard Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |   Route::get('/', 'DashboardController@showHome');
    |
    */

    protected $layout = 'layouts.dashboard.home';

    public function showHome()
    {
        $this->layout->head         = View::make('components.head')->with('title', 'my first title');
        $this->layout->navbar       = View::make('components.navbar');
        $this->layout->breadcrumbs   = View::make('components.breadcrumbs');

        $this->layout->settings  = View::make('components.screen.settings');
        $this->layout->weather   = View::make('components.screen.weather');
        $this->layout->albums    = View::make('components.screen.albums');
        $this->layout->tags      = View::make('components.screen.tags');
        $this->layout->list      = View::make('components.screen.list');
    }

}