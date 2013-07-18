<?php 

return array(
	'base_url' => 'https://datahub.dev/', // location of the datahub server
	'resource' => 'query/events.json', // resource on the server that contains the items
	'user' => 'username', // username for datahub
	'password' => 'password', // password for datahub
	'interval' => 2, // interval in days
    'lat_min' => 50, // max area to retrieve data from.
	'lat_max' => 54, // latitude
	'lon_min' => 2,  // longitude
	'lon_max' => 4,  // 
	'limit' => 500, // default limit of items to retrieve
	'cache_ttl' => 60*60 // set cache time to live
);