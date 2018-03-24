<?php
if ($_SERVER["REQUEST_METHOD"]==="POST")
{
    
    $solicitud=$_GET["solicitud"];
    $descripcion=$_GET["descripcion"];
    $marca=$_GET["marca"];
    $modelo=$_GET["modelo"];
    $serie=$_GET["serie"];
    $pais=$_GET["pais"];
    $patente=$_GET["patente"];
    
    //  graba modificacion pantalla 1
    include "../lib/database.php";
    $sql="update formulario_activo 
	  set  descripcion_bien=upper('$descripcion'),marca='$marca',modelo='$modelo',numero_serie='$serie',pais_origen='$pais',patente='$patente'
	  where idformulario=$solicitud ";
    $resul=sqlsrv_query($actf,$sql);
       if ($resul)
           echo '0';
       else
           echo '1';


}