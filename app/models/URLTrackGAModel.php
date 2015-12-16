<?php

class URLTrackGAModel extends Eloquent {

	/**
	 *     Table name of model used
	 *     @var string
	 */
	public $timestamps = false;
	protected $table = 'url_track_ga';

	public function store($inputs){
		DB::table('url_track_ga')->truncate();
		$value = array();
		if(!empty($inputs)){
			$url_array = explode("http", $inputs);

	        if(is_array($url_array)){
	            foreach($url_array as $item){
	                if(trim($item)!=""){
	                    $urlTrackGA = new URLTrackGAModel;
	                    $urlTrackGA->url = ("http". trim($item));
	                    $urlTrackGA->save();    
	                    $value[] = "http" . trim($item);
	                }
	            }
	        }
		}

		$redis = new RedisBaseModel(Config::get('redis.redis_2.host'), Config::get('redis.redis_2.port'),false);
        $cacheKey = "url_track_ga";
      	if(is_array($value) && sizeof($value) > 0){
      		$value =json_encode($value);	
      	}else{
      		$value = "";
      	}
        $redis->set($cacheKey, $value);
	}

	/*
	* Get All function
	* @return array
	*/
	public function getAll(){
		$redis = new RedisBaseModel(Config::get('redis.redis_2.host'), Config::get('redis.redis_2.port'),false);
		$cacheKey = "url_track_ga";
		$results = $redis->get($cacheKey);		
		if(empty($results)){
			$results = URLTrackGAModel::all()->lists('url');
		}else{
			$results = json_decode($results);
		}
		return $results;
	}
}