<?php
class MyFTP {
	const FILE_READ_MODE  = 0644;
	const FILE_WRITE_MODE = 0666;
	const DIR_READ_MODE   = 0755;
	const DIR_WRITE_MODE  = 0777;

	public $ftpCon = '';

	public function __construct($connection = ''){
		if($connection)
			$this->ftpCon = Ftp::connection($connection);
		else
			$this->ftpCon = Ftp::connection();
	}
    function checkExtension($file){
        $type = strtolower(substr($file, strrpos($file, '.'), strlen($file)));
        if ($type == ".png" || $type == ".jpeg"  || $type == ".jpg" || $type == ".gif" || $type == ".swf" || $type == ".mp4" || $type == ".flv" || $type == ".xml") {
            return true;
        }
        return false;
    }
	function uploadFtp($dirUpload,$tmpFile, $fileName, $chmodFolder = '', $chmodFile = ''){

        if(!$this->checkExtension($fileName)){
            return false;
        } 
        if($dirUpload == ""){
            $dirUpload = date("Y").'/'.date("m").'/';
        }
        $isDir = $this->ftpCon->getDirListing($dirUpload);
        if(empty($isDir)){
            if(!$this->makeDirs($dirUpload, $chmodFolder)){
                return false;
            }
        }
        if($this->ftpCon->uploadFile($tmpFile, $dirUpload.$fileName)){
            if($chmodFile != '')
                  $this->ftpCon->permission($chmodFile, $dirUpload.$fileName);
             return true;
        }
	    return false;
	}
	function makeDirs($ftpPath = '', $chmod){
		$chmod = $chmod == '' ? self::DIR_WRITE_MODE : $chmod;
	   	if($ftpPath){
	   		$parts = explode('/',$ftpPath); // 2013/06/11/username
	   		$dir = "";
		   	foreach($parts as $part){
		   		$dir .= "/" . $part;
		   		// pr($this->ftpCon->getDirListing($dir));
	      		if(!$this->ftpCon->getDirListing($dir)){
			        $this->makeDir($dir, $chmod);
	      		}
		   }
		   return true;
	   	}
	   	else
	   	return false;
	}

	public function makeDir($directory, $chmod = '')
    {
    	$chmod = $chmod == '' ? self::DIR_WRITE_MODE : $chmod;
        if ($this->ftpCon->makeDir($directory)){
        	$this->ftpCon->permission($chmod, $directory);
            return true;
        }
        else
            return false;
    }

 	public function deleteFile($file){
 		if( !empty($file) ){
 			if($file['0'] != "/"){
 				$file = "/".$file;
 			}
	 		if( $this->ftpCon->size($file) > 0 ){
	 			return $this->ftpCon->delete($file);
	 		}else{
	 			return FALSE;
	 		} 		
	 	}
	 	return FALSE;
 	}

 	public function rename($remoteFile, $newFile){
 		return $this->ftpCon->rename($remoteFile, $newFile);
 	}

 	public function disconnect(){
 		return $this->ftpCon->disconnect();
 	}

 	public function size($remoteFile){
 		return $this->ftpCon->size($remoteFile);
 	}
}