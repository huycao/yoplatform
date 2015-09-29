<?php

class AdFormatBaseModel extends Eloquent {

	/**
	 *     Table name of model used
	 *     @var string
	 */
	protected $table = 'ad_format';

	public function getAllForm($defaultValue = '', $defaultOption = 'Select Ad Format'){
		$list = $this->orderBy('name','asc')
							->select('id', 'type','name')
							->get()
							->toArray();
							
		return $list;
	}
    public static function getView($id){
        $view = "";
        $ad_format =  AdFormatBaseModel::where("id","=",$id)->first();
        if($ad_format){
            $view = $ad_format->code_view;
        }

        return 'partials.code'.$view;
    }

}