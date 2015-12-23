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
			"website"=> "required",
		];
	}

	public static function getLangs(){
		return array(
			"url.required"		=>	"Url field is required.",
			"amount.required"	=>	"Amount field is required",
			"amount.numeric"	=>  "Amount must be a number",
			"website.required"  =>  "Website field is required"
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
		$track_id = $urlTrackGA->id;
		
		if ($urlTrackGA->active == 1) {
			$redis = new RedisBaseModel(Config::get('redis.redis_6.host'), Config::get('redis.redis_6.port'), false);
			$cacheKey = "URLTrack_{$track_id}";
			$value = [
				'id' => $urlTrackGA->id,
				'url'=> $urlTrackGA->url,
				'amount'=> $urlTrackGA->amount,
				'webiste' => $urlTrackGA->website,
				'run'=> $urlTrackGA->run,
			];
		    $retval = $redis->hMset($cacheKey, $value);
		} 
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
		if ($inputs['url'] == 1) {
			$redis = new RedisBaseModel(Config::get('redis.redis_6.host'), Config::get('redis.redis_6.port'), false);
			$cacheKey = "URLTrack_{$id}";
			$value = [
				'id' => $id,
				'url'=> $inputs['url'],
				'amount'=> $inputs['amount'],
				'website'=> $inputs['website'],
				'run'=> $inputs['run'],
			];
		    $retval = $redis->hMset($cacheKey, $value);
		} 
		
	}

	/*
	* delete info
	*/
	public function deleteItem($id){
		URLTrackGAModel::find($id)->delete();
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