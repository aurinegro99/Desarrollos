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

   window.location.href='modifica_solicitud.php';
  
  
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

var xform=document.getElementById('idsolicitud').value;



var teclaASCII=event.keyCode 


if (teclaASCII==13){

    var d= document.fm_consulta;
	
	
   
   	if (xform.length<=0){
	   alert('Debe Ingresar Numero Solicitud');
		return false;
	}
	
	ajax = nuevoajax();
        ajax.onreadystatechange = refrescar;//Quien me procesa los 4 estados
	ajax.open('POST','../acciones/revisa_solicitud.php?solicitud='+xform, true);
        ajax.send(null);
	
	
	

		}
else
    {
	   return false;
	}		
} 
   
   

function refrescar()
{


 var out=ajax.responseText;
 
 
 
  if(ajax.readyState == 4){
    //alert(out)
 
     if (out==0)
	alert('Nro. Solicitud No Existe');
	 
 
      else{
       
		if (out=='A')
		    alert('Solicitud Activa');
		    
		else
		
		   alert('Solicitud Desactivada');
		
		
		var xform=document.getElementById('idsolicitud').value;
	   
	    //   mostrar tabla
		
	   var xtabla = document.getElementById("tabla");
	   
	   xtabla.style.display='';
	   
	   
	   tabbar.setContentHref("b2", "rev_ingreso_informacion.php?solicitud="+xform);
	   tabbar.setContentHref("b3", "rev_datos_activo.php?solicitud="+xform);
	   
	   //tabbar.setContentHref("b4", "rev_asignacion_activo.php?solicitud="+xform+"&codigo="+lista[17]+"&centro="+lista[15]);
	   tabbar.setContentHref("b4", "rev_asignacion_activo.php?solicitud="+xform);
	   
	   
	   tabbar.setTabActive("b2");
	 }
 
  }


}


</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<head>
	<title>Loading in iframes(init from html)</title>
	<link rel="STYLESHEET" type="text/css" href="../codebase2/dhtmlxtabbar.css">
	<script  src="../codebase2/dhtmlxcommon.js"></script>
	<script  src="../codebase2/dhtmlxtabbar.js"></script>
	
	
</head>

<body>
<table width="200" border="0" cellspacing="0" cellpadding="0" align="center">
					   <tr>
					   <td class="titletable">Modifica Solicitud Activo Fijo </td>
					  </tr>
		    </table>


<br>
<br>

<table width="95%" align="center">
       <tr>
         <td>
           <table width="500" align="center">
              <tr>
              <td class="titledatos" width="150">Solicitud</td>
					  <td width="2%"></td>
					  <td >
					  <input name="solicitud" value="" type="text"  size="20" maxlength="15"  onkeydown="revisar()" id="idsolicitud" class="numeros">
                      </td>
            
             
            <td>
              <img src="../img/nuevo.gif" align="right" alt="Limpiar" border="1" style="cursor:hand" onClick="javascript:Limpiar();">
             <!--  <img src="../img/46.png" align="right" alt="Grabar" border="1" style="cursor:hand" onClick="javascript:grabar();">-->
             
            </td>
           </tr>
         </table>
      </td>     
      </tr>
</table>



<br />
	<table align="center" id="tabla" style="display:none">
		<tr>
			<td>
                <div hrefmode="iframes"   id="a_tabbar" class="dhtmlxTabBar" imgpath="../codebase/imgs/" style="width:1000px; height:300px;"  skinColors="#FCFBFC,#F4F3EE" >
                 	<!--<div id="b2" width="150" name="Informaci�n General" href="rev_ingreso_informacion.php" ></div>
                     <div id="b3" width="150" name="Datos Activo Fijo" href="rev_datos_activo.php"></div>
                    <div id="b4" width="200" name="Asignaci�n Activo Fijo" href="rev_asignacion_activo.php"></div>
                    <div id="b5" width="150" name="Area Contrato" href="rev_ingreso_activo.php"></div>
                    <div id="b6" width="150" name="Area Compras" href="rev_compra_activo.php"></div>-->
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



<? include "../footer/pie_pagina.php"; ?>