<?php

class RawTrackingAudience extends Moloquent {

    protected $table      = 'tracking_audience';
    protected $tableMySQL = 'tracking_audience';
    protected $connection = 'mongodb';
    public $timestamps    = false;
    
    public function reportAudience(){
        set_time_limit(0);
        $recordUpdated = 0;
        
        $data = (new RawTrackingAudience())->getAudienceData();
        $recordUpdated = $this->generateAudienceData($data);

        return $recordUpdated;
    }

    public function getAudienceData(){
        return \DB::connection('mongodb')->collection($this->table)->get();
    }
    
    public function generateAudienceData($rawAudienceData){
        $recordUpdated = 0;
        if(empty($rawAudienceData)){
            return $recordUpdated;
        }

        foreach ($rawAudienceData as $row) {
            $dataUpdate = [];
            $where = [];
            $where = [
                'object_id' => $row['_id']->{'$id'}
            ];

            $dataUpdate = [
                'uuid' => $row['uuid'],
            	'bid'   => $row['bid'],
                'impression' => !empty($row['impression']) ? $row['impression'] : 0,
            	'click' => !empty($row['click']) ? $row['click'] : 0
            ];

            $checkExists = \DB::table($this->tableMySQL)->select('id')->where($where)->first();

            if($checkExists){
                \DB::table($this->tableMySQL)->where('id', $checkExists->id)->update($dataUpdate);
            } else{
                $dataUpdate = array_merge($dataUpdate, $where);
                \DB::table($this->tableMySQL)->insert($dataUpdate);   
            }

            $recordUpdated++;
        }

        return $recordUpdated;
    }

    public function getListAudienceTracking($bid){
        $retval = [];
        if( !empty($bid) ){
            $retval = \DB::table($this->tableMySQL)->where('bid', $bid)->get();
        }
        
        return $retval;
    }
}
