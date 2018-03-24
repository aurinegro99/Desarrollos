<?php
session_start();
// crear o continuar la sesi�n
//
//session_register('actividad'); 
//session_register('cliente'); 
//session_register('correo'); 
//echo 'Cliente sesion '.$cliente.'<br>';
//echo 'Correo Cliente '.$correo.'<br>';
//echo 'La sesi�n actual es: '.session_id(); 
//foreach($actividad as $salida =>$z){
//print '<br>'.$z.'<br>' ;
//}
// vaciarla
$_SESSION = array();

// destruirla
session_destroy();
header('location:..\ingreso\ingreso_usuario.php');


?>