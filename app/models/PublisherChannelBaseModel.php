<?php

class PublisherChannelBaseModel extends Eloquent {

	protected $table = 'publisher_channel';

	protected $fillable = array(
        'publisher_id',
        'channel_name',
        "channel_id"
    );	
			
}
