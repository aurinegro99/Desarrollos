<?php
session_start();
$idusuario = $_SESSION["usuario"];

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
	
 window.location.href='crear_solicitud_activo.php';	 
}

function revisar_ingreso()
{
	var f1=window.frames[0].document.fm_ingreso;
        
	if ((isBlanco(f1.solicita.value)) || (isBlanco(f1.rut_solicita.value)))
        {
            alert('Debe Ingresar Rut Solicitante ');
            return false;
        }
	
	ajax = nuevoajax();
       ajax.onreadystatechange = revisa_rut_solicita//Quien me procesa los 4 estados
       ajax.open('GET','../rutinacarga/revisa_rut.php?rut='+f1.rut_solicita.value, true);
       ajax.send(null);
}

function revisa_rut_solicita()
{
	if(ajax.readyState == 4)
        {
	 //   alert(ajax.responseText);  
           var out = ajax.responseText;
	   if (out==0) 
           {
	     alert('Rut Solicitante No existe');
	     return false;
	   }
	 
	   if(out==1)
           {
		alert('Rut Solicitante No esta Habilitado en la Compañia')
		return false;
	   }
	
	
	if ((out!==0) || (out!==1))
           grabar()
	
		
  }
  

} 
 


function grabar()
{
	


var f1=window.frames[0].document.fm_ingreso;
var f2=window.frames[1].document.fm_datos;
var f3=window.frames[2].document.fm_asigna;

if (isBlanco(f1.aprueba.value))
{
   alert('Debe Ingresar Aprobado por ');
   fb.disabled=false;
   return false;
}

if (f1.clase.value<=0)
{
   alert('Debe Ingresar Clase Activo ');
   fb.disabled=false;
   return false;
}


if ((f1.clase.value==10)||(f1.clase.value==80))
{  //   compoenente  Z213 Z211
	
	if (isBlanco(f2.marca.value))
        {
		alert('Debe Ingresar Modelo Equipo Uso Componente (Campo Marca) ');
		fb.disabled=false;
		return false;
	}
	
	if (isBlanco(f2.modelo.value))
        {
		alert('Debe Ingresar Numero Parte Componente (Campo Modelo) ');
		fb.disabled=false;
		return false;
	}
	
	if (isBlanco(f2.nro_serie.value))
        {
		alert('Debe Ingresar Numero Serie Componente ');
		fb.disabled=false;
		return false;
	}
	
	
}



if (isBlanco(f2.descripcion.value))
{
   alert('Debe Ingresar Descripción del Bien ');
   fb.disabled=false;
   return false;
}


if (f2.pais.value<=0)
{
	alert('Debe Ingresar Pais Origen ');
	fb.disabled=false;
    return false;
	
}

 
if (((f1.clase.value>=16) && (f1.clase.value<=19)) ||  ((f1.clase.value>=75) && (f1.clase.value<=78) ))
{

   if (isBlanco(f2.marca.value))
   {
       alert('Debe Ingresar Marca del Bien ');
	   fb.disabled=false;
       return false;
      }
	  
   if (isBlanco(f2.modelo.value))
   {
	   fb.disabled=false;
       alert('Debe Ingresar Modelo del Bien ');
       return false;
      }
   
   if (isBlanco(f2.nro_serie.value))
   {
	   fb.disabled=false;
       alert('Debe Ingresar Numero Serie del Bien ');
       return false;
      }	  
 }


if (isBlanco(f3.responsable.value))
{
   alert('Debe Ingresar Responsable del Bien ');
   fb.disabled=false;
   return false;
}


if (f3.faena.value<=0)
{
   alert('Debe Ingresar Faena  ');
   fb.disabled=false;
   return false;
}


if (f3.sucursal.value<=0)
{
   alert('Debe Ingresar Sucursal o Centro  ');
   fb.disabled=false;
   return false;
}


if (f3.emplazamiento.value<=0)
{
   alert('Debe Ingresar Emplazamiento ');
   fb.disabled=false;
   return false;
}


if (f3.codigo.value<=0)
{
   alert('Debe Ingresar Código Inversión  ');
   fb.disabled=false;
   return false;
}


//alert(f3.centro_costo.value);

if (isBlanco(f3.centro_costo.value))
{
   alert('Debe Ingresar Centro Costo  ');
   fb.disabled=false;
   return false;
}

if (isBlanco(f3.lugar_uso.value))
    {
   alert('Debe Ingresar Lugar Uso ');
   fb.disabled=false;
   return false;
}


if (f3.valor.value<=0)
{
   alert('Debe Ingresar Costo Compra  ');
   fb.disabled=false;
   return false;
}



if (isBlanco(f3.comentarios.value))
{
   alert('Debe Ingresar Comentarios  ');
   fb.disabled=false;
   return false;
}



// clase activo
//if (f3.tipop.value==1)
	
if (f3.clase.value!=='999'){

    if (f1.clase.value!=f3.clase.value)
        {
    	alert('Clase Activo Solicitud debe ser Igual a Clase Activo Presupuesto');
     	fb.disabled=false;
	    return false;
	}
	
}

//if (((f3.tipoinv.value==1) && (f3.tipop.value==1))||((f3.tipoinv.value==2) && (f3.tipop.value==1))){
	
	
//alert(f3.monto_presup.value);	

var presup= parseFloat(f3.monto_presup.value);
var saldo_p = parseFloat(f3.saldo_presup.value);
var saldo2 = parseFloat(f3.saldo2.value);
var saldo = parseFloat(f3.saldo.value);
	
if (presup>0)
{	
	
	//alert(f3.saldo_presup.value+'  '+f3.saldo2.value+'   '+f3.saldo.value);
	if (saldo2<0)
        {
	
	     if (saldo2*-1>(saldo*0.05))
             {
	 	    alert('Saldo Presupuesto No debe ser Mayor a 5% Monto Presupuesto');
		    fb.disabled=false;
		    return false;
		 }
	
	}
}

//  revisar rut responsable


 Cargar();

if ((f1.clase.value==10)||(f1.clase.value==80))
{ 
   ajax = nuevoajax();
   ajax.onreadystatechange = revisa_parte//Quien me procesa los 4 estados
   ajax.open('GET','../rutinacarga/revisa_numero_parte.php?numero_parte='+f2.modelo.value , true);
   ajax.send(null); 

}

else
{
       ajax = nuevoajax();
       ajax.onreadystatechange = revisa_carga_rut//Quien me procesa los 4 estados
       ajax.open('GET','../rutinacarga/revisa_rut_ws.php?rut='+f3.responsable.value, true);
       ajax.send(null);
	   
   }


}


function revisa_parte()
{
	 
	 if(ajax.readyState == 4)
         {
           //alert(ajax.responseText);  
	   var out = ajax.responseText;
	   if (out=='0')
           {
		   alert('Numero Parte No esta Registrado, Registrar para continuar');
		   
		   Carga_Lista();
		   return false;
	   }	
	   
	 else{
		   
		    var f2=window.frames[1].document.fm_datos;
	   	    var f3=window.frames[2].document.fm_asigna;
		    f2.descripcion.value=out+' NP/'+f2.modelo.value+' S/'+f2.nro_serie.value; 
		    ajax = nuevoajax();
                    ajax.onreadystatechange = revisa_carga_rut//Quien me procesa los 4 estados
                    ajax.open('GET','../rutinacarga/revisa_rut_ws.php?rut='+f3.responsable.value, true);
                    ajax.send(null);
	   }
	 }
	
}  // funcion





function revisa_carga_rut()
{

 fb=document.getElementById('bt_grabar');	
 
  if(ajax.readyState == 4)
  {
	// alert(ajax.responseText);  
     var out = ajax.responseText;
	 if (out==0) 
         {
	     alert('Rut No existe'); 
		 Carga_Lista();
		 
		 return false;
		
	 }
	 
	if(out==1) 
        {
		alert('Rut No esta Habilitado en la Compañia')
		Carga_Lista();
		
		return false;
	}
	
	
	if ((out!==0) || (out!==1))	
	    confirma_grabar()
        //      alert('listo grabar');
	
		
  }
  
  
  
  
}


function confirma_grabar()
{

var f1=window.frames[0].document.fm_ingreso;
var f2=window.frames[1].document.fm_datos;
var f3=window.frames[2].document.fm_asigna;


  //alert(f2.descripcion.value);
  //Cargar();
  ajax = nuevoajax();
  ajax.onreadystatechange = refrescar;//Quien me procesa los 4 estados
  ajax.open('POST','../acciones/grabaformulario.php?d1='+f1.solicita.value+'&d2='+f1.aprueba.value+'&d3='+f1.clase.value+'&d4='+f2.descripcion.value+'&d5='+f2.marca.value+'&d6='+f2.modelo.value+'&d7='+f2.nro_serie.value+'&d8='+f2.pais.value+'&d9='+f2.patente.value+'&d10='+f3.responsable.value+'&d11='+f3.faena.value+'&d12='+f3.sucursal.value+'&d13='+f3.codigo.value+'&d14='+f3.centro_costo.value+'&d15='+f3.valor.value+'&d16='+f3.lugar_uso.value+'&d17='+f3.saldo2.value+'&d18='+f3.vdolar.value+'&d19='+f3.tc.value+'&rut_sol='+f1.rut_solicita.value+'&idemplaza='+f3.emplazamiento.value+'&comenta='+f3.comentarios.value , true);
  ajax.send(null);

}


function refrescar()
{
	 if(ajax.readyState == 4)
         {
             //alert(ajax.responseText);
             var out=ajax.responseText;
             
	     fb=document.getElementById('bt_grabar');	
             //fb.disabled=false;
	 //  alert(fb.disabled);
             
//alert(out);

        alert ('Solicitud Activo Fijo '+ajax.responseText+' Creada');
        Carga_Lista();
        Limpiar();

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

var xform=document.getElementById('form').value;

var teclaASCII=event.keyCode 


if (teclaASCII==13)
{

    var d= document.fm_consulta;
	
	if (isNaN(xform))
        {
	    alert('Dato Formulario Debe Ser numerico');
		return false;
	}
   
   	if (xform<=0)
        {
	   alert('Formulario Debe Ser Mayor a Cero');
		return false;
	}   
	
	ajax = nuevoajax();
        ajax.onreadystatechange = refrescar9;//Quien me procesa los 4 estados
	ajax.open('GET','../acciones/revisamodelo_new.php?formulario='+xform, true);
        ajax.send(null);
	
   }
   
 
 
 }
   
function refrescar9()
{

   if (ajax.readyState == 4)
     {
      var out=ajax.responseText;
      //alert(out)
      var lista=out.split('*');
      if (lista.length==1)
         {
           if (lista[0]==0){
	          alert('Nro. Formulario no Existe');
		     return false
		   }
         } 
      else
        {
          var f1=window.frames[0].document.fm_ingreso;
          var f2=window.frames[1].document.fm_datos;
          var f3=window.frames[2].document.fm_asigna;

		 //f1.solicita.value=lista[0]
          f1.aprueba.value=lista[1];
          f1.clase.value=lista[2];
          f2.descripcion.value=lista[3]
          f2.marca.value=lista[4];
          f2.modelo.value=lista[5];
          f2.nro_serie.value=lista[6];
          f2.pais.value=lista[7];
          f2.patente.value=lista[8];    
          f3.responsable.value=lista[9];  
          f3.lugar_uso.value=lista[11];  


        }
	 }

}   


function Cargar(){
document.getElementById("tabla1").style.display="none";
document.getElementById("tabla2").style.display="none";	
	
document.getElementById("imgLOAD").style.display="";
} 
   
   
function Carga_Lista(){
document.getElementById("imgLOAD").style.display="none";
document.getElementById("tabla1").style.display="";
document.getElementById("tabla2").style.display="";	
}     

</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<head>
	<title>Loading in iframes(init from html)</title>
	<link rel="STYLESHEET" type="text/css" href="../codebase/dhtmlxtabbar.css">
	<script  src="../codebase/dhtmlxcommon.js"></script>
	<script  src="../codebase/dhtmlxtabbar.js"></script>
	<script  src="../codebase/dhtmlxtabbar_start.js"></script>
	
</head>

<body>
<table width="200" border="0" cellspacing="0" cellpadding="0" align="center">
					   <tr>
					   <td class="titletable">Ingreso Solicitud </td>
					  </tr>
		    </table>


<br>
    
<div id="imgLOAD" style="text-align:center; display:none; cursor:wait">
<h3><img src="../img/ajax-loader.gif" /></h3>
</div>    
    
    
<br>
<table width="95%" align="center" id="tabla1">
       <tr>
       <td>
       <table width="500" align="center">
              <tr>
              <td class="titledatos" width="150">Formulario Modelo</td>
					  <td width="2%"></td>
					  <td >
					  <input name="formulario" value="" type="text"  size="15" maxlength="10"  onkeydown="revisar()" class="numeros"  id="form">
                      </td>
       <td>     
       <img src="../img/nuevo.gif" align="right" title="Limpiar" border="1" style="cursor:hand" onClick="Limpiar();">
       <img src="../img/46.png" align="right" title="Grabar" border="1" style="cursor:hand" onClick="revisar_ingreso();" id="bt_grabar">
       </td>
           </tr>
         </table>
      </td>     
      </tr>
</table>

	<table align="center" id="tabla2">
		<tr>
			<td>
                <div hrefmode="iframes"   id="a_tabbar" class="dhtmlxTabBar" imgpath="../codebase/imgs/" style="width:900px; height:300px;"  skinColors="#FCFBFC,#F4F3EE" >
                 	<div id="idframe1" width="150" name="Información General" href="ingreso_informacion.php" ></div>
                     <div id="idframe2" width="150" name="Datos Activo Fijo" href="datos_activo.php"></div>
                    <div id="idframe3" width="200" name="Asignación Activo Fijo" href="asignacion_activo_new.php"></div>
                    
               </div>
			</td>
        </tr>
	</table>

</body>
</html>

<?php include "../footer/pie_pagina.php"; ?>