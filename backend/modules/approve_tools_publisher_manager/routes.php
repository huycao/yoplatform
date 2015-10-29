<?php
Route::group(array('before' => 'basicAuth', 'prefix'    => Config::get('backend.uri').'/publisher-manager' ),function(){


    Route::group(array('prefix' => 'approve-tools' ),function() {
        $prefixName = Str::studly(pathinfo(__DIR__, PATHINFO_BASENAME));
        $prefixSlug = Str::snake($prefixName,'-');
        //--Show List
        Route::get('/',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'ShowList','uses'   =>  $prefixName.'Controller@showList'));
        //-------manager user---------//
        
        //show list user & get list user
        Route::get('users-list',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'ShowUserList','uses'   =>  $prefixName.'Controller@showUserList'));
        Route::post('get-list',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'GetList','uses'    =>  $prefixName.'Controller@getListUser'));
        //--Delete user
        Route::post('delete',       array('before' =>   'hasPermissions:'.$prefixSlug.'-delete','as'    =>  $prefixName.'Delete','uses' =>  $prefixName.'Controller@deleteUser'));
        //--Create
        Route::get('create',        array('before' =>   'hasPermissions:'.$prefixSlug.'-create','as'    =>  $prefixName.'ShowCreate','uses' =>  $prefixName.'Controller@showUpdateUser'));
        Route::post('create',       array('before' =>   'hasPermissions:'.$prefixSlug.'-create|csrf','as'   =>  $prefixName.'ShowCreate','uses' =>  $prefixName.'Controller@showUpdateUser'));
        //--Update
        Route::get('update/{id}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'ShowUpdate','uses' =>  $prefixName.'Controller@showUpdateUser'));
        Route::post('update/{id}',  array('before' =>   'hasPermissions:'.$prefixSlug.'-edit|csrf','as'   =>  $prefixName.'ShowUpdate','uses' =>  $prefixName.'Controller@showUpdateUser'));
        //--Update Status
        Route::post('changeBooleanType', array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'ChangeBooleanType','uses'   =>  $prefixName.'Controller@changeStatusUser'));
        //profile publisher
        Route::get('profile',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'Profile','uses' =>  $prefixName.'Controller@myProfile'));
        Route::post('profile',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'Profile','uses' =>  $prefixName.'Controller@myProfile'));
        //--------end manager user--------//
        Route::any('payment-request/{status}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'PaymentRequest','uses' =>  $prefixName.'Controller@paymentRequest'));
        Route::get('payment-request-detail/{id}',   array('as' =>  $prefixName.'PaymentRequestDetail',  'uses' =>  $prefixName.'Controller@paymentRequestDetail'));
        Route::post('changeStatusPaymentRequest',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as' =>  $prefixName.'ChangeStatusPaymentRequest','uses' =>  $prefixName.'Controller@changeStatusPaymentRequest'));
        Route::get('export-payment-request/{id}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as' =>  $prefixName.'ExportExcelPaymentDetail','uses' =>  $prefixName.'Controller@exportExcelPaymentDetail'));

    });
});
