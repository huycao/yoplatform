<?php

class RpconversionAdvertiserManagerController extends AdvertiserManagerController {

    public function __construct(TrackingConversionBaseModel $model) {
        parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
        $this->model = $model;
    }

    /**
     *     trigger before show list render view
     */
    function beforeShowList($camp = 0) {
        View::share('jsTag', HTML::script("{$this->assetURL}js/select.js"));
    }
    
    function showList(){
        $this->layout->content = View::make('showList', $this->data);
    }

    public function getListData() {
        $this->data['lists'] = $this->model->search($this->searchData)
                                   ->orderBy($this->defaultField, $this->defaultOrder)
                                   ->paginate($this->showNumber);
                                  
       return $this->data['lists'];
    }
}
