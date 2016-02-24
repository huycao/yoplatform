<?php
require_once 'ReportSummary.php';

$tracking = new ReportSummary;

$type= isset($argv[1]) ? $argv[1] : '';
$date = isset($argv[2]) ? $argv[2] : '';
$hour = isset($argv[3]) ? $argv[3] : '';

switch ($type) {
    case 'hourly':
        $time = strtotime("-1 hour");
        if($rows = $tracking->getSummaryHourData($time)){
            echo "Report Success: {$rows}\n";
        } else {
            echo "No Report Complete\n";
        }
        break;
    case 'daily':
        $time = strtotime("-1 day");
        if($rows = $tracking->getSummaryDayData($time)){
            echo "Report Success: {$rows}\n";
        } else {
            echo "No Report Complete\n";
        }
        break;
    case 'time':
        if ('' != $date) {
            if ('' != $hour) {
                $time = strtotime("{$date} {$hour}:00:00");
                if($rows = $tracking->getSummaryHourData($time)){
                    echo "Report Success: {$rows}\n";
                } else{
                    echo "No Report Complete\n";
                }
            } else {
                $time = strtotime($date);
                if($rows = $tracking->getSummaryDayData($time)){
                    echo "Report Success: {$rows}\n";
                } else{
                    echo "No Report Complete\n";
                }
            }
        } else {
            echo "Miss param.\n";
            exit();
        }
        break;
    
    case 'today':
        if($rows = $tracking->getSummaryDayData()){
            echo "Report Success: {$rows}\n";
        } else {
            echo "No Report Complete\n";
        }
        break;
    default:
        echo "Miss param.\n";
        exit();
}