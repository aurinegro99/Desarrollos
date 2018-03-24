<?php

if ($_SERVER["REQUEST_METHOD"]==="POST")
{
     include "../lib/database.php";
     $solicitud=$_GET["solicitud"];  

     //$fecha_dig=date('d/m/Y H:i:s');


$nreg=0;
$sql="select status_solicitud from formulario_activo
      where idformulario=$solicitud";

//echo $sql;

$resul=sqlsrv_query($actf,$sql);

$rows=sqlsrv_has_rows($resul);

//echo $rows;

if ($rows===false)
    echo '0';

else
    {
     $obj = sqlsrv_fetch_object($resul);
     
     $d1=$obj->status_solicitud;
     echo $d1;
             
    
}

}
	 
	  
	  	 	 
