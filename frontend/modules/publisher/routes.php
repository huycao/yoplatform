<?php

Route::group(array('prefix'  => 'publisher/' ),function(){
	Route::get('register', array('as'     =>  'PublisherRegisterPage','uses'   =>  'PublisherController@register'));
	Route::post('register', array('as'    =>  'PublisherRegisterPage','uses'   =>  'PublisherController@register'));
});

