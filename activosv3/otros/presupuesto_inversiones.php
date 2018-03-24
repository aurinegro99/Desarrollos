<?php
session_start();
$idusuario = $_SESSION["usuario"];


include "../header/header.php"; 
include "../lib/database.php";
include "../lib/database_amazon.php";

// cargar periodos
$opcion_periodo='';
$sql="select idperiodo from periodos_inversion where activo='A' order by idperiodo ";
$resule=sqlsrv_query($actf,$sql);
while($obj = sqlsrv_fetch_object($resule))
{
    $opcion_periodo.="<option value=$obj->idperiodo >$obj->idperiodo</option>";
}


$opcion_gerencia='';

include "../rutinacarga/CargaGerenciaUsuario.php";


?>


<script language="JavaScript" type="text/JavaScript">


var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
  if(popUpWin)
  {
    if(!popUpWin.closed) popUpWin.close();
  }
  popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}


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





function Limpiar()
{
 window.location.href='presupuesto_inversiones.php';
  
  
 
  
}

function cargafaenas()
{

   // alert('hola');
	
	d=document.fm_cabecera;
	
	if (d.periodo.value<=0){
	   d.faena.length=0;
	   //d.inversion.length=0;
	   return false
	}
	
	ajax = nuevoajax();
    ajax.onreadystatechange = verfaena;//Quien me procesa los 4 estados
	ajax.open('GET','../rutinacarga/cargafaenasgerenciausuario.php?cod_gerencia='+d.gerencia.value, true);
    ajax.send(null);
	
	
	

} 


function verfaena()
{
  
  if(ajax.readyState == 4)
  {
      
     //alert(ajax.responseText);
   var xml = ajax.responseXML;
   
   
   var largo = xml.getElementsByTagName('idfaena').length;
   //alert(largo);
   
   var jmodelo = xml.getElementsByTagName('idfaena');
   var jnombre = xml.getElementsByTagName('nombre');
   
   var select = document.getElementById("faena");
  
   select.length=0;
  
	 
   for (i = 0; i < largo; i++)
   {
   
    select.options[i+1] = new Option(jnombre[i].firstChild.nodeValue, jmodelo[i].firstChild.nodeValue);
   
   }
  }
  
  

}

    
    
    
    

function cargainversion(){
 
     var xfaena = document.getElementById("faena").value;
     var xperiodo = document.getElementById("periodo").value;
    
    
    
    iframeForm.reset();
  
	iframeForm.faena.value= xfaena;
	iframeForm.periodo.value= xperiodo;
	iframeForm.action = "../iframes/ifrm_genera_inversion.php";
    iframeForm.target = "ifrm1";
    iframeForm.submit ();  
    

}


function carga_resumen(){
	var d=document.fm_cabecera;
	if (d.faena.value>0)
	   ajax = nuevoajax();
       ajax.onreadystatechange = verppto1;//Quien me procesa los 4 estados
	   ajax.open('GET','../rutinacarga/carga_inversion.php?idfaena='+d.faena.value+'&idperiodo='+d.periodo.value, true);
       ajax.send(null);
    
    
    
    
	
	}


function verppto1(){
	if(ajax.readyState == 4)
    {
	 //alert(ajax.responseText);	
	  	
	  var out = ajax.responseText;
	  var lista=out.split('*');
	  
	  var d=document.fm_cabecera;
	  d.total_inv.value=formatNumber(parseFloat(lista[0]),2,',','.','','','-','');
	  d.total_compo.value=formatNumber(parseFloat(lista[1]),2,',','.','','','-','');
	  d.total_general.value=formatNumber(parseFloat(lista[0])+parseFloat(lista[1]),2,',','.','','','-','');
	  
	  
	  //d.valor_dolar.value=formatNumber(d.valor_dolar.value,2,',','.','','','-','');
	 
	  
	  // traer saldo disponible faena
	}
	
}
 
 
 
function ver_inversion(zcorr){
	
	
	
	 popUpWindow('../ventanas/consulta_inversion_presupuesto.php?corr='+zcorr+'&idfaena='+d.faena.value+'&idperiodo='+d.periodo.value,100,0,1200,400);	
	
	} 


function nuevo(xfaena){
	
	var d = document.fm_cabecera;
	
	if ((d.periodo.value<=0)||(d.gerencia.value<=0)||(d.faena.value<=0)){
		alert('Debe seleccionar Periodo y Area y Faena ');
		return false
		}
	else
	    popUpWindow('../ventanas/nueva_inversion_presupuesto.php?idfaena='+d.faena.value+'&idperiodo='+d.periodo.value,100,0,1000,400);
	
	} 
	
function listar(){
	
	var d = document.fm_cabecera;
	if (d.faena.value<=0){
	    alert('No hay Datos Para Listar');
		return false;
	}	
	
	if (d.periodo.value<=0){
	    alert('No hay Datos Para Listar');
		return false;
	}
	
	 d.action='imprime_inversion_faena.php?idfaena='+d.faena.value+'&idperiodo='+d.periodo.value;
     d.submit();	
	
	
}



function bajar_planilla(){
	var d = document.fm_cabecera;
	if (d.faena.value<=0){
	    alert('Debe Seleccionar Faena');
		return false;
	}
	d.action='baja_planilla_datos.php?idfaena='+d.faena.value+'&idperiodo='+d.periodo.value;
     d.submit();
	
	}


function duplicar(zcorr){
	var d = document.fm_cabecera;
	
	ajax = nuevoajax();
    ajax.onreadystatechange = verduplex;//Quien me procesa los 4 estados
	ajax.open('POST','../acciones/duplica_inversion.php?idfaena='+d.faena.value+'&idperiodo='+d.periodo.value+'&corr='+zcorr, true);
    ajax.send(null);
	}

	
function verduplex(){
	if(ajax.readyState == 4){
	 //alert(ajax.responseText);	
	  	
	 cargainversion();
  // traer saldo disponible faena
	}
}	

function borrar(xcorr){
	
	var confirmacion = confirm("Desea Eliminar Inversion");
	   if (confirmacion){
		   var d=document.fm_cabecera;
		   ajax = nuevoajax();
           ajax.onreadystatechange = refresca_elimina;//Quien me procesa los 4 estados
           ajax.open('POST','../acciones/elimina_nueva_inversion.php?corr='+xcorr+'&idfaena='+d.faena.value+'&idperiodo='+d.periodo.value,true);
           ajax.send(null);
		   
		   }
	
	}

function refresca_elimina(){
	
	
	if(ajax.readyState == 4){
	   	//alert(ajax.responseText);
	   var out = ajax.responseText;
	   if (out=='0'){
	       alert('Dato  Eliminado Ok');
		   cargainversion();
		   // traer saldo disponible faena
	       }
 	    else{
		    alert('Error al Eliminar');
		    return false;
		    }
	 }
}	





function formatNumber(num,dec,thou,pnt,curr1,curr2,n1,n2) {var x = Math.round(num * Math.pow(10,dec));if (x >= 0) n1=n2='';var y = (''+Math.abs(x)).split('');var z = y.length - dec; if (z<0) z--; for(var i = z; i < 0; i++) y.unshift('0');y.splice(z, 0, pnt); if(y[0] == pnt) y.unshift('0'); while (z > 3) {z-=3; y.splice(z,0,thou);}var r = curr1+n1+y.join('')+n2+curr2;return r;}




</script>
<html>
<head>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
</head>


<body>
<table width="200" border="0" cellspacing="0" cellpadding="0" align="center">
					   <tr>
					   <td class="titletable">Genera Presupuesto Inversiones</td>
					  </tr>
		    </table>


<br>


<table width="500" align="center" class="tablabase">
 
 <tr></tr>
   <tr>
   <td>
     <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">  
     <form name='fm_cabecera' method="post" >
     
      <tr>
               <td class="titledatos" width="100">Periodo</td>
					  <td width="2%"></td>
					  <td >
					  <select name="periodo" id="periodo" >
                      <option value=0></option>
                           
                      <?php echo $opcion_periodo?>
                      
                      </select>
                      </td>
            
             
               </tr>
                     
                     
                   <tr></tr>  
                   
                   
                   
                   <tr>
               <td class="titledatos" width="150">Gerencia</td>
					  <td width="2%"></td>
					  <td >
					 <select name='gerencia'onChange="cargafaenas()" id="gerencia">
                      <option value=0></option>
                     
                      <?php echo $opcion_gerencia?>
               
                      </select>      
                      </td>
            
             
               
               </tr> 
               <tr></tr>
                   
                   
                   
                     
				     <tr>
				     <td class="titledatos" width="150">Seleccione Faena</td>
					 <td width="2%"></td>
				     <td ><select name='faena'onChange="cargainversion()" id="faena">
                          
				     <option value=0></option>
				     </select></td>
				     </tr>
			
				
			
				<tr></tr>
              
          
          
          
               <tr>
                  <td class="titledatos" width="150">Total Inversion S/C (USD)</td>
              	  <td width="2%"></td>
                  <td ><input name="total_inv" type="text"  value="" class="numeros"  maxlength="10" id="total_inv" readonly ></td>
              </tr>
              <tr></tr>
              
              <tr >
                 <td class="titledatos" width="170">Total Componentes(USD)</td>
	             <td width="2%"></td>
                 <td ><input name="total_compo" type="text"  value="" class="numeros"  maxlength="10" id="total_compo" readonly ></td>
    
              </tr>
              
               <tr></tr>
     
              <tr >
                 <td class="titledatos" width="170">Gran Total Inversiones (USD)</td>
	             <td width="2%"></td>
                 <td ><input name="total_general" type="text"  value="" class="numeros"  maxlength="10" id="total_general" readonly ></td>
    
              </tr>
            <tr></tr>
               
               
               
     
     
       <tr></tr>
     
     
     <tr> <td height="5"></td></tr>
    <tr> 
      <td colspan="5"><div align="center">
      
		<!--<img src="../img/43.png" align="right"  border="1" style="cursor:hand" onClick="subir_planilla();" title="Bajar Planilla">
        <img src="../img/44.png" align="right"  border="1" style="cursor:hand" onClick="bajar_planilla();" title="Subir Planilla">-->
        <img src="../img/nuevo.gif" align="right"  border="1" style="cursor:hand" onClick="javascript:Limpiar();" title="Limpiar">
		<img src="../img/excel_icono.gif" align="right" title="Listar" border="1" style="cursor:hand" onClick="javascript:listar();" >
        <img src="../img/folio02.gif" align="right" title="Nuevo" border="1" style="cursor:hand" onClick="javascript:nuevo();" >
		
          </div>
	  </td>
	</tr> 
     
     </form>
     </table>
   </td>
   </tr>
   </table>  
   
   
   
   <br>

<table width="1200" height="0" border="0" align="center" cellspacing="0" style="table-layout:fixed;" class="tablaprincipal">
    <tr> 
	
    <td width="70"><div align="left">Centro Costo</div></td>
    <td width="180"><div align="left">Clase Activo</div></td>
    <td width="250"><div align="left">Descripcion Bien</div></td>
    <td width="30"><div align="center">Cant.</div></td>
    <td width="50"><div align="right">Valor Unit.</div></td>
    <td width="50"><div align="right">Total Ppto.</div></td>
    <td width="80"><div align="center">Mes Compra</div></td>
    <td width="80"><div align="left">Mes Activacion</div></td>
    <td width="70"><div align="left">T. Inversion</div></td>
    <td width="50"><div align="left">    </div></td>
    

  </tr>
  </table>
  <div align="center">
	<table width="1200" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;" class="tablaframe" >
		<tr>
			<td>
			   
				<iframe name="ifrm1" width="100%" height="250" scrolling="yes" src="../iframes/ifrm_genera_inversion.php"  frameborder="0" align="middle" ></iframe>
			</td>
		</tr>
	</table>
</div>

    
<form id="iframeForm" method="post" target="" action="">

<input type="hidden" value="" name="faena">
<input type="hidden" value="" name="periodo">

	
  
</form>    



</body>
</html>

<br>
<br>
<br>
<br>
<br>
<br>

<? include "../footer/pie_pagina.php"; ?>