<?php

use CountryBaseModel as modelCountry;
use PublisherApproveBaseModel as modelPubApprove;
use ApprovePublisherManagerModel as modelAppPubManager;
class ApproveReportPublisherManagerController extends PublisherManagerController 
{
	protected $limit=10;
	protected $dateEnd='';
	protected $dateLast='';

	public function __construct(PublisherBaseModel $model) {
		parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
		$this->model = $model;
		$this->layout = 'layout.indexPublisher';
	}

	//show report publisher approve
	function showList(){

		$this->data['defaultField'] = $this->defaultField;
		$this->data['defaultOrder'] = $this->defaultOrder;
		$this->data['defaultURL'] 	= $this->moduleURL;

		//get month now
		$monthDate=date('M-Y');
		$this->data['monthDate']=$monthDate;

		$this->layout->content = View::make('showList', $this->data);
	}
	/*----------------------------- CREATE & UPDATE --------------------------------*/
	//get report publisher approve
	public function getReport(){
		
		$flagReport=Input::get('flagreport');
		if($flagReport==1){ //get report publisher last 12 month before month now
			$dateNow=date('Y-m-d');
			$this->dateEnd=date('Y-m-d',strtotime($dateNow."+ 1 day"));
			
			$arrDate=getMonthBefore();
			end($arrDate);
			$dateLast=key($arrDate)."-01";
			$this->dateLast=date('Y-m-d',strtotime($dateLast."- 1 day"));

			$data=$this->model->GetListByDate($this->dateEnd,$this->dateLast);
			//reverse array
			$arrDate=array_reverse($arrDate);
			//get report json
			$arrJson=$this->getReportJson($arrDate,$data,$flagReport);
			
		}else{ //get report monthly
			$monthly=Input::get('monthly');
			//math number day of an month
			list($y,$m)=explode('-', $monthly);
			$numDay=cal_days_in_month(CAL_GREGORIAN,$m,$y);

			$dateNow = date('Y-m');
			
			if($dateNow == $monthly){ // if month current
				$numDay=date('j'); //get number day current
			} 
				
			
			//get days of monthly
			$arrDate=$this->getDaysOfMonthly($numDay);
			end($arrDate);

			$dateLast=$monthly."-01";
			$this->dateLast = date('Y-m-d', strtotime($dateLast."- 1 day"));
			$dateEnd =$monthly."-".current($arrDate);
			$this->dateEnd = date('Y-m-d', strtotime($dateEnd." + 1 day"));

			//get data monthly
			$data=$this->model->GetListByDate($this->dateEnd,$this->dateLast);

			//get report json
			$arrJson=$this->getReportJson($arrDate,$data,$flagReport);
			
		}
		return $arrJson;
		
	}
	//get report json
	public function getReportJson($arrDate,$data,$flagReport){
		//get country
		$itemCountry = modelCountry::select('id','country_name')->get();
		if($data && count($data) > 0){
			
			$totalDisapperved=0;$totalApproved=0;
			foreach ($arrDate as $key => $value) {
				$approved=0;$disapproved=0;
				foreach ($data as $key1 => $value1) {
					if($flagReport==1){
						$dateFormat=date("Y-n",strtotime($value1->updated_at));
					}
					else{
						$dateFormat=date("d",strtotime($value1->updated_at));
						$key=$value;
					}

					if($key==$dateFormat){
						if($value1->status==modelAppPubManager::STATUS_APPROVED){//publisher approved
							$approved++;
							$totalApproved++;
						}
						if($value1->status==modelAppPubManager::STATUS_DISAPPROVED){//publisher disapproved
							$disapproved++;
							$totalDisapperved++;
						}
					}
					
					
				}
				$arrDataApproved[]=$approved;
				$arrDataDisapproved[]=$disapproved;
			}

			//math percent approved and disapproved
			$total=$totalApproved+$totalDisapperved;
			if($total > 0){
				$percentApproved=round(($totalApproved/$total)*100,2);
				$percentDisapproved=round(($totalDisapperved*100)/$total,2);	
			}else{
				$percentApproved=0;
				$percentDisapproved=0;	
			}
			
			//math percent new publisher
			$mathPercentNewPublisher = $this->mathPercentNewPublisher($flagReport,$itemCountry,$data);
			//get data approve
			$itemApprove = modelPubApprove::whereBetween('updated_at',[$this->dateLast,$this->dateEnd])->limit($this->limit)->get()->toArray();			

			//show list approve
			if($itemApprove)
				$htmlListApprove=$this->showListApprove($itemApprove);
			else
				$htmlListApprove=trim(trans("backend::publisher/text.no_data"));

			$arrJson=[
			'status'	=> 1,
			'series'	=> [
				[
				 'name'	=> 'Approved',
				 'data'	=> $arrDataApproved
				],
				[
				 'name'	=> 'Disapproved',
				 'data'	=> $arrDataDisapproved
				]
			],
			'xAxis'		=> array_values($arrDate),
			'chartpie'	=> [
				[
					'name'=>'Percentage',
					'data'=>[
						['Approved',$percentApproved],						
						['Disapproved',$percentDisapproved]
					]
				]				
			],
			'textPie'	=> 'Application status',

			'chartpie2'	=> $mathPercentNewPublisher,
			'textPie2'	=> 'New publisher',

			'htmlApprove'	=>trim($htmlListApprove)
			];
		}else{
			$arrJson=[
			'status'	=> 0,
			];
		}
		
		return json_encode($arrJson);
	}
	//get days of an month
	//@parram: num days of month
	public function getDaysOfMonthly($numDay){
		$tmpI='';
		for($i=1;$i<=$numDay;$i++){
			if($i<10) $tmpI='0'.$i;
			else $tmpI=$i;
			$arrDay[]=$tmpI;
		}
		return $arrDay;
	}
	//math percent new publisher by country
	public function mathPercentNewPublisher($flagReport,$itemCountry,$data){
		$total=0;
		foreach ($itemCountry as $key => $value) {
			$country=0;
			foreach ($data as $key1 => $value1) {
				if($value->id==$value1->country){
					$country++;
				}
			}
			if($country > 0){
				$arrCountry[$value->country_name]=$country;
				$total+=$country; 
			}
		}

		//math percent new publisher
		$arrMath = array();
		if( !empty($arrCountry) ){
			foreach ($arrCountry as $key => $value) {
				//percent
				$percent = round(($value*100)/$total,2);
				$arrMath[]=[$key,$percent];
			}
		}

		$chartPie=[
			[
				'name'=>'Percentage',
				'data'=>$arrMath
			]
		];
		return $chartPie;
	}
	//show list approve
	public function showListApprove($itemApprove){
		$arrUsername = array_column($itemApprove,'username');
		$arrUsername = array_unique($arrUsername);
		
		foreach ($arrUsername as $key => $value) {
			$approved=0;$disapproved=0;
			foreach ($itemApprove as $key1 => $value1) {
				if($value==$value1['username']){
					if($value1['publisher_status']==modelAppPubManager::STATUS_APPROVED){
						$approved++;
					}elseif($value1['publisher_status']==modelAppPubManager::STATUS_DISAPPROVED){
						$disapproved++;
					}
				}
			}
			$arr[]=["username"=>$value,"approved"=>$approved,"disapproved"=>$disapproved];
		}
		
		$this->data['lists']=$arr;
		return View::make('ajaxShowList',$this->data);
	}
	///
}