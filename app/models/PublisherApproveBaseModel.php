<?php

class PublisherApproveBaseModel extends Eloquent {

	protected $table = 'publisher_approver';

	protected $fillable = [
				'user_id',
				'publisher_id',
				'username',
				'publisher_status'
			];
			
}