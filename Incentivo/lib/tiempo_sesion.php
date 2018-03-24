<?
$segundos = 300 ; //si pasa este tiempo se detecta la inactividad del usuario en el sitio 
if(($_SESSION['tiempo']+$segundos) < time()) { 
   echo'<script type="text/javascript">alert("Su sesion ha expirado por inactividad'; 
   echo', vuelva a logearse para continuar");window.location.href="../ingreso/ingreso_usuario.php";</script>';     
}else 
   $_SESSION['tiempo']=time();


?>
