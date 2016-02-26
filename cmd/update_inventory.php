<?php
	error_reporting('E_ALL');
	ini_set('display_errors', 1);



	// Configuration
	$dbHostMongo = 'localhost';
	$dbHostMongoOld = 'localhost';
	$dbNameMongo = 'yomedia';
	$dbCollectionMongo = 'trackings_summary';

	$redisHost = '127.0.0.1';
	$redisPort = '6379';

	try {
		$mongo = new Mongo("mongodb://$dbHostMongo");
		$mongoOld = new Mongo("mongodb://$dbHostMongoOld");
	} catch (Exception $ex) {
		die('Cannot connect to Mongo!');
	}

	$db = $mongo->selectDB($dbNameMongo);
	$collection = $db->selectCollection($dbCollectionMongo);
	$dbOld = $mongoOld->selectDB($dbNameMongo);
	$collectionOld = $dbOld->selectCollection($dbCollectionMongo);

	$redis = new Redis();
    $redis->connect($redisHost, $redisPort);

    $flights = $redis->hgetall('Flight');

    if (!empty($flights)) {
    	foreach ($flights as $flight) {
    		$flight = json_decode($flight);
        	$inventory = getInventoryFromDBOld($flight->id, $flight->event, $collection, $collectionOld);
        	$cacheKey = "Flight_Inventory_{$flight->id}_{$flight->event}";
        	$redis->setex($cacheKey, 15768000, $inventory);
        	echo "{$redis->get($cacheKey)}\n";
        }
    }

    echo "Done!\n";
	
	function getInventoryFromDBOld($fid, $event, $collection, $collectionOld) {

        if ($fid) {
            $where['f'] = intval($fid);
        }
        
        $rs = $collection->find($where);
        $rs_old = $collectionOld->find($where);
        
        $inventory = 0;
        $inventoryOvr = 0;
        foreach ($rs as $val) {
            if (isset($val[$event])) {
                if ('ovr' === substr($val['_id'], -3)) {
                    $inventoryOvr += $val[$event];
                } else {                    
                    $inventory += $val[$event];
                }
            }
        }

        foreach ($rs_old as $val) {
            if (isset($val[$event])) {
                if ('ovr' === substr($val['_id'], -3)) {
                    $inventoryOvr += $val[$event];
                } else {                    
                    $inventory += $val[$event];
                }
            }
        }
        
        return $inventory;
    }
?>