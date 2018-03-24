<?php
if ($_SERVER["REQUEST_METHOD"]==="POST")
{
    $solicitud=$_GET["solicitud"];
    include "../lib/database_sauce.php";
    $xworkflow=0;
    
    $sql="select idworkflow from flujo_solicitud where idsolicitud=$solicitud ;";
    $resul=$pdoGestion->query($sql);
    if ($resul->fetchColumn()>0)
    {
        $res=$resul->fetch(PDO::FETCH_ASSOC);
        $xworkflow=$res['idworkflow'];
    }
    else
        $xworkflow=0;
   
    echo $xworkflow;

}
?>