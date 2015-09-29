<?php

class ConversionAdvertiserManagerController extends AdvertiserManagerController {

    public function __construct(ConversionBaseModel $model) {
        parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
        $this->model = $model;
        $this->loadLeftMenu('menu.tool');
    }

    /**
     *     trigger before show list render view
     */
    function beforeShowList($camp = 0) {
        View::share('jsTag', HTML::script("{$this->assetURL}js/select.js"));
    }
    
    function showList($campaignID = 0){
        $this->data['defaultField'] = $this->defaultField;
		$this->data['defaultOrder'] = $this->defaultOrder;
        $this->data['defaultURL'] 	= $this->moduleURL . "{$campaignID}/";
        $this->data['campaignID'] 	= $campaignID;
        
        if( method_exists($this, 'beforeShowList') ){
			$this->beforeShowList();
		}
		
		$this->loadLeftMenu('menu.conversionList');
        $this->layout->content = View::make('showList', $this->data);
    }

    public function getListData() {
        $this->data['lists'] = $this->model->with('campaign')
                                   ->search($this->searchData)
                                   ->orderBy($this->defaultField, $this->defaultOrder)
                                   ->paginate($this->showNumber);
        
    }

    /**
     *     add/update agency
     *     @param  integer $id
     */
    function showUpdate($campaignID = 0, $id = 0) {
        $this->data['campaign'] = CampaignBaseModel::find($campaignID);
        
        if (Request::isMethod('get')) {
            $arrWhere = array(
                'campaign_id' => $campaignID,
                'id'		  => $id
            );
            $this->data['data'] = $this->model->where($arrWhere)->first();
        } else {
            if ($this->postUpdate($campaignID, $id)) {
                return Redirect::to("{$this->moduleURL}{$campaignID}/view/{$this->data['id']}");
            }
        }
        
        if ($campaignID && $id) {
            $this->loadLeftMenu('menu.conversionUpdate');
        } else {
            $this->loadLeftMenu('menu.conversionList');
        }

        $this->layout->content = View::make('showUpdate', $this->data);
    }

    /**
     *     handle form add/update agency
     *     @param  integer $id
     */
    function postUpdate($campaignID = 0, $id = 0) {
        $validate = Validator::make(Input::all(), $this->model->getUpdateRules($campaignID, $id), $this->model->getUpdateLangs());

        if ($validate->passes()) {
            $updateData = array(
                'name'		    => Input::get('name'),
            	'status'		=> Input::get('status'),
                'campaign_id'	=> Input::get('campaign_id'),
                'param'		    => json_encode(Input::get('param')),
                'source'		=> Input::get('source'),
                'updated_by'	=> $this->user->id
            );
            if (0 == $id) {
                $updateData['created_by'] = $this->user->id;
                if ($item = $this->model->create($updateData)) {
                    $this->data['id'] = $item->id;
                    (new Delivery())->renewCache('conversion', $item->id);
                    return TRUE;
                }
            } else {
                $item = $this->model->find($id);
                if ($item) {
                    $this->data['id'] = $item->id;
                    if ($item->update($updateData)) {
                        (new Conversion())->renewCache('conversion', $item->id);
                        return TRUE;
                    }
                }
            }
        } else {
            $this->data['errors'] = $validate->messages();
        }
        
        return FALSE;
    }
    
    function showView($campaignID = 0, $id = 0) {
        $this->loadLeftMenu('menu.conversionList', array('campaignID' => $campaignID));
        $arrWhere = array(
            'campaign_id' => $campaignID,
            'id'		  => $id
        );
        
        $this->data['data'] = $this->model->where($arrWhere)->with('campaign')->first();

        if ($campaignID && $id) {
            $this->loadLeftMenu('menu.conversionView');
        } else {
            $this->loadLeftMenu('menu.conversionList');
        }
        $this->layout->content = View::make('showView', $this->data);
    }
    
    function changeStatus(){
		if( Request::ajax() ){
			$id = Input::get('id');
			$currentStatus = Input::get('status');
            $status = ($currentStatus) ? 0 : 1;

			$item = $this->model->find($id);

			if( $item ){
				$item->status = $status;
			    if( $item->save() ){
			        $dataLog = array(
                        'title'     => 'Change Status Flight ID: ' . $item->id,
                        'content'   => json_encode(array('status'=>$status)),
                        'type_task' => Request::segment(4)
                    );
                    
                    $this->inputLogs($dataLog);
                    
                    (new Conversion())->renewCache('conversion', $item->id);
                    
					return View::make('ajaxChangeStatus', compact('item'));
				}
			}
		}

		return "fail";
	}
	
    function renewCache($campaignID, $id){
        if (Request::ajax()) {
            if($id){
                (new Conversion())->renewCache('conversion', $id);

                return "success";
            }
        }

        return "fail";

    }
    
    function saveCode($campaignID, $id) {
        $this->data['data'] = $this->model->find($id);

        if ($this->data['data']) {
            if (!empty($this->data['data']->param)) {
                $this->data['data']->param = json_decode($this->data['data']->param);
            }
            
            $contents = View::make('conversionSaveCode', $this->data);
            $response = Response::make($contents, '200');
            $filename = str_replace(' ' , '_', (strtolower($this->data['data']->name)));
            $response->header('Content-Description', 'File Transfer');
            $response->header('Content-Type', 'application/octet-stream');
            $response->header('Content-Disposition', "attachment; filename={$filename}.txt");
            $response->header('Content-Transfer-Encoding', 'binary');
            $response->header('Expires', '0');
            $response->header('Cache-Control', 'must-revalidate');
            $response->header('Pragma', 'public');

            return $response;
        }

    }
}
