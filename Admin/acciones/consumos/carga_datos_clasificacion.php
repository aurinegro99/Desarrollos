<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["REQUEST_METHOD"]==="GET"){
    //require_once '../ini/inicial.php';

    require_once "../../../general/app/clases/UsuarioAmazon.php";
     
    $xid=$_GET["xid"];
    
    $clasif=new UsuarioAmazon();
    
    //echo $idusuario;

    $listado=$clasif->getDatosClasficacion($xid);
    
    //var_dump($listado);
    
    
    // echo $listado;
    foreach ($listado as $datos){
            $xnombre=$datos["descripcion"]; 
            $xactivo=$datos["activa"];
            $xcontrato=$datos["idcontrato"];
            $xmoneda=$datos["moneda_pago"];
            
        
    }
    
    // armat json
    $data = array('success' => true,'nombre'=>$xnombre,'idcontrato'=>$xcontrato,'vigente'=>$xactivo,'moneda_pago'=>$xmoneda);
    echo json_encode($data); 

}

