<?php


if ($_SERVER["REQUEST_METHOD"]==="GET")
{
    $xfaena=$_GET["faena"];
    include "../lib/database.php";
    $xml='';
    $xml.="<centros>";
    $sql="select emplazamiento,nombre_emplazamiento from faena_emplazamiento
          where idfaena=$xfaena order by idfaena";
	  
//echo $sql;

   $resul=sqlsrv_query($actf,$sql);
   
    $ind=0;
     while ($obj = sqlsrv_fetch_object($resul)){
	    $xml.="<idcentro>$obj->emplazamiento</idcentro>";  
		$xml.="<nombre>$obj->nombre_emplazamiento</nombre>";  
	
	
	}
	
$xml.="</centros>";
 
echo $xml;
header('Content-Type: text/xml');
}