<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_SERVER["REQUEST_METHOD"]==="GET"){
    include_once '../app/clases/UsuarioLocal.php';
    
    $usuario=$_GET["usuario"];
    $perfil=$_GET["perfil"];
    $habilita=$_GET["habilita"];
    
    
       
    
    $dbusuario=new UsuarioLocal();
   
    if ($habilita=='S') {  // habilitar usuario
        $dbusuario->eliminaUsuario($usuario);
        $dbusuario->crearPerfil($usuario, $perfil);
    }
    
    if ($habilita=='N'){
        $dbusuario->eliminaAllFaena($usuario);
        $dbusuario->eliminaUsuario($usuario);
        
    }
    echo '0';
}


