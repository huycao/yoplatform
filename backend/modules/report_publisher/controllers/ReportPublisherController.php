 <?php

class ReportPublisherController extends PublisherBackendController {

    public function __construct(ReportEarningsPublisherModel $model) {   
        parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
        $this->model = $model;
    }

    public function beforeGetList(){
        $this->data['showField'] = array(
            'name'         =>  array(
                'label'         =>  'Title',
                'type'          =>  'text'
            ),
            'amount'         =>  array(
                'label'         =>  'Amount',
                'type'          =>  'text'
            ),
            'total_impression'         =>  array(
                'label'         =>  'Impression',
                'type'          =>  'text',
            ),
            'total_unique_impression'  =>  array(
                'label'         =>  'Unique Impression',
                'type'          =>  'text'
            ),
            'total_click'  =>  array(
                'label'         =>  'Click',
                'type'          =>  'text'
            ),
            'frequency'  =>  array(
                'label'         =>  'Frequency',
                'type'          =>  'text'
            ),
            'ctr'  =>  array(
                'label'         =>  'CTR',
                'type'          =>  'text'
            ),
            'ecpm'  =>  array(
                'label'         =>  'eCPM',
                'type'          =>  'text'
            )
        );
    }

    public function getListData(){
        $websiteRange = $this->getPublisher()->publisherSite->lists('id');
        $this->data['lists'] = $this->model->search($this->searchData, $websiteRange)
                                           ->orderBy($this->defaultField, $this->defaultOrder)
                                           ->paginate($this->showNumber);
    }


}

