<?php

class Permission extends Eloquent {

	protected $table = 'permissions';
	protected $fillable = array('name', 'slug', 'module_id', 'group_id', 'action', 'status');

	public function module()
    {
        return $this->belongsTo('Modules');
    }

}
