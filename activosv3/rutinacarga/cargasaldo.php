<?php

if ($_SERVER["REQUEST_METHOD"]==="GET")
{
    $xcodigo=$_GET["codigo"];
    include "../lib/database.php";

    // scaar id faena

    $costo=0;$avance=0;
    $sql="select valor_presupuesto,tipo_inversion,clase_activo,tipo_presupuesto from presupuesto_inversion where correlativo='$xcodigo'";
    $resul=sqlsrv_query($actf,$sql);
    $obj = sqlsrv_fetch_object($resul);
    $costo=$obj->valor_presupuesto;
    $tipoin=$obj->tipo_inversion;
    $clase=$obj->clase_activo;
    $tipop=$obj->tipo_presupuesto;
    
    $sql="select sum(valor_compra) as valor from formulario_activo where codigo_presupuesto='$xcodigo' and status_solicitud='A' ";
    //echo $sql;
    $resul=sqlsrv_query($actf,$sql);
    $obj = sqlsrv_fetch_object($resul);
    $avance=$obj->valor;
    
    $costo1=number_format($costo,2,'.',',');
    $msaldo=$costo-$avance;
    $msaldo1=number_format($msaldo,2,'.',',');
    echo $costo.'*'.$costo1.'*'.$msaldo.'*'.$msaldo1.'*'.$tipoin.'*'.$clase.'*'.$tipop;
}
