<?php

class PublisherRevenueSharingBaseModel extends Eloquent {

	protected $table = 'publisher_revenue_sharing';

	protected $fillable= [
		"tax",
		"management_free",
		"split_billing",
		"revenue_sharing",
		"primium_publisher",
		"domain_checking",
		"vast_tag",
		"network_publisher",
		"mobile_ad",
		"access_to_all_channels",
		"newsletter",
		"company_name",
		'name_contact',
        'email_contact',
        'phone_contact',
        'address_contact',
		"enable_report_by_model"
			];
			
}
