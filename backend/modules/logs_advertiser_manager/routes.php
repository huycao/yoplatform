<?php
Route::group(array('before' => 'basicAuth', 'prefix'    => Config::get('backend.uri').'/'.Config::get('backend.group_advertiser_manager_url') ),function(){
    Route::group(array('prefix' => 'logs' ),function() {
        $prefixName = Str::studly(pathinfo(__DIR__, PATHINFO_BASENAME));
        $prefixSlug = Str::snake($prefixName,'-');
        //--Show List
        Route::get('show-list',     array('as'  =>  $prefixName.'ShowList','uses'   =>  $prefixName.'Controller@showList'));
        Route::post('get-list',     array('as'  =>  $prefixName.'GetList','uses'    =>  $prefixName.'Controller@getList'));
        Route::get('delete/{id}',   array('as'    =>  $prefixName.'ShowDelete','uses' =>  $prefixName.'Controller@showDelete'));
        Route::post('delete/{id}',  array('as'   =>  $prefixName.'ShowDelete','uses' =>  $prefixName.'Controller@showDelete'));
	//--Revert
        Route::get('revert/{id}',     array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'  =>  $prefixName.'ShowRevert','uses'   =>  $prefixName.'Controller@revert'));
    });
}); 