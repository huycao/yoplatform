<?php

class AudienceModel extends Eloquent {

	/**
	 *     Table name of model used
	 *     @var string
	 */
	protected $table = 'audience';
	public $timestamps = false;	

	 protected $appends = array('pfcount');

	 /**
     * Get the campaign that owns the audience.
     */
	public function campaign(){
		return $this->belongsTo('CampaignBaseModel');
	}

	/*
	* Get Create Rules
	*
	*@return array
	*/

	public function getCreateRules() {
        return array(
            "name"         => "required",
        );
    }

    /*
	* Get Create Langs
	*
	*@return array
	*/
	
    public function getCreateLangs() {
        return array(
            "name.required" => 'Name of audience required.',
        );
    }

    /*
	* Get Create Rules
	*
	*@return array
	*/

	public function getUpdateRules() {
        return array(
            "name"         => "required",                    
        );
    }

    /*
	* Get Create Langs
	*
	*@return array
	*/
	
    public function getUpdateLangs() {
        return array(
            "name.required" => 'Name of audience required.',
        );
    }

    /*
    * Create Item
    *
    * @param array $inputs
    * @return string | boolean
    */
    public function createItem($inputs){
    	$audience = new AudienceModel;
        $audience->audience_id = time();
    	$audience->name = $inputs['name'];
    	$audience->description = $inputs['description'];
    	$audience->campaign_id = $inputs['campaign_id'];
    	$audience->ad_id = $inputs['ad_id'];
    	$audience->audience_update = date('Y-m-d H:i:s');
    	$audience->last_editor =$inputs['last_editor'];
    	if($audience->save()){
    		return $audience->name;
    	}
    	return false;

    }

    /*
    * Create Item
    *
    * @param array $inputs
    * @return string | boolean
    */
    public function updateItem($inputs, $id){
    	if($id){
    		$options['name'] = $inputs['name'];
    		$options['description'] = $inputs['description'];	
    		$options['audience_update'] = date('Y-m-d H:i:s');
    		$options['last_editor'] =$inputs['last_editor'];
    		$this->where('audience_id', $id)->update($options);
    	}
    	return false;
    }

    /*
    * Get Item By Id
    *
    * @param int $id
    * @return array
    */
    public function getItemById($id){
    	return AudienceModel::where('audience_id', $id)->first();
    }

    /*
    * Get List Items
    *
    * @param int $id
    * @param string $defaultField,
    * @param string $defaultOrder,
    * @param int $showNumber
    * @return array
    */
    public function getItems($id, $field="ad_id"){
    	if($id!=''){
    		return $this->where($field, $id)->get();
    	}
    }

    /*
    * GEt Pfcount Attribute
    * return 
    */
    public function getPfcountAttribute(){
    	 $oRedis = new RedisBaseModel(Config::get('redis.redis_6.host'), Config::get('redis.redis_6.port'), false);
    	 $kM ="au.".$this->audience_id;
		return $oRedis->pfcount($kM);
    }

    /*
    * Delete Audiences
    * 
    * @param array $ids
    * @return boolean
    */
    public function deleteAudiences($ids){
        if ($this->whereIn('audience_id', $ids)->delete()){
            DB::table('ad')->whereIn('audience_id', $ids)->update(array('audience_id'=>''));
             foreach($ids as $id){
                DB::table('flight')->where('audience', 'LIKE', '%'.$id.'%')->update(array('use_retargeting'=>2, 'audience'=>''));
            }
           return true;
        }
        return false;
    }

    /*
    * update campaign
    * @param int $id
    * @param int $campaign_id
    */
    public function updateCampaign($id, $campaign_id){
        $this->where('ad_id', $id)->update(array('campaign_id'=> $campaign_id));
    }
}