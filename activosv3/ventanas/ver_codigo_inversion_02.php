
<html>
<link rel="stylesheet" type="text/css" href="../css/estilo.css" />
<title>Consulta Codigo Inversion</title>

<body>
<br>


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



function cerrar()
{
	window.close()
}



function isBlanco(texto)
   {
   largo = texto.length
   for (i=0; i < largo ; i++ )
       if ( texto.charAt(i) !=" ")
          return false;
    return true
   }
   
   
   
function grabar()
{
   d=document.frm_datos;
   
  
	if (d.mes_compra.value<=0)	{
       alert('Debe Seleccionar Mes Compra');
	   return false;
   }    
   
   if (d.mes_activa.value<=0)	{
       alert('Debe Seleccionar Mes Activacion');
	   return false;
   }
   
   
   var mesc=parseInt(d.mes_compra.value);
   var mesa=parseInt(d.mes_activa.value);
   
   
 /*  
   
   
   
   alert(mesa);
   */
   
   //alert(d.mes_compra.value+'  '+d.mes_activa.value);
   
   /*if (d.mes_compra.value>d.mes_activa.value){
	   alert('Mes Activacion debe ser Mayor o Igual a Mes Compra');
	   return false;
	   
	   }   */
   
   if (mesc>mesa){
	   alert('Mes Activacion debe ser Mayor o Igual a Mes Compra');
	   return false;
	   
	   }   
    
   
   ajax = nuevoajax();
   ajax.onreadystatechange = refresca_grabar;//Quien me procesa los 4 estados
   ajax.open('GET','../acciones/graba_status_codigo_02.php?idcodigo='+d.codigo.value+'&mes_c='+mesc+'&mes_a='+mesa,true);
   ajax.send(null);
   
   

}  

function refresca_grabar()
{
    if(ajax.readyState == 4){
	   out=ajax.responseText;
	   
	  // alert(out);
	   
	   if (out==0){
	      alert('Datos Grabados Correctamente');
		  opener.cargainversion();
		  cerrar();
		 
	   }
	   
	   else
	   {
		 
	     alert('Error al Grabar Datos');
		 return false;
	   }
	}
}


function cerrar()
{
	window.close()
} 

</script>




<?

#incluir librerias necesarias
include "../lib/database.php"; 
//include "../lib/database_activo.php"; 

include "../lib/meses_01.php"; 

// datos desde sauce
$sql=" select a.descripcion,a.cantidad,a.idcentro_costo,a.valor_presupuesto,b.tipo_clase,b.nombre_clase,a.mes_compra,a.mes_activacion from presupuesto_inversion a 
       left join clase_activo b on a.clase_activo=b.idclase
      where a.correlativo='$idcod' ;";
$resul=mssql_query($sql,$act);
list($xdescrip,$xcant,$xcentro,$xvalor_tot,$xclase,$xnombre,$mes_c,$mes_a)=mssql_fetch_row($resul);	

$monto_sol=0;
$cant_sol=0;

// solicitado x codigo

$sql="select sum(valor_compra),count(*) from formulario_activo where codigo_presupuesto='$idcod' and status_Activo='A' ;";
$resul=mssql_query($sql,$act);
list($monto_sol,$cant_sol)=mssql_fetch_row($resul);
  
  
/*// status codigo

$sql="select status,mes_compra,mes_activacion from proceso_activo where codigo_inversion='$idcod' ;";
$resul=mssql_query($sql,$nact);
list($xst,$mes_c,$mes_a)=mssql_fetch_row($resul);*/
 

$opcion_mc='';
for ($z = 9; $z <= 12; $z++){
	if ($z<=9)
	   $i=$z+3;
	else
	   $i=$z-9;    
	if ($z==$mes_c)
	   $opcion_mc.="<option value=$z selected >$meses[$i]</option>"; 
	else
	   $opcion_mc.="<option value=$z >$meses[$i]</option>"; 
}

$opcion_ma='';
for ($z = 9; $z <= 12; $z++){
	if ($z<=9)
	   $i=$z+3;
	else
	   $i=$z-9;    
	if ($z==$mes_a)
	   $opcion_ma.="<option value=$z selected >$meses[$i]</option>"; 
	else
	   $opcion_ma.="<option value=$z >$meses[$i]</option>"; 
}


?>

<table width="350" border="0" cellspacing="0" cellpadding="0" align="center">
   <tr>
   <td class="titletable">Consultar Codigo Inversion </td>
  </tr>
</table>
<br>

<table width="800" align="center" class="tablabase">
 
 <tr></tr>
   <tr>
   <td>
     <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">  
     <form name='frm_datos' method="post" >
     
       <tr>
        <td class="titledatos" width="150">Codigo </td>
	    <td width="2%"></td>
        <td  ><input  name="codigo" type="text" value="<?=$idcod?>" size="20" readonly ></td>
      </tr>
      <tr><td height="2"></td></tr>
      <tr>  
        <td class="titledatos" width="150">Clase Activo </td>
        <td width="2%"></td>
        <td  ><input  name="clase" type="text" value="<?=$xclase.'/'.$xnombre?>" size="50" readonly ></td>
       </tr> 
       <tr><td height="2"></td></tr>
       <tr>
        <td class="titledatos" width="150">Descripcion</td>
	    <td width="2%"></td>
        <td><input type="text" name="nombre" size="100" value="<?=$xdescrip?>" readonly ></td>
       </tr> 
        <tr><td height="2"></td></tr>
      <tr>
        <td class="titledatos" width="150">Centro Costo</td>
	    <td width="2%"></td>
        <td><input type="text" name="ceco" size="50" value="<?=$xcentro?>" readonly ></td>
       </tr> 
        <tr><td height="2"></td></tr>  
        
        
       <tr>
        <td class="titledatos" width="150">Monto Presupuesto</td>
	    <td width="2%"></td>
        <td><input type="text" name="monto" size="10" value="<?=$xvalor_tot?>" readonly ></td>
       </tr>
       <tr> 
        <td class="titledatos" width="150">Cant. Presupuesto</td>
	    <td width="2%"></td>
        <td><input type="text" name="cant" size="10" value="<?=$xcant?>" readonly ></td>
       </tr> 
       <tr> <td height="5"></td></tr>
       
       <tr>
        <td class="titledatos" width="150">Monto Solicitado</td>
	    <td width="2%"></td>
        <td><input type="text" name="monto_s" size="10" value="<?=$monto_sol?>" readonly ></td>
       </tr>
       <tr> 
        <td class="titledatos" width="150">Cant. Solicitado</td>
	    <td width="2%"></td>
        <td><input type="text" name="cant_s" size="10" value="<?=$cant_sol?>" readonly ></td>
       </tr> 
       <tr> <td height="5"></td></tr>
       <tr>
        <td class="titledatos" width="150">Saldo Codigo</td>
	    <td width="2%"></td>
        <td><input type="text" name="saldo" size="10" value="<?=number_format($xvalor_tot-$monto_sol,2,'.',',')?>" readonly ></td>
       </tr> 
        <tr> <td height="7"></td></tr>
        
       <tr>
        <td class="titledatos" width="150">Mes Compra</td>
	    <td width="2%"></td>
        <td ><select name="mes_compra" > 
        <option value=-1></option>
        <?=$opcion_mc?>
        </select></td>
        </tr>
        
       <tr>
        <td class="titledatos" width="150">Mes Activacion</td>
	    <td width="2%"></td>
        <td ><select name="mes_activa" > 
        <option value=-1></option>
        <?=$opcion_ma?>
        </select></td>
        </tr>  
        
     
    <tr> 
      <td colspan="3"><div align="center">
      
		
        <img src="../img/010.png" align="right" alt="Cerrar" border="1" style="cursor:hand" onClick="javascript:cerrar();">
       	<img src="../img/46.png" align="right" alt="Crear" border="1" style="cursor:hand" onClick=" return grabar();" >
      
	  </td>
	</tr> 
       
       
       
       
       
     </form>
     </table>
     
     
     
   </td>
   </tr>
</table>     



</body>

