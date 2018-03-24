<?php
session_start();
$idusuario = $_SESSION["usuario"];
$idperfil = $_SESSION["perfil"];

include "../header/header.php"; 
include "../lib/database.php";
include "../lib/database_amazon.php";

// cargar periodos
$opcion_periodo='';
$sql="select idperiodo from periodos_inversion order by idperiodo ";
$resule=sqlsrv_query($actf,$sql);
while($obj = sqlsrv_fetch_object($resule))
{
    $opcion_periodo.="<option value=$obj->idperiodo >$obj->idperiodo</option>";
}


$opcion_gerencia='';

include "../rutinacarga/CargaGerenciaUsuario.php";

?>
<script language="JavaScript" type="text/JavaScript">

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////                   FUNCION AJAX PARA LA CARGA INSTANTANEA                            /////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function nuevoajax(){ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false;
	try	{ 
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e){
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


function limpiar()
{
     window.location.href='informe_presupuesto_inversion.php';	
    
    
}


function cargafaenas()
{

   // alert('hola');
	
	d=document.fm_detalle;
	
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



	
function isBlanco(texto){
   largo = texto.length
   for (i=0; i < largo ; i++ )
       if ( texto.charAt(i) !=" ")
          return false;
return true
}

function imprime() 
{
	
	var d=document.fm_detalle;
	
	if (d.periodo.value<=0) 
        {
            alert("Debe Seleccionar Periodo");
            return false;
        }   
        
    if (isBlanco(d.gerencia.value))
        {
            alert("Debe Seleccionar Gerencia");
            return false;
            
        }
        
    if ((d.perfil.value<=1) && (d.faena.value<=0))
        {
            alert("Debe Seleccionar Faena");
            return false;
        }
        
        
		
	  d.action='../salidas/listado_presupuesto_inversion.php';
      d.submit();
	
	
}
		
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////             CHEQUEAR  VALORES NO NULOS       //////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
  
</script>
<?


?>

<br>
<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">
   <tr>
   <td class="titletable">Informe Presupuesto Inversiones</td>
  </tr>
</table>
 <br>
 
<table width="400" align="center" class="tablabase">
 
 <tr></tr>
   <tr>
   <td>
     <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">  
	 
     <form name='fm_detalle' method="post" >
     <input type="hidden" name="perfil" value="<?php echo $idperfil?>"  />
			
					 
                     <tr>
               <td class="titledatos" width="100">Periodo</td>
					  <td width="2%"></td>
					  <td >
					  <select name='periodo' >
                      <option value=0></option>
                      <?php echo $opcion_periodo?>
                      </option>
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
                      </option>
                      </select>      
                      </td>
            
             
               
               </tr> 
               <tr></tr>
                   
                   
                   
                     
				     <tr>
				     <td class="titledatos" width="150">Seleccione Faena</td>
					 <td width="2%"></td>
				     <td ><select name='faena'onChange="" id="faena">
				     <option value=0></option>
				     </select></td>
				     </tr>
			
				
			
				<tr></tr>
                     
			<td colspan="3"><div align="center">
		  
		    	<img src="../img/excel_icono.gif" align="right" title="Emitir Informe" border="1" style="cursor:hand" onClick="javascript:imprime();">
                        <img src="../img/nuevo.gif" align="right" title="Limpiar" border="1" style="cursor:hand" onClick="javascript:limpiar();">
		   </td>
		   <td>
		  
		   </td>
		   
		  
	     </tr>
	</form>
	</table>

  <br> 	  
	  
	  
	  
  
  </table>
      
  </tr>
  </table>
  
  
<br> 


<? include "../footer/pie_pagina.php"; ?>