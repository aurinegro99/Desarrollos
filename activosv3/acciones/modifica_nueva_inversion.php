<?php
session_start();
if ($_SERVER["REQUEST_METHOD"]==="POST")
{
 $xusuario=$_SESSION["usuario"]; 
    
include "../lib/database.php";
    $idcentro=$_REQUEST["idcentro"];
    $idclase=$_REQUEST["idclase"];
    $descripcion=$_REQUEST["descripcion"];
    $cantidad=$_REQUEST["cantidad"];
    $valor=$_REQUEST["valor"];
    $mes_c=$_REQUEST["mes_c"];
    $mes_a=$_REQUEST["mes_a"];
    $proyecto=$_REQUEST["proyecto"];
    $motivo=$_REQUEST["motivo"];
    $prioridad=$_REQUEST["prioridad"];
    $corr=$_REQUEST["corr"];
    $idfaena=$_REQUEST["idfaena"];
    $idperiodo=$_REQUEST["idperiodo"];


$sql="update inversiones_presupuesto
      set ceco='$idcentro',idclase=$idclase,descripcion_bien='$descripcion',cantidad=$cantidad,valor_unitario=$valor,mes_compra=$mes_c,mes_activacion=$mes_a,proyecto=$proyecto,motivo=$motivo,prioridad='$prioridad'
	  where correlativo=$corr and idfaena=$idfaena and idperiodo=$idperiodo";
//echo $sql;    
$resul=sqlsrv_query($actf,$sql); 
if ($resul)
   echo '0';
else
   echo '1';   	  

}
