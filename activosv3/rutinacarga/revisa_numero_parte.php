<?php

if ($_SERVER["REQUEST_METHOD"]==="GET")
{
   $xparte=$_GET["numero_parte"];
   include "../lib/database.php";
   // reviso maestro estrategico
   $sql="select numero_parte from maestro_estrategico where numero_parte='$xparte'";
   //echo $sql;
   $resul=sqlsrv_query($actf,$sql);
   $obj = sqlsrv_fetch_object($resul);
   
   if (strlen( $obj->numero_parte )>0)
   {
       include "../lib/database_amazon.php";
       $sql="select nombre_material from gestion.dbo.maestro_material "
               . "where material='$xparte' and idioma='S' ;";
       
       $resul=$pdoGestion->query($sql);
       foreach($resul as $dato) {
           $xnombre=rtrim($dato["nombre_material"]);
           
       }
        
       //$resul=sqlsrv_query($gest,$sql);
       //$obj = sqlsrv_fetch_object($resul);
       //$xnombre=$obj->nombre_material;
       if (strlen($xnombre)>0)
          echo $xnombre;
       else
          echo '0';  
   }
       
   else
       echo '0'; 

}

?>