<?php
require_once 'ReportSummary.php';

$tracking = new ReportSummary;

$date = isset($argv[1]) ? $argv[1] : '';
$hour = isset($argv[2]) ? $argv[2] : '';
if ('' != $date) {
    if ('' != $hour) {
        $created_h = strtotime("{$date} {$hour}:00:00");
        if($rows = $tracking->updateReportHour($created_h)){
            echo "Report Success: ". $rows;
        } else{
            echo "No Report Complete";
        }
    } else {
        $created = strtotime($date);
        if($rows = $tracking->updateReportDay($created)){
            echo "Report Success: ". $rows;
        } else{
            echo "No Report Complete";
        }
    }
}
