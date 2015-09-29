<?php

class Modules extends Eloquent {

	protected $table = 'modules';
	protected $fillable = array('name', 'slug', 'group_id', 'status');

}
