<?php
//Cache
define('REDIS_HOST', '127.0.0.1');
define('REDIS_PORT_2', 6379);
//Mysql
define('DB_HOST', '127.0.0.1');
define('DB_PORT', 3306);
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'yomedia');

echo "Cache for: " . $type . "\n";
//Connect Mysql
$servername = DB_HOST;;
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
$current_date = date('Y-m-d');
$sql = <<<EOF
                SELECT f.id, f.cost_type
                FROM pt_campaign c, pt_flight f
                WHERE  c.id = f.campaign_id
                AND '$current_date' >= c.start_date
                AND '$current_date' <= c.end_date
                AND f.status = 1
EOF;


$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $redis = new Redis();
    $redis->connect(REDIS_HOST, REDIS_PORT_2);
    while($row = $result->fetch_assoc()) {
        $flight_id = $row['id'];
        if ($row['cost_type'] == 'cpm') {
            $event = 'impression';
        } elseif ($row['cost_type'] == 'cpc') {
            $event = 'click';
        } else {
            $event = '';
        }
        $cacheKey = "Flight_Inventory_{$flight_id}_{$event}";
        
        $sql_summary = <<<EOF
                SELECT flight_id, SUM(impression) as total_impression, SUM(click) as total_click
                FROM pt_tracking_summary
                WHERE flight_id = $flight_id AND ovr=0
                GROUP BY flight_id, ovr
EOF;
        $rs = $conn->query($sql_summary);
        $inventory = 0;
        if ($result->num_rows > 0) {
            while($data = $rs->fetch_assoc()) {
                if ($event == 'impression') {
                    $inventory += $data['total_impression'];
                } elseif ($event == 'click') {
                    $inventory += $data['total_click'];
                }
            }
        }
        $redis->setex($cacheKey, 15768000, $inventory);

        echo "Updated flight {$flight_id} with inventory: {$inventory}\n";
    }
} 
$conn->close();

