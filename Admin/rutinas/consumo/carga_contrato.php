<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_SERVER["REQUEST_METHOD"]==="POST"){

require_once '../../../General/app/clases/UsuarioAmazon.php';

$idfaena=$_REQUEST["idfaena"];


$xfaena=new UsuarioAmazon();
$xlistado=$xfaena->getDatosContratoActivos($idfaena);
echo json_encode($xlistado); 
}