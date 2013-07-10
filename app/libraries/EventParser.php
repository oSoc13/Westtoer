<?php

/**
 * EventParser - for Laravel Framework
 *
 * @author Ah-Lun Tang (tang@ahlun.be)
 * @copyright 2013 by OKFN Belgium
 *
 */
class EventParser {

    public static function getEvents($raw_events)
    {

        foreach ($raw_events as $key => $raw_event) {
            $event                  = new Event();
            $event->name            = EventParser::retrieve_value($raw_event,'http://schema.org/name');
            $event->image           = EventParser::retrieve_value($raw_event,'http://schema.org/image');
            $event->location        = EventParser::retrieve_value($raw_event,'http://schema.org/location');
            $event->startDate       = EventParser::retrieve_value($raw_event,'http://schema.org/startDate');
            $event->endDate         = EventParser::retrieve_value($raw_event,'http://schema.org/endDate');
            $event->startTime       = EventParser::retrieve_value($raw_event,'http://westtoer.be/voc/startTime');
            $event->endTime         = EventParser::retrieve_value($raw_event,'http://westtoer.be/voc/endTime');
            $event->addressLocality = EventParser::retrieve_value($raw_event,'http://schema.org/addressLocality');;

            if( EventParser::is_event($event) ){
                // use 'unique' events based on name
                $eventlist[$event->name] = $event;
            }
        }

        foreach( $eventlist as $key => $value) {
            $events[] = $value;
        }
        
        return $events;
    }


    private static function retrieve_value($array, $key){
        /* Checks if value is set and returns the value, if value is not set, return null.
         * @param array
         * @param key
         * @return value if set, null if not set.
         */

        return isset($array[$key]) ? $array[$key][0]['value'] : null;
    }

    private static function is_event($event){
        // if event has no values, returns false to drop it. 
        // Allowed number of null values can be set through base_score.
        $base_score = -3; 
        $score = 0;
        foreach ($event as $key => $value) {
            if( $value == null )
                $score--;
        }
        return $score >= $base_score;
    }
}