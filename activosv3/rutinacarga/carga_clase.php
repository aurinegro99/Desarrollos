<?php
   
   $sql="select idclase,tipo_clase,nombre_clase from clase_activo where activo='S' "
            . " order by idclase";
   
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
         
         $opcion_clase.="<option value=$obj->idclase >$obj->tipo_clase --> $xnombre</option>";
         
     }

   

