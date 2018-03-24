<?php
session_start();


$solicitud=$_GET["solicitud"];

/*

$idusuario=$_SESSION["usuario"];
//$xcorreo=$_SESSION["correo"];
$xsolicitante=$_SESSION["rut"];
*/
include "../lib/database.php";
include "../lib/database_amazon.php";


$xsaldo=0;

$sql="select responsable_activo,descripcion_bien,marca,modelo,numero_serie,pais_origen,codigo_presupuesto,round(valor_compra,2) as valor,idcentro_costo,lugar_uso,sucursal,emplazamiento,idclase,observaciones,solicitante,usuario from formulario_activo where idformulario=$solicitud ;";
$resul=sqlsrv_query($actf,$sql);
$obj=sqlsrv_fetch_object($resul);

$rutResponsable=$obj->responsable_activo;
$xdescripcion=$obj->descripcion_bien;
$xmarca=$obj->marca;
$xmodelo=$obj->modelo;
$xserie=$obj->numero_serie;
$xpais=$obj->pais_origen;
$xcodigo=$obj->codigo_presupuesto;
$xvalor=$obj->valor;
$xcentro=$obj->idcentro_costo;
$xlugar=$obj->lugar_uso;
$xsucursal=$obj->sucursal;
$xemplaza=$obj->emplazamiento;
$xidclase=$obj->idclase;
$xobserva=$obj->observaciones;
$xnombre_solicita=$obj->solicitante;   
$xdigita=$obj->usuario;

//list($rutResponsable,$xdescripcion,$xmarca,$xmodelo,$xserie,$xpais,$xcodigo,$xvalor,$xcentro,$xlugar,$xsaldo,$xsucursal,$xemplaza,$xidclase,$xobserva,$xcorreo,$xnombre_solicita,$zusuario)=mssql_fetch_row($resul);


// sacar rut correo solicitante

$xdigita="KCCL".chr(92).$xdigita;

$sqlc="select mail_usuario from usuarios_informe  where usuario='$xdigita' ;";
$resulc=sqlsrv_query($amazon,$sqlc);
$obj=sqlsrv_fetch_object($resulc);
$xcorreo=$obj->mail_usuario;
//$resul=mssql_query($sql);
//list($xsolicitante)=mssql_fetch_row($resul);



// nombre centro
$xnombre_centro='';
$sqlc="select nombre_ceco from dim_cebe_ceco where ceco='$xcentro' ;";
$resulc=sqlsrv_query($amazon,$sqlc);
$obj=sqlsrv_fetch_object($resulc);
$xnombre_centro=$obj->nombre_ceco;

$xnombre_centro=str_replace(chr(143),'A',$xnombre_centro);
				$xnombre_centro=str_replace(chr(144),'E',$xnombre_centro);
				$xnombre_centro=str_replace(chr(214),'I',$xnombre_centro);
				$xnombre_centro=str_replace(chr(224),'O',$xnombre_centro);
				$xnombre_centro=str_replace(chr(233),'U',$xnombre_centro);
				
				
				
				$xnombre_centro=str_replace(chr(160),'a',$xnombre_centro);
				$xnombre_centro=str_replace(chr(130),'e',$xnombre_centro);
				$xnombre_centro=str_replace(chr(161),'i',$xnombre_centro);
				$xnombre_centro=str_replace(chr(162),'o',$xnombre_centro);
				$xnombre_centro=str_replace(chr(163),'u',$xnombre_centro);
				
				
$xnombre_centro=str_replace('á','a',$xnombre_centro);
$xnombre_centro=str_replace('é','e',$xnombre_centro);
$xnombre_centro=str_replace('í','i',$xnombre_centro);
$xnombre_centro=str_replace('ó','o',$xnombre_centro);
$xnombre_centro=str_replace('ú','u',$xnombre_centro);

				



// monto presupuesto

$sql="select valor_presupuesto,clase_activo,tipo_presupuesto,periodo from presupuesto_inversion where correlativo='$xcodigo' ;";
$resul=sqlsrv_query($actf,$sql);
$obj=sqlsrv_fetch_object($resul);
$xppto=$obj->valor_presupuesto;
$zclase=$obj->clase_activo; 
$ztipo=$obj->tipo_presupuesto;
$zperiodo=$obj->periodo;
//  tipo inversión  para determinar si compres en presupuestada o no


if (($zclase=='999') and ($ztipo==2)){
	$xcodigo_1='SP';
	$xcompra_prog='No';	
	$xcodigo_2=$zperiodo;
	}
else{
    $xcompra_prog='Si';	
	$pos=strpos($xcodigo,'-',0);
    $xcodigo_1=substr($xcodigo,0,$pos);
    $xcodigo_2=substr($xcodigo,$pos+1);
	
	}
 

/*$sql="select cod_pais from pais_origen where idpais=$xpais ;";
$resul=sqlsrv_query($actf,$sql);
$obj=sqlsrv_fetch_object($resul);

$resul=mssql_query($sql);
list($xpais)=mssql_fetch_row($resul);*/
$xpais = "";


//echo $sql;
// cambiar letras

                $xdescripcion = str_replace("Â","",$xdescripcion);
                $xdescripcion = str_replace("=3D ","*",$xdescripcion);
                $xdescripcion = str_replace(" 3D ","*",$xdescripcion);
                $xdescripcion = str_replace("Ã¡","a",$xdescripcion);
                $xdescripcion = str_replace("Ã©","e",$xdescripcion);
                $xdescripcion = str_replace("Ã¬","i",$xdescripcion);
                $xdescripcion = str_replace("Ã³","o",$xdescripcion);
                $xdescripcion = str_replace("Ãº","u",$xdescripcion);
                $xdescripcion = str_replace("á","a",$xdescripcion);
                $xdescripcion = str_replace("á","a",$xdescripcion);
                $xdescripcion = str_replace("á","a",$xdescripcion); 
                $xdescripcion = str_replace("ä","a",$xdescripcion);
                $xdescripcion = str_replace("é","e",$xdescripcion);
                $xdescripcion = str_replace("è","e",$xdescripcion);
                $xdescripcion = str_replace("ë","e",$xdescripcion);
                $xdescripcion = str_replace("í","i",$xdescripcion);
                $xdescripcion = str_replace("í","i",$xdescripcion);
                $xdescripcion = str_replace("ì","i",$xdescripcion);
                $xdescripcion = str_replace("ï","i",$xdescripcion);
                $xdescripcion = str_replace("ó","o",$xdescripcion);
                $xdescripcion = str_replace("ò","o",$xdescripcion);
                $xdescripcion = str_replace("ö","o",$xdescripcion);
                $xdescripcion = str_replace("¢","o",$xdescripcion);
                $xdescripcion = str_replace("°","",$xdescripcion);
                $xdescripcion = str_replace("ç","",$xdescripcion);
                $xdescripcion = str_replace("m t","mat",$xdescripcion);
                $xdescripcion = str_replace("ú","u",$xdescripcion);
                $xdescripcion = str_replace("ù","u",$xdescripcion);
                $xdescripcion = str_replace("ü","u",$xdescripcion);
                $xdescripcion = str_replace("ñ","n",$xdescripcion);
                $xdescripcion = str_replace("Ñ","N",$xdescripcion);
                $xdescripcion = str_replace("Ã?","N",$xdescripcion);
                $xdescripcion = str_replace("Ã±","n",$xdescripcion);
                $xdescripcion = str_replace("&","y",$xdescripcion);
                $xdescripcion = str_replace("º",".",$xdescripcion);
                $xdescripcion = str_replace("•",".",$xdescripcion);
                $xdescripcion = str_replace("N°","No",$xdescripcion);
                $xdescripcion = str_replace("Nº","No",$xdescripcion);
                $xdescripcion = str_replace("Nª","No",$xdescripcion);
                $xdescripcion = str_replace("n°","No",$xdescripcion);
                $xdescripcion = str_replace("nº","No",$xdescripcion);
                $xdescripcion = str_replace("Ã","A",$xdescripcion);
                $xdescripcion = str_replace("Ã‰","E",$xdescripcion);
                $xdescripcion = str_replace("Ãš","U",$xdescripcion);
                $xdescripcion = str_replace("Á","A",$xdescripcion);
                $xdescripcion = str_replace("ª","A",$xdescripcion);
                $xdescripcion = str_replace("É","E",$xdescripcion);
                $xdescripcion = str_replace("Í","I",$xdescripcion);
                $xdescripcion = str_replace("Ó","O",$xdescripcion);
                $xdescripcion = str_replace("Ó","O",$xdescripcion);
                $xdescripcion = str_replace("Ú","U",$xdescripcion);
                $xdescripcion = str_replace("|"," ",$xdescripcion);
                $xdescripcion = str_replace("!"," ",$xdescripcion);
                $xdescripcion = str_replace("¡"," ",$xdescripcion);
                $xdescripcion = str_replace("*","=",$xdescripcion);
                $xdescripcion = str_replace("´","'",$xdescripcion);
				$xdescripcion = str_replace('"',"'",$xdescripcion);
				$xdescripcion = str_replace("/"," ",$xdescripcion);
				$xdescripcion = str_replace("."," ",$xdescripcion);
				$xdescripcion = str_replace("("," ",$xdescripcion);
				$xdescripcion = str_replace(")"," ",$xdescripcion);
				$xdescripcion = str_replace('"'," ",$xdescripcion);
				$xdescripcion=str_replace(chr(209),'N',$xdescripcion);
				$xdescripcion=str_replace(chr(241),'n',$xdescripcion);
				$xdescripcion=str_replace(chr(176),'ro.',$xdescripcion);



                $xobserva = str_replace("Â","",$xobserva);
                $xobserva = str_replace("=3D ","*",$xobserva);
                $xobserva = str_replace(" 3D ","*",$xobserva);
                $xobserva = str_replace("Ã¡","a",$xobserva);
                $xobserva = str_replace("Ã©","e",$xobserva);
                $xobserva = str_replace("Ã¬","i",$xobserva);
                $xobserva = str_replace("Ã³","o",$xobserva);
                $xobserva = str_replace("Ãº","u",$xobserva);
                $xobserva = str_replace("á","a",$xobserva);
                $xobserva = str_replace("á","a",$xobserva);
                $xobserva = str_replace("á","a",$xobserva);
                $xobserva = str_replace("ä","a",$xobserva);
                $xobserva = str_replace("é","e",$xobserva);
                $xobserva = str_replace("è","e",$xobserva);
                $xobserva = str_replace("ë","e",$xobserva);
                $xobserva = str_replace("í","i",$xobserva);
                $xobserva = str_replace("í","i",$xobserva);
                $xobserva = str_replace("ì","i",$xobserva);
                $xobserva = str_replace("ï","i",$xobserva);
                $xobserva = str_replace("ó","o",$xobserva);
                $xobserva = str_replace("ò","o",$xobserva);
                $xobserva = str_replace("ö","o",$xobserva);
                $xobserva = str_replace("¢","o",$xobserva);
                $xobserva = str_replace("°","",$xobserva);
                $xobserva = str_replace("ç","",$xobserva);
                $xobserva = str_replace("m t","mat",$xobserva);
                $xobserva = str_replace("ú","u",$xobserva);
                $xobserva = str_replace("ù","u",$xobserva);
                $xobserva = str_replace("ü","u",$xobserva);
                $xobserva = str_replace("ñ","n",$xobserva);
                $xobserva = str_replace("Ñ","N",$xobserva);
                $xobserva = str_replace("Ã?","N",$xobserva);
                $xobserva = str_replace("Ã±","n",$xobserva);
                $xobserva = str_replace("&","y",$xobserva);
                $xobserva = str_replace("º",".",$xobserva);
                $xobserva = str_replace("•",".",$xobserva);
                $xobserva = str_replace("N°","No",$xobserva);
                $xobserva = str_replace("Nº","No",$xobserva);
                $xobserva = str_replace("Nª","No",$xobserva);
                $xobserva = str_replace("n°","No",$xobserva);
                $xobserva = str_replace("nº","No",$xobserva);
                $xobserva = str_replace("Ã","A",$xobserva);
                $xobserva = str_replace("Ã‰","E",$xobserva);
                $xobserva = str_replace("Ãš","U",$xobserva);
                $xobserva = str_replace("Á","A",$xobserva);
                $xobserva = str_replace("ª","A",$xobserva);
                $xobserva = str_replace("É","E",$xobserva);
                $xobserva = str_replace("Í","I",$xobserva);
                $xobserva = str_replace("Ó","O",$xobserva);
                $xobserva = str_replace("Ó","O",$xobserva);
                $xobserva = str_replace("Ú","U",$xobserva);
                $xobserva = str_replace("|"," ",$xobserva);
                $xobserva = str_replace("!"," ",$xobserva);
                $xobserva = str_replace("¡"," ",$xobserva);
                $xobserva = str_replace("*","=",$xobserva);
                $xobserva = str_replace("´","'",$xobserva);
				$xobserva = str_replace('"',"'",$xobserva);
				$xobserva = str_replace("/"," ",$xobserva);
				$xobserva = str_replace("."," ",$xobserva);
				$xobserva = str_replace("("," ",$xobserva);
				$xobserva = str_replace(")"," ",$xobserva);
				$xobserva = str_replace('"'," ",$xobserva);
				
				$xobserva=str_replace(chr(209),'N',$xobserva);
				$xobserva=str_replace(chr(241),'n',$xobserva);
				
				$xobserva=str_replace(chr(176),'ro.',$xobserva);
				
				
				
				
				$xnombre_solicita=str_replace(chr(209),'N',$xnombre_solicita);
				$xnombre_solicita=str_replace(chr(241),'n',$xnombre_solicita);
				
				$xnombre_solicita=str_replace(chr(143),'A',$xnombre_solicita);
				$xnombre_solicita=str_replace(chr(144),'E',$xnombre_solicita);
				$xnombre_solicita=str_replace(chr(214),'I',$xnombre_solicita);
				$xnombre_solicita=str_replace(chr(224),'O',$xnombre_solicita);
				$xnombre_solicita=str_replace(chr(233),'U',$xnombre_solicita);
				
				
				
				$xobserva=str_replace(chr(160),'a',$xobserva);
				$xobserva=str_replace(chr(130),'e',$xobserva);
				$xobserva=str_replace(chr(161),'i',$xobserva);
				$xobserva=str_replace(chr(162),'o',$xobserva);
				$xobserva=str_replace(chr(163),'u',$xobserva);
				
				
				







//echo $xcodigo_1.'   '.$xcodigo_2.'<br>';






$sql="select tipo_clase from clase_activo where idclase=$xidclase ; ";
$resul=sqlsrv_query($actf,$sql);
$obj=sqlsrv_fetch_object($resul);
$xclase=$obj->tipo_clase;

//$resul=mssql_query($sql);
//list($xclase)=mssql_fetch_row($resul);


$sql="select idemplazamiento from centro_logistico where idcentro=$xemplaza ;";
$resul=sqlsrv_query($actf,$sql);
$obj=sqlsrv_fetch_object($resul);
$xemplaza=$obj->idemplazamiento;

//$resul=mssql_query($sql);
//list($xemplaza)=mssql_fetch_row($resul);


$wsdlurl= "http://arrayanv2:50000/WS_INFOPUBLISHER/Config1?wsdl&style=document" ; // productivo
//$wsdlurl  ="http://10.4.52.50:51000/WS_INFOPUBLISHER/Config1?wsdl&style=document"; //  desarrollo

$login    = "";
$password = "";
$client = new SoapClient($wsdlurl,
			array('login'      => $login,
				  'password'   => $password,
				  'trace'	   => true,
				  'exceptions' => true));
//var_dump($client->__getFunctions());

$param = array("rut"=>"$rutResponsable");

$result = $client -> datosEmpleado($param);


//print_r($result);

$emailUsuario = $result->Response->email;
$codigoCentroCosto = $result->Response->numcentrocosto;
$uJefe = $result->Response->ujefe;
$usuarioSap = $result->Response->usuariosap;
$codCompania = $result->Response->codcompania;
$nombreCompania = $result->Response->nombrecompania;
$emailJefe = $result->Response->codciudad;
$solicitadoPor = $result->Response->nombre;

$nombreJefe = $result->Response->nombrejefe;
$carg = $result->Response->categoria;
$carg2 =$result->Response->cargo;
$nombre_responsable =$result->Response->nombre;

 $nivel = "0";
				   
				   $carg = trim($carg);
				   
				   if($carg2 == "Presidente") $nivel = "5";
					elseif($carg == "Directivo") $nivel = "4";
					elseif($carg == "Gerente")  $nivel = "3";
					elseif($carg == "Subgerente") $nivel = "2";
					elseif($carg == "Jefe")	$nivel = "1";
				
				if($nivel == "0") $Puedeaprobar = false;
				else $Puedeaprobar = true;



$solicitadoPor=str_replace('Ñ','N',$solicitadoPor);

$solicitadoPor=str_replace(chr(143),'A',$solicitadoPor);
				$solicitadoPor=str_replace(chr(144),'E',$solicitadoPor);
				$solicitadoPor=str_replace(chr(214),'I',$solicitadoPor);
				$solicitadoPor=str_replace(chr(224),'O',$solicitadoPor);
				$solicitadoPor=str_replace(chr(233),'U',$solicitadoPor);



$nombre_responsable=str_replace('Ñ','N',$solicitadoPor);

$xnombre_solicita=str_replace(chr(218),'U',$xnombre_solicita);

//echo $xdescripcion.'  ## '.$xpepa.' ---> '.$xnombre_solicita.'  '.$solicitadoPor.'  '.$nombre_responsable.' '.'<br>';



//exit(0);					



//FOLIO
$wsdlurl  ="http://arrayanv2:50000/WSFOLIOSAF/Config1?wsdl&style=document";  // productivo

//$wsdlurl  ="http://10.4.52.50:51000/WSFOLIOSAF/Config1?wsdl&style=document";  // desarrollo


$login    = "";
$password = "";
$client = new SoapClient($wsdlurl,
			array('login'      => $login,
				  'password'   => $password,
				  'trace'	   => true,
				  'exceptions' => true));
//var_dump($client->__getFunctions());

$param = array("valor"=>"");

//$result = $client -> Foloaf($param);

//$folioAF = $result->Response->numfol;



//echo $folioAF;

//FIN FOLIO

$folioAF=99999;


//  generro WorkFlow


$wsdlurl  ="http://desbpm.kcl.cl:50000/bpm/demosapcom/prcsolaf/TriggerAF?wsdl";  // productivo

$login    = "webadm";// PROD
$password = "Kcl2112.";// PROD";


/*
$wsdlurl  ="http://devbpm.kcl.cl:50000/bpm/demosapcom/prcsolaf/TriggerAF?wsdl";//des
$login    = "Whkcc";// DES "Whkcc";
$password = "Kccbpm12";  // des

*/
$client = new SoapClient($wsdlurl,
			array('login'      => $login,
				  'password'   => $password,
				  'trace'	   => true,
				  'exceptions' => true));
//var_dump($client->__getFunctions());


//A CONTINUACI�N EST�N LOS DATOS QUE DEBEN ENVIARSE AL WF.

$param = array(
"Resp"=>array("usuario"=>"USER.PRIVATE_DATASOURCE.un:".$uJefe),
"Solactivo"=>array("montoPresupuestado"=>$xppto
,"saldoPresupuesto"=>$xsaldo
,"NewElement"=>''
,"pais"=>$xpais
,"centroCosto"=>$xcentro
,"vidaUtil"=>''
,"descripcion"=>$xdescripcion
,"marca"=>$xmarca
,"valorPresupuestado"=>$xppto
,"nombreCentroCosto"=>$xnombre_centro
,"rutResponsable"=>$rutResponsable
,"numeroCentroCosto"=>$xcentro
,"serie"=>$xserie
,"compraPresupuestada"=>$xcompra_prog
,"elementoPep"=>''
,"valorCompra"=>$xvalor
,"cantidad"=>1
,"codigoPresupuesto"=>$xcodigo_1
,"saldoPresupuestoItem"=>$xsaldo
,"clase"=>$xclase
,"nombreResponsable"=>$nombre_responsable
,"lugar_uso"=>$xlugar
,"modelo"=>$xmodelo
,"centro"=>$xsucursal
,"condicion"=>'Nuevo'
,"emplazamiento"=>$xemplaza
,"ordenCo"=>''
,"anoPpto"=>$xcodigo_2
,"valorResidual"=>''
,"vidaUtilHoras"=>''
,"comentarios"=>$xobserva
,"textoEmplazamiento"=>''
,"textoCentro"=>''
)
,"montoPresupuestado"=>$xppto
,"saldoPresupuesto"=>$xsaldo
,"centroCosto"=>$xcentro."//".$xcentro
,"vidaUtil"=>''
,"marca"=>$xmarca
,"nombreCentroCosto"=>$xnombre_centro
,"rutResponsable"=>$rutResponsable
,"numeroCentroCosto"=>$xcentro
,"serie"=>$xserie
,"compraPresupuestada"=>$xcompra_prog
,"elementoPep"=>''
,"valorCompra"=>$xvalor
,"cantidad"=>1
,"codigoPresupuesto"=>$xcodigo_1
,"saldoPresupuestoItem"=>$xsaldo
,"nombreResponsable"=>$nombre_responsable
,"modelo"=>$xmodelo
,"centro"=>$xsucursal
,"emplazamiento"=>$xemplaza
,"ordenCo"=>''
,"anoPpto"=>$xcodigo_2
,"sociedad"=>'Komatsu Chile S.A.'
,"paisOrigen"=>$xpais
,"solicitadoPor"=>$xnombre_solicita
,"lugarUso"=>$xlugar
,"aprobador"=>$nombreJefe
,"fecha"=>date('d-m-Y')
,"cantidadBien"=>1
,"aprobar"=>true
,"valorPresupuestado"=>$xppto
,"descripcionBien"=>$xdescripcion
,"puedeaprobar"=>$Puedeaprobar
,"uresponsable"=>"USER.PRIVATE_DATASOURCE.un:".$usuarioSap
,"uresponsablececo"=>"USER.PRIVATE_DATASOURCE.un:".$uJefe
,"adjuntar"=>''
,"usolicitante"=>$xsolicitante
,"emailsolicitante"=>$xcorreo
,"emailrespcentrocosto"=>$emailJefe
,"uresponsablecentrocosto"=>$uJefe
,"codigocompania"=>$codCompania
,"folio"=>$folioAF
,"idarchivos"=>''
);


print_r($param);

//$result = $client -> NewOperation($param);


//  grabar registro en tabla


/*
include "../lib/database_sauce.php";

$sql="insert into flujo_solicitud
      (idsolicitud,idworkflow,fecha_creacion,informa_activo,fecha_informe_activo)
	  values($solicitud,$folioAF,getdate(),'N',convert(datetime,'01/01/3000',103)) ;";

$resul=$pdoGestion->query($sql);
//$resul=mssql_query($sql);

// genero correo

$mensaje=" <p>";
$mensaje.="Se ha generado un nueva solicitud de aprobacion de Activo Fiijo (WorkFlow) <p>";
$mensaje.="Numero Solicitud WorkFlow : $folioAF <p>";
$mensaje.="Numero Solicitud KCH : $solicitud <p>";
 $mensaje.="Komatsu Chile S.A.";

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From:  Unidad Contratos <presupuesto@komatsu.cl>    \r\n";
$lista_mail='';
$lista_mail=$xcorreo;
mail($lista_mail.',maria.aguilar@komatsu.cl,camila.pinto@komatsu.cl,marcela.villegas@komatsu.cl','Generación WorkFlow Activo Fijo',$mensaje,$headers);
	            

if ($resul)	  
    echo $folioAF;


*/

echo $folioAF;	

?>