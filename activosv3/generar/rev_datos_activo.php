<?php

include "../lib/database.php";

$solicitud=$_GET["solicitud"];

if(!isset($solicitud))
   $solicitud=0;
$xdescrip='';
$xmodelo='';
$xmarca='';
$xserie='';
$xpais='';
$xpatente='';
   
   
if ($solicitud > 0)  {

$sql="select descripcion_bien,marca,modelo,numero_serie,pais_origen,patente from formulario_activo 
      where idformulario=$solicitud ;";
//echo $sql;	  

$resul=sqlsrv_query($actf,$sql);
$obj=sqlsrv_fetch_object($resul);

$xdescrip=$obj->descripcion_bien;
$xmarca=$obj->marca;
$xmodelo=$obj->modelo;
$xserie=$obj->numero_serie;
$xpais=$obj->pais_origen;
$xpatente=$obj->patente;

if (strlen($xpais)>0){
$sql="select cod_pais,nombre_pais from pais_origen where idpais=$xpais  ";
$resul=sqlsrv_query($actf,$sql);
$obj=sqlsrv_fetch_object($resul); 
$d1=$obj->cod_pais;
$d2=$obj->nombre_pais;
$xpais=$d1.'--->'.$d2;
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
			
<form name="fm_datos" method="post"  >

    
	<table width="95%" align="center" class="tablabase">
				  <tr></tr>
                 
				   <tr>
				   <td>
     	  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">    
					<tr>
					  <td colspan="3" class="titledatos" width="150" align="center"><div align="center">Descripción del Bien </div></td>
					  
					</tr>
					<tr></tr>
                    <td colspan="3">
                      <div align="center">
                      <textarea name="descripcion" id="descripcion" cols="100" rows="3" disabled><?php echo $xdescrip?>  </textarea>
                      </div>
                    </td>
                    	<tr></tr>
					<tr>
					  <td class="titledatos"width="150">Marca</td>
					  <td width="2%"></td>
					  <td >
					  <input name="marca" type="text" value="<?php echo $xmarca?>" size="45" maxlength="30" readonly ></td>
					</tr>
					<tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Modelo</td>
					  <td width="2%"></td>
					  <td >
					  <input name="modelo" type="text" value="<?php echo $xmodelo?>" size="45" maxlength="30" readonly ></td>
					</tr>
					<tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Nro.Serie</td>
					  <td width="2%"></td>
					  <td ><input name="nro_serie" type="text" value="<?php echo $xserie?>" size="45" maxlength="30" readonly ></td>
					</tr>
					<tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Pais Origen</td>
					  <td width="2%"></td>
					  <td >	<input name="pais" type="text" value="<?php echo $xpais?>" size="45" maxlength="30" readonly ></td>
					</tr>
					<tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Patente</td>
					  <td width="2%"></td>
					  <td >
					  <input name="patente" type="text" value="<?php echo $xpatente?>" size="20" maxlength="15" readonly ></td>
					</tr>
					<tr></tr>  
					
					
					
		</table>
	</td>
	</tr>	
	</table> 
</form>
<br>


</body>

