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

    'default' => 'connection1',

    /*
    |--------------------------------------------------------------------------
    | FTP Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the FTP connections setup for your application.
    |
    */

    'connections' => array(

        'connection1' => array(
            'host'   => 'export.bonotel.com/TravelLinked/PromotionV1/',
            'port'  => 21,
            'username' => 'TravelLinked_export',
            'password'   => 't5Mj2rrHuY7AsKd',
            'passive'   => false,
        ),
    ),



);


