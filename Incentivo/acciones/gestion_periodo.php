<?php
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


if ($_SERVER["REQUEST_METHOD"]==="GET"){
    $usuario=$_SESSION["usuario"];  
    require_once '../app/clases/UsuarioLocal.php';
    $status=$_REQUEST["status"];
    
    $periodo=new UsuarioLocal();
    
    if ($status=='A')
        echo $periodo->cierraPeriodo($usuario);
    if ($status=='C')
        echo $periodo->abrePeriodo($usuario);

}
