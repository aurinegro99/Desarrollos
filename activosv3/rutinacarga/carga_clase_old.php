<?php
    $xml='';
    $xml.="<clases>"; 
    include "../lib/database.php";
    $tipo=$_GET["tipo"];
    if ($tipo=='N')
       $sql="select idclase,tipo_clase,nombre_clase from clase_activo where activo='S' "
            . " order by idclase";
    if ($tipo=='C')
       $sql="select idclase,tipo_clase,nombre_clase from clase_activo where idclase in (10,80) order by tipo_clase"; 
    //echo $sql;
    $resul=sqlsrv_query($actf,$sql);
     while($obj = sqlsrv_fetch_object( $resul))
     {
         // reemplazar texto
         
         $xnombre= str_replace(chr(225),'a', $obj->nombre_clase);
         $xnombre= str_replace(chr(233),'e', $obj->nombre_clase);
         $xnombre= str_replace(chr(237),'i', $obj->nombre_clase);
         $xnombre= str_replace(chr(243),'o', $obj->nombre_clase);
         $xnombre= str_replace(chr(250),'u', $obj->nombre_clase);
         $xnombre= str_replace(chr(157),'o', $obj->nombre_clase);
         
          $xml.="<idclase>$obj->idclase</idclase>";  
	  $xml.="<nombre>$obj->tipo_clase --> $xnombre</nombre>";  
     }

    $xml.="</clases>";
 
    echo $xml;
   header('Content-Type: text/xml');


