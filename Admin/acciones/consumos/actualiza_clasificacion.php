<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["REQUEST_METHOD"]==="POST"){
    
        
    $dato= new ArrayObject();
    
    
    $dato->append(array($_REQUEST["idclasif"],$_REQUEST["idfaena"],$_REQUEST["idcontrato"],$_REQUEST["descripcion"],$_REQUEST["moneda"],$_REQUEST["vigente"]));
     
    include_once '../../../general/app/clases/UsuarioAmazon.php';
    
    $contrato=new UsuarioAmazon();
    
    if ($_REQUEST["idclasif"]=='0')
        $contrato->setNuevaClasificacion($dato);
    else
        $contrato->setClasificacion($dato);
    
    echo '0';
    
    
}
