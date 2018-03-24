 <?php
session_start();

$idusuario = $_SESSION["usuario"];


include "../lib/database.php";
include "../lib/database_amazon.php";


$sql="select convert(varchar,fecha,103) as fecha2,valor from tipo_cambio order by fecha desc;";
$resul=sqlsrv_query($actf,$sql);
$obj = sqlsrv_fetch_object($resul);
$fechatc=$obj->fecha2;
$tipo_cambio=round($obj->valor,2);


if(!isset($responsable))
	$responsable='';	
if(!isset($sucursal))
	$sucursal='';
if(!isset($valor))
	$valor=0;		
$opcion_centro='';		
$opcion_codigo='';	
$opcion_faena='';
// cargar faena según perfil usuario

include "CargaFaenaUsuario.php";


	
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

 
function cargacentro()
{
  var d=document.fm_asigna;
  ajax = nuevoajax();
  ajax.onreadystatechange = vercentros;//Quien me procesa los 4 estados
  ajax.open('GET','../rutinacarga/cargacentrofaena.php?faena='+d.faena.value, true);
  ajax.send(null);


}


function vercentros()
{ 
  if(ajax.readyState == 4)
  {
      //alert(ajax.responseText);
   var xml = ajax.responseXML;
   
   
   var largo = xml.getElementsByTagName('idcentro').length;
   //alert(largo);
   
   var jmodelo = xml.getElementsByTagName('idcentro');
   var jnombre = xml.getElementsByTagName('nombre');
   
   var select = document.getElementById("sucursal");
  
   select.length=0;
  
	 
   for (i = 0; i < largo; i++){
   
    select.options[i+1] = new Option(jmodelo[i].firstChild.nodeValue +'  ----->  '+jnombre[i].firstChild.nodeValue , jmodelo[i].firstChild.nodeValue);
	}
   
   }
  }
  
  
  
function cargaemplazamiento()
{
	
	var d=document.fm_asigna;
	ajax = nuevoajax();
        ajax.onreadystatechange = veremplazamiento;//Quien me procesa los 4 estados
        ajax.open('GET','../rutinacarga/cargaemplazamiento.php?centro='+d.sucursal.value, true);
        ajax.send(null);
	
}
	
	
function veremplazamiento()
{
	if(ajax.readyState == 4){
           var xml = ajax.responseXML;
   
   
   var largo = xml.getElementsByTagName('idemplaza').length;
   //alert(largo);
   
   var jmodelo = xml.getElementsByTagName('idemplaza');
   var jnombre = xml.getElementsByTagName('nombre');
   
   var select = document.getElementById("emplazamiento");
  
   select.length=0;
  
	 
   for (i = 0; i < largo; i++){
   
    
	  select.options[i+1] = new Option(jmodelo[i].firstChild.nodeValue +'  ----->  '+jnombre[i].firstChild.nodeValue , jmodelo[i].firstChild.nodeValue);
	}
   
   }
	
	
	
}	



function cargacentrocosto()
{
  var d=document.fm_asigna;
    
  ajax = nuevoajax();
  ajax.onreadystatechange = vercentrocosto//Quien me procesa los 4 estados
  ajax.open('GET','../rutinacarga/cargacentrocosto.php?faena='+d.faena.value, true);
  ajax.send(null);


}



function vercentrocosto()
{

//alert(ajax.responseText)
  
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


  

function cargainversion()
{
  var d = document.fm_asigna;
  ajax = nuevoajax();
  ajax.onreadystatechange = verinversion;//Quien me procesa los 4 estados
  ajax.open('GET','../rutinacarga/cargapresupuesto.php?ceco='+d.centro_costo.value, true);
  ajax.send(null);


}


function verinversion()
{

        if(ajax.readyState == 4){
	  
	// alert(ajax.responseText);  
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






function cargacosto()
{
    var  xcod=document.fm_asigna.codigo.value;

//alert(xcod);

 ajax = nuevoajax();
  ajax.onreadystatechange = cargapresupuesto//Quien me procesa los 4 estados
  ajax.open('GET','../rutinacarga/cargasaldo.php?codigo='+xcod, true);
  ajax.send(null);



}


function cargapresupuesto()
{

  if(ajax.readyState == 4){
//alert(ajax.responseText);
var out = ajax.responseText;

var lista = out.split('*');
   
document.fm_asigna.monto_presup.value=lista[1];
document.fm_asigna.ppto.value=lista[0];

document.fm_asigna.saldo_presup.value=lista[3];
document.fm_asigna.saldo.value=lista[2];


document.fm_asigna.tipoinv.value=lista[4];
document.fm_asigna.clase.value=lista[5];
document.fm_asigna.tipop.value=lista[6];


  }


}



function calculasaldo()
{
var d=document.fm_asigna;

if (isNaN(d.valor.value)==true) {
   alert("Dato Valor Compra debe ser Numerico ");
   return false
}


d.valor_dolar.value=d.valor.value/d.tc.value
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
	d.valor.value=0;
	d.valor_dolar.value=0;
	d.vdalor_dolar.value=0;
	return false;
  
   }

d.saldo2.value=parseFloat(msaldo);

d.saldo_presup.value=parseFloat(msaldo);


//d.saldo_presup.value=Decimales(d.saldo_presup.value, 2);

d.valor_dolar.value=Decimales(d.valor_dolar.value, 2);

d.saldo_presup.value=formatNumber(d.saldo_presup.value,2,',','.','','','-','');

d.valor_dolar.value=formatNumber(d.valor_dolar.value,2,',','.','','','-','');



//roundNumber();
//roundNumber1();
 
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




function formatNumber(num,dec,thou,pnt,curr1,curr2,n1,n2) 
{
    var x = Math.round(num * Math.pow(10,dec));if (x >= 0) n1=n2='';var y = (''+Math.abs(x)).split('');var z = y.length - dec; if (z<0) z--; for(var i = z; i < 0; i++) y.unshift('0');y.splice(z, 0, pnt); if(y[0] == pnt) y.unshift('0'); while (z > 3) {z-=3; y.splice(z,0,thou);}var r = curr1+n1+y.join('')+n2+curr2;return r;
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
  if(ajax.readyState == 4){
	 //alert(ajax.responseText);  
     var out = ajax.responseText;
	 if (out==0) {
	     alert('Rut No Existe o No esta Habilitado en la Compañia')
		 d.nombre_responsable.value='';
		 return false;
		
	 }
	 
	/*if(out==1){
		alert('Rut No esta Habilitado en la Compa�ia')
		d.nombre_responsable.value='';
		return false;
		}
	*/
	
	if ((out!==0) || (out!==1))	{
		//alert('sdsdsdsdsdsdsd');
		
	   d.nombre_responsable.value=out;
	}
		
  }
  
  
  
  
}



</script>
<link rel="stylesheet" type="text/css" href="../css/estilo.css" />
<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#FFFFCC" >
<br>
<br>
			
<form name="fm_asigna" method="post"  >
<input name="ppto" type="hidden">
<input name="saldo" type="hidden">
<input name="saldo2" type="hidden">
<input name="vdolar" type="hidden">
<input name="tipoinv" type="hidden">
<input name="clase" type="hidden">
<input name="tipop" type="hidden">

<input name="tc" type="hidden" value="<?=$tipo_cambio?>">
	
	<table width="95%" align="center" class="tablabase">
				 <tr></tr>
				   <tr>
				   <td>
     	  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">   
                 <tr>
					  <td class="titledatos" width="150">Rut Responsable</td>
					  <td width="2%"></td>
					  <td >
					  <input name="responsable" value="" type="text"  size="10" maxlength="11"  onkeydown="revisar()" >
					  <input name="nombre_responsable" value="" type="text"  size="40" maxlength="45" readonly ></td>
                      
		</tr>
		<tr></tr>
                <tr>
					  <td class="titledatos" width="150">Sucursal o Faena </td>
					  <td width="2%"></td>
                                          <td > 
                                              
                                              <select name="faena" onChange="cargacentro()" id="faena">
                                             <option value=-1></option>
                                              <?php echo $opcion_faena?>
                                              
                                              </select>
                                              
                                              
                                          </td>
					  
		</tr>
		<tr></tr>
          
          
           
					
					
                    <tr>
					  <td class="titledatos"width="150">Centro (Sucursal)</td>
					  <td width="2%"></td>
					  <td ><select name='sucursal' onChange="cargaemplazamiento()" id="sucursal">
                      
                      </select>
					 </td>
					</tr>
                    
                    
                    <tr>
					  <td class="titledatos"width="150">Emplazamiento</td>
					  <td width="2%"></td>
					  <td ><select name='emplazamiento' onChange="cargacentrocosto();" id="emplazamiento">
                      
                      </select>
					 </td>
					</tr>
                    
                    
                    <tr></tr>
                    
                    <tr>
					  <td class="titledatos"width="150">Centro Costo</td>
					  <td width="2%"></td>
					  <td >
					  <select name='centro_costo'onChange="cargainversion()" id="centro_costo">
                     
                     
                      </select></td>
					</tr>
                    
					<tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Código Presupuesto</td>
					  <td width="2%"></td>
					  <td >
                      <select name='codigo'onChange="cargacosto();" id="codigo">
                      
                     
                      </select>
					  </td>
					</tr>
					
                    
                    <tr></tr>
                    
                    <tr>
					  <td class="titledatos"width="150">Lugar Uso Bien</td>
					  <td width="2%"></td>
					  <td colspan="3" >
                      
                      <input name="lugar_uso" type="text" value="" size="45" maxlength="40">
					 </td>
					</tr>
                    
                    
					<tr></tr>
					
                    <tr>
					  <td class="titledatos"width="150">Valor Compra (Pesos)</td>
					  <td width="2%"></td>
					  <td >
					  <input name="valor" type="text" value="" size="20" maxlength="10"  onchange="calculasaldo();" class="numeros" ></td>
					</tr>
					<tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Valor Compra (Dolar)</td>
					  <td width="2%"></td>
					  <td colspan="4" >
					  <input name="valor_dolar" type="text" value="" size="20" maxlength="10"  class="numeros" readonly>
                       <strong>
                      <? echo 'Tipo Cambio : '.$tipo_cambio.' Fecha T/C : '.$fechatc ?>
                      </strong>
                      </td>
                      
					</tr>
					<tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Monto Presupuesto</td>
					  <td width="2%"></td>
					  <td >
					  <input name="monto_presup" type="text" value="0" size="20" maxlength="10" readonly class="numeros" >
                      </td>
                     
					</tr>
					<tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Saldo Presupuesto</td>
					  <td width="2%"></td>
					  <td >
					  <input name="saldo_presup" type="text" value="0" size="20" maxlength="10"  readonly class="numeros"></td>
					</tr>
					<tr></tr>
                    <tr></tr>
                    <tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Observaciones</td>
					  <td width="2%"></td>
					  <td >
					  <input name="comentarios" type="text" size="100" maxlength="100"  ></td>
					</tr>
                    
					
		</table>
	</td>
	</tr>	
	</table> 
</form>
<br>


</body>

