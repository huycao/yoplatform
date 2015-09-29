<?php

class CountryBaseModel extends Eloquent {

	protected $table = 'country';

	public function getAll(){
		return $this->orderBy('country_name','asc')->get();
	}

	public function getAllForm(){
		$listCountry = $this->orderBy('country_name','asc')->get()->lists('country_name','id');
		return array(''=>'Select Country') + $listCountry;
	}

			
}
