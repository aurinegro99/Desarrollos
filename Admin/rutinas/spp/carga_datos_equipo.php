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
    
    $equipo=new UsuarioAmazon();
    
    //echo $idusuario;

    $listado=$equipo->getDatosEquipo($xid);
    
    
    echo json_encode($listado); 

}

