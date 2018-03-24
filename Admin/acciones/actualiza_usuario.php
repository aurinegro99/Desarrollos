<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["REQUEST_METHOD"]==="POST"){
    
        
    $dato= new ArrayObject();
    
    $dato->append(array($_REQUEST["inputidU"],$_REQUEST["nombreUsuario"],$_REQUEST["inputEmail"],$_REQUEST["rutUsuario"],$_POST["activo"]));
     
    include_once '../../general/app/clases/UsuarioAmazon.php';
    
    $usuario=new UsuarioAmazon();
    
    if ($_REQUEST["tipo"]=='S'){
        $usuario->setDatosUsario($dato);
        echo '0';
    }
    else    
    {    
        $sw=$usuario->getUsuarioDup($_REQUEST["inputidU"],$_REQUEST["rutUsuario"],$_REQUEST["inputEmail"]);
         
        if ($sw==1)
            $usuario->setNewUsuario($dato); 
        echo $sw;
        
       
        }
    
    
}


