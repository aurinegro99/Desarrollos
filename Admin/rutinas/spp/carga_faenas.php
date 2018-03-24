<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../General/app/clases/UsuarioAmazon.php';

$opcion_faena="";
$xtipo=new UsuarioAmazon();
$xlistado=$xtipo->getDimFaenas();
foreach ($xlistado as $detalle){
        $opcion_faena.="<option value=".$detalle["idfaena"]." >".$detalle["nombre_faena"]."</option>";
    }