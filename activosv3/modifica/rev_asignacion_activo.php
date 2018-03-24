<?php
session_start();
$idusuario=$_SESSION["usuario"];
$solicitud=$_GET["solicitud"];
include "../lib/database.php";
include "../lib/database_amazon.php";

$sql="select a.idfaena,b.periodo,a.codigo_presupuesto,a.responsable_activo,a.sucursal,d.nombre_emplazamiento,a.idcentro_costo,a.lugar_uso,a.valor_pesos,a.valor_compra,a.tipo_cambio,a.emplazamiento,a.sucursal,a.observaciones from formulario_activo a
      left join presupuesto_inversion  b on a.codigo_presupuesto=b.correlativo
      left join faena_emplazamiento d on a.idfaena=d.idfaena and a.sucursal=d.emplazamiento
      where idformulario=$solicitud";
//echo $sql;
$resul=sqlsrv_query($actf,$sql);
$obj = sqlsrv_fetch_object($resul);
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
$xsucursal=$obj->sucursal;
$xobservaciones=$obj->observaciones;

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


// cargar emplazamiento

$opcion_emplaza="";

$sql="select idcentro,idemplazamiento,nombre_emplazamiento from centro_logistico where centro_logistico='$xsucursal' ;";
//echo $sql;
$resul=sqlsrv_query($actf,$sql);

$ind=0;
while ($obj = sqlsrv_fetch_object($resul))
{
        if ($obj->idcentro==$xemplaza)
	   $opcion_emplaza.="<option value=$obj->idcentro selected >$obj->idemplazamiento ---> $obj->nombre_emplazamiento </option>";
	else
	   $opcion_emplaza.="<option value=$obj->idcentro >$obj->idemplazamiento--->$obj->nombre_emplazamiento </option>";    
				
				
}

//  recalculo el saldo

$sql="select valor_presupuesto from presupuesto_inversion where correlativo='$xcorr' and periodo=$xperiodo";

//echo $sql;
$resul=sqlsrv_query($actf,$sql);
$obj=sqlsrv_fetch_object($resul);
$xxppto=$obj->valor_presupuesto;


$sql="select sum(valor_compra) as saldo,sum(valor_real) as saldo1 from formulario_Activo where codigo_presupuesto='$xcorr' and status_solicitud='A' ;";
$resul=sqlsrv_query($actf,$sql);
$obj=sqlsrv_fetch_object($resul);
$rows=sqlsrv_has_rows($resul);
if ($rows===true)
{
    if ($obj->saldo== null)
        $xacum=0;
    else    
        $xacum=$obj->saldo;
    if ($obj->saldo1 == null)
        $xacum2=0;
    else    
        $xacum2=$obj->saldo;
}
   
else
   $xacum=0;  $xacum1=0;

$xsaldo=($xxppto-($xacum+$xacum2));

$opcion_codigo='';	

// inverion por faena
$sql="select a.correlativo,a.descripcion,a.valor_presupuesto from presupuesto_inversion  a
      where  a.idcentro_costo='$xccosto' and a.periodo=$xperiodo and a.status_codigo='A' and  tipo_presupuesto in ('N','C') ;";
$resul=sqlsrv_query($actf,$sql);

$monto_presupuesto=0;
while($obj=sqlsrv_fetch_object($resul)){
	 if ($xcorr==$obj->correlativo){
	    $opcion_codigo.="<option value=$obj->correlativo selected >$obj->correlativo ----> $obj->descripcion </option>";
	    $monto_presupuesto=$obj->valor_presupuesto;
	 }
	 else
	    $opcion_codigo.="<option value=$obj->correlativo >$obj->correlativo ----> $obj->descripcion </option>";
	
	}		   


// centro costos
$opcion_centro='';
$sql="select a.ceco,a.nombre_ceco,c.nombre_faena from dim_cebe_ceco a
      left join dim_faena_cebe b on a.cebe=b.cebe
      left join dim_faenas c on b.idfaena=c.idfaena
      where c.idfaena=$xfaena ;";
//echo $sql;
$resul=sqlsrv_query($amazon,$sql);

while($obj=sqlsrv_fetch_object($resul)){
         $xnombre_faena=$obj->nombre_faena;
	 if ($xccosto==$obj->ceco)
	    $opcion_centro.="<option value=$obj->ceco selected >$obj->ceco ----> $obj->nombre_ceco </option>";
	 else
	    $opcion_centro.="<option value=$obj->ceco >$obj->ceco ----> $obj->nombre_ceco </option>";
	
	}		  



//  	
	
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

 
function cargainversion(){
  var d = document.fm_asigna;

  ajax = nuevoajax();
  ajax.onreadystatechange = verinversion;//Quien me procesa los 4 estados
  ajax.open('GET','../rutinacarga/cargapresupuesto.php?ceco='+d.centro.value, true);
  ajax.send(null);


}


function verinversion(){

  //alert(ajax.responseXML);
  
  if(ajax.readyState == 4)
  {
   var xml = ajax.responseXML;
   
   
   var largo = xml.getElementsByTagName('idinversion').length;
   //alert(largo);
   
   var jmodelo = xml.getElementsByTagName('idinversion');
   var jnombre = xml.getElementsByTagName('nombre');
   
   var select = document.getElementById("codigo");
  
   select.length=0;
  
	 
   for (i = 0; i < largo; i++){
   
    select.options[i+1] = new Option(jmodelo[i].firstChild.nodeValue +'  ----->  '+jnombre[i].firstChild.nodeValue , jmodelo[i].firstChild.nodeValue);
	}
   
   }
  }


function cargacentrocosto()
{
  var faenaxx = document.fm_asigna.faena.value;

  
  
  ajax = nuevoajax();
  ajax.onreadystatechange = vercentrocosto//Quien me procesa los 4 estados
  ajax.open('GET','../rutinacarga/cargacentrocosto.php?faena='+faenaxx, true);
  ajax.send(null);


}



function vercentrocosto(){


  
  if(ajax.readyState == 4){
   var xml = ajax.responseXML;
   
   
   var largo = xml.getElementsByTagName('idccosto').length;
   //alert(largo);
   
   var jmodelo = xml.getElementsByTagName('idccosto');
   var jnombre = xml.getElementsByTagName('nombre');
   
   var select = document.getElementById("centro_costo");
  
   select.length=0;
  
	 
   for (i = 0; i < largo; i++){
   
    select.options[i+1] = new Option(jmodelo[i].firstChild.nodeValue +'  ----->  '+jnombre[i].firstChild.nodeValue , jmodelo[i].firstChild.nodeValue);
	}
   
   }
  }




function cargacosto(){
var  xcod=document.fm_asigna.codigo.value;

//alert(xcod);

 ajax = nuevoajax();
  ajax.onreadystatechange = cargapresupuesto//Quien me procesa los 4 estados
  ajax.open('GET','../rutinacarga/cargasaldo.php?codigo='+xcod, true);
  ajax.send(null);



}


function cargapresupuesto(){

 if(ajax.readyState == 4)
 {

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


//alert( ajax.responseText)
/*alert(ajax.readyState);
 if(ajax.readyState == 4){
   var out = ajax.responseText;
   
   document.fm_asigna.monto_presup.value=out;
   
   }
*/
//cargacentrocosto();
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


function revisar()
{


var teclaASCII=event.keyCode 


   if (teclaASCII==13){
	   
	  var d=document.fm_asigna;
	  if (isBlanco(d.responsable.value)){
		 alert('Debe Ingresar Rut Responsable');
		 return false  
	  }
	

       revisa_rut()
	
     }


}


function revisa_rut()
{
	var d=document.fm_asigna;
	
	if (!isBlanco(d.responsable.value)){
	
	   ajax = nuevoajax();
       ajax.onreadystatechange = revisa_carga_rut//Quien me procesa los 4 estados
       //ajax.open('GET','../rutinacarga/revisa_rut.php?rut='+d.responsable.value, true);
	   ajax.open('GET','../rutinacarga/revisa_rut_ws.php?rut='+d.responsable.value, true);
       ajax.send(null); 
	
	
	}
}




function revisa_carga_rut()
{

  
  var d=document.fm_asigna 
  if(ajax.readyState == 4)
  {
	 // alert(ajax.responseText);  
     var out = ajax.responseText;
	 if (out==0) 
         {
	     alert('Rut No existe o No esta Habilitado en la Compañia')
		 d.nombre_responsable.value='';
		 return false;
		
	 }
	 
	if(out==1)
        {
		alert('Rut No esta Habilitado en la Compañia')
		d.nombre_responsable.value='';
		return false;
		}
	
	
	if ((out!==0) || (out!==1))	{
		//alert('sdsdsdsdsdsdsd');
		
	   d.nombre_responsable.value=out;
	}
		
  }
  
  
  
   
}




function grabar()
{
	
	var d=document.fm_asigna;
	if (isBlanco(d.responsable.value))
        {
		 alert('Debe Ingresar Rut Responsable');
		 return false  
	  }
	ajax = nuevoajax();
        ajax.onreadystatechange = revisa_grabar_rut//Quien me procesa los 4 estados
        ajax.open('GET','../rutinacarga/revisa_rut_ws.php?rut='+d.responsable.value, true);
        ajax.send(null);   
	  
	
	
	
    }
	



function revisa_grabar_rut()
{
  
  var d=document.fm_asigna ;
  if(ajax.readyState == 4)
  {
	 
	 var out = ajax.responseText;   
	 if (out==0)
         {
	     alert('Rut No existe')
		 return false;
		
	 }
	 
	if(out==1)
        {
		alert('Rut No esta Habilitado en la Compa�ia')
		return false;
	}
	
	
	if ((out!==0) || (out!==1))	
        {
		
		//  otra revisiones
		
		if (d.emplazamiento.value<=0)
                {
			alert('Debe Seleccionar Emplazamiento');
                        return false;
		}
		
		if (isBlanco(d.lugar_uso.value))
                {
                 alert('Debe Ingresar Lugar Uso');
                 return false;
                }
		
		if (d.codigo.value<=0)
                {
                    alert('Debe Ingresar Código Inversión  ');
                   return false;
                 }

       if (isBlanco(d.centro.value)){
           alert('Debe Ingresar Centro Costo  ');
           return false;
       }

       if (d.valor_pesos.value<=0){
           alert('Debe Ingresar Costo Compra  ');
           return false;
       }

       if (isBlanco(d.comentarios.value)){
           alert('Debe Ingresar Observaciones');
           return false;
       }
       
       if (isBlanco(d.lugar_uso.value)){
           alert('Debe Ingresar Lugar Uso');
           return false;
       }
       // revisar saldo
       
       var presup= parseFloat(d.ppto.value);
       var saldo = parseFloat(d.saldo.value);
       var saldo2 = parseFloat(d.saldo2.value);


	
       if (presup>0)
          {	
	
	//alert(f3.saldo_presup.value+'  '+f3.saldo2.value+'   '+f3.saldo.value);
      	    if (saldo2<0)
               {
	
	          if (saldo2*-1>(saldo*0.05))
                      {
	 	        alert('Saldo Presupuesto No debe ser Mayor a 5% Monto Presupuesto');
		        d.valor_pesos.value=d.pesos.value;
                        d.valor_dolar.value=d.dolar.value;        
                        d.saldo_presup.value=d.saldo.value;        
	       	        return false;
		      }
	
	       } 
           }
       
       ajax = nuevoajax();
       ajax.onreadystatechange = graba_modificacion//Quien me procesa los 4 estados
       ajax.open('POST','../acciones/grabar_03_modificacion.php?solicitud='+d.solicitud.value+'&codigo='+d.codigo.value+'&centro='+d.centro.value+'&lugar='+d.lugar_uso.value+'&valor_pesos='+d.valor_pesos.value+'&responsable='+d.responsable.value+'&emplaza='+d.emplazamiento.value+'&observacion='+d.comentarios.value, true);
       ajax.send(null);
		
	} 

        }
	  
}

 
function graba_modificacion()
{
    // alert('hola 2'); 
	//alert(ajax.responseText);
    if(ajax.readyState == 4)
    {
	   var out = ajax.responseText; 
           //alert(out);
	   if (out==0)
	      alert('Datos Grabados');
	   if (out==1)	  
	       alert('Error al Grabar Modificacion');
	   
	}
}


function roundNumber() 
{
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





function roundNumber1()
{
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





function Decimales(Numero, Decimales)
{

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
<input name="ppto" type="hidden" value="<?php echo $monto_presupuesto?>">
<input name="saldo" type="hidden" value="<?php echo $xsaldo?>">
<input name="saldo2" type="hidden" >
<input name="pesos" type="hidden" value="<?php echo $xpesos?>">
<input name="dolar" type="hidden" value="<?php echo $xdolar?>">
<input name="vdolar" type="hidden" >
<input name="cambio" type="hidden" value="<?php echo $xcambio?>">
<input name="inv_orig" type="hidden" value="<?php echo $xcorr?>">
<input name="solicitud" type="hidden" value="<?php echo$solicitud?>">


	
	<table width="95%" align="center" class="tablabase">
				 
                 <tr>
                    <td>
                      <img src="../img/46.png" align="right" alt="Grabar" border="1" style="cursor:hand" onClick="javascript:grabar();">
                    </td>
                 </tr>
                 <tr>
                 <td>   
			<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">   
                 <tr>
					  <td class="titledatos" width="150">Rut Responsable</td>
					  <td width="2%"></td>
					  <td >
					  <input name="responsable" value="<?php echo $xresponsable?>" type="text"  size="20" maxlength="20"   onkeydown="revisar()">
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
					  <td ><select name='emplazamiento' onChange="" id="emplazamiento">
                      <option value=-1></option>
                      <?php echo $opcion_emplaza?> </td>
                      </select>
					 </td>
					</tr>
                    
                    <tr></tr>
                    
                    <tr>
					  <td class="titledatos"width="150">Centro Costo</td>
					  <td width="2%"></td>
					  <td >
					  <select name='centro'onChange="cargainversion();" id="centro">
                      <option value=-1></option>
                      <?php echo $opcion_centro?>
                     </select></td>
					</tr>
                    
                    <tr></tr>
                    
                    <tr>
					  <td class="titledatos"width="150">Código Presupuesto</td>
					  <td width="2%"></td>
					  <td >
                      <select name='codigo'onChange="cargacosto()" id="codigo">
                      <option value=-1></option>
                      <?php echo $opcion_codigo?>
                     </select>
					  </td>
					</tr>
					<tr></tr>
                    
                    
                    
                    <tr>
					  <td class="titledatos"width="150">Lugar Uso Bien</td>
					  <td width="2%"></td>
					  <td >
                      
                      <input name="lugar_uso" type="text" value="<?php echo $xuso?>" size="45" maxlength="40" >
					 </td>
					</tr>
                    
                    
					<tr></tr>
					
                    <tr>
					  <td class="titledatos"width="150">Valor Compra (Pesos)</td>
					  <td width="2%"></td>
					  <td >
					  <input name="valor_pesos" type="text" value="<?php echo $xpesos?>" size="20" maxlength="10"  class="numeros" onChange="calculasaldo();" ></td>
					</tr>
					<tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Valor Compra (Dolar)</td>
					  <td width="2%"></td>
					  <td >
					  <input name="valor_dolar" type="text" value="<?php echo number_format($xdolar,2,'.',',')?>" size="20" maxlength="10"  class="numeros" readonly></td>
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
					  <td class="titledatos"width="150">Saldo Presupuesto</td>
					  <td width="2%"></td>
					  <td >
					  <input name="saldo_presup" type="text" value="<?php echo number_format($xsaldo,2,'.',',')?>" size="20" maxlength="10"  readonly class="numeros"></td>
					</tr>
					<tr></tr>
                     <tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Observaciones</td>
					  <td width="2%"></td>
					  <td >
					  <input name="comentarios" type="text" size="100" maxlength="100" value="<?php echo $xobservaciones?>" id="comentarios" ></td>
					</tr>
					
		</table>
	</td>
	</tr>	
	</table> 
</form>
<br>


</body>

