<?php
Route::group(array('before' => 'basicAuth', 'prefix'    => Config::get('backend.uri').'/'.Config::get('backend.group_advertiser_manager_url') ),function(){
    Route::group(array('prefix' => 'flight' ),function() {
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
        // order
        Route::get('order/{id}',        array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowOrder','uses' =>  $prefixName.'Controller@showOrder'));
        Route::post('saveOrder',        array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'SaveOrder','uses' =>  $prefixName.'Controller@saveOrder'));
        //--Select Publisher
        Route::get('select-website/{id}',        array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowSelectWebsite','uses' =>  $prefixName.'Controller@ShowSelectWebsite'));
        //--Update
        Route::get('update/{id}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'ShowUpdate','uses' =>  $prefixName.'Controller@showUpdate'));
        Route::post('update/{id}',  array('before' =>   'hasPermissions:'.$prefixSlug.'-edit|csrf','as'   =>  $prefixName.'ShowUpdate','uses' =>  $prefixName.'Controller@showUpdate'));
        //--Delete
        Route::post('delete',       array('before' =>   'hasPermissions:'.$prefixSlug.'-delete','as'    =>  $prefixName.'Delete','uses' =>  $prefixName.'Controller@delete'));
        Route::post('flightdatedelete',       array('before' =>   'hasPermissions:'.$prefixSlug.'-delete','as'    =>  $prefixName.'FlightDateDelete','uses' =>  $prefixName.'Controller@flightdatedelete'));

        //-- Modal
        Route::post('updateWebiste',       array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'   =>  $prefixName.'ShowUpdateWebsite','uses' =>  $prefixName.'Controller@updateWebsite'));
        Route::post('addAllWebsite',       array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'   =>  $prefixName.'ShowAddAllWebsite','uses' =>  $prefixName.'Controller@addAllWebsite'));
        Route::post('deleteWebsite',       array('before' =>   'hasPermissions:'.$prefixSlug.'-delete','as'   =>  $prefixName.'DeleteWebsite','uses' =>  $prefixName.'Controller@deleteWebsite'));
        Route::post('loadModal',    array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'   =>  $prefixName.'LoadModal','uses' =>  $prefixName.'Controller@loadModal'));
        
        Route::get('add-date/{mode}/{index}',        array('before' =>   'hasPermissions:'.$prefixSlug.'-create','as'    =>  $prefixName.'showUpdateDateInfo','uses' =>  $prefixName.'Controller@showUpdateDateInfo'));
        Route::post('change-status',        array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'ChangeStatus','uses' =>  $prefixName.'Controller@changeStatus'));
        Route::post('website-change-status',        array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'WebsiteChangeStatus','uses' =>  $prefixName.'Controller@websiteChangeStatus'));
        //renew cache
        Route::post('renew-cache/{id}',  array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'   =>  $prefixName.'renewCache','uses' =>  $prefixName.'Controller@renewCache'));
        Route::post('renew-cache-website/{id}',  array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'   =>  $prefixName.'RenewCacheFlightWebsite','uses' =>  $prefixName.'Controller@renewCacheFlightWebsite'));
        
    });
});
