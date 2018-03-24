<?php
session_start();

$perfil = $_SESSION["perfil"];
$id=$_REQUEST["id"];

if ($id==102)
    {
    if ($perfil<>1)
      header('location:acceso_denegado.html');

    else

       header('location:..\mantencion\regenera_clave.php');




}


if ($id==201)
    {
    if ($perfil==5)
      header('location:acceso_denegado.html');

    else

       header('location:..\solicitud\crear_solicitud_activo.php');




}


if ($id==202)
    {
    if ($perfil<>9)
      header('location:acceso_denegado.html');

    else

       header('location:..\generar\genera_flujo.php');

}


if ($id==203)
    {
    if ($perfil<>9)
      header('location:acceso_denegado.html');

    else

       header('location:..\modifica\modifica_solicitud.php');
}



if ($id==401)
    {
    if ($perfil<>9)
      header('location:acceso_denegado.html');

    else

       header('location:..\otros\subir_datos_activacion.php');
}


if ($id==402)
    {
    if ($perfil<>9)
      header('location:acceso_denegado.html');

    else

       header('location:..\otros\subir_datos_compra.php');
}



?>