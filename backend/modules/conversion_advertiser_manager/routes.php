<?php

Route::group(array('before' => 'basicAuth', 'prefix'    => Config::get('backend.uri').'/'.Config::get('backend.group_advertiser_manager_url') ),function(){
    Route::group(array('prefix' => 'conversion' ),function() {
        $prefixName = Str::studly(pathinfo(__DIR__, PATHINFO_BASENAME));
        $prefixSlug = Str::snake($prefixName,'-');
        //--Show List
        Route::get('show-all',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'ShowList','uses'   =>  $prefixName.'Controller@showList'));
        Route::get('{camp}/show-list',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'ShowList','uses'   =>  $prefixName.'Controller@showList'));
        //Route::get('list',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'ShowList','uses'   =>  $prefixName.'Controller@showList'));
        Route::post('{camp}/get-list',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'GetList','uses'    =>  $prefixName.'Controller@getList'));
        //--Create
        Route::get('{camp}/create',        array('before' =>   'hasPermissions:'.$prefixSlug.'-create','as'    =>  $prefixName.'ShowCreate','uses' =>  $prefixName.'Controller@showUpdate'));
        Route::post('{camp}/create',       array('before' =>   'hasPermissions:'.$prefixSlug.'-create|csrf','as'   =>  $prefixName.'ShowCreate','uses' =>  $prefixName.'Controller@showUpdate'));
        //--View
        Route::get('{camp}/view/{id}',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowView','uses' =>  $prefixName.'Controller@showView'));
        //--Update
        Route::get('{camp}/update/{id}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'ShowUpdate','uses' =>  $prefixName.'Controller@showUpdate'));
        Route::post('{camp}/update/{id}',  array('before' =>   'hasPermissions:'.$prefixSlug.'-edit|csrf','as'   =>  $prefixName.'ShowUpdate','uses' =>  $prefixName.'Controller@showUpdate'));
        //-- Change status of conversion
        Route::post('change-status',        array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'ChangeStatus','uses' =>  $prefixName.'Controller@changeStatus'));
        //-- Renew cache of conversion
        Route::post('{camp}/renew-cache/{id}',  array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'   =>  $prefixName.'renewCache','uses' =>  $prefixName.'Controller@renewCache'));
        //-- Save code of conversion
        Route::get('{camp}/save-code/{id}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'SaveCode','uses' =>  $prefixName.'Controller@saveCode'));
    });
});
