<?php 
if ($_SERVER["REQUEST_METHOD"]==="POST")
{
    $corr=$_GET["corr"];
    $idfaena=$_GET["idfaena"];
    $idperiodo=$_GET["idperiodo"];
include "../lib/database.php";

// elimina el registro

$sql="delete from Inversiones_Presupuesto where correlativo=$corr and idfaena=$idfaena and idperiodo=$idperiodo ;";
//echo $sql;    
$resul=sqlsrv_query($actf,$sql);

if ($resul)
    echo '0';
else
    echo '1';	
}
