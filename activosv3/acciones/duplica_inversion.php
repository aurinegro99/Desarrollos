<?php
session_start();
if ($_SERVER["REQUEST_METHOD"]==="POST")
{
     $xusuario=$_SESSION["usuario"]; 
    $corr=$_REQUEST["corr"];
    $idfaena=$_REQUEST["idfaena"];
    $idperiodo=$_REQUEST["idperiodo"];
    
include "../lib/database.php";


$sql="insert into Inversiones_Presupuesto
(idperiodo,idfaena,ceco,idclase,descripcion_bien,cantidad,valor_unitario,mes_compra,mes_activacion,proyecto,motivo,fecha_ingreso,usuario)
(select idperiodo,idfaena,ceco,idclase,descripcion_bien,cantidad,valor_unitario,mes_compra,mes_activacion,proyecto,motivo,getdate(),'$xusuario' from Inversiones_Presupuesto
where correlativo=$corr)";
echo $sql;    
$resul=sqlsrv_query($actf,$sql);    
if ($resul)
   echo '0';
else
   echo '1';   	  

}
