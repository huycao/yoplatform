<?php
Route::group(array('before' => 'basicAuth', 'prefix'    => Config::get('backend.uri').'/publisher' ),function(){

    Route::group(array('prefix' => 'campaign'),function() {
        $prefixName = Str::studly(pathinfo(__DIR__, PATHINFO_BASENAME));
        $prefixSlug = Str::snake($prefixName,'-');

        //--Show List
        Route::get('/',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'ShowList','uses'   =>  $prefixName.'Controller@showList'));
        Route::post('get-list',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'GetList','uses'    =>  $prefixName.'Controller@getList'));
        //--Create
        Route::get('create',        array('before' =>   'hasPermissions:'.$prefixSlug.'-create','as'    =>  $prefixName.'ShowCreate','uses' =>  $prefixName.'Controller@showUpdate'));
        Route::post('create',       array('before' =>   'hasPermissions:'.$prefixSlug.'-create|csrf','as'   =>  $prefixName.'ShowCreate','uses' =>  $prefixName.'Controller@showUpdate'));
        //--Update
        Route::get('update/{id}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'ShowUpdate','uses' =>  $prefixName.'Controller@showUpdate'));
        Route::post('update/{id}',  array('before' =>   'hasPermissions:'.$prefixSlug.'-edit|csrf','as'   =>  $prefixName.'ShowUpdate','uses' =>  $prefixName.'Controller@showUpdate'));
        //--Update Status
        Route::post('changeBooleanType', array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'ChangeBooleanType','uses'   =>  $prefixName.'Controller@changeBooleanType'));
        //--Delete
        Route::post('delete',       array('before' =>   'hasPermissions:'.$prefixSlug.'-delete','as'    =>  $prefixName.'Delete','uses' =>  $prefixName.'Controller@delete'));

        //view campaign
        Route::get('view/{id}',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'ShowView','uses'    =>  $prefixName.'Controller@showView'));
        //comment campaign
        Route::post('comment-campaign',  array('before' =>   'hasPermissions:'.$prefixSlug.'-edit|csrf','as'   =>  $prefixName.'CommnetCampaign','uses' =>  $prefixName.'Controller@commentCampaign'));
    });
});
