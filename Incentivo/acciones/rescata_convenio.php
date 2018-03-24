<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["REQUEST_METHOD"]==="GET"){
    include_once '../app/clases/UsuarioLocal.php';
    
        
    $id=$_REQUEST["id"];
    $convenio=new UsuarioLocal();
    
    
    $listado=$convenio->getConveniosId($id);
    foreach ($listado as $datos){
        
        $lista=$datos["numero_convenio_kcc"].'*'.$datos["nombre_convenio_kcc"].'*'.$datos["inicio"].'*'.$datos["termino"].'*'.$datos["status_convenio"];
        
        
    }
    
    echo $lista;
    
}
