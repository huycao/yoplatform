<?php
Route::group(array('before' => 'basicAuth', 'prefix'    => Config::get('backend.uri').'/publisher' ),function(){

    Route::group(array('prefix' => 'payment'),function() {
        $prefixName = Str::studly(pathinfo(__DIR__, PATHINFO_BASENAME));
        $prefixSlug = Str::snake($prefixName,'-');

        //--Show List
        Route::get('/',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'ShowList','uses'   =>  $prefixName.'Controller@showList'));
        Route::post('/',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'ShowList','uses'   =>  $prefixName.'Controller@showList'));
        Route::post('get-list',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'GetList','uses'    =>  $prefixName.'Controller@getList'));
        Route::post('get-pdf',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'GetPdf','uses'    =>  $prefixName.'Controller@getPdf'));
        Route::get('get-pdf',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'GetPdf','uses'    =>  $prefixName.'Controller@getPdf'));
        //get invoice
        Route::get('get-invoice',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'GetInvoice','uses'   =>  $prefixName.'Controller@getInvoice'));
        //showe payment info
        Route::get('payment-info',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'PaymentInfo','uses'   =>  $prefixName.'Controller@showPaymentInfo'));
      
    });
});
