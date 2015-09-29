<?php

use PublisherInfoPaymentBaseModel as modelInfoPayment;

class PaymentPublisherController extends PublisherBackendController {

    public function __construct(modelInfoPayment $model) {
        parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
        $this->model = $model;
    }

    //show payment history publisher
    public function showList() {
        $paymenthistory = new PaymentHistoryBaseModel();
        $this->data['item'] = array();
        $this->data['showmonth'] = "";
        if (Request::isMethod('post')) {
            $showmonth = Input::get('showmonth');
            if (is_numeric($showmonth)) {
                $i = $showmonth;
                for ($index = 1; $index <= $showmonth; $index++) {
                    $data[$i] = $paymenthistory->whereRaw('YEAR(`created_at`) = YEAR(CURRENT_DATE - INTERVAL '.$index.' MONTH) AND MONTH(`created_at`) = MONTH(CURRENT_DATE - INTERVAL '.$index.' MONTH)  and publisher_id = ' . $this->getPublisher()->id)->select('*')->get();
                    $i--;
                } 
                $this->data['item'] = $data;
                $this->data['showmonth'] = $showmonth;
            }
        }
        $this->layout->content = View::make('paymentHistory',$this->data);
    }

    //get invoice publisher
    public function getInvoice() {
        $this->layout->content = View::make('getInvoice') ;
    }

    //get invoice publisher
    public function getPdf() {
        $datemonth = Input::get('datemonth');
        if ($datemonth ) {
            if ($datemonth != null) {
                ($datemonth >= 1 && $datemonth <= 9) ? $month = '0' . $datemonth : $month = $datemonth;
                $flight = new FlightWebsiteBaseModel ( );
                $start_date = date('Y', time()) . '-' . $month . '-01';
                $end_date = date('Y', time()) . '-' . $month . '-' . date('t', strtotime($start_date));
                $idpublisher = $this->getPublisher()->id;

                // get Campagin da chay
                $camend = $flight
                            ->join('campaign', 'campaign.id', '=', 'flight.campaign_id')
                            ->join('flight', 'flight.id', '=', 'flight_website.flight_id')
                            ->where('campaign.start_date', '>=', $start_date)->where('campaign.end_date', '<=', $end_date)
                            ->where('flight_website.website_id', '=', $idpublisher)
                            ->select(array('campaign.name as campaignname', 'campaign.start_date', 'campaign.end_date', 'campaign.sale_order_tax', 'flight_website.*'))->get();
                 
                $camend = $this->sumEarnings($camend, $start_date, $end_date);

                pr($camend, 1);

                //$camend = $this->sumEarnings($camend, $start_date, $end_date);
                //// get Campagin dang chay
                $camrun = $flight
                    ->join('campaign', 'campaign.id', '=', 'flight.campaign_id')
                    ->join('flight', 'flight.id', '=', 'flight_website.flight_id')
                    ->where('campaign.start_date', '<', $end_date)
                    ->where('campaign.end_date', '>', date("Y-m-d", time()))
                    ->where('flight_website.website_id', '=', $idpublisher)
                    ->select(array('campaign.name as campaignname', 'campaign.start_date', 'campaign.end_date', 'campaign.sale_order_tax', 'flight_website.*'))
                    ->get();
            
                if ((count($camrun) == 0) && (count($camend) == 0)) {
                    $_SESSION['error'] = "No data";
                    return Redirect::to($this->moduleURL . 'get-invoice');
                }
                $camrun = $this->sumEarnings($camrun, $start_date, $end_date);

                $publisher = PublisherBaseModel::find($idpublisher);
                $param['datemonth'] = $datemonth;
                $param['camend'] = $camend;
                $param['mont'] = $start_date;
                $param['camrun'] = $camrun;
                $param['publisher'] = $publisher;
                $param['pinetech'] = ConfigBaseModel::find(1);
                if($param['pinetech'] == null){
                    $pinetech  = new stdClass();
                    $pinetech->name = "N/A";
                    $pinetech->address = "N/A";
                    $pinetech->state = "N/A";
                    $pinetech->city = "N/A";
                    $pinetech->country = "N/A";
                    $param['pinetech'] = $pinetech;
                }           
                $pdf = PDF::loadView('getInvoicePdf', $param)->setPaper('a4')->setWarnings(false);
                $file = "Invoice_" . $publisher->id . "_" . $publisher->company . "_" . date('M_Y', strtotime($start_date)) . '.pdf';
                return $pdf->download($file);
            } else {
                return Redirect::to($this->moduleURL . 'get-invoice');
            }
        }else{
            return Redirect::to($this->moduleURL . 'get-invoice');
        }
    }

    function sumEarnings($campaign, $start_date, $end_date) {
        if (count($campaign) > 0) {
            foreach ($campaign as $keycam => $cam) {
                $data = new TrackingSummaryBaseModel();
                $Earnings = $data->whereRaw("date >= '" . $start_date . "' AND date <= '" . $end_date . "' and flight_id = " . $cam->id)->groupby('flight_id')->select(DB::raw("sum(impression)as sum_impression"), DB::raw("sum(click)as sum_click"), 'flight_id')->first();

                $earning = 0;
                $delivered = 0;
                if ($Earnings != null) {
                    if ($cam->cost_type == 'cpc') {
                        $earning = mathECPC($Earnings->sum_click, $cam->publisher_cost, $cam->total_inventory);
                        $delivered = $Earnings->sum_click;
                    } else if ($cam->cost_type == 'cpm') {
                        $earning = mathECPM($Earnings->sum_impression, $cam->publisher_cost, $cam->total_inventory);
                        $delivered = $Earnings->sum_impression;
                    }
                }
                $campaign[$keycam]->delivered = $delivered;
                $campaign[$keycam]->earning = $earning;
                $campaign[$keycam]->earning_tax = $earning * ($cam->sale_order_tax / 100);
            }
        }
        return $campaign;
    }

    //show payment info publisher
    public function showPaymentInfo() {
        $currentUser = Session::get('currentUserSess');
        $this->data['item'] = modelInfoPayment::where('publisher_id', $this->getPublisher()->id)->first();

        $this->layout->content = View::make('showPaymentInfo', $this->data);
    }

}
