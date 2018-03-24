<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["REQUEST_METHOD"]==="GET"){
    //require_once '../ini/inicial.php';

    require_once "../../../general/app/clases/UsuarioAmazon.php";
     
    $idcontrato=$_GET["xid"];
    
    $usuario=new UsuarioAmazon();
    
    //echo $idusuario;

    $listado=$usuario->getDatosContrato($idcontrato);
    
    //var_dump($listado);
    
    
    // echo $listado;
    foreach ($listado as $datos){
            $xnumero=$datos["numero_contrato"];
            $xnombre=$datos["descripcion_trabajo"];
            $xmandante=$datos["empresa_mandante"];
            $xinicio=$datos["inicio"];
            $xtermino=$datos["termino"];
            $xvigente=$datos["vigente"];
            $xid=$datos["idestado"];
        
    }
    
    // armat json
    $data = array('success' => true,'numero'=>$xnumero,'nombre'=>$xnombre,'empresa'=>$xmandante,'inicio'=>$xinicio,'termino'=>$xtermino,'vigente'=>$xvigente,'id'=>$xid);
    echo json_encode($data); 
}