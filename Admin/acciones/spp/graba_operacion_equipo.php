<?php
session_start();

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["REQUEST_METHOD"]==="POST"){
    
    $dato= new ArrayObject();
    
    $dato->append(array($_POST["idfaena"],$_POST["idequipo"],$_POST["numero_interno"],$_POST["horometro"],$_POST["fecha"],$_SESSION["usuario"]));
     
    include_once '../../../general/app/clases/UsuarioAmazon.php';
    
    $equipo=new UsuarioAmazon();
    
    if ($_POST["accion"]==0)
       $resul= $equipo->grabaOperacionEquipo($dato);
    if ($_POST["accion"]==1)
        $resul=$equipo->modificaOperacionEquipo($dato);
    echo $resul;
    
    
}
