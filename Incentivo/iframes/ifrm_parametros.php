<link rel="stylesheet" type="text/css" href="../css/estilo.css" />

<?php

require_once '../app/clases/UsuarioLocal.php';

?>

<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#FFFFCC" onLoad="">
    
<table width="500" border="0" align="center" cellspacing="0" style="table-layout:fixed;" class="tablalistado" id="100">
<?php
    
    $param=new UsuarioLocal();
    $xlistado=$param->getParametros();
    foreach ($xlistado as $detalle){
 ?>
    
    <tr bgcolor= "#FFFFCC" onMouseOver="this.bgColor= '#EEEEEE'" onMouseOut="this.bgColor='#FFFFCC'" > 
        <td width="250" style="cursor:hand" onclick="parent.modifica(<?php echo $detalle["IdParametro"] ?>)"> <div align="left"> <?php echo $detalle["Nombre_Parametro"] ?></div> </td>
        <td width="90"> <div align="left"> <?php echo $detalle["Clave"] ?></div> </td> 
        <td width="90"> <div align="left"> <?php echo $detalle["Nombre_variable"] ?></div> </td> 
        <td width="30"><div align="right"> <img src="../img/editar_new.gif" border="0" alt="Editar" onClick="confirma(<?=$d6?>,<?=$solicitud?>)" style="cursor:hand"> </a> </div></td>
        <td width="30"><div align="right"> <img src="../img/basket.gif" border="0" alt="Elimina" onClick="confirma(<?=$d6?>,<?=$solicitud?>)" style="cursor:hand"> </a> </div></td>
        
        
    </tr>
  <?php      
    }  // foreach
   
  ?>
    </table>

</body> 


