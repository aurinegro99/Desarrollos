<?php

$solicitud=$_GET["solicitud"];

include "../lib/database.php";
include "../lib/database_amazon.php";

$solicita='';
$sql="select idclase,solicitante,aprobador,convert(varchar,fecha_solicitud,103) as fecha,convert(varchar,fecha_solicitud,108) as hora,status_solicitud,usuario from formulario_activo 
      where idformulario=$solicitud ;";
//echo $sql;	  
$resul=sqlsrv_query($actf,$sql);
$obj = sqlsrv_fetch_object($resul);
$xclase=$obj->idclase;
$xsolicita=$obj->solicitante;
$xaprueba=$obj->aprobador;
$xfecha=$obj->fecha;
$xhora=$obj->hora;
$xstatus=$obj->status_solicitud;
$xusuario=$obj->usuario;

$xnombre_estatus='No Determinado';


if ($xstatus=='A')
    $xnombre_estatus='Solicitud Activa';
if ($xstatus=='D')
    $xnombre_estatus='Solicitud Desactivada';


$xusuario="KCCL".chr(92).$xusuario;

$sql="select rut_usuario,nombre_usuario from usuarios_informe where usuario='$xusuario' ;";
$resul=sqlsrv_query($amazon,$sql);
$obj = sqlsrv_fetch_object($resul);
$xrut=$obj->rut_usuario;
$solicita=$obj->nombre_usuario;

/*
$wsdlurl= "http://arrayanv2:50000/WS_INFOPUBLISHER/Config1?wsdl&style=document" ; // productivo
//$wsdlurl  ="http://10.4.52.50:51000/WS_INFOPUBLISHER/Config1?wsdl&style=document"; //  desarrollo

$login    = "";
$password = "";
$client = new SoapClient($wsdlurl,
			array('login'      => $login,
				  'password'   => $password,
				  'trace'	   => true,
				  'exceptions' => true));
//var_dump($client->__getFunctions());

$param = array("rut"=>"$xrut");

$result = $client -> datosEmpleado($param);


//print_r($result);


$solicita=$result->Response->nombre;
 
  
 */

/*






if (strlen($xrut)>0){
	$sql="select nombre from personal_rrhh where ltrim(codigo)='$xrut' and estado='A' and glosa_corta='KCH' ;";
	//echo $sql;
	$resul=mssql_query($sql);
	list($solicita)=mssql_fetch_row($resul);
	
}

else
     $solicita=$xusuario;


*/
$opcion_clase='';	
	
$sql="select idclase,tipo_clase,nombre_clase from clase_activo where activo='S' order by tipo_clase ";
$resul=sqlsrv_query($actf,$sql);
$obj = sqlsrv_fetch_object($resul);
//$resul=mssql_query($sql);
while($obj=sqlsrv_fetch_object($resul)){
	  if ($obj->idclase==$xclase)
	     $opcion_clase.="<option value=$obj->idclase selected  >$obj->tipo_clase --> $obj->nombre_clase</option   >";
	  else
         $opcion_clase.="<option value=$obj->idclase >$obj->tipo_clase --> $obj->nombre_clase</option>";

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
 

function grabar()
{
	 var d=document.fm_ingreso;
	
	 if (isBlanco(d.rut_solicita.value)){
        alert('Debe Ingresar Solicitante ');
        return false;
      }
	  
	if (isBlanco(d.aprueba.value)){
        alert('Debe Ingresar Aprobador');
        return false;
      }  
	
	if (d.clase.value<=0){
        alert('Debe Ingresar Clase Activo');
        return false;
      }  
	  
	  var xstatus=d.status.checked;
	var xletra='';
	if (xstatus==true)
	   xletra='A';
	   
	else
	   xletra='D';
	   
	   
	//alert(xletra);   
	  
    ajax = nuevoajax();
  ajax.onreadystatechange = refrescar;//Quien me procesa los 4 estados
  ajax.open('POST','../acciones/grabar_01_modificacion.php?solicitud='+d.solicitud.value+'&aprobador='+d.aprueba.value+'&clase='+d.clase.value+'&letra='+xletra+'&nombre_solicita='+d.solicita.value, true);
  ajax.send(null);
	
	
	
}



function refrescar()
{

   if(ajax.readyState == 4)
     {
       var d=document.fm_ingreso;
       var out=ajax.responseText;

       //alert(out);
       if (out==0)
          alert('Datos Modificados Satisfactoriamente ');
       else
          alert('Error al Grabar');
       window.location.href='rev_ingreso_informacion.php?solicitud='+d.solicitud.value;

     } 
}

</script>
<link rel="stylesheet" type="text/css" href="../css/estilo.css" />
<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#FFFFCC" >
<br>
<br>
			
<form name="fm_ingreso" method="post"  >
	<input type="hidden" name="solicitud" value="<?php echo $solicitud?>">
	<table width="95%" align="center" class="tablabase">
				 <tr></tr>
                 <tr>
                    <td>
              
               <img src="../img/46.png" align="right" alt="Grabar" border="1" style="cursor:hand" onClick="javascript:grabar();">
             
            </td>
                 </tr>
                 
                 
				   <tr>
				   <td>
     	  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">    
                    <tr>
                       <td class="titledatos" width="150">Estatus Solicitud </td>
					   <td width="2%"></td>
					   <td > <input name="status" type="checkbox" <?php if ($xstatus=='A') echo 'checked'   ?> ><strong><?php echo '     '.$xnombre_estatus?></strong></td>
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
					  <td class="titledatos" width="150">Solicitado por </td>
					  <td width="2%"></td>
					  <td > <input name="rut_solicita" value="<?php echo $xrut ?>" type="text"  size="15" maxlength="12" readonly>
                            <input name="solicita" type="text" size="60" value="<?php echo $solicita?>" readonly>
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
					  <td >
					 <select name='clase'onChange="">
                      <option value=-1></option>
                      <?php echo $opcion_clase?>
                      </select>
                     </td>
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

