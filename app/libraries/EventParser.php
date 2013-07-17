<?php

/**
 * EventParser - for Laravel Framework
 *
 * @author Ah-Lun Tang (tang@ahlun.be)
 * @copyright 2013 by OKFN Belgium
 *
 */
class EventParser {

    public static function getEvents($raw_events) {

        foreach ($raw_events as $key => $raw_event) {
            $event                  = new Event();
            $event->name            = EventParser::retrieve_value($raw_event,'http://schema.org/name');
            $event->name            = str_replace("/","-",$event->name);
            $event->image           = EventParser::retrieve_value($raw_event,'http://schema.org/image');
            $event->lat             = EventParser::retrieve_value($raw_event,'http://www.w3.org/2003/01/geo/wgs84_pos#lat');
            $event->lon             = EventParser::retrieve_value($raw_event,'http://www.w3.org/2003/01/geo/wgs84_pos#lon');
            $event->location        = EventParser::retrieve_value($raw_event,'http://schema.org/location');
            $type                   = EventParser::retrieve_value($raw_event,'http://www.w3.org/1999/02/22-rdf-syntax-ns#type');
            $event->type            = ($type == "http://schema.org/TouristAttraction") ? "attraction" : "event"; 
            $event->startDate       = EventParser::retrieve_value($raw_event,'http://schema.org/startDate');
            $event->endDate         = EventParser::retrieve_value($raw_event,'http://schema.org/endDate');
            $event->startTime       = EventParser::retrieve_value($raw_event,'http://westtoer.be/voc/startTime');
            $event->endTime         = EventParser::retrieve_value($raw_event,'http://westtoer.be/voc/endTime');
            $event->addressLocality = EventParser::retrieve_value($raw_event,'http://schema.org/addressLocality');;

            if( EventParser::is_valid($event) ){
                // use 'unique' events based on name
                $eventlist[$event->name] = $event;
            }
        }

        // foreach( $eventlist as $key => $value) {
        //     $events[] = $value;
        // }
        
        return $eventlist;
    }


    private static function retrieve_value($array, $key) {
        /* Checks if value is set and returns the value, if value is not set, return null.
         * @param array
         * @param key
         * @return value if set, null if not set.
         */

        return isset($array[$key]) ? $array[$key][0]['value'] : null;
    }

    private static function is_valid($event){

        $base_values = ( isset($event->name) &&
                         isset($event->lat) &&
                         isset($event->lon) &&
                         isset($event->location)
                       );
        if ($event->type == "attraction"){
            return $base_values;
                   
        } else { // assume event, we need at least a date.
            return $base_values && isset($event->startDate);
        }
        /*
        // if event has no values, returns false to drop it. 
        // Allowed number of null values can be set through base_score.
        $base_score = -3; 
        $score = 0;
        foreach ($event as $key => $value) {
            if( $value == null )
                $score--;
        }
        return $score >= $base_score;*/
    }
}