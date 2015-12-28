<?php
    //Mysql
    define('DB_HOST', '127.0.0.1');
    define('DB_PORT', 3306);
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'root');
    define('DB_NAME', 'yomedia');
    define('DB_TABLE', 'tracking_adrequest');

    define('MDB_HOST', '127.0.0.1');
    define('MDB_PORT', 27017);
    define('MDB_NAME', 'yomedia');
    define('MDB_COLLECTION', 'trackings_adrequest');

    if (isset($argv[1])) {
        $type = isset($argv[1]);
        switch ($type) {
            case 'hourly':
                reportScheduleHourly();
                break;
            case 'daily':
                reportScheduleDaily();
                break;
            case 'today':
                reportScheduleDaily(time());
                break;
        }
    } else {
        //echo "Miss param.\n";
        //exit();
    }

    function connectMysql() {
        $servername = DB_HOST;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;
        $dbname = DB_NAME;

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            return false;
        } 

        return $conn;
    }

    function connectMongoDB() {
        $servername = "mongodb://" . MDB_HOST . ":" . MDB_PORT;
        $m = new MongoClient($servername);
        $db = $m->selectDB(MDB_NAME);
        $collection = new MongoCollection($db, MDB_COLLECTION);

        return $collection;
    }

    function getData($arrQuery){      
        $retval = array();
        $data = connectMongoDB()->find($arrQuery);
        foreach ($data as $item) {
            $retval[] = $item;
        }

        return $retval;
    }

    function getRecentHourData($timestamp = ''){
        $dateH = !empty($timestamp) ? date('Y-m-d H', $timestamp) : date('Y-m-d H');

        $arrQuery = array(
            'created_h' => $dateH
        );
        $retval = getData($arrQuery);

        return $retval;
    }

    function getSummaryDayData($timestamp = ''){
        $date = !empty($timestamp) ? date('Y-m-d', $timestamp) : date('Y-m-d');
        $arrQuery = array(
            'created_d' => $date
        );
        $retval = getData($arrQuery);

        return $retval;
    }


    function reportScheduleHourly(){
        $recordUpdated = 0;
        $data = getRecentHourData(strtotime("-1 hour"));
        $recordUpdated = generateSummaryData($data);
        echo $recordUpdated . "\n";
        
    }

    function reportScheduleDaily($time = ''){
        $recordUpdated = 0;
        $time = !empty($time) ? $time : strtotime("-1 day");
        $data = getSummaryDayData($time);
        $recordUpdated = generateSummaryData($data);

        echo $recordUpdated . "\n";
    }

    function generateSummaryData($rawSummaryData) {
        $recordUpdated = 0;
        if(empty($rawSummaryData)){
            return $recordUpdated;
        }

        $servername = DB_HOST;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;
        $dbname = DB_NAME;

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            return false;
        }
        foreach ($rawSummaryData as $row) {
            $dataUpdate = [];
            $where = [];
            $where = [
                'website_id'           =>   $row['wid'],
                'publisher_ad_zone_id' =>   $row['zid'],
                'hour'                 =>   intval(substr($row['created_h'], -2)),
                'date'                 =>   $row['created_d']
            ];
            $website_id = $row['wid'];
            $zid = $row['zid'];
            $hour = intval(substr($row['created_h'], -2));
            $date = $row['created_d'];
            $count = 0;
            if(!empty($row['count'])) {
                $count = $row['count'];
            }

            $sql_exist = <<<EOF
                    SELECT id
                    FROM pt_tracking_adrequest
                    WHERE website_id = $website_id
                    AND publisher_ad_zone_id = $zid
                    AND hour = $hour
                    AND date = '$date'
EOF;
            $checkExists = $conn->query($sql_exist);

            if ($checkExists->num_rows > 0) {
                $sql = <<<EOF
                    UPDATE pt_tracking_adrequest
                    SET count = $count
                    WHERE website_id = $website_id
                    AND publisher_ad_zone_id = $zid
                    AND hour = $hour
                    AND date = '$date'
EOF;
                $conn->query($sql);
            } else {
                $sql = <<<EOF
                    INSERT INTO pt_tracking_adrequest
                    (website_id, publisher_ad_zone_id, hour, date, count)
                    VALUES ($website_id, $zid, $hour,'$date', $count)
EOF;

                $conn->query($sql);
            }

            $recordUpdated++;
        }

        $conn->close();

        return $recordUpdated;
    }

?>