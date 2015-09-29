<?php

class LogsAdvertiserManagerController extends AdvertiserManagerController {

    public function __construct(LogsBaseModel $model) {
        parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
        $this->model = $model;
        $this->loadLeftMenu('menu.tool');
    }


    public function getListData() {
        $this->data['lists'] = $this->model
            ->search($this->searchData)
            ->orderBy($this->defaultField, $this->defaultOrder)
            ->paginate($this->showNumber);
    }
    public function showDelete($id) {
        $item = $this->model->find($id);
        if ($item) {
            if ($item->delete()) {

            }
        }
        return Redirect::to($this->moduleURL . 'show-list');
    }

}
