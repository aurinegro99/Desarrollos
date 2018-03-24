<?php

/*$db_host        = "sauce";

$connectionInfo = array( "Database"=>"Gestion", "UID"=>"contrato", "PWD"=>"contrato");
$sauce = sqlsrv_connect( $db_host, $connectionInfo);

//echo $conn;

if( !$sauce ) 
{
     echo "Conexión no se pudo establecer.<br />";
     die( print_r( sqlsrv_errors(), true));
}
*/


$db_host        = "sauce";
$db_name        = "Gestion";
$db_username    = "contrato";
$db_password    = "contrato";

    //$gestion=mssql_connect($db_host,$db_username,$db_password);
    //mssql_select_db($db_name) or die (error_conexion);

$connectionString = "odbc:Driver={SQL Server};Server=$db_host;Database=$db_name;;MARS_Connection=yes";

$pdoGestion = new PDO($connectionString,$db_username,$db_password);

if($pdoGestion == null)
    die (error_conexion);
