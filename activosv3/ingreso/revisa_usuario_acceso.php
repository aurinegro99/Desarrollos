<?php
        
if ($_SERVER["REQUEST_METHOD"]==="POST")
{
     include "../lib/database.php"; 
     $musuario = $_GET["musuario"];
     $xd=0;		

     $sql="select count(*) as acceso from usuario_faena where usuario='$musuario'";
     $resul=sqlsrv_query($actf,$sql);
     $obj = sqlsrv_fetch_object($resul);
     $xd=$obj->acceso;
     if ($xd>0)
        echo '1';
     else
        echo '0';     		
}		
