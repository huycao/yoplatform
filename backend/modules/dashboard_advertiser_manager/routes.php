<?php
Route::group(array('before' => 'basicAuth', 'prefix'    => Config::get('backend.uri').'/'.Config::get('backend.group_advertiser_manager_url') ),function(){

    Route::group(array('prefix' => 'dashboard' ),function() {
        $prefixName = Str::studly(pathinfo(__DIR__, PATHINFO_BASENAME));
        $prefixSlug = Str::snake($prefixName,'-');
        Route::get('/',     array('as'  =>  $prefixName.'ShowIndex','uses'    =>  $prefixName.'Controller@showIndex'));
        Route::post('/get-list',     array('as'  =>  $prefixName.'ShowDashboard','uses'    =>  $prefixName.'Controller@getDashboard'));
	    Route::post('loadLastCampaignChart',     array('as'  =>  $prefixName.'loadLastCampaignChart','uses'    =>  $prefixName.'Controller@loadLastCampaignChart'));
	    Route::get('publisher',     array('as'  =>  $prefixName.'ShowPublisher','uses'    =>  $prefixName.'Controller@showPublisher'));
	    Route::post('publisher',     array('as'  =>  $prefixName.'ShowPublisher','uses'    =>  $prefixName.'Controller@showPublisher'));
    });


});
