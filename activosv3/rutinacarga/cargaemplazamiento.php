<?php

if ($_SERVER["REQUEST_METHOD"]==="GET")
{
include "../lib/database.php";
$xcentro=$_GET["centro"];
$xml='';
$xml.="<emplazamiento>";
$sql="select idemplazamiento,nombre_emplazamiento from centro_logistico where centro_logistico='$xcentro' ;";
$resul=sqlsrv_query($actf,$sql);

 while ($obj = sqlsrv_fetch_object($resul))
         {

	    $xml.="<idemplaza>$obj->idemplazamiento</idemplaza>";  
		$xml.="<nombre>$obj->nombre_emplazamiento</nombre>";  
	
	
	}
	
$xml.="</emplazamiento>";
 
echo $xml;
header('Content-Type: text/xml');
}
