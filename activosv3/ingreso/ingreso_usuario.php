<?php
//include "../header/header.php"; ?>

<link rel="stylesheet" type="text/css" href="../css/estilo.css" />




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





function revisar()
{

 
var xusu=document.getElementById('idusuario').value;
var xpas=document.getElementById('idclave').value;

//alert('Hola Juan Manuel');


var teclaASCII=event.keyCode 


if (teclaASCII==13){

   if (xusu.length<=0){
    alert('Debe Ingresar Usuario');
	return false;
	
}


if (xpas.length<=0){
    alert('Debe Ingresar Clave');
	return false;
	
}


    ajax = nuevoajax();
	ajax.onreadystatechange = refrescar_active;//Quien me procesa los 4 estados
	ajax.open('POST','revisa_usuario_active.php?musuario='+xusu+'&clave='+xpas, true);
    ajax.send(null);
	
	
	
}  //  tecla 13

}   //  function



function revisar2()
{

var xusu=document.getElementById('idusuario').value;
var xpas=document.getElementById('idclave').value;

   if (xusu.length<=0){
    alert('Debe Ingresar Usuario');
	return false;
}	



if (xpas.length<=0){
    alert('Debe Ingresar Clave');
	return false;
	
}
    ajax = nuevoajax();
	ajax.onreadystatechange = refrescar_active;//Quien me procesa los 4 estados
	ajax.open('POST','revisa_usuario_active.php?musuario='+xusu+'&clave='+xpas, true);
    ajax.send(null);
	
    



}   //  function


function refrescar_active()
{
if(ajax.readyState == 4){
	//alert(ajax.responseText);
	var out=ajax.responseText;

var xusu=document.getElementById('idusuario').value;

if (out=='OK')
   {
	// revsair si tiene acceso ala sistena
	
	
	ajax = nuevoajax();
	ajax.onreadystatechange = refrescar_ingreso;//Quien me procesa los 4 estados
	ajax.open('POST','revisa_usuario_acceso.php?musuario='+xusu, true);
    ajax.send(null);
	
	}

else{
	
    alert('Usuario y/o Clave No Existen');
	return false;
}




}

}


function refrescar_ingreso(){

//alert(ajax.responseText);

if(ajax.readyState == 4){
    //alert(ajax.responseText);
	
   var out=ajax.responseText;
   if (out=='1'){
	   var xusu=document.getElementById('idusuario').value;	  
   window.location.href='index.php?idusuario='+xusu;	  
      
      }
    else{
		alert('Usuario no Tiene Acceso');
	  return false;
		
	}	  
   
      	  

}

}
</script>

<table width="200" border="0" cellspacing="0" cellpadding="0" align="center">
					   <tr>
					   <td class="titletable">Ingreso Usuario </td>
					  </tr>
		    </table>
            <br />


<table width=500 align="center" class="tablabase">
       <tr>
	   <td>
     	  <table width="95%"  bordercolor="#000066">    
             <tr>
               <td class="titledatos"width="150">Ingrese Usuario U</td>
	    	   <td width="2%"></td>
		       <td >
     			 <input name="usuario" type="text" value="" size="25" maxlength="20" id="idusuario"  onkeydown="revisar()"></td>
             </tr>    
             <tr></tr>
             <tr>
               <td class="titledatos"width="150">Clave Correo</td>
	    	   <td width="2%"></td>
               <td >
     			 <input name="clave" type="password" value="" size="25" maxlength="40" onkeydown="revisar()" id="idclave" ></td>
               <td>
               <img src="../img/ingreso.png" align="right" title="Validar" border="1" style="cursor:hand" onClick="javascript:revisar2();">
               </td>  
             </tr>
          </table>
       </td>
       </tr>          
               
                 
  
</table>

<?php  
include "../footer/pie_pagina.php";
  
 ?>
