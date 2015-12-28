<?php

class URLTrackGAModel extends Eloquent {

	/**
	 *     Table name of model used
	 *     @var string
	 */
	public $timestamps = false;
	protected $table = 'url_track_3rd';

	public static function getRules() {
		return [
			"url"	=> "required",
			"amount"=> "required|numeric",
		];
	}

	public static function getLangs(){
		return array(
			"url.required"		=>	"Url field is required.",
			"amount.required"	=>	"Amount field is required",
			"amount.numeric"	=>  "Amount must be a number",
		);
	}

	public function store($inputs){
		$value = array();
		$urlTrackGA = new URLTrackGAModel;
		$urlTrackGA->url = $inputs['url'];
		$urlTrackGA->active = $inputs['active'];
		$urlTrackGA->run = $inputs['run'];
		$urlTrackGA->amount = $inputs['amount'];
		$urlTrackGA->website = $inputs['website'];
		$urlTrackGA->save();
		
		$this->storeRedis();
	}

	/*
	 * Update info
	*/
	public function updateInfo($inputs, $id){
		$options = [
			'url'		=> $inputs['url'],
			'active'	=> $inputs['active'],
			'run'		=> $inputs['run'],
			'website' 	=> $inputs['website'],
			'amount'	=> $inputs['amount']
		];
		$this->where('id', $id)->update($options);
		$this->storeRedis();
	}

	/*
	* delete info
	*/
	public function deleteItem($id){
		URLTrackGAModel::find($id)->delete();
		$this->storeRedis();
	}

	/*
	* Get All function
	* @return array
	*/
	public function getAll(){
		$results = URLTrackGAModel::all();
		return $results;
	}

	public function getListActive(){
		return $this->select('id', 'url', 'website', 'amount','run')->where('active', 1)->where('amount', '>', 0)->get();
	}

	public function storeRedis(){
		$redis = new RedisBaseModel(Config::get('redis.redis_6.host'), Config::get('redis.redis_6.port'), false);
		$cacheKey = "URLTrack3rd";
		$value = json_encode($this->getListActive());					
	    $retval = $redis->set($cacheKey, $value);
	}
}