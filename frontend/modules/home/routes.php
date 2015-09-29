<?php
	Route::get('/', array('as'     =>  'HomePage','uses'   =>  'HomeController@index'));
	Route::get('/publisher', array('as'     =>  'PublicsherPage','uses'   =>  'HomeController@publisher'));
	Route::get('/advertisers', array('as'     =>  'AdvertisersPage','uses'   =>  'HomeController@advertiser'));
	Route::get('/about-us', array('as'     =>  'AboutUsPage','uses'   =>  'HomeController@aboutUs'));
	Route::get('/contact-us', array('as'     =>  'ContactUsPage','uses'   =>  'HomeController@contactUs'));

	Route::any('/contact-info', array('as'     =>  'ContactInfoPage','uses'   =>  'HomeController@contactInfo'));
	Route::get('/videos', array('as'     =>  'VideoPage','uses'   =>  'HomeController@video'));
