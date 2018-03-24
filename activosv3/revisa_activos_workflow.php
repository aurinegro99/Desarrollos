<?php


//include "lib/database.php";

$db_host        = "sauce";
$db_name        = "Gestion";
$db_username    = "contrato";
$db_password    = "contrato";

    //$gestion=mssql_connect($db_host,$db_username,$db_password);
    //mssql_select_db($db_name) or die (error_conexion);

$connectionString = "odbc:Driver={SQL Server};Server=$db_host;Database=$db_name;;MARS_Connection=yes";

$pdoGestion = new PDO($connectionString,$db_username,$db_password);

if($pdoGestion == null)
    die (error_conexion);

// nueva base
$db_host        = "CVWDSQL12";
$db_name        = "Activo_Fijo";
$db_username    = "contrato";
$db_password    = "contrato";

$connectionString = "odbc:Driver={SQL Server};Server=$db_host;Database=$db_name;;MARS_Connection=yes";

$pdoActivo = new PDO($connectionString,$db_username,$db_password);

if($pdoActivo == null)
    die (error_conexion);


// amazon

$db_host        = "kch-1ano-sql-de.czvz6jrh66tt.us-west-2.rds.amazonaws.com";
$db_name        = "DB_informe_gestion";
$db_username    = "master_user";
$db_password    = "komatsu2016";

$connectionString = "odbc:Driver={SQL Server};Server=$db_host;Database=$db_name;;MARS_Connection=yes";

$pdoAmazon = new PDO($connectionString,$db_username,$db_password);

if($pdoAmazon == null)
    die (error_conexion);




// rescata workflow sin activo sin informar

$sql="select  idsolicitud,idworkflow from flujo_solicitud where informa_activo='N' order by idsolicitud ;";
$st=$pdoGestion->query($sql);

$resArray = $st->fetchAll(PDO::FETCH_NUM);

foreach($resArray as $resul){
	
	list($xidsol,$xidwk) = $resul;
	
	// buscar si tiene activo fijo la solicitud
	
	$sqlf="select numero_activo from formulario_activo where idformulario=$xidsol";

	
	$resulf= $pdoGestion->query($sqlf);
	
	if(!$resulf){
		die( "Error: " . print_r($pdoGestion->errorInfo()));	
	}

	$res=$resulf->fetch(PDO::FETCH_ASSOC);
	
	$xnumero=$res['numero_activo'];


	
	if (strlen($xnumero)>=5){
		// mandar correo
		// genero correo
		
		//echo $xidsol.'   '.$xnumero.'<br>';
		
		//  buscar datos de la solicitud base nueva  usuario y clase
		$sqln="select usuario,idclase,idfaena from formulario_activo where idformulario=$xidsol";
		//echo $sqln;
		$resuln=$pdoActivo->query($sqln);
		$res2=$resuln->fetch(PDO::FETCH_ASSOC);
		$xusuario=$res2['usuario'];
		$xclase=$res2['idclase'];
		$xfaena=$res2['idfaena'];
		
		
		// datos usuario
		$xusuario="KCCL".chr(92).$xusuario;
		$sqln="select mail_usuario from usuarios_informe where usuario='$xusuario'";
		$resuln=$pdoAmazon->query($sqln);
		$res2=$resuln->fetch(PDO::FETCH_ASSOC);
		$xcorreo=$res2['mail_usuario'];
		// buscar datos del usuario

$mensaje=" <p>";
$mensaje.="Se ha creado un Activo Fijo para solicitud ingresada <p>";
$mensaje.="Numero Activo Fijo Creado : $xnumero <p>";
$mensaje.="Numero Solicitud WorkFlow : $xidwk <p>";
$mensaje.="Numero Solicitud KCH : $xidsol <p>";


 $mensaje.="Komatsu Chile S.A.";

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From:  Unidad Contratos <presupuesto@komatsu.cl>    \r\n";
$lista_mail='';
$lista_mail=$xcorreo;

if (($xclase==81) or ($xclase==84))
    $lista_mail=$lista_mail.',alejandro.santana@komatsu.cl,barbara.villarroel@komats.cl,catalina.castillo@komatsu.cl';
	
 if (($xclase==10) or ($xclase==80))
    $lista_mail=$lista_mail.',rene.tapia@komatsu.cl'; 
	
if ($xclase==81)
    $lista_mail=$lista_mail.',elizabeth.pizarro@komatsu.cl';	

if (($xfaena==1) or ($xfaena==2))
    $lista_mail=$lista_mail.',andrea.rojas@komatsu.cl';

mail($lista_mail.',maria.aguilar@komatsu.cl,camila.pinto@komatsu.cl','Creación Activo Fijo',$mensaje,$headers);

//mail($lista_mail.',mmorgado@komatsu.cl','Creación Activo Fijo',$mensaje,$headers);
		
		
		// actualizar registro
		$sqlf="update flujo_solicitud
		       set informa_activo='S',fecha_informe_activo=getdate()
			   where idsolicitud=$xidsol and idworkflow=$xidwk ;";
		$resulf=$pdoGestion->exec($sqlf);	   
		
		
		// actaulizar base nueva
		
		$sqln="update formulario_activo
		       set numero_activo=$xnumero, fecha_creacion_activo=getdate()
	           where idformulario=$xidsol ;";
		$resuln=$pdoActivo->exec($sqln);	   
		
		
		
		}
	
	
	//echo $xnumero.'<br>';
	
	}  // while
	
	

// revisar los rechazos
$sql="select  folio,urechazo,nombrerechazo,rolrechazo,convert(datetime,fecha,103),convert(datetime,108) from rechazoaf where informa_rechazo is null OR informa_rechazo='' ;";
$resul=$pdoGestion->query($sql);

$folios = array();

while(list($xfol,$xusuario,$xnombre,$xrol,$xfecha,$xhora)=$resul->fetch(PDO::FETCH_NUM)){
	
	$mensaje=" <p>";
$mensaje.="Se ha Rechazado Solicitud WorkFlow Activo Fijo <p>";
$mensaje.="Numero Solicitud WorkFlow : $xfol <p>";
$mensaje.="Usuario y Nombre quien Rechazo: $xusuario $xnombre   <p>";
$mensaje.="Rol quien Rechaza : $xrol <p>";
$mensaje.="Fecha y Hora del Rechazo: $xfecha <p>";


 $mensaje.="Komatsu Chile S.A.";

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From:  Unidad Contratos <presupuesto@komatsu.cl>    \r\n";
//mail($lista_mail.',maria.aguilar@komatsu.cl,maria.cano@komatsu.cl,sylvana.rivano@komatsu.cl','Generación WorkFlow Activo Fijo',$mensaje,$headers);

mail('maria.aguilar@komatsu.cl,camila.pinto@komatsu.cl,marcela.villegas@komatsu.cl','Rechazo Workflow Activo Fijo '.$xfol,$mensaje,$headers);

	
 $folios[] = $xfol;
	   
	
}

// actualizar registros
		$sqlf="update rechazoaf
		       set informa_rechazo='S',fecha_informe=getdate()
			   where folio IN (".implode(',', $folios).")";
		$resulf=$pdoGestion->exec($sqlf);

	

echo 'Proceso Terminado'

?>