<?php
if ($_SERVER["REQUEST_METHOD"]==="POST")
{
       $nombre_solicita=$_GET["nombre_solicita"];
       $aprobador=$_GET["aprobador"];
       $clase=$_GET["clase"];
       $letra=$_GET["letra"];
       $solicitud=$_GET["solicitud"];
       //  graba modificacion pantalla 1
       include "../lib/database.php";
       $sql="update formulario_activo 
	  set  solicitante='$nombre_solicita',aprobador='$aprobador',idclase=$clase,status_solicitud='$letra'
	  where idformulario=$solicitud ";
       //echo $sql;
       $resul=sqlsrv_query($actf,$sql);
       if ($resul)
           echo '0';
       else
           echo '1';	


}