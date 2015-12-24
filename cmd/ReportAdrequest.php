<?php
	error_reporting('E_ALL');
	ini_set('display_errors', 1);

	//Get argv
	$date = isset($argv[1]) ? $argv[1] : '';
	if(!$date){
		die("Please input date!");
	}
	$hour = isset($argv[2]) ? $argv[2] : -1;

	// Configuration
	$dbHostMongo = 'localhost';
	$dbNameMongo = 'yomedia';
	$dbCollectionMongo = 'trackings_adrequest';
	$dbHostMysql = 'localhost';
	$dbUserMysql = 'root';
	$dbPassMysql = '';
	$dbNameMysql = 'pl_yo_v1';
	$dbTableMysql = 'pt_tracking_adrequest';

	try {
		$mongo = new Mongo("mongodb://$dbHostMongo");
	} catch (Exception $ex) {
		die('Cannot connect to Mongo!');
	}

	$db = $mongo->selectDB($dbNameMongo);
	$collection = $db->selectCollection($dbCollectionMongo);
	if ($hour >= 0){
		$cursor = $collection->find(array('created_h' => $date . ' ' .$hour));
	}else{
		$cursor = $collection->find(array('created_d' => $date));
	}	
	$aResults = array();
	foreach ($cursor as $adrequest) { 
		if ($adrequest['wid'] && $adrequest['zid']){
			$key = $adrequest['wid'] . $adrequest['zid'] . $adrequest['created_h'];
			if (!isset($aResults[$key]['count'])){
				$aResults[$key]['count'] = 0;
			}
			$aResults[$key]['wid'] = $adrequest['wid'];
			$aResults[$key]['zid'] = $adrequest['zid'];
			$aResults[$key]['count'] += $adrequest['count'];
			$aResults[$key]['created_d'] = $adrequest['created_d'];
			$aResults[$key]['created_h'] = intval(substr($adrequest['created_h'], -2));
		}
	}

	// Connect to Mysql
	try {
		$conn = mysql_connect($dbHostMysql, $dbUserMysql, $dbPassMysql);
	} catch (Exception $ex) {
		die('Cannot connect to Mysql!');
	}	
	mysql_select_db($dbNameMysql, $conn);
	foreach ($aResults as $value) {
		if (!mysql_ping($conn)) {
		    $conn = mysql_connect($dbHostMysql, $dbUserMysql, $dbPassMysql);
			mysql_select_db($dbNameMysql, $conn);
		}
		$sql = 'REPLACE INTO ' .$dbTableMysql. 
			   '(`website_id`, `publisher_ad_zone_id`, `hour`, `date`, `count`) VALUES ' .
			   '(' .$value['wid']. ', ' .$value['zid']. ', "' .$value['created_h']. '", "' .$value['created_d']. '", ' .$value['count']. ');';
		mysql_query($sql, $conn);
	}
	mysql_close($conn);
	echo "Done";
?>