<?php
       
$db_host        = "sauce";
$db_name        = "Gestion";

$connectionInfo = array( "Database"=>"Gestion", "UID"=>"contrato", "PWD"=>"contrato");
$gest = sqlsrv_connect( $db_host, $connectionInfo);

//echo $conn;

if( !$gest ) 
{
     echo "Conexión no se pudo establecer.<br />";
     die( print_r( sqlsrv_errors(), true));
}        

?>
