<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../../General/app/clases/UsuarioAmazon.php';

$idcliente=$_REQUEST["idcliente"];


$xubic=new UsuarioAmazon();
$xlistado=$xubic->getUbicacionCliente($idcliente);
//echo json_encode(array("data"=>$xlistado)); 
echo json_encode($xlistado); 