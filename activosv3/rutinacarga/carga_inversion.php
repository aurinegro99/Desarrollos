<?php

if ($_SERVER["REQUEST_METHOD"]==="GET")
{
include "../lib/database.php";
    $idfaena=$_GET["idfaena"];
    $idperiodo=$_GET["idperiodo"];

// scaar id faena

$total_1=0;
$total_2=0;


$sql="select sum(cantidad*valor_unitario) as total from inversiones_presupuesto where idfaena=$idfaena and idperiodo=$idperiodo and idclase<>10";
$resul=sqlsrv_query($actf,$sql);    
$obj = sqlsrv_fetch_object($resul);  
$total_1=$obj->total;    
if (strlen($total_1)<=0)
   $total_1=0;

$sql="select sum(cantidad*valor_unitario) as total from inversiones_presupuesto where idfaena=$idfaena and idperiodo=$idperiodo and idclase=10";
$resul=sqlsrv_query($actf,$sql);    
$obj = sqlsrv_fetch_object($resul);  
$total_2=$obj->total;    
if (strlen($total_1)<=0)
   $total_1=0;
if (strlen($total_2)<=0)
   $total_2=0;

echo $total_1.'*'.$total_2;


}
