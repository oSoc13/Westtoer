<?php

class EventController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$raw_events = Hub::get();


		// foreach ($raw_events as $key => $raw_event) {
		// 	$event = new Event();
		// 	$event->name 		 = $raw_event['http://schema.org/name'][0]['value'];
		//     $event->image        = $raw_event['http://schema.org/image'][0]['value'];
		//     $event->location     = $raw_event['http://schema.org/location'][0]['value'];
		//     $event->startDate    = $raw_event['http://schema.org/startDate'][0]['value'];
		//     $event->endDate      = $raw_event['http://schema.org/endDate'][0]['value'];
		// 	$events[] = $event;
		// }

		foreach ($raw_events as $key => $raw_event) {
			$event 				 = new Event();
			$event->name         = $this->retrieve_value($raw_event,'http://schema.org/name');
		    $event->image        = $this->retrieve_value($raw_event,'http://schema.org/image');
		    $event->location     = $this->retrieve_value($raw_event,'http://schema.org/location');
		    $event->startDate    = $this->retrieve_value($raw_event,'http://schema.org/startDate');
		    $event->endDate      = $this->retrieve_value($raw_event,'http://schema.org/endDate');

		    if( $this->is_event($event) ){
		        // use 'unique' events based on name
		        $eventlist[$event->name] = $event;
		    }
		}

		foreach( $eventlist as $key => $value) {
		    $events[] = $value;
		}

		return $events;
	}

	private function retrieve_value($array, $key){
	    /* Checks if value is set and returns the value, if value is not set, return null.
	     * @param array
	     * @param key
	     * @return value if set, null if not set.
	     */

	    return isset($array[$key]) ? $array[$key][0]['value'] : null;
	}

	private  function is_event($event){
	    // if event has no values, returns false to drop it. 
	    // Allowed number of null values can be set through base_score.
	    $base_score = 0; 
	    $score = 0;
	    foreach ($event as $key => $value) {
	        if( $value == null )
	            $score--;
	    }
	    return $score >= $base_score;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

}