<?php
class RawTrackingAdRequest{

    protected $table      = 'trackings_adrequest';
    protected $tableMySQL = 'tracking_adrequest';
    protected $connection = 'mongodb';
    public $timestamps    = false;

    public function getRecentHourData($timestamp = ''){
        $dateH = !empty($timestamp) ? date('Y-m-d H', $timestamp) : date('Y-m-d H');
        return DB::connection('mongodb')->collection($this->table)->where('created_h', $dateH)->get();
    }

    public function getSummaryDayData($timestamp = ''){
        $date = !empty($timestamp) ? date('Y-m-d', $timestamp) : date('Y-m-d');
        return DB::connection('mongodb')->collection($this->table)->where('created_d', $date)->get();
    }


    public function reportScheduleHourly(){
        set_time_limit(0);
        $recordUpdated = 0;
        
        // begin summary data
        //current hour
        $data = (new RawTrackingAdRequest())->getRecentHourData(strtotime("-1 hour"));

        $recordUpdated = $this->generateSummaryData($data);
        return $recordUpdated;
        
    }

    public function reportScheduleDaily($time = ''){
        //run at 2.00 AM
        set_time_limit(0);
        $recordUpdated = 0;
        
        // begin summary data of yesterday
        $time = !empty($time) ? $time : strtotime("-1 day");
        $data = (new RawTrackingAdRequest())->getSummaryDayData($time);
        $recordUpdated = $this->generateSummaryData($data);

        return $recordUpdated;
    }
    
    public function updateReportHour($timestamp){
        set_time_limit(0);
        $recordUpdated = 0;
        
        $data = (new RawTrackingAdRequest())->getRecentHourData();
        if(!empty($timestamp)){
            $data = (new RawTrackingAdRequest())->getRecentHourData($timestamp);
        }

        $recordUpdated = $this->generateSummaryData($data);
        return $recordUpdated;
        
    }

    public function generateSummaryData($rawSummaryData){
        $recordUpdated = 0;
        if(empty($rawSummaryData)){
            return $recordUpdated;
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

            //list metrics to repport
            $metrics = [
                //general metrics
                'impression','unique_impression','click','unique_click','ads_request','conversion',
                //TVC metrics
                'start','firstquartile','midpoint','thirdquartile','complete','pause','unpause','mute','unmute','fullscreen',
            ];

            $checkExists = DB::table($this->tableMySQL)->select('id')->where($where)->first();
     
            if(!empty($row['count'])) {
                $dataUpdate['count'] = $row['count'];
            }

            if($checkExists) {
                DB::table($this->tableMySQL)->where('id', $checkExists->id)->update($dataUpdate);
            } else {
                $dataUpdate = array_merge($dataUpdate, $where);
                DB::table($this->tableMySQL)->insert($dataUpdate);   
            }

            $recordUpdated++;
        }

        return $recordUpdated;
    }
}
