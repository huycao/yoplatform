<?php
Route::group(array('before' => 'basicAuth', 'prefix'    => Config::get('backend.uri').'/'.Config::get('backend.group_advertiser_manager_url') ),function(){
    Route::group(array('prefix' => 'campaign' ),function() {
        $prefixName = Str::studly(pathinfo(__DIR__, PATHINFO_BASENAME));
        $prefixSlug = Str::snake($prefixName,'-');        
        //--Show List
        Route::get('show-list',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'ShowList','uses'   =>  $prefixName.'Controller@showList'));
        Route::post('get-list',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'GetList','uses'    =>  $prefixName.'Controller@getList'));
        //--Create
        Route::get('create',        array('before' =>   'hasPermissions:'.$prefixSlug.'-create','as'    =>  $prefixName.'ShowCreate','uses' =>  $prefixName.'Controller@showUpdate'));
        Route::post('create',       array('before' =>   'hasPermissions:'.$prefixSlug.'-create|csrf','as'   =>  $prefixName.'ShowCreate','uses' =>  $prefixName.'Controller@showUpdate'));
        //--View
        Route::get('view/{id}',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowView','uses' =>  $prefixName.'Controller@showView'));
        //--Report
        Route::get('report/flight',   array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowFlightReport','uses' =>  $prefixName.'Controller@showFlightReport'));
        
        Route::get('reportExport',       array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'   =>  $prefixName.'ReportExport','uses' =>  $prefixName.'Controller@reportExport'));
        // Report date detail
        Route::post('report/datedetail',       array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ReportDate','uses' =>  $prefixName.'Controller@getReportDateDetail'));
        // Report date website detail
        Route::post('report/datewebsitedetail',       array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ReportDateWebsite','uses' =>  $prefixName.'Controller@getReportDateWebsiteDetail'));

        Route::get('report/{id}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowReport','uses' =>  $prefixName.'Controller@showReport'));        
        Route::post('report/{id}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowReport','uses' =>  $prefixName.'Controller@showReport'));
        
        //--Update
        Route::get('update/{id}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'ShowUpdate','uses' =>  $prefixName.'Controller@showUpdate'));
        Route::post('update/{id}',  array('before' =>   'hasPermissions:'.$prefixSlug.'-edit|csrf','as'   =>  $prefixName.'ShowUpdate','uses' =>  $prefixName.'Controller@showUpdate'));
        //--Delete
        Route::post('delete',       array('before' =>   'hasPermissions:'.$prefixSlug.'-delete','as'    =>  $prefixName.'Delete','uses' =>  $prefixName.'Controller@delete'));
        
        //-- Conversion
        Route::get('report-conversion/{id}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowReportConversion','uses' =>  $prefixName.'Controller@showReportConversion'));  
        Route::get('report/conversion/{id}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowReportConversionDetail','uses' =>  $prefixName.'Controller@showReportConversionDetail'));
        Route::post('report/conversion-date',       array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ReportConversionDate','uses' =>  $prefixName.'Controller@getReportConversionDate'));
        Route::post('list-report-conversion',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'GetListRePortConversion','uses'    =>  $prefixName.'Controller@getListReportConversion'));   
        Route::get('reportExportConversion',       array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'   =>  $prefixName.'ReportExportConversion','uses' =>  $prefixName.'Controller@reportExportConversion'));
        Route::get('export-audience/{bid}',       array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'   =>  $prefixName.'ReportExportAudience','uses' =>  $prefixName.'Controller@reportExportAudience'));
    });
});
