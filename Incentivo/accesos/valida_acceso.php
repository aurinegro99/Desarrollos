<?php
session_start();

$perfil = $_SESSION["perfil"];
$id=$_REQUEST["id"];

//echo $perfil.'  '.$id;


if ($id==1)
    {
    if ($perfil<8)
      header('location:acceso_denegado.html');

    else

       header('location:..\Manten\periodo_proceso.php');
}


if ($id==2)
    {
    if ($perfil<6)
      header('location:acceso_denegado.html');

    else

       header('location:..\Manten\carga_planilla.php');
}


if ($id==3)
    {
    if ($perfil<8)
      header('location:acceso_denegado.html');

    else

       header('location:..\Manten\Convenio_Faena.php');
}


if ($id==4)
    {
    if ($perfil<9)
      header('location:acceso_denegado.html');

    else

       header('location:..\Manten\Habilitar.php');
}

if ($id==5)
    {
    if ($perfil<9)
      header('location:acceso_denegado.html');

    else

       header('location:..\Manten\parametros_kpi.php');
}

if ($id==6)
    {
    if ($perfil<9)
      header('location:acceso_denegado.html');

    else

       header('location:..\Manten\parametros_convenio.php');
}

?>