<?php

class WeatherController extends \BaseController {

    private $screen;


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $this->screen = Screen::find($id);
        if ($weather = Cache::section('screen_weather')->get($id))
        {
            return $weather;
        } 
        else
        {
            $weather = $this->screen->weather()->get();
            $parsed_weather = array();
            foreach ($weather as $key => $item) {
                $latlong = $item->lat . ',' . $item->long;
                $parsed_item = WeatherHub::get($item->lat,$item->long);
                $parsed_item = $parsed_item['hourly_forecast'];
                $parsed_weather[$item->location] = $parsed_item['hourly_forecast'];
                //array_push($parsed_weather, $parsed_item);
            }

            Cache::section('screen_weather')->put($id, $parsed_weather, 60);
            return $parsed_weather;
        }
    }

}