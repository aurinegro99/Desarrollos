<?php

include "../lib/database.php";

	
//$opcion_clase='';
$opcion_pais='';		
	
//$sql="select idclase,tipo_clase,nombre_clase from clase_activo where activo='S' order by tipo_clase  ";
//$resul=mssql_query($sql);
//while(list($d1,$d2,$d3)=mssql_fetch_row($resul)){
//      $opcion_clase.="<option value=$d1 >$d2 --> $d3</option>";
//
//}


$sql="select idpais,cod_pais,nombre_pais from pais_origen order by idpais  ";
$resul=sqlsrv_query($actf,$sql);
while($obj = sqlsrv_fetch_object($resul))
{
      $opcion_pais.="<option value=$obj->idpais >$obj->cod_pais --> $obj->nombre_pais</option>";
}


?>

<script language="JavaScript" type="text/JavaScript">


function maximaLongitud(texto,maxlong) { 
var tecla, in_value, out_value;

if (texto.value.length > maxlong) {
in_value = texto.value;
out_value = in_value.substring(0,maxlong);
texto.value = out_value;
return false;
}
return true;
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
     	  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">    
					<tr>
					  <td colspan="3" class="titledatos" width="200" align="center"><div align="center">Descripción del Bien (Maximo 50 caracteres) </div></td>
					  
					</tr>
					<tr></tr>
                    <td colspan="3">
                      <div align="center">
                      <textarea name="descripcion" id="descripcion" cols="120" rows="3" onKeyDown="return maximaLongitud(this,50)" onKeyUp="return maximaLongitud(this,50)" style="text-transform:uppercase;" ></textarea>
                      </div>
                    </td>
                    	<tr></tr>
                        <tr></tr>
					<tr>
					  <td class="titledatos"width="150">Marca</td>
					  <td width="2%"></td>
					  <td >
					  <input name="marca" type="text" value="" size="45" maxlength="30" ></td>
					</tr>
					<tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Modelo</td>
					  <td width="2%"></td>
					  <td >
					  <input name="modelo" type="text" value="" size="45" maxlength="30" ></td>
					</tr>
					<tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Nro.Serie</td>
					  <td width="2%"></td>
					  <td >
					  <input name="nro_serie" type="text" value="" size="45" maxlength="30" ></td>
					</tr>
					<tr></tr>
                    <tr>
					  <td class="titledatos"width="150">Pais Origen</td>
					  <td width="2%"></td>
					  <td > 
                                              <select name="pais" >
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
					  <input name="patente" type="text" value="" size="20" maxlength="15" ></td>
					</tr>
					<tr></tr>  
					
					
					
		</table>
	</td>
	</tr>	
	</table> 
</form>
<br>


</body>

