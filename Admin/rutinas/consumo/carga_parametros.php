<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_SERVER["REQUEST_METHOD"]==="GET"){
    require_once '../../../General/app/clases/UsuarioAmazon.php';

    $idfaena=$_GET["idfaena"];
    $idcontrato=$_GET["idcontrato"];

    $xdatos=new UsuarioAmazon();
    $xlistado=$xdatos->getParametrosConsumo($idfaena,$idcontrato);
    echo json_encode($xlistado); 
}

