<?php
Route::group(array('before' => 'basicAuth', 'prefix'    => Config::get('backend.uri').'/'.Config::get('backend.group_advertiser_manager_url') ),function(){
    Route::group(array('prefix' => 'website' ),function() {
        $prefixName = Str::studly(pathinfo(__DIR__, PATHINFO_BASENAME));
        $prefixSlug = Str::snake($prefixName,'-');        

        //--Show List
        Route::get('show-list',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'ShowList','uses'   =>  $prefixName.'Controller@showList'));
        Route::post('get-list',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'GetList','uses'    =>  $prefixName.'Controller@getList'));
        //--Create
        Route::get('create',        array('before' =>   'hasPermissions:'.$prefixSlug.'-create','as'    =>  $prefixName.'ShowCreate','uses' =>  $prefixName.'Controller@showUpdate'));
        Route::post('create',       array('before' =>   'hasPermissions:'.$prefixSlug.'-create|csrf','as'   =>  $prefixName.'ShowCreate','uses' =>  $prefixName.'Controller@showUpdate'));
        Route::post('saveOrder',        array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'SaveOrder','uses' =>  $prefixName.'Controller@saveOrder'));
        //--View
        Route::get('view/{id}',        array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowView','uses' =>  $prefixName.'Controller@showView'));
        //--Update
        Route::get('update/{id}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'ShowUpdate','uses' =>  $prefixName.'Controller@showUpdate'));
        Route::post('update/{id}',  array('before' =>   'hasPermissions:'.$prefixSlug.'-edit|csrf','as'   =>  $prefixName.'ShowUpdate','uses' =>  $prefixName.'Controller@showUpdate'));

        Route::get('cost/{id}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'ShowCost','uses' =>  $prefixName.'Controller@showCost'));
        Route::post('cost/{id}',  array('before' =>   'hasPermissions:'.$prefixSlug.'-edit|csrf','as'   =>  $prefixName.'ShowCost','uses' =>  $prefixName.'Controller@showCost'));
        //--Delete
        Route::post('delete',       array('before' =>   'hasPermissions:'.$prefixSlug.'-delete','as'    =>  $prefixName.'Delete','uses' =>  $prefixName.'Controller@delete'));
         
        Route::get('select-flight/{id}',        array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowSelectFlight','uses' =>  $prefixName.'Controller@ShowSelectFlight'));
        
          //-- Modal
        Route::post('updateFlight',       array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'   =>  $prefixName.'ShowUpdateFlight','uses' =>  $prefixName.'Controller@updateFlight'));
        Route::post('deleteFlight',       array('before' =>   'hasPermissions:'.$prefixSlug.'-delete','as'   =>  $prefixName.'DeleteFlight','uses' =>  $prefixName.'Controller@deleteFlight'));
        Route::post('loadModal',    array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'   =>  $prefixName.'LoadModal','uses' =>  $prefixName.'Controller@loadModal'));

        Route::post('updateCost',       array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'   =>  $prefixName.'ShowUpdateCost','uses' =>  $prefixName.'Controller@updateCost'));
        Route::post('loadModalCost',    array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'   =>  $prefixName.'LoadModalCost','uses' =>  $prefixName.'Controller@loadModalCost'));


    });
});
