<link rel="stylesheet" type="text/css" href="../css/estilo.css" />



<?php

require_once '../app/clases/UsuarioLocal.php';


$idfaena = $_REQUEST["idfaena"];

if($idfaena == null)
    $idfaena=0;

?>

<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#FFFFCC" onLoad="">
    
<table width="790" border="0" align="center" cellspacing="0" style="table-layout:fixed;" class="tablalistado" id="100">
<?php
    if ($idfaena>0){
    // sacar modelo,idfaena
    $xconvenio=new UsuarioLocal();
    $xlistado=$xconvenio->getConvenios($idfaena);
    
    if ($xlistado==null){}
    else{
    
    foreach ($xlistado as $detalle){
 ?>
    
    <tr bgcolor= "#FFFFCC" onMouseOver="this.bgColor= '#EEEEEE'" onMouseOut="this.bgColor='#FFFFCC'" > 
        <td width="100" style="cursor:hand" onclick="parent.modifica(<?php echo $detalle["IdConvenio"] ?>)"> <div align="left"> <?php echo $detalle["numero_convenio_kcc"] ?></div> </td>
        <td width="300"   > <div align="left"> <?php echo $detalle["Nombre_Convenio_kcc"] ?></div> </td> 
         <td width="100"   > <div align="left"> <?php echo $detalle["fecha_inicio_convenio"] ?></div> </td> 
         <td width="100"   > <div align="left"> <?php echo $detalle["fecha_termino_convenio"] ?></div> </td> 
         <td width="10"   > <div align="left"> <?php echo $detalle["Status_Convenio"] ?></div> </td> 
        
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


