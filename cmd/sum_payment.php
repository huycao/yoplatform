<?php
//insert data to payment_request tbl, and payment_request_detail tbl on 1-5 every month.
//Mysql
define('DB_HOST', '127.0.0.1');
define('DB_PORT', 3306);
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'yomedia_vn2');

function connectDB(){
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
    }else{
        return $conn;
    }
}

//excute
function processingPaymentRequest($m, $pid){
    //calulate previous month
    if($m!=''){
        $date = date('Y-m', strtotime($m." months"));
    }else{
        $dates = getAllDateFromTrackingSummary();
    }
    //get list publishers
    if(!empty($pid)){
        $pids[] = $pid;
    }else{
        $pids = getAllIdPublishers();
    }
    //get list websites
    if(!empty($pids)){
        foreach($pids as $pid){
            if(!empty($dates)){
                foreach($dates as $date){
                    $date = date('Y-m', strtotime($date));
                    excuteSumPayment($pid, $date);
                }
            }else{
                excuteSumPayment($pid, $date);
            }
        }
    }
}

function excuteSumPayment($pid, $date){
    if(!checkExistPaymentRequest($pid, $date)){
        //get list website id
        $wids = getAllIdWebsites($pid);
        $data = sumEarnPerCampaign($wids,$date);
        $campaigns = $data['campaign'];
        $prid = insertPaymentRequest($pid, $date, $data['total']);//payment request id
        if(!empty($campaigns)){
            foreach($campaigns as $cpid => $campaign){
                $amount       = ($campaign['cost']!='')?$campaign['cost']:0;
                $impression   = $campaign['impression'];
                $click        = $campaign['click'];
                if( $click != 0 && $impression != 0 ){
                    $ctr = $click / $impression;
                }else{
                    $ctr = 0;
                }
                insertPaymentRequestDetail($pid, $cpid, $prid, $amount, $impression, $click, $ctr, $date);
            }
        }
    }
}

//check payment request is exist base on publisher id and date
function checkExistPaymentRequest($pid, $date){
    $m = date('m', strtotime($date));
    $y = date('Y', strtotime($date));
    $conn = connectDB();
    $sql = "SELECT id FROM pt_payment_request WHERE (publisher_id=$pid AND MONTH(created_at)='".$m."' AND YEAR(created_at) = '".$y."')";
    $result = $conn->query($sql);
    if($result && $result->num_rows>0){
        return true;
    }else{
        return false;
    }
    $conn->close();
}
//get all id of publisher
//using pt_publisher table
function getAllIdPublishers(){
    $conn = connectDB();
    $re = array();
    $sql = "SELECT id FROM pt_publisher";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $re[]= $row['id'];
        }
    }
    $conn->close();
    return $re;
}

//get all website base on publisher_id
//using table: publisher_site
function getAllIdWebsites($pid){
    $conn = connectDB();
    $re = array();
    $sql = "SELECT id FROM pt_publisher_site WHERE publisher_id=".$pid;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $re[]= $row['id'];
        }
    }
    $conn->close();
    return $re;
}
//sum earn per campaign
//using tracking_summary
function sumEarnPerCampaign($websites, $date){
    $data = getEarnPerFlight($websites, $date);
    $campaign = array();
    $total = 0;
    if(count($data)>0){
        foreach($data as $item){
            $cost = 0;
            switch ($item->cost_type) {
                case 'cpm':
                    $cost = $item->amount_impression;
                    break;
                case 'cpc':
                    $cost = $item->amount_click;
                    break;
                case 'cpv':
                    $cost = $item->amount_complete;
                    break;
                default:
                    break;
            }
            if( isset($campaign[$item->campaign_id]) ){
                $campaign[$item->campaign_id]['cost'] += $cost;
                $campaign[$item->campaign_id]['impression'] += $item->total_impression;
                $campaign[$item->campaign_id]['click'] += $item->total_click;
            }else{
                $campaign[$item->campaign_id]['cost'] = $cost;
                $campaign[$item->campaign_id]['impression'] = $item->total_impression;
                $campaign[$item->campaign_id]['click'] = $item->total_click;
            }
            $total += $cost;
        }
    }
    $result = array(
        'campaign'  => $campaign,
        'total'     => $total
    );
    return $result;
}

//getEarnPerFlight
function getEarnPerFlight($websites, $date){
    if(!empty($websites)){
        $m = date('m', strtotime($date));
        $y = date('Y', strtotime($date));
        $re = array();
        $conn = connectDB();
        $sql = "SELECT `pt_flight`.`campaign_id`, `pt_flight`.`cost_type`, `pt_tracking_summary`.`flight_id`, `pt_tracking_summary`.`flight_website_id`,
       ROUND(pt_flight_website.publisher_base_cost,2) as ecpm,
       SUM(impression) as total_impression,
       SUM(unique_impression) as total_unique_impression,
       SUM(click) as total_click,
       ROUND(SUM(impression)/SUM(unique_impression),2) as frequency,
       ROUND(SUM(click)/SUM(impression)*100,2) as ctr,
       ROUND(pt_tracking_summary.publisher_base_cost/1000*SUM(impression),2) as amount_impression,
       ROUND(pt_tracking_summary.publisher_base_cost*SUM(click),2) as amount_click,
       SUM(complete) as total_complete,
       ROUND(pt_tracking_summary.publisher_base_cost*SUM(complete),2) as amount_complete
       FROM `pt_tracking_summary`
       inner join `pt_flight_website` on `pt_tracking_summary`.`flight_website_id` = `pt_flight_website`.`id`
       inner join `pt_flight` on `pt_flight`.`id` = `pt_flight_website`.`flight_id`
       where `pt_tracking_summary`.`website_id` in (".implode(",",$websites).") and MONTH(`pt_tracking_summary`.`date`)= '".$m."'
       and YEAR(`pt_tracking_summary`.`date`) = '".$y."' and `ovr` = 0
       group by `pt_flight_website`.`flight_id`, `pt_tracking_summary`.`publisher_base_cost`";
        $result = $conn->query($sql);
        if(isset($result) && isset($result->num_rows) && $result->num_rows>0){
            while($row = $result->fetch_object()) {
                $re[]= $row;
            }
        }
        $conn->close();
        return $re;
    }
}

//insert 1 item payment request
//tbl: payment_request
function insertPaymentRequest($pid, $date, $amount){
    $conn = connectDB();
    $status = 'waiting';
    $date = date('Y-m-d H:i:s', strtotime($date));

    $sql = "INSERT INTO pt_payment_request(publisher_id, amount, status, created_at) VALUES ($pid, $amount, '".$status."', '".$date."')";
    $result = $conn->query($sql);
    if($result === TRUE){
        return $conn->insert_id;
    }else{
        die('Cannot insert new payment_request record');
    }
    $conn->close();
}

//create payment request detail base on payment request
function insertPaymentRequestDetail($pid, $cpid, $prid, $amount, $impression, $click, $ctr, $date){
    $conn = connectDB();
    $date = date('Y-m-d H:i:s', strtotime($date));
    $sql = "INSERT INTO pt_payment_request_detail(payment_request_id, publisher_id, campaign_id, amount, impression, click, ctr, created_at) VALUES ($prid,$pid, $cpid, $amount, $impression, $click, $ctr, '".$date."')";
    if($conn->query($sql) === TRUE){

    }else{
        print_r($sql);die;
        die('Cannot insert new payment_request_detail record');
    }
    $conn->close();
}

//get all date from tracking summary but not include current date
function getAllDateFromTrackingSummary(){
    $conn = connectDB();
    $re = array();
    $sql = "SELECT date FROM pt_tracking_summary GROUP BY MONTH(date), YEAR(date)";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if(!checkCurrentMonthAndYear($row['date'])){
                $re[]= $row['date'];
            }
        }
    }
    $conn->close();
    return $re;
}

function checkCurrentMonthAndYear($date){
    $today = date('Y-m');
    if(date('Y-m', strtotime($date)) === $today){
        return true;
    }else{
        return false;
    }
}



$m = isset($argv[1])?$argv[1]:'';
$pid = isset($argv[2])?$argv[2]:'';

processingPaymentRequest($m, $pid);

?>