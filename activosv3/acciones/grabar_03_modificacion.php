<?php
//  graba modificacion pantalla 1
if ($_SERVER["REQUEST_METHOD"]==="POST")
{
    
    $codigo=$_GET["codigo"];
    $solicitud=$_GET["solicitud"];
    $lugar=$_GET["lugar"];
    $responsable=$_GET["responsable"];
    $centro=$_GET["centro"];
    $observacion=$_GET["observacion"];
    $emplaza=$_GET["emplaza"];
    $valor_pesos=$_GET["valor_pesos"];
    
    
    include "../lib/database.php";
    

/*$costo=0;$avance=0;
$sql="select valor_presupuesto,cantidad,descripcion from presupuesto_inversion where correlativo='$codigo'";
$resul=mssql_query($sql);
list($costo,$ncant,$descrip_inversion)=mssql_fetch_row($resul);

$sql="select sum(valor_compra) as valor1,sum(cantidad) from formulario_activo where codigo_presupuesto='$codigo'  and status_solicitud='A'  ";
$resul=mssql_query($sql);
list($avance,$acant)=mssql_fetch_row($resul);
*/

$sql="select codigo_presupuesto,valor_compra,tipo_cambio from formulario_activo where idformulario=$solicitud ";
$resul=sqlsrv_query($actf,$sql);
$obj = sqlsrv_fetch_object($resul);
$xtipo=$obj->tipo_cambio;

/*$resul=mssql_query($sql);
list($xcodigo,$xcompra,$xtipo)=mssql_fetch_row($resul);

$new_saldo=$costo-$avance;

//  valñor dolar modificacion
*/
$new_dolar=round($valor_pesos/$xtipo,2);

//$new_saldo=$new_saldo-$new_dolar;

//echo $new_saldo.' ---- ';

//if ($codigo==$xcodigo){
//   if ($new_saldo>=0)	
//      $new_saldo=$new_saldo-$xcompra;
//   else  
//      $new_saldo=$new_saldo+$xcompra;
//}


//echo $new_saldo.' ** ';

$sql="update formulario_activo 
	  set lugar_uso='$lugar',responsable_activo='$responsable',codigo_presupuesto='$codigo',valor_compra=$new_dolar,idcentro_costo='$centro',valor_pesos=$valor_pesos,emplazamiento=$emplaza,observaciones='$observacion'
	 where idformulario=$solicitud ";
//echo $sql;

$resul=sqlsrv_query($actf,$sql);

if ($resul)
    echo '0';
else
    echo '1';	
}
