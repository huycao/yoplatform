<?php

Route::get('/track', array('as'	=>	'TrackingAd', 'uses'	=>	'TrackingController@track'));
Route::get('/rt', array('as'	=>	'TrackingAd', 'uses'	=>	'DeliveryController@retargeting'));
Route::get('/testrt', array('as'	=>	'TrackingAd', 'uses'	=>	'DeliveryController@retargetingtest'));