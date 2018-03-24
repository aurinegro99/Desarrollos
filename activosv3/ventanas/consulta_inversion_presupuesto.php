
<html>
<link rel="stylesheet" type="text/css" href="../css/estilo.css" />
<title>Cosnulta Nueva Inversion</title>

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
		
		
		d.total.value=formatNumber(total_codigo,2,',','.','','','-','');;
		
		
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
		alert('Debe Seleccionar Prioridad');
		return false
		
		}
	    
	
   ajax = nuevoajax();
   ajax.onreadystatechange = refresca_grabar;//Quien me procesa los 4 estados
   ajax.open('POST','../acciones/modifica_nueva_inversion.php?idcentro='+d.centro_costo.value+'&idclase='+d.clase_activo.value+'&descripcion='+d.descripcion.value+'&cantidad='+d.cantidad.value+'&valor='+d.valor_u.value+'&mes_c='+d.mes_compra.value+'&mes_a='+d.mes_activacion.value+'&idfaena='+d.idfaena.value+'&idperiodo='+d.idperiodo.value+'&motivo='+d.motivo_inversion.value+'&proyecto='+d.tipo_proyecto.value+'&corr='+d.idcorr.value+'&prioridad='+d.prioridad.value,true);
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


function formatNumber(num,dec,thou,pnt,curr1,curr2,n1,n2) {var x = Math.round(num * Math.pow(10,dec));if (x >= 0) n1=n2='';var y = (''+Math.abs(x)).split('');var z = y.length - dec; if (z<0) z--; for(var i = z; i < 0; i++) y.unshift('0');y.splice(z, 0, pnt); if(y[0] == pnt) y.unshift('0'); while (z > 3) {z-=3; y.splice(z,0,thou);}var r = curr1+n1+y.join('')+n2+curr2;return r;}

</script>




<?php
    
$corr=$_REQUEST["corr"];    
$idfaena=$_REQUEST["idfaena"];  
$idperiodo=$_REQUEST["idperiodo"];      

#incluir librerias necesarias
include "../lib/database.php"; 
include "../lib/database_amazon.php"; 


// cargar los datos

$sql="select ceco,idclase,descripcion_bien,cantidad,valor_unitario,mes_compra,mes_activacion,proyecto,motivo,prioridad from Inversiones_Presupuesto where correlativo=$corr ";
$resul=sqlsrv_query($actf,$sql); 
$obj = sqlsrv_fetch_object($resul);    



$opcion_clase="";
$opcion_centro="";
$opcion_motivo="";
$opcion_proyecto="";
$sql="select idclase,tipo_clase,nombre_clase from clase_activo where activo='S'  order by tipo_clase ";
$resul=sqlsrv_query($actf,$sql);
while($objg = sqlsrv_fetch_object($resul)){
	  if ($objg->idclase==$obj->idclase)
          $opcion_clase.="<option value=$objg->idclase selected >$objg->tipo_clase --> $objg->nombre_clase</option>";
	  else
	     $opcion_clase.="<option value=$objg->idclase >$objg->tipo_clase --> $objg->nombre_clase</option>"; 	  
}

// centro costo
$sql="select a.ceco,a.nombre_ceco from dim_cebe_ceco a
       left join dim_faena_cebe b on a.cebe=b.cebe
        where b.idfaena=$idfaena and a.activo='S' ;";
$resul=sqlsrv_query($amazon,$sql);
while($objg = sqlsrv_fetch_object($resul)){
	  if ($objg->ceco==$obj->ceco)
          $opcion_centro.="<option value=$objg->ceco selected>$objg->ceco --> $objg->nombre_ceco </option>";
	  else
	      $opcion_centro.="<option value=$objg->ceco >$$objg->ceco --> $objg->nombre_ceco</option>";
}

// motivo
$sql="select idmotivo,nombre_motivo from motivo_inversion  order by idmotivo ;";
$resul=sqlsrv_query($actf,$sql);
while($objg = sqlsrv_fetch_object($resul)){
	  if ($objg->idmotivo==$obj->motivo)
         $opcion_motivo.="<option value=$objg->idmotivo selected >$objg->nombre_motivo</option>";
	  else
	     $opcion_motivo.="<option value=$objg->idmotivo >$objg->nombre_motivo</option>";	 
}

// proyecto
$sql="select idproyecto,nombre_proyecto from proyecto_inversion where idfaena=$idfaena order by idproyecto ;";
$resul=sqlsrv_query($actf,$sql);
while($objg = sqlsrv_fetch_object($resul)){
	   if ($objg->idproyecto==$obj->proyecto)
          $opcion_proyecto.="<option value=$objg->idproyecto selected >$objg->nombre_proyecto</option>";
	   else	  
	      $opcion_proyecto.="<option value=$objg->idproyecto >$objg->nombre_proyecto</option>";
		  
}


 if ($obj->mes_compra<=9)
	   $indc=$obj->mes_compra+3;
	 else
	   $indc=$obj->mes_compra-9;  
	   
	 if ($obj->mes_activacion<=9)
	   $inda=$obj->mes_activacion+3;
	 else
	   $inda=$obj->mes_activacion-9;  



?>

<table width="350" border="0" cellspacing="0" cellpadding="0" align="center">
   <tr>
   <td class="titletable">Consulta Nueva Inversion </td>
  </tr>
</table>
<br>

<table width="1100" align="center" class="tablabase">
 
 <tr></tr>
   <tr>
   <td>
     <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">  
     <form name='frm_datos' method="post" >
     <input name="idfaena" type="hidden" value="<?php echo $idfaena?>">
     <input name="idcorr" type="hidden" value="<?php echo $corr?>">
     <input name="idperiodo" type="hidden" value="<?php echo $idperiodo?>">
     
     
        <tr>
        <td class="titledatos" width="150">Centro Costo</td>
	    <td width="2%"></td>
        <td  >
        <select name='centro_costo ' onChange="" id="centro_costo">
                      <option value=-1></option>
                      <?php echo $opcion_centro?>
                      </select>
        </td>
      </tr>
     
       <tr>
        <td class="titledatos" width="150">Clase Activo </td>
	    <td width="2%"></td>
        <td  > <select name='clase_activo'onChange="" id="clase_activo">
                      <option value=-1></option>
                      <?php echo $opcion_clase?>
                      </select>
        </td>
      </tr>
      <tr><td height="2"></td></tr>
      <tr>  
        <td class="titledatos" width="150">Descripcion Bien </td>
        <td width="2%"></td>
        <td  ><input  name="descripcion" type="text" value="<?php echo $obj->descripcion_bien ?>" size="100" maxlength="50" id="descripcion" ></td>
       </tr> 
       <tr><td height="2"></td></tr>
       <tr>
        <td class="titledatos" width="150">Cantidad</td>
	    <td width="2%"></td>
        <td><input type="text" name="cantidad" size="10" value="<?php echo $obj->cantidad?>" class="numeros" id="cantidad" onChange="calculavalor();"></td>
       </tr> 
        <tr><td height="2"></td></tr>
      <tr>
        <td class="titledatos" width="150">Valor Unitario (USD)</td>
	    <td width="2%"></td>
        <td><input type="text" name="valor_u" size="10" value="<?php echo $obj->valor_unitario?>" class="numeros" id="valor_u" onChange="calculavalor();" ></td>
       </tr> 
        <tr><td height="2"></td></tr> 
        
        <tr>
        <td class="titledatos" width="150">Total (USD)</td>
	    <td width="2%"></td>
        <td><input type="text" name="total" size="10" value="<?php echo number_format($obj->cantidad*$obj->valor_unitario,2,'.',',')?>" class="numeros" id="total" disabled ></td>
       </tr> 
        <tr><td height="2"></td></tr>
        
      <tr><td height="2"></td></tr> 
        
        <tr>
        <td class="titledatos" width="150">Mes Compra</td>
	    <td width="2%"></td>
        <td><select name='mes_compra'onChange="" id="mes_compra">
                      <option value=-1></option>
                      <option value=1<?php  if ($obj->mes_compra==1)  echo '  selected' ; ?>>Abril</option>
                      <option value=2<?php if ($obj->mes_compra==2)  echo '  selected' ; ?>>Mayo</option>
                      <option value=3<?php if ($obj->mes_compra==3)  echo '  selected' ; ?>>Junio</option>
                      <option value=4<?php if ($obj->mes_compra==4)  echo '  selected' ; ?>>Julio</option>
                      <option value=5<?php if ($obj->mes_compra==5)  echo '  selected' ; ?>>Agosto</option>
                      <option value=6<?php if ($obj->mes_compra==6)  echo '  selected' ; ?>>Septiembre</option>
                      <option value=7<?php if ($obj->mes_compra==7)  echo '  selected' ; ?>>Octubre</option>
                      <option value=8<?php if ($obj->mes_compra==8)  echo '  selected' ; ?>>Noviembre</option>
                      <option value=9<?php if ($obj->mes_compra==9)  echo '  selected' ; ?>>Diciembre</option>
                      <option value=10<?php if ($obj->mes_compra==10)  echo '  selected' ; ?>>Enero</option>
                      <option value=11<?php if ($obj->mes_compra==11)  echo '  selected' ; ?>>Febrero</option>
                      <option value=12<?php if ($obj->mes_compra==12)  echo '  selected' ; ?>>Marzo</option>
                      
                      </select></td>
        </tr> 
         <tr><td height="2"></td></tr> 
        
        <tr>
        <td class="titledatos" width="150">Mes Activacion</td>
	    <td width="2%"></td>
        <td><select name='mes_activa'onChange="" id="mes_activacion">
                      <option value=-1></option>
                       <option value=1<?php if ($obj->mes_activacion==1)  echo '  selected' ; ?>>Abril</option>
                      <option value=2<?php if ($obj->mes_activacion==2)  echo '  selected' ; ?>>Mayo</option>
                      <option value=3<?php if ($obj->mes_activacion==3)  echo '  selected' ; ?>>Junio</option>
                      <option value=4<?php if ($obj->mes_activacion==4)  echo '  selected' ; ?>>Julio</option>
                      <option value=5<?php if ($obj->mes_activacion==5)  echo '  selected' ; ?>>Agosto</option>
                      <option value=6<?php if ($obj->mes_activacion==6)  echo '  selected' ; ?>>Septiembre</option>
                      <option value=7<?php if ($obj->mes_activacion==7)  echo '  selected' ; ?>>Octubre</option>
                      <option value=8<?php if ($obj->mes_activacion==8)  echo '  selected' ; ?>>Noviembre</option>
                      <option value=9<?php if ($obj->mes_activacion==9)  echo '  selected' ; ?>>Diciembre</option>
                      <option value=10<?php if ($obj->mes_activacion==10)  echo '  selected' ; ?>>Enero</option>
                      <option value=11<?php if ($obj->mes_activacion==11)  echo '  selected' ; ?>>Febrero</option>
                      <option value=12<?php if ($obj->mes_activacion==12)  echo '  selected' ; ?>>Marzo</option>
                      
                      </select>
                          
                      </td>
        </tr> 
        
       
        <tr><td height="2"></td></tr>
        
        <tr>
        <td class="titledatos" width="150">Tipo Proyecto </td>
	    <td width="2%"></td>
        <td  > <select name='tipo_proyecto'onChange="" id="tipo_proyecto">
               <option value=-1></option>
               <?php echo $opcion_proyecto?>
               </select>
        </td>
      </tr>
      <tr><td height="2"></td></tr>
      <tr>
        <td class="titledatos" width="150">Motivo Inversion</td>
	    <td width="2%"></td>
        <td><select name='motivo_inversion'onChange="" id="motivo_inversion">
            <option value=-1></option>
            <?php echo $opcion_motivo?>
            </select>
        </td>
      </tr>
      <tr><td height="2"></td></tr>  
      <tr>
        <td class="titledatos" width="150">Prioridad</td>
	    <td width="2%"></td>
        <td><select name='prioridad'onChange="" id="prioridad">
            <option value=0></option>
            <option value=A<?php if ($obj->prioridad=='A')  echo '  selected' ; ?>>A</option>
            <option value=B<?php if ($obj->prioridad=='B')  echo '  selected' ; ?>>B</option>
            <option value=C<?php if ($obj->prioridad=='C')  echo '  selected' ; ?>>C</option>
            <option value=D<?php if ($obj->prioridad=='D')  echo '  selected' ; ?>>D</option>
            <option value=E<?php if ($obj->prioridad=='E')  echo '  selected' ; ?>>E</option>
            <option value=F<?php if ($obj->prioridad=='F')  echo '  selected' ; ?>>F</option>
            <option value=G<?php if ($obj->prioridad=='G')  echo '  selected' ; ?>>G</option>
            
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

