<?php

class GeoBaseModel extends Eloquent {

    /**
     *     Table name of model used
     *     @var string
     */
    protected $table = 'geo';

    public $timestamps = false;

    public function getCountry() {
        $redis = new RedisBaseModel(Config::get('redis.redis_3.host'), Config::get('redis.redis_3.port'), false);
        $cacheKey = 'GeoBaseModel:CountryList:All';
        $retval = $redis->get($cacheKey);
        if (!$retval) {
            $retval = $this->groupBy('country_code')
            ->where('country_code', '<>', '-')
            ->get(array('country_code', 'country_name'));

            $redis->set($cacheKey, $retval);
        }

        return $retval;
    }

    /**
     * 
     * Enter Get province list
     * @param array $country_code country code
     */
    public function getRegionByCountry($country_code = array()) {
        $redis = new RedisBaseModel(Config::get('redis.redis_3.host'), Config::get('redis.redis_3.port'), false);
        $result = array();
        if (!empty($country_code)) {
            foreach ($country_code as $value) {
                $cacheKey = "GeoBaseModel:Region:{$value}";
                $retval = $redis->get($cacheKey);
                if (!$retval) {
                    $retval = DB::table('geo')->select('country_code','country_name','region')
                                           ->groupBy('country_code','region')
                                           ->where('region', '<>', '-')
                                           ->where('country_code', $value)
                                           ->get();
                    $redis->set($cacheKey, $retval);
                }
                
                $result = $this->meargeObj($result, $retval);
            }
            
            return $result;
        } else {
            return FALSE;
        }
    }
    
    /**
     * 
     * Merge object geo
     * @param GeoBaseModel $obj1
     * @param GeoBaseModel $obj2
     */
    public function meargeObj($obj1, $obj2=array()) {
        foreach ($obj2 as $value) {
            $obj1[] = $value;
        }
        return $obj1;
    }
}