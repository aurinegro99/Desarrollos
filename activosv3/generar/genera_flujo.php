  <?php
include "../header/header.php"; 

 
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
 


function Limpiar()
{
	
	
window.location.href='genera_flujo.php';	
	
}


function generar(){

var d=document.fm_generar;

var xform=document.getElementById('solicitud');



if (isBlanco(xform.value)){
   alert('Debe Ingresar Numero Solicitud ');
   return false;
}


if (d.cargar.value=='N'){
	alert('Solicitud Ingresada no esta cargada ');
   return false;
	}

Cargar();
    
    ajax = nuevoajax();
    ajax.onreadystatechange = ver_consistencia;//Quien me procesa los 4 estados
	ajax.open('POST','../acciones/revisa_consistencia.php?solicitud='+xform.value, true);
    ajax.send(null);



    


}



function ver_consistencia(){
	
	var out=ajax.responseText;
	alert(out);
	
	if(ajax.readyState == 4){
	
	if (out==0){
		
		var xform=document.getElementById('solicitud');
		ajax = nuevoajax();
        ajax.onreadystatechange = ver_solicitud;//Quien me procesa los 4 estados
	    ajax.open('POST','../acciones/revisa_workflow.php?solicitud='+xform.value, true);
        ajax.send(null);
	
	}
	
	else
	{
            Carga_Lista();
	    alert('Solicitud presenta inconsistencia de datos');
		return false;
	}

}

}

function ver_solicitud()
{

	//alert(ajax.responseText)
    var out=ajax.responseText;
	if(ajax.readyState == 4){
	  // alert(out); 
	if (out>0){
            Carga_Lista();
	    alert('Solicitud ya tiene Workflow Generado '+out);
		return false;
	}
	else{
		var xform=document.getElementById('solicitud');
		  
		  
		  
		  //alert('Crear Solicitud');
		
		 ajax = nuevoajax();
         ajax.onreadystatechange = ver_generacion;//Quien me procesa los 4 estados
	     ajax.open('POST','../acciones/genera_workflow.php?solicitud='+xform.value, true);
         ajax.send(null);
		
		}
	}

}

function ver_generacion(){
	
	var out=ajax.responseText;
	//alert(out);
	if(ajax.readyState == 4){
	
	var xform=document.getElementById('solicitud');
	if (out<=0){
            Carga_Lista();
	   alert('Error al crear Workflow para solicitud '+xform); 
	   return false
	}
	else{
            //Carga_Lista();
	  alert('Workflow '+out+' Creado para solicitud '+xform); 
          Carga_Lista();
	  Limpiar();
	}
	  
	}

}


function isBlanco(texto)
   {
   largo = texto.length
   for (i=0; i < largo ; i++ )
       if ( texto.charAt(i) !=" ")
          return false;
return true
   }
 
 
function revisar()
{

var xform=document.getElementById('solicitud');

var teclaASCII=event.keyCode 


if (teclaASCII==13){

   var d=document.fm_generar;

  // alert('PASO 1 '+d.solicitud.value);

	if (isNaN(xform.value)){
	    alert('Dato Solicitud Debe Ser numerico');
		return false;
	}
   
   	if (xform.value<=0){
	   alert('Solicitud Debe Ser Mayor a Cero');
		return false;
	}
	
	ajax = nuevoajax();
    ajax.onreadystatechange = refresca_solicitud;//Quien me procesa los 4 estados
	ajax.open('POST','../acciones/revisaformulario_new.php?formulario='+xform.value, true);
    ajax.send(null);
		}
		
} 
   
   

function refresca_solicitud()
{



 if(ajax.readyState == 4){
   //alert(ajax.responseText) ;

 var out=ajax.responseText;
 
 //alert(out)
 
 var xform=document.getElementById('solicitud');
 
 //   revisiones
 
 if (out=='0') {  // no existe
    alert('Nro. Solicitud no Existe');
	return false;
    }
 
 if (out!=xform.value) { // ya tiene activo asignado
    alert('Nro. Solicitud tiene Activo Asignado o Solicitud WorkFlow Generada '+out);
	return false;
 }
 
 if (out==xform.value)  // puede asignar activo
     alert('Solicitud Activa');
 	   cargar_datos();
	   
 
 }


}



function cargar_datos(){
	
	
	var d=document.fm_generar;
	
	d.cargar.value='S';
	var xform=document.getElementById('solicitud');
	
    //alert(xform.value);	
	tabbar.setContentHref("b2", "rev_ingreso_informacion.php?solicitud="+xform.value);
	tabbar.setContentHref("b3", "rev_datos_activo.php?solicitud="+xform.value);
	tabbar.setContentHref("b4", "rev_asignacion_activo.php?solicitud="+xform.value);
	
	
}


function Cargar(){
document.getElementById("imgLOAD").style.display="";
} 
   
   
function Carga_Lista(){
document.getElementById("imgLOAD").style.display="none";
} 

</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<head>
	
    
    <link rel="STYLESHEET" type="text/css" href="../codebase2/dhtmlxtabbar.css">
	<script  src="../codebase2/dhtmlxcommon.js"></script>
	<script  src="../codebase2/dhtmlxtabbar.js"></script>
    
    
	
</head>

<body>
<table width="200" border="0" cellspacing="0" cellpadding="0" align="center">
					   <tr>
					   <td class="titletable">Genera WorkFlow Activo Fijo </td>
					  </tr>
		    </table>


<br>
    <div id="imgLOAD" style="text-align:center; display:none; cursor:wait">
<h3><img src="../img/cargando.gif" /></h3>
</div>    
    
    
<br>


<form name="fm_generar" >
<input type="hidden" name="cargar" value="N" />
</form>
<table width="95%" align="center">
       <tr>
         <td>
           <table width="500" align="center">
              <tr>
              <td class="titledatos" width="150">Número Solicitud</td>
					  <td width="2%"></td>
					  <td >
					  <input name="solicitud" value="" type="text"  size="15" maxlength="10"  onkeydown="revisar()" class="numeros"  id="solicitud">
                      </td>
            
             
            <td>
              <img src="../img/nuevo.gif" align="right" alt="Limpiar" border="1" style="cursor:hand" onClick="Limpiar();">
              <img src="../img/application.png" align="right" alt="Genera Flujo" border="1" style="cursor:hand" onClick="generar();">
            </td>
           </tr>
         </table>
      </td>     
      </tr>
</table>



<br />
	<table align="center">
		<tr>
			<td>
                <div hrefmode="iframes"   id="a_tabbar" class="dhtmlxTabBar" imgpath="../codebase2/imgs/" style="width:900px; height:300px;" >
                 	<!--<div id="b2" width="150" name="Informaci�n General" href="rev_ingreso_informacion.php" ></div>
                     <div id="b3" width="150" name="Datos Activo Fijo" href="rev_datos_activo.php"></div>
                    <div id="b4" width="200" name="Asignación Activo Fijo" href="rev_asignacion_activo.php"></div>-->
                  <!--  <div id="b5" width="150" name="Area Contrato" href="ingreso_activo.php"></div>-->
               </div>
			</td>
        </tr>
	</table>

</body>
</html>

 <script>
 
 tabbar = new dhtmlXTabBar("a_tabbar", "top");
tabbar.setSkin('dhx_skyblue');
tabbar.setImagePath("../codebase2/imgs/");
tabbar.addTab("b2", "Información General", "200px");
tabbar.addTab("b3", "Datos Activo Fijo", "200px");
tabbar.addTab("b4", "Asignación Activo Fijo", "200px");


tabbar.setHrefMode("iframe");
tabbar.setContentHref("b2", "rev_ingreso_informacion.php");
tabbar.setContent("b3", "rev_datos_activo.php");
tabbar.setContent("b4","rev_asignacion_activo.php");

tabbar.setTabActive("b2");

</script>


<?php include "../footer/pie_pagina.php"; 