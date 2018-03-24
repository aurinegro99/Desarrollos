<?php

if ($_SERVER["REQUEST_METHOD"]==="GET")
{
   $xfaena=$_GET["faena"];
   include "../lib/database_amazon.php";
   $xml='';
   $xml.="<centrocosto>";
   $sql="select a.ceco,a.nombre_ceco from dim_cebe_ceco a
         left join dim_faena_cebe b on a.cebe=b.cebe
         where b.idfaena=$xfaena and a.activo='S'
         order by a.ceco ; ";
$resul=sqlsrv_query($amazon,$sql);

 while ($obj = sqlsrv_fetch_object($resul))
        {
              

	    $xml.="<idccosto>$obj->ceco</idccosto>";  
	    $xml.="<nombre>$obj->nombre_ceco</nombre>";  
	
	
	}
	
$xml.="</centrocosto>";
 
echo $xml;
header('Content-Type: text/xml');
}