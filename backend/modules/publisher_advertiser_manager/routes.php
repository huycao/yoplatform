<?php
Route::group(array('before' => 'basicAuth', 'prefix'    => Config::get('backend.uri').'/'.Config::get('backend.group_advertiser_manager_url') ),function(){
    Route::group(array('prefix' => 'publisher' ),function() {
        $prefixName = Str::studly(pathinfo(__DIR__, PATHINFO_BASENAME));
        $prefixSlug = Str::snake($prefixName,'-');        

        //--Show List
        Route::get('show-list',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'ShowList','uses'   =>  $prefixName.'Controller@showList'));
        Route::post('get-list',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'GetList','uses'    =>  $prefixName.'Controller@getList'));
        //--Create
        Route::get('create',        array('before' =>   'hasPermissions:'.$prefixSlug.'-create','as'    =>  $prefixName.'ShowCreate','uses' =>  $prefixName.'Controller@showUpdate'));
        Route::post('create',       array('before' =>   'hasPermissions:'.$prefixSlug.'-create|csrf','as'   =>  $prefixName.'ShowCreate','uses' =>  $prefixName.'Controller@showUpdate'));
        Route::post('saveOrder',        array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'SaveOrder','uses' =>  $prefixName.'Controller@saveOrder'));

        Route::get('{pid}/create-site',        array('before' =>   'hasPermissions:'.$prefixSlug.'-create','as'    =>  $prefixName.'ShowCreateSite','uses' =>  $prefixName.'Controller@showUpdateSite'));
        Route::post('{pid}/create-site',       array('before' =>   'hasPermissions:'.$prefixSlug.'-create|csrf','as'   =>  $prefixName.'ShowCreateSite','uses' =>  $prefixName.'Controller@showUpdateSite'));
        
        Route::get('{pid}/update-site/{id}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'ShowUpdateSite','uses' =>  $prefixName.'Controller@showUpdateSite'));
        Route::post('{pid}/update-site/{id}',  array('before' =>   'hasPermissions:'.$prefixSlug.'-edit|csrf','as'   =>  $prefixName.'ShowUpdateSite','uses' =>  $prefixName.'Controller@showUpdateSite'));
        
        Route::get('{pid}/show-list-site',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'ShowListSite','uses'   =>  $prefixName.'Controller@showListSite'));
        Route::get('{pid}/view-site/{id}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'ShowViewSite','uses' =>  $prefixName.'Controller@showViewSite'));

        Route::get('{pid}/del-site/{id}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-delete','as'    =>  $prefixName.'ShowDelSite','uses' =>  $prefixName.'Controller@showDelSite'));

        Route::get('{pid}/view-site/{wid}/create-zone',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'ShowCreateZone','uses' =>  $prefixName.'Controller@showUpdateZone'));
        Route::post('{pid}/view-site/{wid}/create-zone',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'ShowCreateZone','uses' =>  $prefixName.'Controller@showUpdateZone'));
        
        Route::get('{pid}/view-site/{wid}/update-zone/{zid}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'ShowUpdateZone','uses' =>  $prefixName.'Controller@showUpdateZone'));
        Route::post('{pid}/view-site/{wid}/update-zone/{zid}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'ShowUpdateZone','uses' =>  $prefixName.'Controller@showUpdateZone'));
        
        Route::get('{pid}/view-site/{wid}/get-code/{zid}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowGetCode','uses' =>  $prefixName.'Controller@showGetCode'));
        Route::get('{pid}/view-site/{wid}/save-code/{zid}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'SaveGetCode','uses' =>  $prefixName.'Controller@saveGetCode'));

        //--View
        Route::get('view/{id}',        array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowView','uses' =>  $prefixName.'Controller@showView'));
        Route::get('review/{id}',        array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ReviewPublisher','uses' =>  $prefixName.'Controller@reviewPublisher'));
        //--Update
        Route::get('payment-request/{id}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'PaymentRequest','uses' =>  $prefixName.'Controller@paymentRequest'));
        Route::get('payment-request-detail/{id}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'PaymentRequestDetail','uses' =>  $prefixName.'Controller@paymentRequestDetail'));
        // Route::post('update/{id}',  array('before' =>   'hasPermissions:'.$prefixSlug.'-edit|csrf','as'   =>  $prefixName.'ShowUpdate','uses' =>  $prefixName.'Controller@showUpdate'));
        //--Delete
        Route::post('delete',       array('before' =>   'hasPermissions:'.$prefixSlug.'-delete','as'    =>  $prefixName.'Delete','uses' =>  $prefixName.'Controller@delete'));
         
        Route::get('select-flight/{id}',        array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowSelectFlight','uses' =>  $prefixName.'Controller@ShowSelectFlight'));
        
          //-- Modal
        Route::post('updateFlight',       array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'   =>  $prefixName.'ShowUpdateFlight','uses' =>  $prefixName.'Controller@updateFlight'));
        Route::post('deleteFlight',       array('before' =>   'hasPermissions:'.$prefixSlug.'-delete','as'   =>  $prefixName.'DeleteFlight','uses' =>  $prefixName.'Controller@deleteFlight'));
        Route::post('loadModal',    array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'   =>  $prefixName.'LoadModal','uses' =>  $prefixName.'Controller@loadModal'));
        Route::post('loadModalAlternateAd',    array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'   =>  $prefixName.'LoadModalAlternateAd','uses' =>  $prefixName.'Controller@loadModalAlternateAd'));
        Route::post('updateAlternateAd',    array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'   =>  $prefixName.'UpdateAlternateAd','uses' =>  $prefixName.'Controller@UpdateAlternateAd'));
        Route::post('deleteAlternateAd',       array('before' =>   'hasPermissions:'.$prefixSlug.'-delete','as'   =>  $prefixName.'DeleteAlternateAd','uses' =>  $prefixName.'Controller@DeleteAlternateAd'));
        
        //-- Phuong-VM - 2015/05/03
        Route::post('list-flight',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'ShowListFlight','uses' =>  $prefixName.'Controller@showListFlight'));
        Route::post('change-status',        array('before' =>   'hasPermissions:'.$prefixSlug.'-create','as'    =>  $prefixName.'changeStatus','uses' =>  $prefixName.'Controller@changeStatus'));
        Route::get('{fwid}/preview/{id}',        array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowPreview','uses' =>  $prefixName.'Controller@showPreview'));
        Route::get('previewVast/{id}',        array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowPreviewVast','uses' =>  $prefixName.'Controller@previewVast'));
        // Report publiser
        Route::get('report',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'Report','uses'   =>  $prefixName.'Controller@report'));
        Route::post('report',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'ReportPost','uses'   =>  $prefixName.'Controller@report'));
        Route::any('reportExport',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'ReportExport','uses'   =>  $prefixName.'Controller@reportExport'));
        Route::get('ut',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'Ut','uses'   =>  $prefixName.'Controller@updateTrackingSumary'));
    });
});
