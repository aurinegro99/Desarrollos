<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_SERVER["REQUEST_METHOD"]==="GET"){
    include_once '../app/clases/UsuarioAmazon.php';
    
    $usuario=$_GET["musuario"];
    
    $xusuario=new UsuarioAmazon();

    $xdatos=$xusuario->getDatosUsuario($usuario);
    
    if ($xdatos==null)
       echo '0';
    else
    {
        //echo $xdatos;
        foreach($xdatos as $xlista){
            echo $xlista["nombre_usuario"].'*'.$xlista["mail_usuario"];
            
        }
        
    } 


}
