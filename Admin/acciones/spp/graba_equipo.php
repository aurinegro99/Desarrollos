<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["REQUEST_METHOD"]==="POST"){
    
    $dato= new ArrayObject();
    
    $dato->append(array($_POST["idequipo"],$_POST["idmodelo"],$_POST["serie"],$_POST["sap"],$_POST["fabricante"],$_POST["procedencia"],$_POST["fabricacion"],$_POST["ubicacion"],$_POST["status"],$_POST["tipo_equipo"]));
     
    include_once '../../../general/app/clases/UsuarioAmazon.php';
    
    $equipo=new UsuarioAmazon();
    
    if ($_POST["idequipo"]==0)
        $resul=$equipo->grabarEquipo($dato);
    else
        $resul=$equipo->modificaEquipo($dato);
    
    echo $resul;
    
    
}
