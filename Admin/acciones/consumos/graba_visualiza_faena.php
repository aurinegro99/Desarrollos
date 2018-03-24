<?php
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["REQUEST_METHOD"]==="POST"){
    
     $dato= new ArrayObject();
    
    
    $dato->append(array($_POST["correlativo"],$_POST["datos"],$_POST["idfaena"],$_POST["idcontrato"],$_SESSION["usuario"]));
     
    include_once '../../../general/app/clases/UsuarioAmazon.php';
    
    $grabar=new UsuarioAmazon();
    if ($_POST["correlativo"]>0)
       $grabar->modificaDatosVisualizacion($dato);
    else
       $grabar->setDatosVisualizacion($dato);
    echo '0';
}