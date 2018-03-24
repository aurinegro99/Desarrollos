<?php

if ($_SERVER["REQUEST_METHOD"]==="POST")
{
     include "../lib/database.php";
     $solicitud=$_GET["solicitud"];
     $sql=" select pais_origen,emplazamiento,observaciones,status_solicitud from formulario_activo where idformulario=$solicitud";
     $resul=sqlsrv_query($actf,$sql);
     $obj=sqlsrv_fetch_object($resul);
     $xpais=$obj->pais_origen;
     $xemplaza=$obj->emplazamiento;
     $xobserva=$obj->observaciones;
     $xstatus=$obj->status_solicitud;
     if ($xstatus=='A')
     {
	if ($xpais>0){
		if (strlen($xobserva)>0)
		   echo '0';
		else
		    echo '8';	
		
		}
	else
	   echo '7';	
     }
      else
         echo '6';

}
?>