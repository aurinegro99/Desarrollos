<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once "../../general/app/clases/UsuarioAmazon.php";

$usuario=new UsuarioAmazon();

$listado=$usuario->getAmazon();

//echo var_dump($listado);

//$new_json="{ data : [".$listado."]}";

echo json_encode(array("data"=>$listado)); 

