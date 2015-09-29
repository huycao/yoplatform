<?php
return array(

    /*
	|--------------------------------------------------------------------------
	| Default FTP Connection Name
	|--------------------------------------------------------------------------
	|
	| Here you may specify which of the FTP connections below you wish
	| to use as your default connection for all ftp work.
	|
	*/

    'default' => 'yostatic',

    /*
    |--------------------------------------------------------------------------
    | FTP Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the FTP connections setup for your application.
    |
    */

    'connections' => array(
        'yostatic' => array(
            'host'     => '221.132.35.175',
            'port'     => 21,
            'username' => 'yostatic',
            'password' => '3edc$RFV',
            'passive'  => true,
        )
    ),
);