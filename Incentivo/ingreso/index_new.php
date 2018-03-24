<?php 
session_start();

//  modo local


$xperfil=0;

//include "../lib/database_amazon.php";

require_once "../app/clases/UsuarioAmazon.php";

//  byscar datos
$zusuario='';
 if (isset($_SESSION['correo_verif']))
     {
        //buscar datos 
        $xcorreo=$_SESSION['correo_verif'];
        $dbusuario=new Usuarioamazon();
        $listado=$dbusuario->getUsuarioCorreo($xcorreo);
        
        //$sql="select nombre_usuario,usuario,rut_usuario,mail_usuario FROM usuarios_informe where mail_usuario='$xcorreo'";
        //$resul= $pdoAws->query($sql);
        //$user = $resul->fetch(PDO::FETCH_NUM);
        
        if ($listado==null) {
             echo"<script language=Javascript> alert('Usuario no esta Registrado'); </script>"; 
             echo "<script language=Javascript> location.href=\"../index.php\"; </script>"; 
            
        }
         
        foreach ($listado as $lista) {
            $zusuario=substr($lista["usuario"],5);
            // asigno datoa  sesion
            $_SESSION['usuario']=$zusuario;	
            $_SESSION['nombre']=$lista["nombre_usuario"];	  
            $_SESSION['correo']=$lista["mail_usuario"];
            $_SESSION['rut']=$lista["rut_usuario"];
    
            
    
          }
        
         
     }

else
     {
      $idusuario = $_GET["idusuario"];
      $musuario="KCCL".chr(92).$idusuario;
      $nreg=0;
      $sql="select nombre_usuario,mail_usuario,rut_usuario FROM usuarios_informe where usuario='$musuario'";

      $resul= $pdoAws->query($sql);

      $user = $resul->fetch(PDO::FETCH_NUM);

      if ($user != null)
      {
    
         list($xnombre,$xcorreo,$xrut)= $user;
	     $_SESSION['usuario']=$idusuario;	
         $_SESSION['nombre']=$xnombre;	  
         $_SESSION['correo']=$xcorreo;
         $_SESSION['rut']=$xrut;
	
      }

    
    }

// datos del usuario

$xdato_usuario=$zusuario.': '.$_SESSION["nombre"];

// revsiar si esta habilitado en el sistema


require_once "../app/clases/UsuarioLocal.php";

//include "../lib/database.php";
$xusuario=new UsuarioLocal();
$user=$xusuario->getUsuarioFaena($zusuario);

// revisar si esyta habilitado
//$sql="select * FROM usuario_faena where usuario='$zusuario'";
//echo $sql;
//$resul= $pdoInc->query($sql);
//$user = $resul->fetch(PDO::FETCH_NUM);
if ($user==null) {
  
    echo"<script language=Javascript> alert('Usuario no esta Habilitado'); </script>"; 
   echo "<script language=Javascript> location.href=\"../index.php\"; </script>"; 
}

// obtengo o genero perfil


$_SESSION['perfil']=$xusuario->getPerfil($zusuario);

/*
$sql="select perfil FROM perfil_usuario where usuario='$zusuario'";

$resul= $pdoInc->query($sql);
$user = $resul->fetch(PDO::FETCH_NUM);
if ($user==null) {
    
    $_SESSION['perfil']=1;
    
}
else{
    
    list($xperfil)= $user; 
    $_SESSION['perfil']=$xperfil;
}

*/

//echo 'Perifl :'.$_SESSION["perfil"];
include "../header/header_new.php"; 
?>


<table style="width: 1500px;height:500px;border:0;text-align:center" >
  <!-- <tr>
     <td valign="middle"><strong> <? //echo $idusuario.' '.$xnombre ?></strong>  </td>
   </tr>-->
  <tr>
    <td width="755" valign="middle"> 
      <div align="center"><img src="../diseno/Komatsu-myndaseria-2.gif" width="310" height="250" align="center"></div>
	</td>
  </tr>
</table>




<?  


 
 ?>
