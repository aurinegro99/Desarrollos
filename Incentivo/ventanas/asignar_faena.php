<?php
$usuario=$_REQUEST["usuario"];    

require_once '../app/clases/UsuarioLocal.php';
require_once '../app/clases/UsuarioAmazon.php';
?>
<html>
<link rel="stylesheet" type="text/css" href="../css/estilo.css" />
<title>Asignar Faenas</title>

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
    var largo=document.frm_asigna.idfaena.length;
    var lista=document.frm_asigna.idfaena;
    //alert(largo);
    for (x =0 ;x<largo ; x++ ){
	    if (lista[x].checked){
		   cuenta++;
		}
	}  
        
    //alert(cuenta);
    if (cuenta==0){
        alert('Debe Seleccionar Faenas');
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
    ajax.open('GET','../acciones/grabar_asigna_faenas.php?usuario='+d.usuario.value+'&faenas='+compo, true);
    ajax.send(null);
}  
 
function refresca_grabar()
{
    
     //
    if(ajax.readyState == 4){
        
       //alert(ajax.responseText); 
	   out=ajax.responseText;
	   
	 // alert(out);
	   
	   if (out==0){
	      alert('Datos Grabados Correctamente');
		  opener.carga_faenas();
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
   <td class="titletable">Asignar Faenas Usuario </td>
  </tr>
</table>
<br>    

<table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
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
    
    
<table width="600" border="0" align="center" cellspacing="0" style="table-layout:fixed;" class="tablalistado" id="100">
    <tr>
        <td width="100" class="titletable"> 
    <div align="left">Idfaena</div></td>
    <td width="350" class="titletable"> 
    <div align="left">Nombre Faena</div></td>
    <td width="100" class="titletable">
        <div align="center">Asignar</div></td>
    </tr>   
    
<form name="frm_asigna">   
  <input type="hidden" name="usuario" value="<?php echo $usuario ?>">      

<?php
    


$xfaena=new UsuarioLocal();
$xlistado=$xfaena->getUsuarioFaena($usuario);

//var_dump($xlistado);

if ($xlistado==null)
    $xlistado=999;
    
$xfaenas= new Usuarioamazon();
$xlistanombre=$xfaenas->getNombreFaenasExc($xlistado);
foreach ($xlistanombre as $detalle){
 ?>
   
    
    <tr bgcolor= "#FFFFCC" onMouseOver="this.bgColor= '#EEEEEE'" onMouseOut="this.bgColor='#FFFFCC'" > 
        <td width="100"> <div align="left"> <?php echo $detalle["idfaena"] ?></div> </td>
        <td width="300"   > <div align="left"> <?php echo $detalle["nombre_faena"] ?></div> </td> 
        <td width="20"><div align="right"> <input name="idfaena" type="checkbox"  value="<?php echo $detalle["idfaena"] ?>" </div></td>
    </tr>
  <?php      
    }  // foreach


?>

    </form>
</table>     

</body>

