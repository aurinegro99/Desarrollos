<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["REQUEST_METHOD"]==="GET"){
    include_once '../app/clases/UsuarioLocal.php';
    
    $usuario=$_GET["musuario"];
    
    $xusuario=new UsuarioLocal();

    echo $xusuario->getPerfil($usuario).'*'.$xusuario->getHabilita($usuario);
    

}
