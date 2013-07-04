<?php
/*
 * Fetcher
 * @author: Ah-Lun Tang (tang@ahlun.be)
 * @license: AGPLv3
 */

# loading vendor components
require_once 'vendor/autoload.php';

use Doctrine\Common\Cache\ArrayCache;
use Guzzle\Http\Client;
use Guzzle\Cache\DoctrineCacheAdapter;
use Guzzle\Plugin\Cache\CachePlugin;


date_default_timezone_set('UTC');

class Fetcher {

    private $client;
    private $user;
    private $pass;

    function __construct($uri, $user, $pass) {
        $this->client = new Client($uri, array( 'params.cache.override_ttl' => 3600,
                                                'params.cache.revalidate'   => 'skip'
                                               ));
        # add caching object.
        $this->client->addSubscriber(new CachePlugin(new DoctrineCacheAdapter(new ArrayCache()), true));
        $this->user = $user;
        $this->pass = $pass;
    }

    function get($resource){
        # get request object
        $request = $this->client->get($resource)->setAuth($this->user, $this->pass);

        # get response
        $response = $request->send();

        return json_decode($response->getBody(),true);
    }

    
}
