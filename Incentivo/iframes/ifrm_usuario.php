<link rel="stylesheet" type="text/css" href="../css/estilo.css" />

<script language="javascript">
    
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

function confirma(d1){

    var confirmacion = confirm("Desea Eliminar Faena ");

    if (confirmacion){
        
        var d=document.frm_asigna;
        //alert(d.usuario.value);
        ajax = nuevoajax();
        ajax.onreadystatechange = refresca_elimina;
        ajax.open('GET','../acciones/elimina_faenas.php?usuario='+d.usuario.value+'&faena='+d1, true);
        ajax.send(null);    
        
    }else
        return false ;
    
    
}

function refresca_elimina()
{
    
     //
    if(ajax.readyState == 4){
        
      // alert(ajax.responseText); 
	   out=ajax.responseText;
	   
	 // alert(out);
	   
	   if (out==0){
	      alert('Datos Eliminados Correctamente');
		  parent.carga_faenas();
		  
		  
		 
	   }
	   
	   else
	   {
		 alert('Error al Eliminar Datos');
		 return false;
	   }
	}
}



</script>


<?php

require_once '../app/clases/UsuarioLocal.php';
require_once '../app/clases/UsuarioAmazon.php';

$usuario = $_REQUEST["usuario"];

if($usuario == null)
    $usuario="";

//echo $usuario;

?>

<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#FFFFCC" onLoad="">
    

    
    
<table width="890" border="0" align="center" cellspacing="0" style="table-layout:fixed;" class="tablalistado" id="100">
<?php
    if (strlen($usuario)>0){
    // sacar modelo,idfaena
    $xfaena=new UsuarioLocal();
    $xlistado=$xfaena->getUsuarioFaena($usuario);
    
    if ($xlistado==null){}
    else{
    $xfaenas= new Usuarioamazon();
    $xlistanombre=$xfaenas->getNombreFaenas($xlistado);
    
    foreach ($xlistanombre as $detalle){
 ?>
    
    <tr bgcolor= "#FFFFCC" onMouseOver="this.bgColor= '#EEEEEE'" onMouseOut="this.bgColor='#FFFFCC'" > 
        <td width="100"> <div align="left"> <?php echo $detalle["idfaena"] ?></div> </td>
        <td width="300"   > <div align="left"> <?php echo $detalle["nombre_faena"] ?></div> </td> 
        <td width="20"><div align="right"> <img src="../img/basket.gif" border="0" title="Elimina Faena" onClick="confirma(<?php echo $detalle["idfaena"]?>)" style="cursor:hand"> </a> </div></td>
    </tr>
  <?php      
    }  // foreach
    }   
    
    }
  ?>
    </table>

			
<form name="frm_asigna">   
  <input type="hidden" name="usuario" value="<?php echo $usuario ?>"> 
</form> 

</body> 

