<?php
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["REQUEST_METHOD"]==="POST"){
    
        
    $dato= new ArrayObject();
    
    
    $dato->append(array($_REQUEST["inicio"],$_REQUEST["termino"],$_REQUEST["idfaena"],$_REQUEST["idcontrato"],$_REQUEST["ciclo"],$_REQUEST["aprobacion"],$_REQUEST["agrupacion"],$_REQUEST["chequeado"],$_SESSION["usuario"],$_REQUEST["planificada"]));
     
    include_once '../../../general/app/clases/UsuarioAmazon.php';
    
    $contrato=new UsuarioAmazon();
        
    
    echo $contrato->setParametrosFaena($dato);
    
    
}

