<?php
if ($_SERVER["REQUEST_METHOD"]==="GET")
{
    $xceco=$_GET["ceco"];
    // obtener empresa del ceco para filtra ppto
    include "../lib/database_amazon.php";
    $sql="select e.cod_empresa from dim_cebe_ceco a 
          left join dim_faena_cebe b on a.cebe=b.cebe
          left join dim_faenas c on b.idfaena=c.idfaena
          left join dim_unidad d on c.idunidad=d.cod_unidad
          left join dim_gerencia e on d.cod_gerencia=e.cod_gerencia
          where a.ceco='$xceco' ;";
    $resul=sqlsrv_query($amazon,$sql);
    $obj = sqlsrv_fetch_object($resul);
    $xempresa=$obj->cod_empresa;
    
    
    include "../lib/database.php";

    // obteneer periodo activo
    $sql="select idperiodo from periodos_inversion where activo='S' order by idperiodo ";
    $resul=sqlsrv_query($actf,$sql);
    $obj = sqlsrv_fetch_object($resul);
    $xperiodo=$obj->idperiodo;
    $xml='';
    $xml.="<inversion>";
    $sql="select correlativo,descripcion from presupuesto_inversion  
          where  idcentro_costo='$xceco' and periodo=$xperiodo and status_codigo='A' and empresa='$xempresa' order by correlativo ";
    //echo $sql;
    $resul=sqlsrv_query($actf,$sql);
    while ($obj = sqlsrv_fetch_object($resul))
    {
   	    $xml.="<idinversion>$obj->correlativo</idinversion>";  
    	    $xml.="<nombre>$obj->descripcion </nombre>";  
	
	
	}
	
$xml.="</inversion>";
 
echo $xml;
header('Content-Type: text/xml');

}