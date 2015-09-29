<?php

class PaymentHistoryBaseModel extends Eloquent {

	protected $table = 'payment_history';
        function campaign() {
           return $this->belongsTo('CampaignBaseModel','campaign_id'); 
        }
}
