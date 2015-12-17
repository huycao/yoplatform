<?php
//Cache
define('REDIS_HOST', '172.28.29.247');
define('REDIS_PORT', 6380);
define('REDIS_PORT_1', 6381);
define('REDIS_PORT_2', 6382);
//Mysql
define('DB_HOST', '127.0.0.1');
define('DB_PORT', 3306);
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'yomedia');


$type = isset($argv[1]) ? $argv[1] : '';

if (!empty($type)) {
    $rs = getData($type);
    echo "Done: " . count($rs) . "\n\n";
} else {
    $arrType = array('Campaign', 'Flight', 'Adzone', 'Ad', 'PublisherAlternateAd', 'FlightDate',
                 'PublisherSite', 'PublisherAdZone', 'Category', 'AdFormat', 'FlightWebsite',
                 'Conversion');
    
    foreach ($arrType as $type) {
        $rs = getData($type);
        echo "Done: " . count($rs) . "\n\n";
    }
}

function getData($type) {
    echo "Cache for: " . $type . "\n";
    //Connect Mysql
    $servername = DB_HOST . ":" . DB_PORT;
    $username = DB_USERNAME;
    $password = DB_PASSWORD;
    $dbname = DB_NAME;
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = '';
    $arrResult = array();
    $cacheKey = '';
    switch($type) {
        case 'Campaign':
            $cacheKey = 'Campaign';
            $current_date = date('Y-m-d');
            $sql = <<<EOF
                    SELECT id,name,advertiser_id,category_id
                    FROM pt_campaign
                    WHERE '$current_date' >= start_date
                    AND '$current_date' <= end_date
EOF;
            break;
        case 'Flight':
            // Get nhung flight dang trong thoi gian chay dang chay
            $current_date = date('Y-m-d');
            $sql = <<<EOF
                    SELECT f.id, f.name, f.ad_id, f.ad_format_id, f.campaign_id, f.start_hour, f.end_hour,
    				f.frequency_cap, f.frequency_cap_time, f.campaign_retargeting, f.age, f.sex, f.country,
    				f.province, f.total_inventory, f.value_added, f.cost_type, f.event, f.is_fix_inventory,
    				f.day, f.status, f.retargeting_url, f.retargeting_show, f.retargeting_number, f.category_id, f.audience, f.filter
                    FROM pt_campaign c, pt_flight f
                    WHERE  c.id = f.campaign_id
                    AND '$current_date' >= c.start_date
                    AND '$current_date' <= c.end_date
                    AND f.status = 1
EOF;
            break;
        case 'Adzone':
            $sql = <<<EOF
                    SELECT id,publisher_site_id,ad_format_id,alternatead,width,height,alternateadtype,alternatead,element_id
                    FROM pt_publisher_ad_zone
                    ORDER BY id ASC
EOF;
            break;
        case 'Ad':
            // Get nhung flight dang trong thoi gian chay dang chay
            $current_date = date('Y-m-d');
            $sql = <<<EOF
                    SELECT c.*
                    FROM pt_campaign a, pt_flight b, pt_ad c
                    WHERE  a.id = b.campaign_id
                    AND b.ad_id = c.id
                    AND b.status = 1
                    AND '$current_date' >= a.start_date
                    AND '$current_date' <= a.end_date
EOF;
            break;
        case 'PublisherAlternateAd':
            $sql = <<<EOF
                    SELECT publisher_ad_zone_id, code, weight
                    FROM pt_publisher_alternate_ad
                    ORDER BY publisher_ad_zone_id ASC
EOF;
            break;
        case 'FlightDate':
            $current_date = date('Y-m-d');
            $sql = <<<EOF
                    SELECT c.flight_id, c.start, c.end, c.diff, c.hour, c.frequency_cap, c.frequency_cap_time, c.daily_inventory
                    FROM pt_campaign a, pt_flight b, pt_flight_date c
                    WHERE  a.id = b.campaign_id
                    AND b.id = c.flight_id
                    AND b.status = 1
                    AND '$current_date' >= a.start_date
                    AND '$current_date' <= a.end_date
                    ORDER BY c.flight_id, c.start ASC
EOF;
            break;
        case 'PublisherSite':
            $sql = <<<EOF
                    SELECT id,url,domain_checking
                    FROM pt_publisher_site
                    ORDER BY id ASC
EOF;
            break;
        case 'PublisherAdZone':
            $sql = <<<EOF
                    SELECT id,publisher_site_id,ad_format_id,alternatead,width,height,alternateadtype,alternatead
                    FROM pt_publisher_ad_zone
                    ORDER BY id ASC
EOF;
            break;
        case 'Category':
            $sql = <<<EOF
                    SELECT id, name
                    FROM pt_category
                    WHERE status = 1
                    ORDER BY id ASC
EOF;
            break;
        case 'AdFormat':
            $sql = <<<EOF
                    SELECT id, name
                    FROM pt_ad_format
                    ORDER BY id ASC
EOF;
            break;
        case 'FlightWebsite':
            $current_date = date('Y-m-d');
            $sql = <<<EOF
                    SELECT d.id,d.platform,d.flight_id,
    					d.website_id,d.total_inventory,d.value_added,
    					d.status,d.publisher_base_cost,b.ad_format_id,
    			        b.retargeting_url,b.retargeting_show,b.retargeting_number,a.advertiser_id,b.ad_id
                    FROM pt_campaign a, pt_flight b, pt_ad c, pt_flight_website d
                    WHERE  a.id = b.campaign_id
                    AND b.ad_id = c.id
                    AND b.id = d.flight_id
                    AND b.status = 1
                    AND d.status = 1
                    AND '$current_date' >= a.start_date
                    AND '$current_date' <= a.end_date
                    ORDER BY a.id, b.id, d.id ASC
EOF;
            break;
        case 'Conversion':
            $current_date = date('Y-m-d');
            $sql = <<<EOF
                    SELECT b.id, b.name, b.campaign_id, b.param, b.source, a.name
                    FROM pt_campaign a, pt_conversion b
                    WHERE  a.id = b.campaign_id
                    AND '$current_date' >= a.start_date
                    AND '$current_date' <= a.end_date
                    AND b.status = 1
EOF;
            break;
    }
    
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $arrResult[] = $row;
        }
        setCache($type, $arrResult);
    } 
    $conn->close();
    
    return $arrResult;
}

function setCache($type, $arrData=array()){
    
    switch($type) {
        case 'Campaign':
            $redis = new Redis();
            $redis->connect(REDIS_HOST, REDIS_PORT_1);
            $cacheKey = 'Campaign';
            $arrCampaign = $redis->hgetall($cacheKey);
            
            $servername = DB_HOST . ":" . DB_PORT;
            $username = DB_USERNAME;
            $password = DB_PASSWORD;
            $dbname = DB_NAME;
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 
            
            foreach ($arrData as $data) {
                if (!empty($data)) {
                    //print_r($data);
                    $redis->hset($cacheKey, $data['id'], json_encode($data));  
                    unset($arrCampaign[$data['id']]);             
                    $campaign_id = $data['id'];
                    $campConvKey = "CampConv_{$campaign_id}";
                    $arrCampConv = $redis->hgetall($campConvKey);
                    
                    $sql = <<<EOF
                    SELECT id, campaign_id
                    FROM pt_conversion
                    WHERE  status = 1
                    AND campaign_id = $campaign_id
EOF;

                    $result = $conn->query($sql);
                    $arrTmp = array();
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $arrTmp[] = $row;
                        }
                    } 
                    
                    foreach ($arrTmp as $item) {
                        $redis->hSet($campConvKey, $item['id'], $item['id']);
                        if (!empty($arrCampConv[$item['id']])) {
                            unset($arrCampConv[$item['id']]);
                        }
                    }
                    
                    if (!empty($arrCampConv)) {
                        foreach ($arrCampConv as $key=>$val) {
                            $redis->hdel($campConvKey, $key);
                        }
                    }
                }
            }
            if(!empty($arrCampaign)) {
                foreach ($arrCampaign as $id=>$campaign) {
                    $redis->hdel($cacheKey, $id);
                    $redis->del("CampConv_{$id}");
                }
            }
            break;
        case 'Flight':
            $redis = new Redis();
            $redis->connect(REDIS_HOST, REDIS_PORT_1);
            $cacheKey = 'Flight';
            $arrFlight = $redis->hgetall($cacheKey);
            foreach ($arrData as $data) {
                if (!empty($data)) {
                    //print_r($data);
                    $data['country'] = json_decode($data['country']);
                    $data['province'] = json_decode($data['province']);
                    $redis->hset($cacheKey, $data['id'], json_encode($data));
                    unset($arrFlight[$data['id']]);
                }
            }
            if(!empty($arrFlight)) {
                foreach ($arrFlight as $id=>$flight) {
                    $redis->hdel($cacheKey, $id);
                }
            }
            break;
        case 'Adzone':
            $redis = new Redis();
            $redis->connect(REDIS_HOST, REDIS_PORT_1);
            
            $servername = DB_HOST . ":" . DB_PORT;
            $username = DB_USERNAME;
            $password = DB_PASSWORD;
            $dbname = DB_NAME;
            
            $cacheKey = 'Adzone';
            
            $arrAdzone = $redis->hgetall($cacheKey);
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 
            
            $sql = '';
            foreach ($arrData as $data) {
                if (!empty($data)) {
                    //print_r($data);
                    
                    $publisher_site_id = $data['publisher_site_id'];
                    $sql = <<<EOF
                    SELECT url
                    FROM pt_publisher_site
                    WHERE id = $publisher_site_id
EOF;

                    $result = $conn->query($sql);
                    $arrTmp = array();
                    if ($result->num_rows > 0) {
                        $arrTmp = $result->fetch_assoc();
                    } 
                    $data['site'] = $arrTmp;
                    
                    $publisher_ad_zone_id = $data['id'];
                    $sql = <<<EOF
                    SELECT code, weight
                    FROM pt_publisher_alternate_ad
                    WHERE publisher_ad_zone_id = $publisher_ad_zone_id
EOF;

                    $result = $conn->query($sql);
                    $arrTmp = array();
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $arrTmp[] = $row;
                        }
                    } 
                    $data['alternateAds'] = $arrTmp;
                    
                    $redis->hset($cacheKey, $data['id'], json_encode($data));
                    unset($arrAdzone[$data['id']]);
                }
            }
            
            if(!empty($arrAdzone)) {
                foreach ($arrAdzone as $id=>$zone) {
                    $redis->hdel($cacheKey, $id);
                }
            }
            break;
        case 'Ad':
            $redis = new Redis();
            $redis->connect(REDIS_HOST, REDIS_PORT_1);
            $cacheKey = 'Ad';
            $arrAd = $redis->hgetall($cacheKey);
            foreach ($arrData as $data) {
                if (!empty($data)) {
                    //print_r($data);
                    $redis->hset($cacheKey, $data['id'], json_encode($data));
                    unset($arrAd[$data['id']]);
                }
            }
            
            if(!empty($arrAd)) {
                foreach ($arrAd as $id=>$ad) {
                    $redis->hdel($cacheKey, $id);
                }
            }
            break;
        case 'PublisherAlternateAd':
            $redis = new Redis();
            $redis->connect(REDIS_HOST, REDIS_PORT_2);
            $cacheKey = 'PublisherAlternateAd';
            $arrPublisherAlternateAd= $redis->hgetall($cacheKey);
            foreach ($arrData as $data) {
                if (!empty($data)) {
                    //print_r($data);
                    $redis->hset($cacheKey, $data['publisher_ad_zone_id'], json_encode($data));
                    unset($arrPublisherAlternateAd[$data['publisher_ad_zone_id']]);
                }
            }
            
            if(!empty($arrPublisherAlternateAd)) {
                foreach ($arrPublisherAlternateAd as $id=>$publisherAlternateAd) {
                    $redis->hdel($cacheKey, $id);
                }
            }
            break;
        case 'FlightDate':
            $redis = new Redis();
            $redis->connect(REDIS_HOST, REDIS_PORT_1);
            $cacheKey = 'FlightDate';
            $arrFlightDate = $redis->hgetall($cacheKey);
            $arrFlight = array();
            foreach ($arrData as $data) {
                if (!empty($data)) {
                    $data['hour'] = json_decode($data['hour']);
                    $arrFlight[$data['flight_id']][] = $data;
                }
            }
            
            foreach ($arrFlight as $key=>$flight) {
                
                $redis->hset($cacheKey, $key, json_encode($flight));
                //print_r($flight);
                unset($arrFlightDate[$key]);
            }
            
            if(!empty($arrFlightDate)) {
                foreach ($arrFlightDate as $id=>$flightDate) {
                    $redis->hdel($cacheKey, $id);
                }
            }
            break;
        case 'PublisherSite':
            $redis = new Redis();
            $redis->connect(REDIS_HOST, REDIS_PORT_1);
            $cacheKey = 'PublisherSite';
            $arrPublisherSite = $redis->hgetall($cacheKey);
            foreach ($arrData as $data) {
                if (!empty($data)) {
                    //print_r($data);
                    $redis->hset($cacheKey, $data['id'], json_encode($data));
                    unset($arrPublisherSite[$data['id']]);
                }
            }
            
            if(!empty($arrPublisherSite)) {
                foreach ($arrPublisherSite as $id=>$publisherSite) {
                    $redis->hdel($cacheKey, $id);
                }
            }
            break;
        case 'PublisherAdZone':
            $redis = new Redis();
            $redis->connect(REDIS_HOST, REDIS_PORT_1);
            $cacheKey = 'PublisherAdZone';
            $arrPublisherAdZone = $redis->hgetall($cacheKey);
            foreach ($arrData as $data) {
                if (!empty($data)) {
                    //print_r($data);
                    $redis->hset($cacheKey, $data['id'], json_encode($data));
                    unset($arrPublisherAdZone[$data['id']]);
                }
            }
            
            if(!empty($arrPublisherAdZone)) {
                foreach ($arrPublisherAdZone as $id=>$publisherAdZone) {
                    $redis->hdel($cacheKey, $id);
                }
            }
            break;
        case 'Category':
            $redis = new Redis();
            $redis->connect(REDIS_HOST, REDIS_PORT_1);
            $cacheKey = 'Category';
            $arrCategory = $redis->hgetall($cacheKey);
            foreach ($arrData as $data) {
                if (!empty($data)) {
                    //print_r($data);
                    $redis->hset($cacheKey, $data['id'], json_encode($data));
                    unset($arrCategory[$data['id']]);
                }
            }
            
            if(!empty($arrCategory)) {
                foreach ($arrCategory as $id=>$category) {
                    $redis->hdel($cacheKey, $id);
                }
            }
            break;
        case 'AdFormat':
            $redis = new Redis();
            $redis->connect(REDIS_HOST, REDIS_PORT_1);
            $cacheKey = 'Ad_Format';
            $arrAdFormat = $redis->hgetall($cacheKey);
            foreach ($arrData as $data) {
                if (!empty($data)) {
                    //print_r($data);
                    $redis->hset($cacheKey, $data['id'], json_encode($data));
                    unset($arrAdFormat[$data['id']]);
                }
            }
            
            if(!empty($arrAdFormat)) {
                foreach ($arrAdFormat as $id=>$adFormat) {
                    $redis->hdel($cacheKey, $id);
                }
            }
            break;
        case 'FlightWebsite':
            $redis = new Redis();
            $redis->connect(REDIS_HOST, REDIS_PORT_1);
            $arrFlightWebsite = array();
            foreach ($arrData as $data) {
                if (!empty($data)) {
                    //print_r($data);
                    $cacheKey = "FlightWebsite_{$data['website_id']}_{$data['ad_format_id']}";
                    if (empty($arrFlightWebsite[$cacheKey])) {
                        $arrFlightWebsite[$cacheKey] = $redis->hgetall($cacheKey);
                    }
                    $redis->hset($cacheKey, $data['id'], json_encode($data));
                    
                    unset($arrFlightWebsite[$cacheKey][$data['id']]);
                }
            }
            
            foreach ($arrFlightWebsite as $key=>$flightWebsite) {
                foreach ($flightWebsite as $id=>$fw) {
                    $redis->hdel($key, $id);
                }
            }
            
            break;
        case 'Conversion':
            $redis = new Redis();
            $redis->connect(REDIS_HOST, REDIS_PORT_1);
            $cacheKey = 'Conversion';
            $arrConversion = $redis->hgetall($cacheKey);
            foreach ($arrData as $data) {
                if (!empty($data)) {
                    //print_r($data);
                    $data['param'] = json_decode($data['param']);
                    $redis->hset($cacheKey, $data['id'], json_encode($data));
                    unset($arrConversion[$data['id']]);
                }
            }
            
            if(!empty($arrConversion)) {
                foreach ($arrConversion as $id=>$conversion) {
                    $redis->hdel($cacheKey, $id);
                }
            }
            break;
    }    
}
