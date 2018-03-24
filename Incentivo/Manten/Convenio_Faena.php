<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../ini/inicial.php';
$usuario=$_SESSION["usuario"];
require_once '../lib/carga_faenas.php';


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
	 
 window.location.href='Convenio_Faena.php';	 
}




function isBlanco(texto)
   {
   largo = texto.length
   for (i=0; i < largo ; i++ )
       if ( texto.charAt(i) !=" ")
          return false;
return true
   }
   
function carga_convenio(){
    iframeForm.reset();
    iframeForm.idfaena.value= document.frm_cabecera.faena.value;
    iframeForm.action = "../iframes/ifrm_convenios.php";
    iframeForm.target = "ifrm1";
    iframeForm.submit ();
    
    
    
}   
   
function agregar(){
    var d = document.frm_cabecera;
    
    if (d.faena.value<=0){
        alert('Debe Seleccionar Faena');
        return false;
        
    }
    
    if (isBlanco(d.nro_convenio.value)){
        alert('Debe Ingresar Nro. Convenio');
        return false;
        
    }
    
    if (isBlanco(d.nombre_convenio.value)){
        alert('Debe Ingresar Nombre Convenio');
        return false;
        
    }
    
    if (isBlanco(d.inicio.value)){
        alert('Debe Ingresar Fecha Inicio');
        return false;
        
    }
    
    if (isBlanco(d.termino.value)){
        alert('Debe Ingresar Fecha Termino');
        return false;
        
    }
    
    if (isNaN(d.nro_convenio.value)==true){
        alert("Dato Numero Convenio debe ser Numerico ");
        return false
        
    } 
    
    var xhab;
    if (d.activo.checked==true)
        xhab='S';
    else
        xhab='N';
     ajax = nuevoajax();
     ajax.onreadystatechange = refrescar_agregar;//Quien me procesa los 4 estados
     ajax.open('GET','../acciones/agrega_convenio.php?idfaena='+d.faena.value+'&numero='+d.nro_convenio.value+'&nombre='+d.nombre_convenio.value+'&inicio='+d.inicio.value+'&termino='+d.termino.value+'&habilita='+xhab+'&status='+d.status.value+'&id='+d.id.value, true);
     ajax.send(null);
}   

function refrescar_agregar(){
    if(ajax.readyState == 4){
        var out = ajax.responseText; 
        //alert(out);
        if (out=='9'){
            alert('Error en fechas de convenio, revisar ');
            return false;
            
        }
        
        if (out=='0'){
            alert('Datos Grabados OK ');
            carga_convenio();
            return false;
        }
        
         if (out=='1'){
            alert('Error al Grabar ');
            return false;
        }
        
    }
    
}

function modifica(id){
    
    //alert('modifica '+id);
    
     document.frm_cabecera.id.value=id;
     document.frm_cabecera.faena.disabled=true;
     
     ajax = nuevoajax();
     ajax.onreadystatechange = refrescar_rescata;//Quien me procesa los 4 estados
     ajax.open('GET','../acciones/rescata_convenio.php?id='+id, true);
     ajax.send(null);
    
    
}


function refrescar_rescata(){
    if(ajax.readyState == 4){
        var out = ajax.responseText; 
       // alert(out);
        var lista = out.split('*');
        var d=document.frm_cabecera;
        d.nro_convenio.value=lista[0];
        d.nombre_convenio.value=lista[1];
        d.inicio.value=lista[2];
        d.termino.value=lista[3];
        if (lista[4]=='S')
           d.activo.checked=true;  
        else    
           d.activo.checked=false;  
         
        // status   modifica; 
       d.status.value='M';
    }
    
}


</script>

<script language="JavaScript" src="../js/popcalendar.js"></script>


<body >
<table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td class="titletable"><h4><strong>Convenio Faena</strong></h4></td>
    </tr>
 </table>
    
<br>

<form name='frm_cabecera' method="post" >
    <input type="hidden" name="status" value="C">
     <input type="hidden" name="id" value="0">
          
      
      <table width="800" align="center" class="tablabase">
          <tr> <td height="5"></tr>
        <tr>
            <td>
              <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">  
                <tr>
                   
                    <td class="titledatos" width="150">Faena</td>
                        <td width="2%"></td>
                        <td ><select name="faena"  id="faena" onchange="carga_convenio()">
                                <option value=-1></option>
                                <?php echo $opcion_faena?>
                                              
                        </select></td>
                </tr>
                
                <tr></tr>
                
                <tr>
                    <td class="titledatos" width="150">Nro.Convenio</td>
                        <td width="2%"></td>
                        <td ><input name="nro_convenio" id="nro_convenio" maxlength="3" size="10" ></td>
                </tr>
                <tr></tr>
                
                <tr>
                    <td class="titledatos" width="150">Nombre Convenio</td>
                    <td width="2%"></td>
                    <td ><input name="nombre_convenio" id="nombre_convenio" maxlength="100" size="60" ></td>
                </tr>
                
                <tr></tr>
                <tr>
                    <td class="titledatos" width="150">Fecha Inicio</td>
                    <td width="2%"></td>
                    <td ><input name="inicio" id="inicio" readonly="true" size="10">
                    <img src='../img/calendar.gif' width='20' height='16' border=0  style="cursor:hand" title="Seleccione Fecha Inicio" onClick = "GetFecha (1,'document.frm_cabecera.inicio');"></td>
                </tr>
                <tr></tr>
                <tr>
                    <td class="titledatos" width="150">Fecha Termino</td>
                    <td width="2%"></td>
                    <td ><input name="termino" id="termino" readonly="true" size="10">
                    <img src='../img/calendar.gif' width='20' height='16' border=0  style="cursor:hand" title="Seleccione Fecha Termino" onClick = "GetFecha (1,'document.frm_cabecera.termino');"></td>
                </tr>
                <tr></tr>
                
                <tr>
                    <td class="titledatos" width="150">Activo</td>
                        <td width="2%"></td>
                        <td ><input name="activo" id="activo" type="checkbox"></td>
                </tr>
                 
                              
                <tr> 
                    <td height="5"></td>
                </tr>
                <tr> 
                    <td colspan="3"><div align="center">
                        <img src="../img/nuevo.gif" align="right" title="Limpiar" border="2" style="cursor:hand" onClick="Limpiar();">
                                <!--<img src="../img/pdf_icono.gif" align="right" title="Imprime Solicitud" border="1" style="cursor:hand" onClick="javascript:imprime();">-->
                        <img src="../img/46.png" align="right" title="Grabar" border="2" style="cursor:hand" onClick="agregar();">
                        </div>
                     </td>
                </tr> 

              </table>
            </td>
        </tr>
   </table>   
  
    
</form>

<br>
<br>

<table width="800" height="0" border="0" align="center" cellspacing="0" style="table-layout:fixed;" class="tablaprincipal">
    <tr> 
	
    <td width="100"> 
    <div align="left">N/C</div></td>
    <td width="350" > 
    <div align="left">Nombre Convenio</div></td>
    <td width="100"> 
    <div align="left">Fec.Inicio</div></td>
    <td width="100"> 
    <div align="left">Fec.Termino</div></td>
    <td width="50"> 
    <div align="left">Activo</div></td>
  </tr>
  </table>

<div align="center">
    <table width="800" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;" class="tablaframe" >
        <tr>
            <td>
                <iframe name="ifrm1" width="100%" height="250" scrolling="yes" src="../iframes/ifrm_convenios.php"  frameborder="0" align="middle" ></iframe>
            </td>
        </tr>
    </table>
</div>    
    
    
<form id="iframeForm" method="post" target="" action="">
    <input type="hidden" value="" name="idfaena">
    
	
  
</form> 


<script language="JavaScript">

            function GetFecha(i,fechabox)

            {

                        if (i==1)

                        {

                                   var tmp = eval(fechabox)

                                   popcalendar.selectWeekendHoliday(1,1)

                                   popcalendar.show(tmp, null, "Hoy")
								  

                        }

            }

            popcalendar = getCalendarInstance()

            popcalendar.startAt = 1 // 0= Domingo 1= Lunes

            popcalendar.language = 0  // Cambios de  0 = Espaniol; 1 = Ingles; 2 = Portuges

            popcalendar.defaultFormat = "dd/mm/yyyy" //Formato dd/mm/yyyy

            popcalendar.initCalendar();
			
			
			

</script> 