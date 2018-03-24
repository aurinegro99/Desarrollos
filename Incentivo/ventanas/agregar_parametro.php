<?php
session_start();
$usuario=$_SESSION["usuario"];    

$idfaena=$_GET["idfaena"];
$idconv=$_GET["idconvenio"];
        
require_once '../app/clases/Convenio.php';

?>
<html>
<link rel="stylesheet" type="text/css" href="../css/estilo.css" />
<title>Agregar Parametro</title>

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
    
function grabar()
{
    var cuenta=0; 
    var largo=document.frm_asigna.id.length;
    var lista=document.frm_asigna.id;
    //alert(largo);
    for (x =0 ;x<largo ; x++ ){
	    if (lista[x].checked){
		   cuenta++;
		}
	}  
        
    //alert(cuenta);
    if (cuenta==0){
        alert('Debe Seleccionar Parametros');
        return false;
        
    }
    else{
        var compo= new Array(cuenta-1);
	var indic=0;
	for (x =0 ;x<largo ; x++ ){
	    if (lista[x].checked){
	       compo[indic]=lista[x].value;
	        indic++;
	   }
        
         } 
        
     }       
       
    // grabar
    var d=document.frm_asigna;
    
    //alert(compo);
    
    ajax = nuevoajax();
    ajax.onreadystatechange = refresca_grabar;
    ajax.open('GET','../acciones/grabar_asigna_parametros.php?idfaena='+d.idfaena.value+'&idconvenio='+d.idconvenio.value+'&param='+compo, true);
    ajax.send(null);
}  
 
function refresca_grabar()
{
     //
    if(ajax.readyState == 4){
       //alert(ajax.responseText); 
	   out=ajax.responseText; 
	   
	  alert(out);
	   
	   if (out==0){
	      alert('Datos Grabados Correctamente');
		  opener.carga_parametros();
		  cerrar();
		  
		 
	   }
	   
	   else
	   {
		 alert('Error al Grabar Datos');
		 return false;
	   }
	}
}


</script>


<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#FFFFCC" onLoad="">

<table width="350" border="0" cellspacing="0" cellpadding="0" align="center">
   <tr>
   <td class="titletable">Asignar Parametros Convenio </td>
  </tr>
</table>
<br>    

<table width="350" border="0" cellspacing="0" cellpadding="0" align="center">
   <tr>
  <td colspan="3">
      <div align="center">
            <img src="../img/46.png" align="right" title="Grabar" border="2" style="cursor:hand" onClick="grabar()">
      </div>
  </td>
  </tr>
</table>
<br>    
<br>
    
    
<table width="380" border="0" align="center" cellspacing="0" style="table-layout:fixed;" class="tablalistado" id="100">
    <tr>
    <td width="100" class="titletable"> 
    <div align="left">Parametro</div></td>
    <td width="100" class="titletable"> 
    <div align="left">Clave</div></td>
    <td width="100" class="titletable">
        <div align="center">Variable</div></td>
     <td width="80" class="titletable">
        <div align="center"></div></td>
    </tr>   
    
<form name="frm_asigna">   
  <input type="hidden" name="usuario" value="<?php echo $usuario ?>">     
  <input type="hidden" name="idfaena" value="<?php echo $idfaena ?>">     
  <input type="hidden" name="idconvenio" value="<?php echo $idconv ?>">     

<?php
    


$xparam=new Convenio();
$xlistado=$xparam->getParametros();

//var_dump($xlistado);

foreach ($xlistado as $detalle){
 ?>
   
    
    <tr bgcolor= "#FFFFCC" onMouseOver="this.bgColor= '#EEEEEE'" onMouseOut="this.bgColor='#FFFFCC'" > 
        <td width="100"> <div align="left"> <?php echo $detalle["nombre_parametro"] ?></div> </td>
        <td width="100"   > <div align="left"> <?php echo $detalle["clave"] ?></div> </td> 
        <td width="100"   > <div align="left"> <?php echo $detalle["nombre_variable"] ?></div> </td> 
        <td width="20"><div align="right"> <input name="id" type="checkbox"  value="<?php echo $detalle["idparametro"] ?>" </div></td>
    </tr>
  <?php      
    }  // foreach


?>

    </form>
</table>     

</body>

