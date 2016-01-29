<?php
Route::pattern('idu', '[0-9]+');
Route::group(array('before' => 'basicAuth', 'prefix'    => Config::get('backend.uri').'/'.Config::get('backend.group_advertiser_manager_url') ),function(){
    $prefixName = Str::studly(pathinfo(__DIR__, PATHINFO_BASENAME));
    $prefixSlug = Str::snake($prefixName,'-');    

    Route::get('/tool',     array('as'  =>  $prefixName.'ShowTool','uses'   =>  $prefixName.'Controller@tool'));
    Route::post('/tool/search',     array('uses'   =>  $prefixName.'Controller@getListSelect'));
    //profile publisher
    Route::get('/tool/profile',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'Profile','uses' =>  $prefixName.'Controller@myProfile'));
    Route::post('/tool/profile',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'Profile','uses' =>  $prefixName.'Controller@myProfile'));

    Route::post('/tool/get-list',     array('as'  =>  $prefixName.'GetList','uses'   =>  $prefixName.'Controller@getList'));
 
    Route::post('/tool/get-user', array('as'  =>  $prefixName.'GetUser','uses'   =>  $prefixName.'Controller@getUserId'));
    Route::get('/tool/user-manager',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'UserManager','uses' =>  $prefixName.'Controller@userManager'));

    Route::get('/tool/list-publisher',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'ShowListPublisher','uses'   =>  $prefixName.'Controller@showListPublisher'));

    Route::post('/tool/get-list-publisher',     array('as'  =>  $prefixName.'GetListPublisher','uses'   =>  $prefixName.'Controller@getListPublisherManager'));
    
    Route::get('/tool/user-edit/{idu}',     array('as'  =>  $prefixName.'ShowUpdate','uses'   =>  $prefixName.'Controller@myProfile'));
    Route::post('/tool/user-edit/{idu}',     array('as'  =>  $prefixName.'ShowUpdate','uses'   =>  $prefixName.'Controller@myProfile'));

    Route::post('/tool/sort-flight-running',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'SortFlightRunning','uses' =>  $prefixName.'Controller@sortFlightRunning'));
    Route::post('/tool/update-sort-flight-running',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'UpdateSortFlightRunning','uses' =>  $prefixName.'Controller@postSortFlightRunning'));
    
    Route::post('/tool/preview',     array('as'  =>  $prefixName.'Preview','uses'   =>  $prefixName.'Controller@preview'));
    Route::get('/tool/dashboard',     array('as'  =>  $prefixName.'Preview','uses'   =>  $prefixName.'Controller@getDashboard'));
    Route::post('/tool/dashboard/campaign',     array('as'  =>  $prefixName.'PreviewCampaign','uses'   =>  $prefixName.'Controller@getDashboardCampaign'));
    Route::post('/tool/dashboard/flightwebsite',     array('as'  =>  $prefixName.'PreviewFlightWebsite','uses'   =>  $prefixName.'Controller@getDashboardFilghtWebsite'));

    Route::get('/tool/create-new-url-track',   array('as' =>  $prefixName.'CreateNew', 'uses' =>  $prefixName.'Controller@createNewTrackURL'));
    Route::post('/tool/create-new-url-track',   array('as' =>  $prefixName.'CreateNew', 'uses' =>  $prefixName.'Controller@createNewTrackURl'));
    Route::get('/tool/url-track-ga',   array('as' =>  $prefixName.'URLTrackGA', 'uses' =>  $prefixName.'Controller@getUrlTrackGA'));
    Route::get('/tool/edit-url-track/{id}',   array('as' =>  $prefixName.'Edit', 'uses' =>  $prefixName.'Controller@editTrackURL'));
    Route::post('/tool/edit-url-track/{id}',   array('as' =>  $prefixName.'Edit', 'uses' =>  $prefixName.'Controller@editTrackURL'));
    Route::get('/tool/detail-url-track/{id}',   array('as' =>  $prefixName.'DetailUrlTrack', 'uses' =>  $prefixName.'Controller@detailTrackURL'));
    Route::post('/tool/delete-url-track',       array('as'    =>  $prefixName.'Delete','uses' =>  $prefixName.'Controller@deleteTrackURL'));
    
    //Report ad request
    Route::get('/tool/report-adrequest',   array('as' =>  $prefixName.'ReportAdRequest', 'uses' =>  $prefixName.'Controller@getReportAdRequest'));
    Route::post('/tool/show-report-adrequest',   array('as' =>  $prefixName.'ShowReportAdRequest', 'uses' =>  $prefixName.'Controller@showReportAdRequest'));
    Route::post('/tool/report-adrequest-hour',   array('as' =>  $prefixName.'ReportAdRequestHour', 'uses' =>  $prefixName.'Controller@reportAdRequestHour'));
    Route::post('/tool/get-adzone',   array('as' =>  $prefixName.'GetAdZone', 'uses' =>  $prefixName.'Controller@getAdZone'));
    
    /*
     * Added by Phan Minh Hoàng
     */
    Route::get('/tool/stats',   array('as' =>  $prefixName.'stats', 'uses' =>  $prefixName.'Controller@stats'));
    Route::any('/tool/get-campaigns',   array('as' =>  $prefixName.'GetCampaigns', 'uses' =>  $prefixName.'Controller@getCampaigns'));
    Route::any('/tool/get-flights',   array('as' =>  $prefixName.'GetFlights', 'uses' =>  $prefixName.'Controller@getFlights'));
    Route::any('/tool/get-websites',   array('as' =>  $prefixName.'GetWebsites', 'uses' =>  $prefixName.'Controller@getWebsites'));
    Route::any('/tool/show-stats',array('as'=>$prefixName.'ShowStats','uses'=>$prefixName.'Controller@showStats'));
    Route::any('/tool/export-stats',   array('as' =>  $prefixName.'ExportStats', 'uses' =>  $prefixName.'Controller@exportStats'));
});
