<?php
session_start();
include "../lib/database.php";
include "../lib/database_amazon.php";
$idusuario = $_GET["idusuario"];
$musuario="KCCL".chr(92).$idusuario;
$nreg=0;
$sql="select nombre_usuario,mail_usuario,rut_usuario FROM usuarios_informe where usuario='$musuario'";
//echo $sql;
$resul=sqlsrv_query($amazon,$sql);

 $obj = sqlsrv_fetch_object($resul);

 if ($obj !=false)
 {
   
    $_SESSION['usuario']=$idusuario;	
    $_SESSION['nombre']=$obj->nombre_usuario;	  
    $_SESSION['correo']=$obj->mail_usuario;	  
    $_SESSION['rut']=$obj->rut_usuario;	  
    
    // obteber perfil
    $xperfil=1;
    $sqlaf="select perfil FROM perfil_usuario where usuario='$idusuario'";
    $resulaf=sqlsrv_query($actf,$sqlaf);
    $obja = sqlsrv_fetch_object($resulaf);
    if ($obja !=false)
       $xperfil=$obja->perfil;
    $_SESSION['perfil']=$xperfil;	 
}

?>


<?php  include "../header/header.php";  ?>


<br>
<table width=370 height="330" border=0 align="center">
 <tr>
     <td valign="middle"><strong> <?php echo $idusuario.' '.$obj->nombre_usuario ?></strong>  </td>
 </tr>
  <tr>
    <td width="755" valign="middle"> 
      <div align="center"><img src="../diseno/Komatsu-myndaseria-2.gif" width="310" height="250"></div></tr>
<tr>
</table>


</table>


<?php

 include "../footer/pie_pagina.php"; 
 
 ?>
