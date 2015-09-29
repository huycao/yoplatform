<?php

class CampaignCommentBaseModel extends Eloquent {

	/**
	 *     Table name of model used
	 *     @var string
	 */
	protected $table = 'campaign_comment';

	protected $fillable=[
			'campaign_id',
			'comment'	
		];

}