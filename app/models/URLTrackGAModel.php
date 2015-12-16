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
		$urlTrackGA = new URLTrackGAModel;
		$urlTrackGA->url = $inputs['url'];
		$urlTrackGA->active = $inputs['active'];
		$urlTrackGA->run = $inputs['run'];
		$urlTrackGA->save();
		
		$value['url'] = isset($inputs['url']) ? trim($inputs['url']) : '';
		$value['active'] = $inputs['active'];
  		$value['run'] = $inputs['run'];	

		$redis = new RedisBaseModel(Config::get('redis.redis_6.host'), Config::get('redis.redis_6.port'),false);
        $cacheKey = "url_track_ga";
        $redis->set($cacheKey, $value);
	}

	/*
	* Get All function
	* @return array
	*/
	public function getAll(){
		$results = URLTrackGAModel::all();
		return $results;
	}
}