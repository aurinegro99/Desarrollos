<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["REQUEST_METHOD"]==="POST"){
    
        
    $dato= new ArrayObject();
    
    
    $dato->append(array($_REQUEST["idcontrato"],$_REQUEST["idfaena"],$_REQUEST["contrato"],$_REQUEST["nombre"],$_REQUEST["mandante"],$_REQUEST["fechainicio"],$_REQUEST["fechatermino"],$_REQUEST["activo"]));
     
    include_once '../../../general/app/clases/UsuarioAmazon.php';
    
    $contrato=new UsuarioAmazon();
    
    if ($_REQUEST["idcontrato"]=='0')
        $contrato->setNuevoContrato($dato);
    else
        $contrato->setModificaContrato($dato);
    
    echo '0';
    
    
}
