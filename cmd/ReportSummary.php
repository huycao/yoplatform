<?php
require_once 'MysqliDb.php';

class ReportSummary{

    protected $table      = 'trackings_summary';
    protected $tableMySQL = 'tracking_summary';
    protected $connection = 'mongodb';
    public $timestamps    = false;
    
    public function connectionMongo() {
        $m = new MongoClient( "mongodb://192.168.100.8:27017" );
        $db = $m->selectDB('yomedia');
        return $collection = new MongoCollection($db, $this->table);        
    }
    
    public function connectionMysql () {
       $db = new MysqliDb (array (
                'host' => '192.168.100.14',
                'username' => 'root', 
                'password' => '123@qazwsX',
                'db'=> 'yomedia',
                'port' => 3306,
                'prefix' => 'pt_',
                'charset' => 'utf8'));
       
       return $db;
    }

    public function getData($arrQuery){       
        $data = $this->connectionMongo()->find($arrQuery);
        
        return $data;
    }

    public function updateReportDay($timestamp = ''){
        set_time_limit(0);
        $recordUpdated = 0;
        
        if(!empty($timestamp)){
            $arrQuery = array('created_d' => date('Y-m-d', $timestamp));
            $data = $this->getData($arrQuery);
        }
        $recordUpdated = $this->generateSummaryData($data);

        return $recordUpdated;
    }
    
    public function updateReportHour($timestamp){
        set_time_limit(0);
        $recordUpdated = 0;
        
        if(!empty($timestamp)){
            $arrQuery = array('created_h' => date('Y-m-d H', $timestamp));
            $data = $this->getData($arrQuery);
        }

        $recordUpdated = $this->generateSummaryData($data);
        return $recordUpdated;
        
    }
    
    public function generateSummaryData($rawSummaryData){
        $recordUpdated = 0;
        if(empty($rawSummaryData)){
            return $recordUpdated;
        }
        $db = $this->connectionMysql();
        foreach ($rawSummaryData as $row) {
            $dataUpdate = [];
            $where = [];
            $where = [
                'website_id'           =>   $row['w'],
                'publisher_ad_zone_id' =>   $row['az'],
                'ad_format_id'         =>   $row['af'],
                'hour'                 =>   intval(substr($row['created_h'], -2)),
                'date'                 =>   $row['created_d']
            ];
            
            if ('ovr' == substr($row['_id'], -3)) {
                $where['ovr'] = 1;
            } else {
                $where['ovr'] = 0;
            }

            if(strpos($row['_id'], 'noads') === FALSE){
                //summary of tracking success
                $where['flight_id']         = $row['f'];
                $where['flight_website_id'] = $row['fw'];
                $where['campaign_id']       = $row['camp'];
                $where['ad_id']             = $row['a'];

                $arrID = explode('_', $row['_id']);
                if (!empty($arrID) && count($arrID) >= 3 && is_numeric($arrID[2])) {
                    $where['publisher_base_cost']  = $arrID[2];
                } else {
                    $dbFlightWebsite = $this->connectionMysql();
                    $dbFlightWebsite->where('id', $row['fw']);
                    $flight_website = $dbFlightWebsite->getOne('flight_website', 'publisher_base_cost');
                    if($flight_website){
                        $where['publisher_base_cost']  = $flight_website['publisher_base_cost'];
                    }
                }
            }
            else{
                //summary ads request of adzone and adformat when no ads deliveried
                $where['flight_website_id'] = 0;
            }

            //list metrics to repport
            $metrics = [
                //general metrics
                'impression','unique_impression','click','unique_click','ads_request','conversion',
                //TVC metrics
                'start','firstquartile','midpoint','thirdquartile','complete','pause','unpause','mute','unmute','fullscreen',
            ];

            $checkExists = $this->checkSummary($where);
     
            foreach ($metrics as $metric) {
                if(!empty($row[$metric])){
                    $dataUpdate[$metric] = $row[$metric];
                }
            }
            
            if ($checkExists === FALSE) {
                $dataUpdate = array_merge($dataUpdate, $where);                
                $db->insert($this->tableMySQL, $dataUpdate);
            } else {
                $db->where('id', $checkExists);
                $db->update($this->tableMySQL, $dataUpdate);
            }

            $recordUpdated++;
        }

        return $recordUpdated;
    }
    
    public function checkSummary($arrWhere=array()) {
       $db = $this->connectionMysql();
       if (!empty($arrWhere)) {
           foreach ($arrWhere as $key=>$value) {
               $db->where($key, $value);
           }
       }
       $data = $db->getOne('tracking_summary', 'id');
       if (!empty($data)) {
           return $data['id'];
       } else {
           return FALSE;
       }
    }
}
