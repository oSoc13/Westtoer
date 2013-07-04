<?php


/* 
 * Temporary placeholder code to fetch the json from The DataTank.
 * Fetches json from The DataTank
 * Decodes json do array.
 * Only uses first 5 elements.
 */

chdir("../");
require_once 'fetcher.php';

# loading configuration
require_once 'configuration.php';
$config = Configuration::getconfig();

header('Content-Type: application/json');


$fetcher = new Fetcher($config['westtoer']['uri'], $config['westtoer']['user'], $config['westtoer']['pass']);

$events = $fetcher->get('/WIN/Events.json?limit=10000');


//$events = array_slice($events, 1, 10);

// END placeholder code


/* 
 * Parsing the JSON to usable event array.
 * 
 */



function retrieve_value($array, $key){
    /* Checks if value is set and returns the value, if value is not set, return null.
     * @param array
     * @param key
     * @return value if set, null if not set.
     */

    return isset($array[$key]) ? $array[$key][0]['value'] : null;
}

function is_event($event){
    // if event has no values, returns false to drop it. 
    // Allowed number of null values can be set through base_score.
    $base_score = 0; 
    $score = 0;
    foreach ($event as $key => $value) {
        if( $value == null )
            $score--;
    }
    return $score > $base_score;
}

foreach ($events as $event_id => $event){
    $semantic_event = new stdClass();

    $semantic_event->name         = retrieve_value($event,'http://schema.org/name');
    $semantic_event->description  = retrieve_value($event,'http://westtoer.be/voc/extra_info');
    $semantic_event->image        = retrieve_value($event,'http://schema.org/image');
    $semantic_event->location     = retrieve_value($event,'http://schema.org/location');
    $semantic_event->startDate    = retrieve_value($event,'http://schema.org/startDate');
    $semantic_event->endDate      = retrieve_value($event,'http://schema.org/endDate');

    if( is_event($semantic_event) ){
        // save new object to the eventlist
        //$eventlist[] = $semantic_event;

        // use 'unique' events based on name
        $eventlist[$semantic_event->name] = $semantic_event;
    }
}



// END parse code.

foreach( $eventlist as $key => $value) {
    $result[] = $value;
}
$output = json_encode($result, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $output;
