<?php

$db_host        = "kch-1ano-sql-de.czvz6jrh66tt.us-west-2.rds.amazonaws.com";
$db_name        = "DB_Informe_Gestion";

$connectionInfo = array( "Database"=>"DB_Informe_Gestion", "UID"=>"KomatsuDOP", "PWD"=>"kchdop2016");
$amazon = sqlsrv_connect( $db_host, $connectionInfo);

//echo $conn;

if( !$amazon ) {
     echo "Conexión no se pudo establecer.<br />";
     die( print_r( sqlsrv_errors(), true));
}

?>
