<?

if ($_SERVER["REQUEST_METHOD"]==="GET")
    {
      $formulario=$_GET["formulario"];
      include "../lib/database.php";
      $nreg=0;
      $sql="select solicitante,aprobador,idclase,descripcion_bien,marca,modelo,numero_serie,pais_origen,patente,responsable_activo,valor_pesos,lugar_uso 
           from formulario_activo 
           where idformulario=$formulario";
		   
	  $resul=sqlsrv_query($actf,$sql);
      $obj = sqlsrv_fetch_object($resul); 	   
	  if ($obj)
		echo $obj->solicitante.'*'.$obj->aprobador.'*'.$obj->idclase.'*'.$obj->descripcion_bien.'*'.$obj->marca.'*'.$obj->modelo.'*'.$obj->numero_serie.'*'.$obj->pais_origen.'*'.$obj->patente.'*'.$obj->responsable_activo.'*'.$obj->valor_pesos.'*'.$obj->lugar_uso;	 
	
		
	else 
		echo '0';  
	


	
	}
		
	
?>