<?php

class PublisherCountryBaseModel extends Eloquent {

	protected $table = 'publisher_country';

	protected $fillable=[
			"publisher_id",
			"country_name",
			"country_id"
				];
			
}
