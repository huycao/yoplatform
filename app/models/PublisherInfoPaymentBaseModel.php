<?php

class PublisherInfoPaymentBaseModel extends Eloquent {

	protected $table = 'publisher_info_payment';

	protected $fillable = [
				'publisher_id',
				'bank',
				'payment_preference',
				'account_number',
				'account_name'
			];
			
}