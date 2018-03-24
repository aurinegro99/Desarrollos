<?php
session_start();

if (!isset($_SESSION['usuario'])){
  
    echo"<script language=Javascript> alert('Debe Iniciar Sesión'); </script>"; 
    echo "<script language=Javascript> location.href=\"../index.php\"; </script>"; 
}

$usuario = $_SESSION['usuario'];
$nombre = $_SESSION['nombre'];
$rut = $_SESSION['rut'];
$correo = $_SESSION['correo'];

$xdato_usuario=$usuario.': '.$nombre;
