<?php

class PaymentRequestDetailBaseModel extends Eloquent {

	protected $table = 'payment_request_detail';

	public function campaign(){
		return $this->hasOne('CampaignBaseModel','id','campaign_id');
	}

	public function publisher(){
		return $this->hasOne('PublisherBaseModel','id','publisher_id');
	}


	public function exportExcel($data){
        $excel = Excel::create('PaymentRequest',function($excel){
            // Set the title
            $excel->setTitle('Payment Request');
            // Chain the setters
            $excel->setCreator('Yomedia Adnetwork');
            $excel->setCompany('Pinetech');
            // Call them separately
            $excel->setDescription('Publisher payment request');
        });
        $excel->sheet('PaymentRequest', function($sheet) use($data) {
            $sheet->loadView('advertiser_manager.publisher_advertiser_manager.reportPaymentRequest', $data);
            $sheet->setColumnFormat(array(
                'C' => '#,##0',
                'D' => '#,##0',
                'E' => '#,##0'
            ));                     
        });
        ob_end_clean();
        $excel->download('xls');
        exit();
	}
}
