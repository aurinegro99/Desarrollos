<?php

$solicitud=$_GET["solicitud"];

include "../lib/database.php";
include "../lib/database_amazon.php";


if(!isset($solicitud))
   $solicitud=0;
   
$xfecha='';
$xhora='';
$xrut='';   
$xstatus='';
$solicita='';
$xnombre_estatus='';
$xclase='';
$xaprueba='';

if ($solicitud>0){

$sql="select idclase,solicitante,aprobador,convert(varchar,fecha_solicitud,103) as fecha ,convert(varchar,fecha_solicitud,108) as hora,status_solicitud,usuario from formulario_activo 
      where idformulario=$solicitud ;";
//echo $sql;	

$resul=sqlsrv_query($actf,$sql);
$obj=sqlsrv_fetch_object($resul); 
$xclase=$obj->idclase;
$xsolicita=$obj->solicitante;
$xaprueba=$obj->aprobador;
$xfecha=$obj->fecha;
$xhora=$obj->hora;
$xstatus=$obj->status_solicitud;
$xusuario=$obj->usuario;

//list($xclase,$xsolicita,$xaprueba,$xfecha,$xhora,$xstatus,$xusuario)=mssql_fetch_row($resul);	  

if ($xstatus=='A')
    $xnombre_estatus='Solicitud Activa';
if ($xstatus=='D')
	$xnombre_estatus='Solicitud Desactivada';

// buscar datos usuario data amazon

$musuario="KCCL".chr(92).$xusuario;
$sql="select nombre_usuario,rut_usuario FROM usuarios_informe where usuario='$musuario'";
//echo $sql;
$resul=sqlsrv_query($amazon,$sql);
$obj=sqlsrv_fetch_object($resul); 

$solicita=$obj->nombre_usuario;
$xrut=$obj->rut_usuario;




$sql="select tipo_clase,nombre_clase from clase_activo where idclase=$xclase";
$resul=sqlsrv_query($actf,$sql);
$obj=sqlsrv_fetch_object($resul); 
$d1=$obj->tipo_clase;
$d2=$obj->nombre_clase;

$xclase=$d1.'-->'.$d2;

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


function isBlanco(texto)
   {
   largo = texto.length
   for (i=0; i < largo ; i++ )
       if ( texto.charAt(i) !=" ")
          return false;
return true
   }
 

</script>
<link rel="stylesheet" type="text/css" href="../css/estilo.css" />
<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#FFFFCC" >
<br>
<br>
			
<form name="fm_ingreso" method="post"  >
	<input type="hidden" name="solicitud" value="<?=$solicitud?>">
	<table width="95%" align="center" class="tablabase">
				 <tr></tr>
                             
				   <tr>
				   <td>
     	  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">    
                    <tr>
                       <td class="titledatos" width="150">Estatus Solicitud </td>
					   <td width="2%"></td>
					   <td > <input name="status" type="checkbox" <? if ($xstatus=='A') echo 'checked'   ?> disabled ><strong><?='     '.$xnombre_estatus?></strong> </td>
                    </tr>
                    <tr><tr>
          
          			<tr>
					  <td class="titledatos" width="150">Fecha Solicitud </td>
					  <td width="2%"></td>
					  <td >
					  <input name="fecha" value="<?php echo $xfecha.'  '.$xhora?>" type="text"  size="20" readonly ></td>
					</tr>
					<tr></tr>
                    
                    
          
					<tr>
					  <td class="titledatos" width="120">Solicitado por </td>
					  <td width="2%"></td>
					  <td > <input name="rut_solicita" value="<?php echo $xrut ?>" type="text"  size="15" maxlength="12" readonly>  <input name="solicita" type="text" size="60" value="<?php echo $solicita?>" readonly>
                           
                      </td>
					</tr>
					<tr></tr>
					<tr>
					  <td class="titledatos"width="150">Aprobado por</td>
					  <td width="2%"></td>
					  <td >
					  <input name="aprueba" type="text" value="<?php echo $xaprueba?>" size="45" maxlength="40" ></td>
					</tr>
					<tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Clase Activo</td>
					  <td width="2%"></td>
					  <td >  <input name="clase" type="text" value="<?php echo $xclase?>" size="45" maxlength="40" > </td>
					</tr>
					<tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Cantidad</td>
					  <td width="2%"></td>
					  <td >
					  <input name="cantidad" type="text" value="1" size="10" maxlength="2" readonly ></td>
					</tr>
					
					
					
		</table>
	</td>
	</tr>	
	</table> 
</form>
<br>


</body>

