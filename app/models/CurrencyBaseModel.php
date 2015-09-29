<?php

class CurrencyBaseModel extends Eloquent {

	/**
	 *     Table name of model used
	 *     @var string
	 */
	protected $table = 'currency';

	/**
	 *     Get Data for create Form in View
	 *     @param  integer $level
	 *     @return array
	 */
	public function getAllForm(){
		$list = $this->orderBy('name','asc')
					->get()
					->lists('name','id');
		return array(''=>'Select Currency') + $list;
	}			
}