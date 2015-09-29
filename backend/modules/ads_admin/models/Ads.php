<?php namespace Advalue;
use Eloquent;
use View;
use Response;

class Ads extends Eloquent {

	protected $append = array();

	/**
     * RELATIONSHIP
     */
    public function adformat(){
        return $this->hasOne('Adformat');
    }
}
