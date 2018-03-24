<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_SERVER["REQUEST_METHOD"]==="POST"){
    
    $dato= new ArrayObject();
    
    $dato->append(array($_POST["idtipo"],$_POST["modelo"]));
     
    include_once '../../../general/app/clases/UsuarioAmazon.php';
    
    $modelo=new UsuarioAmazon();
    
    $modelo->grabarModelo($dato);
    
    echo '0';
    
    
}