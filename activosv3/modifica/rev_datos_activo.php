<?PHP
$solicitud=$_GET["solicitud"];
include "../lib/database.php";

$sql="select descripcion_bien,marca,modelo,numero_serie,pais_origen,patente,idclase from formulario_activo 
      where idformulario=$solicitud ;";
$resul=sqlsrv_query($actf,$sql);
$obj = sqlsrv_fetch_object($resul);
$xdescrip=$obj->descripcion_bien;
$xmarca=$obj->marca;
$xmodelo=$obj->modelo;
$xserie=$obj->numero_serie;
$xpais=$obj->pais_origen;
$xpatente=$obj->patente;
$xclase=$obj->idclase;

$opcion_pais="";
$sql="select * from pais_origen order by idpais  ";
$resul=sqlsrv_query($actf,$sql);

while($obj=sqlsrv_fetch_object($resul)){
	
	  if ($obj->idpais==$xpais)
         $opcion_pais.="<option value=$obj->idpais selected >$obj->cod_pais --> $obj->nombre_pais</option>";
	  else
	  	 $opcion_pais.="<option value=$obj->idpais >$obj->cod_pais --> $obj->nombre_pais</option>";

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
 


function grabar(){
	
	 var d=document.fm_datos;
	
	 if (isBlanco(d.descripcion.value)){
        alert('Debe Ingresar Descripcion Activo ');
        return false;
      }
	
	
	
	if ((d.clase.value==10) || (d.clase.value==10)){
		
		if (isBlanco(d.nro_serie.value)){
            alert('Debe Ingresar Numero Serie Componente');
            return false;
           }
		
		}
	
	if(d.pais.value<=0) {
		
		alert('Debe seleccionar Pais Origen');
		return false;
		}
	
	
	
	
	  ajax = nuevoajax();
          ajax.onreadystatechange = refrescar;//Quien me procesa los 4 estados
          ajax.open('POST','../acciones/grabar_02_modificacion.php?solicitud='+d.solicitud.value+'&descripcion='+d.descripcion.value+'&marca='+d.marca.value+'&modelo='+d.modelo.value+'&serie='+d.nro_serie.value+'&pais='+d.pais.value+'&patente='+d.patente.value, true);
          ajax.send(null)
	
	
	
	
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

window.location.href='rev_datos_activo.php?solicitud='+d.solicitud.value;

    }
}

</script>
<link rel="stylesheet" type="text/css" href="../css/estilo.css" />
<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#FFFFCC" >
<br>
<br>
			
<form name="fm_datos" method="post"  >

     <input type="hidden" name="clase" value="<?php echo $xclase?>">
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
					  <td colspan="3" class="titledatos" width="150" align="center"><div align="center">Descripción del Bien </div></td>
					  
					</tr>
					<tr></tr>
                    <td colspan="3">
                      <div align="center">
                      <textarea name="descripcion" id="descripcion" cols="100" rows="3" style="text-transform:uppercase;"><?php echo $xdescrip?>  </textarea>
                      </div>
                    </td>
                    	<tr></tr>
					<tr>
					  <td class="titledatos"width="150">Marca</td>
					  <td width="2%"></td>
					  <td >
					  <input name="marca" type="text" value="<?php echo$xmarca?>" size="45" maxlength="30" ></td>
					</tr>
					<tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Modelo</td>
					  <td width="2%"></td>
					  <td >
					  <input name="modelo" type="text" value="<?php echo $xmodelo?>" size="45" maxlength="30"  ></td>
					</tr>
					<tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Nro.Serie</td>
					  <td width="2%"></td>
					  <td >
					  <input name="nro_serie" type="text" value="<?php echo $xserie?>" size="45" maxlength="30"  ></td>
					</tr>
					<tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Pais Origen</td>
					  <td width="2%"></td>
					  <td ><select name="pais" >
                      <option value=-1></option>
                      <?php echo $opcion_pais?>
                      </select>
					  </td>
					</tr>
					<tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Patente</td>
					  <td width="2%"></td>
					  <td >
					  <input name="patente" type="text" value="<?php echo $xpatente?>" size="20" maxlength="15"  ></td>
					</tr>
					<tr></tr>  
					
					
					
		</table>
	</td>
	</tr>	
	</table> 
</form>
<br>


</body>

