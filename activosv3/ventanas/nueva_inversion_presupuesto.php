<html>
<link rel="stylesheet" type="text/css" href="../css/estilo.css" />
<title>Crear Codigo Inversion</title>

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


function Limpiar()
{
	d=document.frm_datos;
	 window.location.href='nueva_inversion_presupuesto.php?idfaena='+d.idfaena.value+'&idperiodo='+d.idperiodo.value;
	
}




function isBlanco(texto)
   {
   largo = texto.length
   for (i=0; i < largo ; i++ )
       if ( texto.charAt(i) !=" ")
          return false;
    return true
   }
   

function calculavalor(){
	var d=document.frm_datos;
	
	//alert('paso1');
	
	if (isNaN(d.cantidad.value)==true){
	   alert('Cantidad  debe ser Numerico');
	   d.cantidad.value=0;
	   d.total.value=0;
	   return false;
	   }
	if (isNaN(d.valor_u.value)==true){
		
	   alert('Valor Unitario debe ser Numerico');
	   d.valor_u.value=0;
	   d.total.value=0;
	   return false;
	   }   
	
	
	//alert(d.cantidad.value+d.valor_u.value);
	
	if ((d.cantidad.value>0)&&(d.valor_u.value>0)){
		
		var total_codigo=parseFloat(d.cantidad.value)*parseFloat(d.valor_u.value);
		d.total.value=total_codigo;
		
		
		}
	else
	    d.total.value=0;	
	
	
	}

   
   
function grabar()
{
   d=document.frm_datos;
   
   if (d.centro_costo.value<=0){
	   alert('Debe seleccionar Centro Costo');
	   return false;
	   }
   if (d.clase_activo.value<=0){
	   alert('Debe seleccionar Clase Activo');
	   return false;
	   } 
   if (isBlanco(d.descripcion.value)){
       alert('Debe Ingresar Descripcion Bien');
	   return false;
   }     
    
	
   if (d.cantidad.value<=0)	{
       alert('Cantidad debe ser Mayor a Cero');
	   return false;
   }
   
   if (isNaN(d.cantidad.value)==true){
	   alert('Cantidad  debe ser Numerico');
	   return false;
	   }
   
   if (d.valor_u.value<=0)	{
       alert('Valor Unitario debe ser Mayor a Cero');
	   return false;
   } 
   
   if (isNaN(d.valor_u.value)==true){
	   alert('Valor Unitario debe ser Numerico');
	   return false;
	   }
   
   if (d.mes_compra.value<=0)	{
       alert('Debe Seleccionar Mes Compra');
	   return false;
   }    
   
   if (d.mes_activacion.value<=0)	{
       alert('Debe Seleccionar Mes Activacion');
	   return false;
   }
   
   if (d.mes_activacion.value<=0)	{
       alert('Debe Seleccionar Mes Activacion');
	   return false;
   }
   
   
   var mesc=parseInt(d.mes_compra.value);
   var mesa=parseInt(d.mes_activa.value);
   var valu=parseFloat(d.valor_u.value);
   
   /*if (d.mes_compra.value>d.mes_activacion.value){
	   alert('Mes Activacion debe ser Mayor o Igual a Mes Compra');
	   return false;
	   
	   }
	*/
	 if (mesc>mesa){
	   alert('Mes Activacion debe ser Mayor o Igual a Mes Compra');
	   return false;
	   
	   }  
	
	
	if (d.tipo_proyecto.value<=0){
		alert('Debe Seleccionar Tipo Proyecto');
		return false
		} 
	if (d.motivo_inversion.value<=0){
		alert('Debe Seleccionar Motivo Inversion');
		return false
		} 	
	
	if (valu<100){
		alert('Valor Unitario debe ser mayor o igual a 100 dolares');
		return false
		
		}
		 
	
	if (d.prioridad.value<=0){
		alert('Debe Seleccionar una Prioridad');
		return false
		
		}
	
	
   ajax = nuevoajax();
   ajax.onreadystatechange = refresca_grabar;//Quien me procesa los 4 estados
   ajax.open('POST','../acciones/graba_nueva_inversion.php?idcentro='+d.centro_costo.value+'&idclase='+d.clase_activo.value+'&descripcion='+d.descripcion.value+'&cantidad='+d.cantidad.value+'&valor='+d.valor_u.value+'&mes_c='+d.mes_compra.value+'&mes_a='+d.mes_activacion.value+'&idfaena='+d.idfaena.value+'&idperiodo='+d.idperiodo.value+'&motivo='+d.motivo_inversion.value+'&proyecto='+d.tipo_proyecto.value+'&prioridad='+d.prioridad.value,true);
   ajax.send(null);
   
   

}  

function refresca_grabar()
{
    if(ajax.readyState == 4){
	   out=ajax.responseText;
	   
	  //alert(out);
	   
	   if (out==0){
	      alert('Datos Grabados Correctamente');
		  opener.cargainversion();
		  Limpiar();
		  
		 
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



function formatNumber(num,dec,thou,pnt,curr1,curr2,n1,n2) {var x = Math.round(num * Math.pow(10,dec));if (x >= 0) n1=n2='';var y = (''+Math.abs(x)).split('');var z = y.length - dec; if (z<0) z--; for(var i = z; i < 0; i++) y.unshift('0');y.splice(z, 0, pnt); if(y[0] == pnt) y.unshift('0'); while (z > 3) {z-=3; y.splice(z,0,thou);}var r = curr1+n1+y.join('')+n2+curr2;return r;}


</script>




<?

#incluir librerias necesarias
include "../lib/database.php"; 
include "../lib/database_amazon.php";

$idfaena = $_REQUEST["idfaena"];
$idperiodo = $_REQUEST["idperiodo"];
    


$opcion_clase="";
$opcion_centro="";
$opcion_motivo="";
$opcion_proyecto="";
$sqlg="select idclase,tipo_clase,nombre_clase from clase_activo where activo='S' order by tipo_clase ";
$resule=sqlsrv_query($actf,$sqlg);
while($obj = sqlsrv_fetch_object($resule)){
      $opcion_clase.="<option value=$obj->idclase >$obj->tipo_clase --> $obj->nombre_clase</option>";
}

// centro costo

$sqlg="select a.ceco,a.nombre_ceco from dim_cebe_ceco a
       left join dim_faena_cebe b on a.cebe=b.cebe
        where b.idfaena=$idfaena and a.activo='S' ;";
$resule=sqlsrv_query($amazon,$sqlg);
while($obj = sqlsrv_fetch_object($resule)){
      $opcion_centro.="<option value=$obj->ceco >$obj->ceco --> $obj->nombre_ceco</option>";
}

// motivo
$sqlg="select idmotivo,nombre_motivo from motivo_inversion  order by idmotivo ;";
$resule=sqlsrv_query($actf,$sqlg);
while($obj = sqlsrv_fetch_object($resule)){
      $opcion_motivo.="<option value=$obj->idmotivo >$obj->nombre_motivo</option>";
}

// proyecto
$sqlg="select idproyecto,nombre_proyecto from proyecto_inversion where idfaena=$idfaena order by idproyecto ;";
$resule=sqlsrv_query($actf,$sqlg);
while($obj = sqlsrv_fetch_object($resule)){
      $opcion_proyecto.="<option value=$obj->idproyecto >$obj->nombre_proyecto</option>";
}

?>

<table width="350" border="0" cellspacing="0" cellpadding="0" align="center">
   <tr>
   <td class="titletable">Crear Nuevo Registro Inversion </td>
  </tr>
</table>
<br>

<table width="900" align="center" class="tablabase">
 
 <tr></tr>
   <tr>
   <td>
     <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">  
     <form name='frm_datos' method="post" >
     <input name="idfaena" type="hidden" value="<?=$idfaena?>">
     <input name="idperiodo" type="hidden" value="<?=$idperiodo?>">
     
     
        <tr>
        <td class="titledatos" width="150">Centro Costo</td>
	    <td width="2%"></td>
        <td  >
        <select name='centro_costo ' onChange="" id="centro_costo">
                      <option value=-1></option>
                      <?=$opcion_centro?>
                      </select>
        </td>
      </tr>
     
       <tr>
        <td class="titledatos" width="150">Clase Activo </td>
	    <td width="2%"></td>
        <td  > <select name='clase_activo'onChange="" id="clase_activo">
                      <option value=-1></option>
                      <?=$opcion_clase?>
                      </select>
        </td>
      </tr>
      <tr><td height="2"></td></tr>
      <tr>  
        <td class="titledatos" width="150">Descripcion Bien </td>
        <td width="2%"></td>
        <td  ><input  name="descripcion" type="text" value="" size="100" maxlength="50" id="descripcion" ></td>
       </tr> 
       <tr><td height="2"></td></tr>
       <tr>
        <td class="titledatos" width="150">Cantidad</td>
	    <td width="2%"></td>
        <td><input type="text" name="cantidad" size="10" value="0" class="numeros" id="cantidad" onChange="calculavalor();"></td>
       </tr> 
        <tr><td height="2"></td></tr>
      <tr>
        <td class="titledatos" width="150">Valor Unitario (USD)</td>
	    <td width="2%"></td>
        <td><input type="text" name="valor_u" size="10" value="0" class="numeros" id="valor_u" onChange="calculavalor();"></td>
       </tr> 
        <tr><td height="2"></td></tr> 
        
        <tr>
        <td class="titledatos" width="150">Total (USD)</td>
	    <td width="2%"></td>
        <td><input type="text" name="total" size="10" value="0" class="numeros" id="total" disabled ></td>
       </tr> 
        <tr><td height="2"></td></tr>
        
      <tr><td height="2"></td></tr> 
        
        <tr>
        <td class="titledatos" width="150">Mes Compra</td>
	    <td width="2%"></td>
        <td><select name='mes_compra'onChange="" id="mes_compra">
                      <option value=-1></option>
                      <option value=1>Abril</option>
                      <option value=2>Mayo</option>
                      <option value=3>Junio</option>
                      <option value=4>Julio</option>
                      <option value=5>Agosto</option>
                      <option value=6>Septiembre</option>
                      <option value=7>Octubre</option>
                      <option value=8>Noviembre</option>
                      <option value=9>Diciembre</option>
                      <option value=10>Enero</option>
                      <option value=11>Febrero</option>
                      <option value=12>Marzo</option>
                      
                      </select></td>
        </tr> 
         <tr><td height="2"></td></tr> 
        
        <tr>
        <td class="titledatos" width="150">Mes Activacion</td>
	    <td width="2%"></td>
        <td><select name='mes_activa'onChange="" id="mes_activacion">
                      <option value=-1></option>
                      <option value=1>Abril</option>
                      <option value=2>Mayo</option>
                      <option value=3>Junio</option>
                      <option value=4>Julio</option>
                      <option value=5>Agosto</option>
                      <option value=6>Septiembre</option>
                      <option value=7>Octubre</option>
                      <option value=8>Noviembre</option>
                      <option value=9>Diciembre</option>
                      <option value=10>Enero</option>
                      <option value=11>Febrero</option>
                      <option value=12>Marzo</option>
                      
                      </select></td>
        </tr> 
        
       
        <tr><td height="2"></td></tr>
        
        <tr>
        <td class="titledatos" width="150">Tipo Proyecto </td>
	    <td width="2%"></td>
        <td  > <select name='tipo_proyecto'onChange="" id="tipo_proyecto">
               <option value=-1></option>
               <?=$opcion_proyecto?>
               </select>
        </td>
      </tr>
      <tr><td height="2"></td></tr>
      <tr>
        <td class="titledatos" width="150">Motivo Inversion</td>
	    <td width="2%"></td>
        <td><select name='motivo_inversion'onChange="" id="motivo_inversion">
            <option value=-1></option>
            <?=$opcion_motivo?>
            </select>
        </td>
      </tr>
      <tr><td height="2"></td></tr>  
      <tr>
        <td class="titledatos" width="150">Prioridad Inversion</td>
	    <td width="2%"></td>
        <td><select name='prioridad'onChange="" id="prioridad">
            <option value=0></option>
            <option value=A>A</option>
            <option value=B>B</option>
            <option value=C>C</option>
            <option value=C>D</option>
            <option value=C>E</option>
            <option value=C>F</option>
            <option value=C>G</option>
            
            </select>
        </td>
      </tr>  
      <tr><td height="2"></td></tr>    
        
        
   
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

