<?php

class ExportExcelPublisherController extends PublisherBackendController {

    public function __construct() {
        parent::__construct(pathinfo(dirname(__DIR__), PATHINFO_BASENAME));
    }

    //get invoice publisher
    public function getExportExcel() {

        if($_SESSION["dataEX"]){
            $this->dataEX['lists']      =$_SESSION["dataEX"];
            $this->dataEX['siteName']   =$_SESSION["dataSiteName"];
            $this->dataEX['date']       =$_SESSION["dataDate"];
        }
        else return Redirect::to(Route('ReportPublisherShowList'));

        $excel=App::make('excel');
        $name='report-earnings-'.date('d-m-Y H:i:s');
        Excel::create($name, function($excel) {
            $excel->sheet('Publisher Advanced Report', function($sheet) {
                $sheet->loadView('viewExcel',$this->dataEX);
            });
        })->export('xlsx'); 
        return View::make('viewExcel')->with('lists',$this->dataEX);
    }

}
