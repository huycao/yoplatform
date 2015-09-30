<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Conversion extends Eloquent{
    const RESPONSE_TYPE_CONVERSION_NOT_FOUND          = 'conversion is not found';
    const RESPONSE_TYPE_CONVERSION_NOT_INVALID        = 'conversion is invalid';
    const RESPONSE_TYPE_CONVERSION_SUCCESS            = 'success';
    const RESPONSE_TYPE_CONVERSION_ERROR              = 'error';
    
    public function renewCache($object, $objectID ){
		$object = strtolower($object);
		$renewCache = true;
		switch ($object) {
			case 'conversion':
			    $this->getConversion($objectID, $renewCache);
			    break;
			default:
				return false;
		}
		return true;
	}
    
    function getConversion($conversionID, $renewCache = false) {
        $redis = new RedisBaseModel(Config::get('redis.redis_2.host'), Config::get('redis.redis_2.port'));
	    $cacheKey = "Conversion";
	    $cacheField = $conversionID;
		$retval = $redis->hGet($cacheKey, $cacheField);
		if(Input::get('cleared') || $renewCache){
		    $redis->hDel($cacheKey, $cacheField);
			$retval = 0;
		}
		if(!$retval){
			$retval = DB::table('conversion')
		                    ->join('campaign', 'conversion.campaign_id', '=', 'campaign.id')
			                ->where('conversion.id', $conversionID)
			                ->where('conversion.status', 1)
			                ->select('conversion.id', 'conversion.name', 'conversion.campaign_id',
			                    'conversion.param', 'conversion.source', 'campaign.name')
			                ->first();
            if ($retval) {
                $retval->param = json_decode($retval->param);
            }
			$redis->hSet($cacheKey, $cacheField, $retval);
		}
		return $retval;
	}
}