<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../../General/app/clases/UsuarioAmazon.php';

$idfaena=$_REQUEST["idfaena"];
$idcont=$_REQUEST["idcontrato"];


$xfaena=new UsuarioAmazon();
$xlistado=$xfaena->getParametrosVisualizacion($idfaena,$idcont);
echo json_encode(array("data"=>$xlistado)); 
