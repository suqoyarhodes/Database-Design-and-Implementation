<?php

try{

    $serverName = 'csc471f21rhodessuqoya.database.windows.net';
    $connectionOptions = [
        'Database' => 'vaccinesf21',
        'Uid' => '',
        'PWD' => ''
    ];
    //Generating conection string to connect to sql server
    $connection  = sqlsrv_connect($serverName, $connectionOptions);
    if($connection)
        echo "connected";

    echo json_encode($connection);
}catch(Exception $e){
    throw new Exception($e->getMessage());   // Exception handled if any error
}

?>
