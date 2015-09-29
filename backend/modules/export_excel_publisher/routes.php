<?php
Route::group(array('prefix'    => Config::get('backend.uri').'/publisher' ),function(){

    Route::group(array('prefix' => 'export'),function() {
        $prefixName = Str::studly(pathinfo(__DIR__, PATHINFO_BASENAME));
        $prefixSlug = Str::snake($prefixName,'-');
        
       Route::get('export-excel', array('as'  =>  $prefixName.'getExportExcel','uses'   =>  $prefixName.'Controller@getExportExcel'));
      
    });
});
