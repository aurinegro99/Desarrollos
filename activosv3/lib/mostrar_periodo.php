<?
$sql="select idpresupuesto,periodo from presupuesto where (status='P' or status='A')";

$resul=mssql_query($sql);

   while (list($d1,$d2) = mssql_fetch_row($resul))
   {

     $opcion_periodo.="<option value=$d1 >$d2</option>";
   
		
   }
?>
