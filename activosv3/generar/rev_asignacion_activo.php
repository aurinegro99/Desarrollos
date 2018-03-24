<?php

$solicitud=$_GET["solicitud"];

include "../lib/database.php";
include "../lib/database_amazon.php";


if(!isset($solicitud))
   $solicitud=0;
   
$xzemplaza='';
$xcentro='';   
$xnombre_faena='';
$xresponsable='';
$xnombre_resp='';
$xsucursal='';
$xcodigo='';
$xuso='';
$xpesos='';
$xdolar='';
$xobservaciones='';
$monto_presupuesto=0;
$xsaldo=0;

if ($solicitud>0){

$sql="select a.idfaena,b.periodo,a.codigo_presupuesto,a.responsable_activo,a.sucursal,d.nombre_emplazamiento,a.idcentro_costo,a.lugar_uso,a.valor_pesos,a.valor_compra,a.tipo_cambio,a.emplazamiento,a.observaciones from formulario_activo a
      left join presupuesto_inversion  b on a.codigo_presupuesto=b.correlativo
      left join faena_emplazamiento d on a.idfaena=d.idfaena and a.sucursal=d.emplazamiento
      where idformulario=$solicitud";

$resul=sqlsrv_query($actf,$sql);
$obj=sqlsrv_fetch_object($resul);

$xfaena=$obj->idfaena;
$xperiodo=$obj->periodo;
$xcorr=$obj->codigo_presupuesto;
$xresponsable=$obj->responsable_activo;
$xsucursal=$obj->sucursal;
$xemplazamiento=$obj->nombre_emplazamiento;
$xccosto=$obj->idcentro_costo;
$xuso=$obj->lugar_uso;
$xpesos=$obj->valor_pesos;
$xdolar=$obj->valor_compra;
$xcambio=$obj->tipo_cambio;
$xemplaza=$obj->emplazamiento;
$xobservaciones=$obj->observaciones;
// buscar faena

$sql="select nombre_faena from dim_faenas where idfaena=$xfaena ";
$resul=sqlsrv_query($amazon,$sql);
$obj=sqlsrv_fetch_object($resul);
$xnombre_faena=$obj->nombre_faena;
                
//  rescata desde ws el nombre del responsable

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

$param = array("rut"=>"$xresponsable");

$result = $client -> datosEmpleado($param);


//print_r($result);


$xnombre_resp=$result->Response->nombre;

// centro costo

$sql="select nombre_ceco from dim_cebe_ceco where ceco='$xccosto' ;";
$resul=sqlsrv_query($amazon,$sql);
$obj=sqlsrv_fetch_object($resul);
$xnombre_costo=$obj->nombre_ceco;
//echo $sql;
$xcentro=$xccosto.'-->'.$xnombre_costo;


// cargar emplazamiento


if (strlen($xemplaza)>0){
    $sql="select idemplazamiento,nombre_emplazamiento from centro_logistico where idcentro=$xemplaza ;";
    $resul=sqlsrv_query($actf,$sql);
    $obj=sqlsrv_fetch_object($resul);
    $d1=$obj->idemplazamiento;
    $d2=$obj->nombre_emplazamiento;
    $xzemplaza=$d1.'-->'.$d2;
}

// presupuesto

$sql="select descripcion,valor_presupuesto from presupuesto_inversion where correlativo='$xcorr' ";
$resul=sqlsrv_query($actf,$sql);
$obj=sqlsrv_fetch_object($resul);
$nombre_ppto=$obj->descripcion;
$monto_presupuesto=$obj->valor_presupuesto;
$xcodigo=$xcorr.'--->'.$nombre_ppto;
            

}


?>

<script language="JavaScript" type="text/JavaScript">

function nuevoajax() 
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false;
	try
	{
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e)
	{
		try
		{
			// Creacion del objet AJAX para IE
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E)
		{
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
		}
	}
	return xmlhttp; 
}



function isBlanco(texto)
   {
   largo = texto.length
   for (i=0; i < largo ; i++ )
       if ( texto.charAt(i) !=" ")
          return false;
return true
   }


function cargapresupuesto(){

//alert(ajax.responseText)
var out = ajax.responseText;

var lista = out.split('*');
   
document.fm_asigna.monto_presup.value=lista[1];
document.fm_asigna.ppto.value=lista[0];

document.fm_asigna.saldo_presup.value=lista[3];
document.fm_asigna.saldo.value=lista[2];

document.fm_asigna.valor_pesos.value=0;
document.fm_asigna.valor_dolar.value=0;



}



function calculasaldo(){
var d=document.fm_asigna;

if (isNaN(d.valor_pesos.value)==true) { 
   alert("Dato Valor Compra debe ser Numerico ");
   return false
}




d.valor_dolar.value=d.valor_pesos.value/d.cambio.value
if (d.saldo.value>=0){



var msaldo= parseFloat(d.saldo.value) - parseFloat(d.valor_dolar.value);}

else{
       var msaldo= d.saldo.value*-1 //+ parseFloat(d.valor_dolar.value);
	   msaldo=msaldo+parseFloat(d.valor_dolar.value);
	   msaldo=msaldo*-1;
	   }


//alert(msaldo);

d.vdolar.value=d.valor_dolar.value;

if (d.vdolar.value<100)
   {
    alert('Valor Compra Mayor a 100 Dolares ');
	d.valor_pesos.value=0;
	d.valor_dolar.value=0;
	d.vdolar.value=0;
	return false;
  
   }

d.saldo2.value=parseFloat(msaldo);

d.saldo_presup.value=parseFloat(msaldo);


//d.saldo_presup.value=Decimales(d.saldo_presup.value, 2);

d.valor_dolar.value=Decimales(d.valor_dolar.value, 2);

d.saldo_presup.value=formatNumber(d.saldo_presup.value,2,',','.','','','-','');

d.valor_dolar.value=formatNumber(d.valor_dolar.value,2,',','.','','','-','');





}


function roundNumber() {
	var numberField = document.fm_asigna.saldo_presup; // Field where the number appears
	var rnum = numberField.value;
	var rlength = 2; // The number of decimal places to round to
	if (rnum > 8191 && rnum < 10485) {
		rnum = rnum-5000;
		var newnumber = Math.round(rnum*Math.pow(10,rlength))/Math.pow(10,rlength);
		newnumber = newnumber+5000;
	} else {
		var newnumber = Math.round(rnum*Math.pow(10,rlength))/Math.pow(10,rlength);
	}
	numberField.value = newnumber;
}





function roundNumber1() {
	var numberField = document.fm_asigna.valor_dolar; // Field where the number appears
	var rnum = numberField.value;
	var rlength = 2; // The number of decimal places to round to
	if (rnum > 8191 && rnum < 10485) {
		rnum = rnum-5000;
		var newnumber = Math.round(rnum*Math.pow(10,rlength))/Math.pow(10,rlength);
		newnumber = newnumber+5000;
	} else {
		var newnumber = Math.round(rnum*Math.pow(10,rlength))/Math.pow(10,rlength);
	}
	numberField.value = newnumber;
}





function Decimales(Numero, Decimales) {

	pot = Math.pow(10,Decimales);
	num = parseInt(Numero * pot) / pot;
	nume = num.toString().split('.');

	entero = nume[0];
	decima = nume[1];

	if (decima != undefined) {
		fin = Decimales-decima.length; }
	else {
		decima = '';
		fin = Decimales; }

	for(i=0;i<fin;i++)
	  decima+=String.fromCharCode(48); 

	num=entero+'.'+decima;
	return num;
}



function formatNumber(num,dec,thou,pnt,curr1,curr2,n1,n2) {var x = Math.round(num * Math.pow(10,dec));if (x >= 0) n1=n2='';var y = (''+Math.abs(x)).split('');var z = y.length - dec; if (z<0) z--; for(var i = z; i < 0; i++) y.unshift('0');y.splice(z, 0, pnt); if(y[0] == pnt) y.unshift('0'); while (z > 3) {z-=3; y.splice(z,0,thou);}var r = curr1+n1+y.join('')+n2+curr2;return r;}


</script>
<link rel="stylesheet" type="text/css" href="../css/estilo.css" />
<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#FFFFCC" >
<br>
<br>
			
<form name="fm_asigna" method="post"  >


	
	<table width="95%" align="center" class="tablabase">
				 <tr>
                 <td>   
			<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">   
                 <tr>
					  <td class="titledatos" width="150">Rut Responsable</td>
					  <td width="2%"></td>
					  <td >
					  <input name="responsable" value="<?php echo $xresponsable?>" type="text"  size="20" maxlength="20" readonly>
                      <input name="nombre_responsable" value="<?php echo $xnombre_resp?>" type="text"  size="40" maxlength="45" readonly ></td>
                      </td>
                      
					</tr>
					<tr></tr>
                    
               
                 <tr>
					  <td class="titledatos" width="150">Faena </td>
					  <td width="2%"></td>
					  <td >
					  <input name="faena" value="<?php echo $xnombre_faena?>" type="text"  size="45" maxlength="40" readonly></td>
					</tr>
					<tr></tr>
          
          
           
					
					
                    <tr>
					  <td class="titledatos"width="150">Centro (Sucursal)</td>
					  <td width="2%"></td>
					  <td ><input name="sucursal" value="<?php echo $xsucursal.'  '.$xemplazamiento?>" type="text"  size="45" maxlength="40" readonly></td>
					 </td>
					</tr>
					<tr></tr>
                    
                     <tr>
					  <td class="titledatos"width="150">Emplazamiento</td>
					  <td width="2%"></td>
					  <td ><input name="emplazamiento" type="text" value="<?php echo $xzemplaza?>" size="60" maxlength="40" readonly > </td>
					</tr>
                    
                    <tr></tr>
                    
                    <tr>
					  <td class="titledatos"width="150">Centro Costo</td>
					  <td width="2%"></td>
					  <td > <input name="centro" type="text" value="<?php echo $xcentro?>" size="60" maxlength="40" readonly ></td>
					</tr>
                    
                    <tr></tr>
                    
                    <tr>
					  <td class="titledatos"width="150">Código Presupuesto</td>
					  <td width="2%"></td>
					  <td > <input name="codigo" type="text" value="<?php echo $xcodigo?>" size="100" maxlength="40" readonly > </td>
					  </td>
					</tr>
					<tr></tr>
                    
                    
                    
                    <tr>
					  <td class="titledatos"width="150">Lugar Uso Bien</td>
					  <td width="2%"></td>
					  <td ><input name="lugar_uso" type="text" value="<?php echo $xuso?>" size="45" maxlength="40" readonly > </td>
					</tr>
                    
                    
					<tr></tr>
					
                    <tr>
					  <td class="titledatos"width="150">Valor Compra (Pesos)</td>
					  <td width="2%"></td>
					  <td >
					  <input name="valor_pesos" type="text" value="<?=$xpesos?>" size="20" maxlength="10"  class="numeros" readonly ></td>
					</tr>
					<tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Valor Compra (Dolar)</td>
					  <td width="2%"></td>
					  <td >
					  <input name="valor_dolar" type="text" value="<?=number_format($xdolar,2,'.',',')?>" size="20" maxlength="10"  class="numeros" readonly></td>
					</tr>
					<tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Monto Presupuesto</td>
					  <td width="2%"></td>
					  <td >
					  <input name="monto_presup" type="text" value="<?php echo number_format($monto_presupuesto,2,'.',',')?>" size="20" maxlength="10" readonly class="numeros" ></td>
					</tr>
					
                     <tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Observaciones</td>
					  <td width="2%"></td>
					  <td >
					  <input name="comentarios" type="text" size="100" maxlength="100" value="<?php echo $xobservaciones?>" id="comentarios" readonly ></td>
					</tr>
					
		</table>
	</td>
	</tr>	
	</table> 
</form>
<br>


</body>

