<?php


class CampaignPublisherController extends PublisherBackendController 
{
	const DEFINE_CPM='cpm';
	const DEFINE_CPC='cpc';

	public function __construct(CampaignPublisherModel $model) {
		parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
		$this->model = $model;
		
	}

	/**
	 *     List item of module
	 */
	function showList(){
		$this->data['defaultField'] = $this->defaultField;
		$this->data['defaultOrder'] = $this->defaultOrder;
		$this->data['defaultURL'] 	= $this->moduleURL;
		$this->data['CPM']=self::DEFINE_CPM;
		$this->data['CPC']=self::DEFINE_CPC;

		$this->data['countCPM']=$this->model->getSearchCampaign([['value'=>'cpm']])
		->where('flight_website.website_id',$this->getPublisher()->id)->count();
		
		$this->data['countCPC']=$this->model->getSearchCampaign([['value'=>'cpc']])
		->where('flight_website.website_id',$this->getPublisher()->id)->count();

		if( method_exists($this, 'beforeShowList') ){
			$this->beforeShowList();
		}
		$this->layout->content = View::make('showList', $this->data);
	}

	/**
	 *     Handle Ajax list item of module
	 */
	function getList(){		
		if(Request::ajax()){
			$defaultField 	= "campaign.".Input::get('defaultField');
			$defaultOrder 	= Input::get('defaultOrder');
			$searchData 	= Input::get('searchData');
			$showNumber 	= Input::get('showNumber');
			$isReset 		= Input::get('isReset');

			$this->data['defaultField'] = str_replace("campaign.", "", $defaultField);
			$this->data['defaultOrder'] = $defaultOrder;
			$this->data['defaultURL'] 	= $this->moduleURL;
			$this->data['showField'] 	= $this->model->getShowField();

			if( $isReset == 1 ){
				Paginator::setCurrentPage(1);
			}
			//pr($userCurrent,1);
			$this->data['lists'] = $this->model->getSearchCampaign($searchData)
			->select('campaign.*','category.name as cate_name','advertiser.name as name_advertiser','flight_website.publisher_base_cost')
			->where('flight_website.website_id',$this->getPublisher()->id)
			->orderBy($defaultField,$defaultOrder)->paginate($showNumber);
		
			return View::make('ajaxShowList', $this->data);
		}
	}

	/*----------------------------- CREATE & UPDATE --------------------------------*/
	function showUpdate($id = 0){
		$this->data['id'] = $id;

		// WHEN UPDATE SHOW CURRENT INFOMATION
		if( $id != 0 ){
			$item = $this->model->find($id);
			if( $item ){
				$this->data['item'] 		= $item;
			}else{
				return Redirect::to($this->moduleURL.'show-list');
			}
		}

		if (Request::isMethod('post'))
		{
			if( $this->postUpdate($id, $this->data) ){
				return $this->redirectAfterSave(Input::get('save'));
			}
		}

		$this->layout->content = View::make('showUpdate', $this->data);

	}

	function postUpdate($id = 0, &$data){

		// check validate
		$validate 		= Validator::make(Input::all(), $this->model->getUpdateRules(), $this->model->getUpdateLangs());

		if( $validate->passes() ){

			$slug = Str::slug(Input::get('title'));

			$updateData = array(
				'status'		=>	(int) Input::get('status'),
				'is_promotion'	=>	(int) Input::get('is_promotion'),
				'title'			=>	Input::get('title'),
				'slug'			=>	$slug
			);

 
			if( $id == 0 ){ // INSERT

				if( $item = $this->model->create($updateData) ){
					$data['id'] 		= $item->id;
					return TRUE;
				}

			}else{ // UPDATE

				// GET CURRENT ITEM
				$item = $this->model->find($id);

				if( $item ){

					if( $this->model->where("id",$id)->update($updateData) ){
						return TRUE;
					}
				}
			}

		}else{
			$data['validate'] = $validate->messages();
		}

		return FALSE;

	}
	/*----------------------------- END CREATE & UPDATE --------------------------------*/


	/*----------------------------- DELETE --------------------------------*/

	function delete(){

		if( Request::ajax() ){
			$id 	= Input::get('id');
			$item 	= $this->model->find($id);
			if( $item ){
				if($item->delete()){
					return "success";
				}
			}
		}
		return "fail";

	}

	
	//
	function changeBooleanType(){

		if( Request::ajax() ){
			$id 			= Input::get('id');
			$field 			= Input::get('field');
			$value 			= Input::get('value');
			$setValue		= ($value == 0) ? 1 : 0;
			$setText		= ($value == 0) ? "Reject" : "Accepted";
			$setClass		= ($value == 0) ? "text-warning" : "text-success";
			$setClassI		= ($value == 0) ? "glyphicon glyphicon-remove" : "glyphicon glyphicon-ok";

			$item = $this->model->find($id);
			if( $item ){
				$item->{$field} = $value;
				if( $item->save() ){
					return '<a href="javascript:;" class="'.$setClass.'" onclick="changeBooleanType('.$id.', '.$setValue.','."'".$field."'".')">
					<span class="'.$setClassI.'"></span> '.$setText.'
					</a>';
				}
			}
		}

	}
	//comment campaign
	public function commentCampaign(){
		$idCampaign=Input::get('id_campaign');
		$valueComment=Input::get('comment');
		$arrComment=commentCampaign();

		if($valueComment==-1){
			$comment=Input::get('orther-comment');
		}else
			$comment=$arrComment[$valueComment];

		$dataUpdate=[
			"campaign_id"=>$idCampaign,
			"comment"=>$comment
			];
		$item=CampaignCommentBaseModel::create($dataUpdate);	
		if($item) return 1;
		else return 0;
	}
	/*----------------------------- END DELETE --------------------------------*/

}