<?php
Route::group(array('before' => 'basicAuth', 'prefix'    => Config::get('backend.uri').'/'.Config::get('backend.group_advertiser_manager_url') ),function(){
    Route::group(array('prefix' => 'contact' ),function() {
        $prefixName = Str::studly(pathinfo(__DIR__, PATHINFO_BASENAME));
        $prefixSlug = Str::snake($prefixName,'-');

        Route::post('update',       array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'   =>  $prefixName.'ShowUpdate','uses' =>  $prefixName.'Controller@update'));
        Route::post('delete',       array('before' =>   'hasPermissions:'.$prefixSlug.'-delete','as'   =>  $prefixName.'Delete','uses' =>  $prefixName.'Controller@delete'));
        Route::post('loadModal',    array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'   =>  $prefixName.'LoadModal','uses' =>  $prefixName.'Controller@loadModal'));

    });
});
