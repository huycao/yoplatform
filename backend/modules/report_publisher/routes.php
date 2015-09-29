<?php
Route::pattern('id', '[0-9]+');
Route::group(array('before' => 'basicAuth', 'prefix'    => Config::get('backend.uri').'/publisher' ),function(){

    Route::group(array('prefix' => 'report'),function() {
        $prefixName = Str::studly(pathinfo(__DIR__, PATHINFO_BASENAME));
        $prefixSlug = Str::snake($prefixName,'-');

        //--Show List
        Route::get('/',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'ShowList','uses'   =>  $prefixName.'Controller@showList'));
        Route::get('/{id}',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'ShowListId','uses'   =>  $prefixName.'Controller@showList'));
        Route::post('get-list',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'GetList','uses'    =>  $prefixName.'Controller@getList'));
       ///show report
        Route::post('get-report',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'GetReport','uses'    =>  $prefixName.'Controller@getReport'));
        //get export
        Route::post('get-export',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'GetExport','uses'    =>  $prefixName.'Controller@GetExport'));
        //get
        Route::get('export-pdf',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'getExportPDF','uses'   =>  $prefixName.'Controller@getExportPDF'));


        
    });
});
