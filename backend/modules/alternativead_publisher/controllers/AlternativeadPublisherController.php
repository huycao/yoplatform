<?php

class AlternativeadPublisherController extends PublisherBackendController {

    public function __construct(AlternateAdBaseModel $model) {
        parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
        $this->model = $model;
    }

    
    function getList() {

        if (Request::ajax()) {
            $defaultField = Input::get('defaultField');
            $defaultOrder = Input::get('defaultOrder');
            $searchData = Input::get('searchData');
            $showNumber = Input::get('showNumber');
            $isReset = Input::get('isReset');

            $this->data['defaultField'] = $defaultField;
            $this->data['defaultOrder'] = $defaultOrder;
            $this->data['defaultURL'] = $this->moduleURL;
            $this->data['showField'] = $this->model->getShowField();

            if ($isReset == 1) {
                Paginator::setCurrentPage(1);
            } 
             $this->data['items'] =  $this->model->where('publisher_id',$this->getPublisher()->id)->get();
            return View::make('ajaxShowList', $this->data);
        }
    }

    /* ----------------------------- CREATE & UPDATE -------------------------------- */

    function showUpdate($id = 0) {
        $this->data['id'] = $id;

        // WHEN UPDATE SHOW CURRENT INFOMATION
        if ($id != 0) {
            $item = $this->model->whereRaw('id = :id AND publisher_id = :publisher_id', array($id,$this->getPublisher()->id))->first();
            if ($item) {
                $this->data['item'] = $item;
            } else {
                return Redirect::to($this->moduleURL);
            }
        }

        if (Request::isMethod('post')) {
            if ($this->postUpdate($id, $this->data)) {
                 return $this->redirectAfterSave(Input::get('save'));
            }
        }

        $this->layout->content = View::make('showUpdate', $this->data);
    }

    function postUpdate($id = 0, &$data) {

        // check validate
        $validate = Validator::make(Input::all(), $this->model->getUpdateRules(), $this->model->getUpdateLangs());

        if ($validate->passes()) {
 
            $updateData = array(
                'name' => Input::get('name'),
                'url' => Input::get('url'),
                'ad_format_id' =>(int)  Input::get('ad_format_id'), 
               'publisher_id' => $this->getPublisher()->id,
            );
 
            if ($id == 0) { // INSERT
                if ($item = $this->model->create($updateData)) {
                    $data['id'] = $item->id;
                    Session::flash('flash-message', 'Create Alternative Ad Success !');
                    return TRUE;
                }
            } else { // UPDATE
                // GET CURRENT ITEM
                $item = $this->model->find($id);

                if ($item) {
                    if ($this->model->where("id", $id)->update($updateData)) {
                        Session::flash('flash-message', 'Update Alternative Ad Success !');
                        return TRUE;
                    }
                }
            }
           
        } else {
            $data['validate'] = $validate->messages();
        }
         Session::put('Error', 'Save Failed !');
        return FALSE;
    }

    /* ----------------------------- END CREATE & UPDATE -------------------------------- */


    /* ----------------------------- DELETE -------------------------------- */

    function delete() {

        if (Request::ajax()) {
            $id = Input::get('id');
            $item = $this->model->find($id);
            if ($item) {
                if ($item->delete()) {
                    return "success";
                }
            }
        }
        return "fail";
    }

    /* ----------------------------- END DELETE -------------------------------- */
     function redirectAfterSave($type) {
        switch ($type) {
            case 'save-return':
                return Redirect::to($this->moduleURL);
                break;

            case 'save-new':
                return Redirect::to($this->moduleURL . 'create');
                break;

            case 'save':
                return Redirect::to($this->moduleURL . 'update/' . $this->data['id']);
                break;

            default:
                return Redirect::to($this->moduleURL);
                break;
        }
    }
}
