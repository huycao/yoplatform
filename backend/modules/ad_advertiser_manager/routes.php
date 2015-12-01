<?php
Route::group(array('before' => 'basicAuth', 'prefix'    => Config::get('backend.uri').'/'.Config::get('backend.group_advertiser_manager_url') ),function(){
    Route::group(array('prefix' => 'ad' ),function() {
        $prefixName = Str::studly(pathinfo(__DIR__, PATHINFO_BASENAME));
        $prefixSlug = Str::snake($prefixName,'-');        

        //--Show List
        Route::get('show-list',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'ShowList','uses'   =>  $prefixName.'Controller@showList'));
        Route::post('get-list',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'GetList','uses'    =>  $prefixName.'Controller@getList'));
        //--Create
        Route::get('create',        array('before' =>   'hasPermissions:'.$prefixSlug.'-create','as'    =>  $prefixName.'ShowCreate','uses' =>  $prefixName.'Controller@showUpdate'));
        Route::post('create',       array('before' =>   'hasPermissions:'.$prefixSlug.'-create|csrf','as'   =>  $prefixName.'ShowCreate','uses' =>  $prefixName.'Controller@showUpdate'));
        //--View
        Route::get('view/{id}',        array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowView','uses' =>  $prefixName.'Controller@showView'));
        Route::get('preview/{id}',        array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowPreview','uses' =>  $prefixName.'Controller@showPreview'));
        Route::get('previewVast/{id}',        array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowPreviewVast','uses' =>  $prefixName.'Controller@previewVast'));

        Route::get('clone/{id}',        array('before' =>   'hasPermissions:'.$prefixSlug.'-create','as'    =>  $prefixName.'ShowClone','uses' =>  $prefixName.'Controller@showClone'));
        Route::post('clone/{id}',        array('before' =>   'hasPermissions:'.$prefixSlug.'-create','as'    =>  $prefixName.'ShowClone','uses' =>  $prefixName.'Controller@postClone'));
        
        //--Update
        Route::get('update/{id}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'ShowUpdate','uses' =>  $prefixName.'Controller@showUpdate'));
        Route::post('update/{id}',  array('before' =>   'hasPermissions:'.$prefixSlug.'-edit|csrf','as'   =>  $prefixName.'ShowUpdate','uses' =>  $prefixName.'Controller@showUpdate'));
        //--Delete
        Route::post('delete',       array('before' =>   'hasPermissions:'.$prefixSlug.'-delete','as'    =>  $prefixName.'Delete','uses' =>  $prefixName.'Controller@delete'));
         
        Route::get('select-flight/{id}',        array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowSelectFlight','uses' =>  $prefixName.'Controller@ShowSelectFlight'));
        
          //-- Modal
        Route::post('updateFlight',       array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'   =>  $prefixName.'ShowUpdateFlight','uses' =>  $prefixName.'Controller@updateFlight'));
        Route::post('deleteFlight',       array('before' =>   'hasPermissions:'.$prefixSlug.'-delete','as'   =>  $prefixName.'DeleteFlight','uses' =>  $prefixName.'Controller@deleteFlight'));
        Route::post('loadModal',    array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'   =>  $prefixName.'LoadModal','uses' =>  $prefixName.'Controller@loadModal'));
        //renew cache
        Route::post('renew-cache/{id}',  array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'   =>  $prefixName.'RenewCache','uses' =>  $prefixName.'Controller@renewCache'));

        //list audiences
        Route::get('show-list-audiences/{id}',       array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'   =>  $prefixName.'ShowListAudiences','uses' =>  $prefixName.'Controller@showListAudiences'));
        Route::post('get-list-audiences/{id}',       array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'   =>  $prefixName.'GetListAudiences','uses' =>  $prefixName.'Controller@getListAudiences'));
        Route::get('show-create-audience/{id}',      array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'   =>  $prefixName.'ShowCreateAudience', 'uses'=>$prefixName.'Controller@showCreateAudience'));
        Route::post('show-create-audience/{id}',      array('before' =>   'hasPermissions:'.$prefixSlug.'-create|csrf','as'   =>  $prefixName.'ShowCreateAudience', 'uses'=>$prefixName.'Controller@showCreateAudience'));
        Route::get('show-update-audience/{id}',       array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'   =>  $prefixName.'ShowUpdateAudience','uses' =>  $prefixName.'Controller@showUpdateAudience'));
        Route::post('show-update-audience/{id}',       array('before' =>   'hasPermissions:'.$prefixSlug.'-edit|csrf','as'   =>  $prefixName.'ShowUpdateAudience','uses' =>  $prefixName.'Controller@showUpdateAudience'));

    });
});
