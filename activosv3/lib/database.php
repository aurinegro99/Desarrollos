<?php

$db_host        = "CVWDSQL12";
$db_name        = "Activo_Fijo";

$connectionInfo = array( "Database"=>"Activo_Fijo", "UID"=>"contrato", "PWD"=>"contrato", "CharacterSet" => "UTF-8");
$actf = sqlsrv_connect( $db_host, $connectionInfo);

//echo $conn;

if( !$actf ) 
{
     echo "Conexión no se pudo establecer.<br />";
     die( print_r( sqlsrv_errors(), true));
}

