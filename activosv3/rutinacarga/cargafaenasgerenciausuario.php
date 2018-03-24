<?php
session_start();
$idusuario = $_SESSION["usuario"];
if ($_SERVER["REQUEST_METHOD"]==="GET")
{
    include "../lib/database.php";
include "../lib/database_amazon.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Rescatar datos de faen x usuario
    $xcod=$_GET["cod_gerencia"];
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
$opcion_faena='';
// rescaat las faenas desde base
$sqlf="select a.idfaena,a.idunidad,a.nombre_faena,b.nombre_unidad,b.cod_gerencia from dim_faenas a 
       left join  dim_unidad b on a.idunidad=b.cod_unidad
       where a.idfaena in (".$xlista.") and b.cod_gerencia='$xcod'
       order by b.cod_gerencia desc ,a.idunidad,a.idfaena";
//echo $sqlf;
$resulf=sqlsrv_query($amazon,$sqlf);

$xml='';
$xml.="<faenas>";
while($obj = sqlsrv_fetch_object($resulf))
{
     $xml.="<idfaena>$obj->idfaena</idfaena>";  
     $xml.="<nombre>$obj->nombre_faena</nombre>";  
    
    
}
$xml.="</faenas>";
 
echo $xml;
header('Content-Type: text/xml');

}