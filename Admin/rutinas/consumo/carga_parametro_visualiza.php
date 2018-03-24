<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["REQUEST_METHOD"]==="POST"){
    require_once '../../../General/app/clases/UsuarioAmazon.php';

    $id=$_POST["correlativo"];
    
    $xdatos=new UsuarioAmazon();
    $xlistado=$xdatos->getParametrosVisualizar($id);
    echo json_encode($xlistado); 
}
