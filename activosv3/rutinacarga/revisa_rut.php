<?php
if ($_SERVER["REQUEST_METHOD"]==="GET")
{
    include "../lib/database.php";
    $rut=$_GET["rut"];
    $sql="select nombre from DB_personal.dbo.nomina_vigente where rut='$rut' and (empresa='3002' or empresa='3001') ";
    $resul=sqlsrv_query($actf,$sql);
    $obj = sqlsrv_fetch_object($resul);
    if ($obj !=false)
    {
        $xnombre=$obj->nombre;
        echo $xnombre;
        
    }
    else
        echo '0';
       
}
else 
  echo '0';  
