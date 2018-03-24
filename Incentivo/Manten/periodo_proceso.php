<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../ini/inicial.php';
$usuario=$_SESSION["usuario"];

require_once '../app/clases/UsuarioLocal.php';

include '../lib/meses_01.php';


// rescata periodo

$xperiodo=new UsuarioLocal();
$lista=$xperiodo->getUltimoPeriodo();
foreach($lista as $datos){
    
    $xperiodo=$datos["periodo"];
    $xmes=$datos["mes"];
    $xstatus=$datos["status"];
    $xusuario=$datos["usuario_creacion"];
    $xfecha=$datos["fecha"];
    $xhora=$datos["hora"];
    
}

if ($xstatus=='C'){
    if ($xmes==12){
        $xmes=1;
        $xperiodo++;
        
    }
 else {
       $xmes++;    
    }    
    
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
 
function grabar(){
    var d=document.frm_cabecera;
    
    if ((d.xaccion.value=='A') && (d.cierre.checked==false)){
        alert('Para cerrar mes debe checkear Cierre Mes ');
        return false;
        
    }
    
    if (d.xaccion.value=='A'){
        var respond=confirm('Esta seguro de Cerrar?? No Se Podrá Ingresar Datos Para Periodo');
        if (respond==false)
            return false;
    }
    
    if (d.xaccion.value=='C'){
        var respond=confirm('Esta seguro de Abrir Nuevo Periodo');
        if (respond==false)
            return false;
    }
        
    //alert('pasar ');    
    ajax = nuevoajax();
    ajax.onreadystatechange = refrescar_periodo;//Quien me procesa los 4 estados
    ajax.open('GET','../acciones/gestion_periodo.php?status='+d.xaccion.value, true);
    ajax.send(null);
    
}

function refrescar_periodo(){
       
       if(ajax.readyState == 4){
           
           var out = ajax.responseText; 
           //alert(out);
           if (out=='0')
               alert('Periodo Cerrado Correctamente');
           if (out=='1')    
              alert('Periodo Abierto Correctamente'); 
           if (out=='9')
               alert('Error Proceso');
            window.location.href='periodo_proceso.php';	
           
       }
    
       
}


</script>


<script language="JavaScript" src="../js/popcalendar.js"></script>



<body >
<table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td class="titletable"><h4><strong>Periodo Proceso</strong></h4></td>
    </tr>
 </table>
    
<br>

<table width="800" align="center" class="tablabase">
       <tr> <td height="5"></tr>
        <tr>
            <td>
             <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">  
     <form name='frm_cabecera' method="post" >
     <input type="hidden" name="xperiodo" value="<?php echo $xperiodo?>">
     <input type="hidden" name="xmes" value="<?php echo $xmes?>">
     <input type="hidden" name="xaccion" value="<?php echo $xstatus?>">
     
     <tr>
     <td class="titledatos" width="150">Periodo</td>
	 <td width="2%"></td>
     <td ><input type="text" name="periodo" value="<?php echo $xperiodo?>" size="20" readonly > </td>
     </tr>
     <tr></tr>
     
     <tr>
     <td class="titledatos" width="150">Mes</td>
	 <td width="2%"></td>
     <td><input type="text" name="mes" value="<?php echo $meses[$xmes]?>" size="20" readonly> </td>
     
     </tr>
     <tr></tr>
     
    <?php if ($xstatus=='A') { ?>
    
    	<tr>
        <td class="titledatos" width="150">Fecha Apertura</td>
	    <td width="2%"></td>
        <td><input type="text" name="fecha" value="<?php echo $xfecha.' '.$xhora?>" size="30" readonly> </td>
        </tr>
        <tr></tr>
        
        <tr>
        <td class="titledatos" width="150">Usuario Apertura</td>
	    <td width="2%"></td>
        <td><input type="text" name="usuario" value="<?php echo $xusuario?>" size="40" readonly> </td>
        </tr>
        <tr></tr>
    	
    
       <tr>
       <td class="titledatos" width="150">Cierre Mes</td>
	   <td width="2%"></td> 
           <td><input type="checkbox" name="cierre"  size="10" id="cierre" > </td>
     
       </tr>
     <tr></tr>
    
    
    <?php  }?>
     
     <tr> <td height="5"></td></tr>
    <tr> 
      <td colspan="5"><div align="center">
      
		
        
       <img src="../img/46.png" title="Grabar" width="16" height="16" border="1" align="right" style="cursor:hand" onClick="grabar();" >
		
		
        
	  </td>
	</tr> 
     
     </form>
     </table>
   </td>
   </tr>
</table>  
</body>
