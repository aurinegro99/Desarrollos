<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Rescatar datos de faen x usuario
$xlista='';
$sqle="select idfaena from usuario_faena where usuario='$idusuario' ;";
$resule=sqlsrv_query($actf,$sqle);
while($obj = sqlsrv_fetch_object($resule))
{
    if (strlen($xlista)<=0)
       $xlista=$obj->idfaena; 
    else    
       $xlista.=','.$obj->idfaena;
    
    
}
// rescaat las faenas desde base
$sqlf="select a.idfaena,a.idunidad,a.nombre_faena,b.nombre_unidad,b.cod_gerencia from dim_faenas a 
       left join  dim_unidad b on a.idunidad=b.cod_unidad
       where a.idfaena in (".$xlista.") 
       order by b.cod_gerencia desc ,a.idunidad,a.idfaena";

$resulf=sqlsrv_query($amazon,$sqlf);
while($obj = sqlsrv_fetch_object($resulf))
{
    $opcion_faena.="<option value=$obj->idfaena >$obj->nombre_faena --($obj->nombre_unidad / $obj->cod_gerencia )</option>";
    
}