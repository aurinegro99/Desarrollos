<?php
session_start();
$idusuario = $_SESSION["usuario"];
$xrut = $_SESSION["rut"];

include "../lib/database.php";


if(!isset($solicita))
	$solicita='';	

if (strlen($xrut)>0){
	//$sql="select nombre from personal_rrhh where ltrim(codigo)='$xrut' and estado='A' and glosa_corta='KCH' ;";
	$sql="select nombre from DB_personal.dbo.nomina_vigente where rut='$xrut' and (empresa='3002' or empresa='3001') ";
              
	$resul=sqlsrv_query($actf,$sql);
	$obj = sqlsrv_fetch_object($resul);
        if ($obj !=false)
	    $solicita=$obj->nombre;
        else
            $solicita='';
	
}


if ((strlen($solicita)<=0) or (strlen($xrut)<=0))
   $xesta='N';
else
   $xesta='S';  

if(!isset($aprueba))
	$aprueba='';
if(!isset($cantidad))
	$cantidad=1;		


$fecha=date('d/m/Y');	

$opcion_clase='';

include_once '../rutinacarga/carga_clase.php';
// carga clase




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




function revisa_rut()
{
	var d=document.fm_ingreso;
	
	if (d.esta_rut.value=='N')
        {
	
		//alert('2');
		
	   if (isBlanco(d.rut_solicita.value)){
		   alert('Debe Ingresar Rut Solicitante');
		   return false  
	      }
		
		ajax = nuevoajax();
                ajax.onreadystatechange = refrescar_rut;//Quien me procesa los 4 estados
	        //ajax.open('POST','../rutinacarga/revisa_rut.php?rut='+d.rut_solicita.value, true);
                ajax.open('GET','../rutinacarga/revisa_rut.php?rut='+d.rut_solicita.value, true);
                ajax.send(null);
		
		
		}
	   
	return true;
}

function refrescar_rut()
{
  var d=document.fm_ingreso 
  if(ajax.readyState == 4)
  {
	  //alert(ajax.responseText);
     var out = ajax.responseText;
	 if (out==0) 
         {
	     alert('Rut No existe')
		 d.solicita.value='';
		 return false;
		 
	 }
	 
	if(out==1)
        {
		alert('Rut No esta Habilitado en la Compañia')
		d.solicita.value='';
		return false;
	}
	if ((out!==0) || (out!==1))	
        {
		//alert('sdsdsdsdsdsdsd');
		
	   d.solicita.value=out;
	}
		
  }

}


</script>
<link rel="stylesheet" type="text/css" href="../css/estilo.css" />
<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#FFFFCC" >
<br>
<br>
			
<form name="fm_ingreso" method="post"  >
<input type="hidden" name="esta_rut" value="<?=$xesta?>">
	
	<table width="95%" align="center" class="tablabase">
				 <tr></tr>
				   <tr>
				   <td>
     	  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">    
          	<tr>
				  <td class="titledatos" width="150">Fecha Solicitud </td>
					  <td width="18"></td>
					  <td width="409" >
					  <input name="fecha" value="<?php echo $fecha?>" type="text"  size="10" readonly ></td>
		</tr>
		<tr></tr>
                <tr>
					  <td class="titledatos" width="150">Solicitado por </td>
					  <td width="2%"></td>
					  <td > <input name="rut_solicita" value="<?php echo $xrut ?>" type="text"  size="15" maxlength="12" <?php if ($xesta=='S') echo 'readonly' ?>  onBlur="revisa_rut();">  <input name="solicita" type="text" size="60" value="<?php echo $solicita?>" readonly></td>
                </tr>
		<tr></tr>
		<tr>
					  <td class="titledatos"width="150">Aprobado por</td>
					  <td width="2%"></td>
					  <td >
					  <input name="aprueba" type="text" value="<?php echo $aprueba ?>" size="45" maxlength="40" ></td>
		</tr>
		<tr></tr>
                
                <tr>
					  <td class="titledatos"width="150">Clase Activo</td>
					  <td width="2%"></td>
					  <td >
                                              <select name='clase'onChange="" id="clase">
                                              <option value="0" ></option>    
                                              <?php echo $opcion_clase ?>
                                              </select></td>
		</tr>
		<tr></tr>
                <tr>
					  <td class="titledatos"width="150">Cantidad</td>
					  <td width="2%"></td>
					  <td >
					  <input name="cantidad" type="text" value="<?php echo $cantidad ?>" size="10" maxlength="2" readonly ></td>
		</tr>
					
					
					
		</table>
	</td>
	</tr>	
	</table> 
</form>
<br>


</body>

