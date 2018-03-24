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
$sqlf=" select distinct(b.cod_gerencia),c.nombre_gerencia from dim_faenas a 
       left join  dim_unidad b on a.idunidad=b.cod_unidad
       left join dim_gerencia c on b.cod_gerencia=c.cod_gerencia
       where a.idfaena in (".$xlista.") 
       order by b.cod_gerencia ";

$resulf=sqlsrv_query($amazon,$sqlf);
while($obj = sqlsrv_fetch_object($resulf))
{
    $opcion_gerencia.="<option value=$obj->cod_gerencia >$obj->nombre_gerencia</option>";
    
}