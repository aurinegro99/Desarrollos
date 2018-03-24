<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_SERVER["REQUEST_METHOD"]==="GET"){
    //require_once '../ini/inicial.php';

    require_once "../../general/app/clases/UsuarioAmazon.php";
     
    $idusuario=$_GET["xid"];
    
    $usuario=new UsuarioAmazon();
    
    //echo $idusuario;

    $listado=$usuario->getDatosUsuario($idusuario);
    
    //var_dump($listado);
    
    
    // echo $listado;
    foreach ($listado as $datos){
            $xnombre=$datos["nombre_usuario"];
            $xrut=$datos["rut_usuario"];
            $xmail=$datos["mail_usuario"];
            $xactivo=$datos["activo"];
            $xid=$datos["usuario"];
        
    }
    
    // armat json
    $data = array('success' => true,'usuario'=>$xid,'nombre_usuario'=>$xnombre,'rut_usuario'=>$xrut,'mail_usuario'=>$xmail,'activo'=>$xactivo);
    echo json_encode($data); 

}