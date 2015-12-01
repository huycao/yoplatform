<?php
/* GLOBAL PATTERN
==========================================*/
App::down(function(){ return "Maintaining";});
Route::pattern('id', '\d+');
Route::pattern('username', '[a-z0-9_.]+');
Route::pattern('slug', '[a-zA-Z0-9-]+');

/* END GLOBAL PATTERN
==========================================*/




/* BACKEND ROUTES
==========================================*/

/*
* Logged routes without permission
*/

Route::group(array('before' => 'basicAuth',	'prefix'    => Config::get('backend.uri') ),function(){
    Route::get('advertiser-manager',                  array('as'  =>  'AdvertiserManagerIndex'          ,'uses' =>  'AdvertiserManagerController@index'));
    Route::get('advertiser-manager/dashboard',        array('as'  =>  'AdvertiserManagerDashboard'      ,'uses' =>  'DashboardAdvertiserManagerController@showIndex'));
    Route::get('advertiser-manager/logout',           array('as'  =>  'AdvertiserManagerLogout'         ,'uses' =>  'AdvertiserManagerController@logout'));
    Route::get('advertiser-manager/access-denied',    array('as'  =>  'AdvertiserManagerAccessDenied'   ,'uses' =>  'AdvertiserManagerController@getAccessDenied'));

    Route::get('advertiser',                          array('as'  =>  'AdvertiserIndex'                 ,'uses' =>  'AdvertiserController@index'));
    Route::get('advertiser/dashboard',                array('as'  =>  'AdvertiserDashboard'             ,'uses' =>  'DashboardAdvertiserController@showIndex'));
    Route::get('advertiser/logout',                   array('as'  =>  'AdvertiserLogout'                ,'uses' =>  'AdvertiserController@logout'));
    Route::get('advertiser/access-denied',            array('as'  =>  'AdvertiserAccessDenied'          ,'uses' =>  'AdvertiserController@getAccessDenied'));

    Route::get('publisher-manager', 			      array('as'  =>  'PublisherManagerIndex'           ,'uses' =>  'PublisherManagerController@index'));
    Route::get('publisher-manager/approve',           array('as'  =>  'PublisherManagerDashboard'       ,'uses' =>  'ApprovePublisherManagerController@showList'));
    Route::post('publisher-manager/show-list',        array('as'  => 'PublisherManagershowListDashboard'       ,'uses' =>  'DashboardPublisherManagerController@showListDashboard'));
    Route::get('publisher-manager/logout',            array('as'  =>  'PublisherManagerLogout'          ,'uses' =>  'PublisherManagerController@logout'));
    Route::get('publisher-manager/access-denied',     array('as'  =>  'PublisherManagerAccessDenied'    ,'uses' =>  'PublisherManagerController@getAccessDenied'));

    Route::get('publisher',                           array('as'  =>  'PublisherIndex'                  ,'uses' =>  'PublisherBackendController@index'));
    Route::get('publisher/dashboard',                 array('as'  =>  'PublisherDashboard'              ,'uses' =>  'DashboardPublisherController@showIndex'));
    Route::post('publisher/show-list',                 array('as'  =>  'PublishershowListDashboard'              ,'uses' =>  'DashboardPublisherController@showListDashboard'));
    Route::get('publisher/logout',                    array('as'  =>  'PublisherLogout'                 ,'uses' =>  'PublisherBackendController@logout'));
    Route::get('publisher/access-denied',             array('as'  =>  'PublisherAccessDenied'           ,'uses' =>  'PublisherBackendController@getAccessDenied'));

    Route::get('admin',                               array('as'  =>  'AdminIndex'                      ,'uses' =>  'AdminController@index'));
    Route::get('admin/dashboard',                     array('as'  =>  'AdminDashboard'                  ,'uses' =>  'DashboardAdminController@showIndex'));
    Route::get('admin/logout',                        array('as'  =>  'AdminLogout'                     ,'uses' =>  'AdminController@logout'));
    Route::get('admin/access-denied', 	              array('as'  =>  'AdminAccess'                     ,'uses' =>  'AdminController@getAccessDenied'));
});

/*
* Unlogged routes
*/
Route::group(array('before' => 'notAuth', 'prefix'  => Config::get('backend.uri') ),function(){

    Route::get('advertiser-manager/login',    array('as'  =>  'AdvertiserManagerLogin'    ,'uses'   =>  'AdvertiserManagerController@login'));
    Route::post('advertiser-manager/login',   array('before' => 'csrf','as'  =>  'AdvertiserManagerLogin'    ,'uses'   =>  'AdvertiserManagerController@login'));

    Route::get('advertiser/login',              array('as'  =>  'AdvertiserLogin'           ,'uses'   =>  'AdvertiserController@login'));
    Route::post('advertiser/login',             array('before' => 'csrf','as'  =>  'AdvertiserLogin'           ,'uses'   =>  'AdvertiserController@login'));

    Route::get('publisher-manager/login',       array('as'	=>  'PublisherManagerLogin'     ,'uses'   =>  'PublisherManagerController@login'));
    Route::post('publisher-manager/login',      array('before' => 'csrf','as'	=>  'PublisherManagerLogin'     ,'uses'   =>  'PublisherManagerController@login'));

    Route::get('publisher/login',               array('as'  =>  'PublisherLogin'            ,'uses'   =>  'PublisherBackendController@login'));
    Route::post('publisher/login',              array('before' => 'csrf','as'  =>  'PublisherLogin'            ,'uses'   =>  'PublisherBackendController@login'));

    Route::get('admin/login',                   array('as'	=>  'AdminLogin'                ,'uses'   =>  'AdminController@login'));
    Route::post('admin/login',                  array('before' => 'csrf','as'	=>  'AdminLogin'                ,'uses'   =>  'AdminController@login'));

});


/* 
==========================================*/



/* FRONTEND
==========================================*/


Route::get('delivery', 'DeliveryController@adsProcess');
Route::get('delivery/ova', 'DeliveryController@makeOva');
Route::get('make-vast',    'DeliveryController@makeVast');
Route::get('vast',    'DeliveryController@adsProcess');
Route::get('track', 'DeliveryController@trackEvent');
Route::get('reportScheduleHourly', function(){
    // return '';
    // pr( Cache::get('Report:Schedule') );
    $cacheKey      = "Report:Schedule:Hourly";
    $tracking = new RawTrackingSummary;
    if($rows = $tracking->reportScheduleHourly()){
        // $cacheKey = "Report:Schedule";
        // Cache::forget($cacheKey);
        pr($rows);
        echo "Report Success";
    }
    else{
        echo "No Report Complete";
    }
    die();
});

Route::get('updateReport', function(){  
    $date = Input::get('date', '');
    $hour = Input::get('hour', '');
    $arrHour = array();
    $tracking = new RawTrackingSummary;
    if ('' != $date) {
        if ('' != $hour) {
            $created_h = strtotime("{$date} {$hour}:00:00");
            if($rows = $tracking->updateReportHour($created_h)){
                echo "Report Success: ". $rows;
            } else{
                echo "No Report Complete";
            }
        } else {
            $created = strtotime($date);
            if($rows = $tracking->reportScheduleDaily($created)){
                echo "Report Success: ". $rows;
            } else{
                echo "No Report Complete";
            }
        }
    }
    die();
});

Route::get('reportScheduleDaily', function(){
    // return '';
    // pr( Cache::get('Report:Schedule') );
    $tracking = new RawTrackingSummary;
    if($rows = $tracking->reportScheduleDaily()){
        // $cacheKey = "Report:Schedule";
        // Cache::forget($cacheKey);
        pr($rows);
        echo "Report Success";
    }
    else{
        echo "No Report Complete";
    }
    die();
});

Route::group(array('prefix'    => 'demo' ), function(){
    View::addLocation(base_path() .'/backend/theme/default/views/demo');
    View::addLocation(base_path() .'/frontend/theme/default/views/home');

    Route::get('jwplayer6/vast',     function(){
        return View::make('demoJWplayer6');
    });
    Route::get('jwplayer5/vast',     function(){
        return View::make('demoJWplayer5');
    });

    Route::get('tvc','HomeController@demoTVC');
    Route::get('run-vast-support', 'HomeController@demoVast');
    Route::get('run-popup', 'HomeController@demoPopup');
    Route::get('balloon', 'HomeController@demoBalloon');
    Route::get('pause-vast', 'HomeController@demoPauseVast');
    Route::get('sidekicknew', 'HomeController@demoSidekick');
	
    
});


Route::get('remonth', function(){
    set_time_limit(0);
    $a = new RawTrackingSummary();
    $days = Input::get('d', 0);
    $perRequest = 5;
    for ($i=0; $i < $perRequest; $i++) { 
        $j = $days + $i;
        pr(date('d-m-Y', strtotime("-$j days")));
        $a->reportScheduleDaily(strtotime("-$j days"));
    }
    $days += $perRequest;
    return Redirect::to(URL::to('remonth?d=' . $days));
});

Route::get('hour', function(){
    // return '';
    // pr( Cache::get('Report:Schedule') );
    $cacheKey   = "Report_Schedule_Hourly";
    $cacheField = "hourly_1";
    RedisHelper::hdel($cacheKey, $cacheField);
    $tracking = new RawTrackingSummary;
    if($rows = $tracking->reportScheduleHourly()){
        // $cacheKey = "Report:Schedule";
        // Cache::forget($cacheKey);
        pr($rows);
        echo "Report Success";
    }
    else{
        echo "No Report Complete";
    }
    die();
});


Route::get('today', function(){
    $a = new RawTrackingSummary();
    pr($a->reportScheduleDaily(time()));
});
Route::get('yesterday', function(){
    $a = new RawTrackingSummary();
    pr($a->reportScheduleDaily(strtotime('-1 day')));
});

Route::get('reportConversionDaily', function(){
    $tracking = new RawTrackingConversion;
    $data = $tracking->reportConversionDaily();
    pr($data);
});

Route::get('reportConversionHourly', function(){
    $tracking = new RawTrackingConversion;
    $data = $tracking->reportConversionHourly();
    pr($data);
});

Validator::extend('variable', function($field,$value,$parameters){
    if (!empty($value)) {
        foreach ($value as $item) {
            if(!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $item)) {
                return false;
            }
        }
    }
    return true;
});

Route::get('mDelKey', function(){
    set_time_limit(0);
    $keys = Input::get('key');
    if (!empty($keys)) {
        RedisHelper::delMKey($keys);
    }
    pr('complete');
});

Route::get('reportAudience', function(){
    $tracking = new RawTrackingAudience;
    $data = $tracking->reportAudience();
    pr($data);
});