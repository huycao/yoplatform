<?php

class AdzonePublisherController extends PublisherBackendController {

    public function __construct(PublisherAdZoneBaseModel $model) {
        parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
        $this->model = $model;
    }

    function getAdFormat() {
        return AdFormatBaseModel::all();
    }

    function getAlternate() {
        return AdFormatBaseModel::all();
    }

    function getAlternateAd() {
        if (Request::ajax()) {
            $id = $_POST['id'];
            $dataaltads = $_POST['data'];
            $atl = new AlternateAdBaseModel();
            $atl = $atl->where('ad_format_id', $id);
            $atl = $atl->where('publisher_id', $this->getPublisher()->id);
            $this->data['item'] = $atl->get();
            $this->data['dataaltads'] = $_POST['data'];
            return View::make('ajaxShowAltenateAd', $this->data);
        }
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

            $this->data['siteLists'] = $this->getPublisher()->publisherSite;
            return View::make('ajaxShowList', $this->data);
        }
    }

    /* ----------------------------- CREATE & UPDATE -------------------------------- */

    function showUpdate($id = 0) {

        $this->data['id'] = $id;
        $this->data['listaltenatead'] = array();
        // WHEN UPDATE SHOW CURRENT INFOMATION
        if ($id != 0) {

            $item = $this->model->find($id);

            if (isset($item->id)) {
                $this->data['item'] = $item;

                $this->data['listaltenatead'] = AlternateAdBaseModel::where('ad_format_id', $item->ad_format_id)->get();
            } else {
                return Redirect::to($this->moduleURL);
            }
        }
        $this->data['listzone'] = $this->getPublisher()->publisherSite;
        $this->data['listadformat'] = $this->getAdFormat();


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
                'publisher_site_id' => Input::get('publisher_site_id'),
                'platform' => Input::get('platform'),
                'ad_format_id' => Input::get('ad_format_id'),
                'adplacement' => Input::get('adplacement', 0),
                'alternateadtype' => Input::get('alternateadtype', 0),
                'alternatead' => json_encode(Input::get('selected_alternatead')),
                'publisher_id' => $this->getPublisher()->id,
                'element_id' => Input::get('element_id', ''),
                'width' => Input::get('width', 0),
                'height' => Input::get('height', 0),
            );
            
            if ($id == 0) { // INSERT 
                if ($item = $this->model->create($updateData)) {
                    $data['id'] = $item->id;
                    Session::flash('flash-message', 'Create Ad Zone Success !');
                    return TRUE;
                }
            } else { // UPDATE
                // GET CURRENT ITEM
                $item = $this->model->find($id);

                if ($item) {

                    if ($this->model->where("id", $id)->update($updateData)) {
                        (new Delivery())->renewCache('adzone', $id);
                        Session::flash('flash-message', 'Update Ad Zone Success !');
                        return TRUE;
                    }
                }
            }
        } else {
            $data['validate'] = $validate->messages();
        }

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
                    (new Delivery())->renewCache('adzone', $id);
                    return "success";
                }
            }
        }
        return "fail";
    }

    /* ----------------------------- END DELETE -------------------------------- */
    /* ----------------------------- TAGS -------------------------------- */

    function showTags($id = null) {
        $item = $this->model
                    ->where('id', $id)->first();

        if( $item ){

            $view = Config::get("ad_format_code.$item->ad_format_id");
            $data['wid'] = $item->publisher_site_id;
            $data['zid'] = $id;
            $data['el_id'] = $item->element_id;
            $data['width'] = $item->width;
            $data['height'] = $item->height;

            $this->data['code'] = View::make($view, $data)->render();
            $this->data['item'] = $item;

            $this->layout->content = View::make('showTags', $this->data);
        }


    }

    /* ----------------------------- END TAGS -------------------------------- */

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
