<?php 
/**
 * Hub - for Laravel Framework
 *
 * @author Ah-Lun Tang (tang@ahlun.be)
 * @copyright 2013 by OKFN Belgium
 *
 */

use Guzzle\Http\Client;

class Hub {
    /**
     * Retrieves info from the datahub, caches where possible.
     * 
     * @param limit amount of triplets to fetch. Use -1 for no limit.
     * @param resource location of info to fetch.
     * 
     * @return info as json.
     */
    public static function get($resource = 'WIN/Events.json', $limit = -1)
    { 
        $base_url   = Config::get('hub.base_url');
        $user       = Config::get('hub.user');
        $password   = Config::get('hub.password');
        $cache_ttl  = Config::get('hub.cache_ttl');

        if ($events = Cache::section('hub')->get($resource))
        {
            return $events;
        }
        else
        {
            $call_url = $resource . '?limit=' . $limit;

            $client = new Client($base_url);

            $events = $client->get($call_url)->setAuth($user, $password)->send();

            if($events->isSuccessful() && $events)
            {
                Cache::section('hub')->put($resource, $events->json(), $cache_ttl);
                return $events->json();
            }
        }

        return null;

    }

}