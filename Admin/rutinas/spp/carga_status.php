<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../General/app/clases/UsuarioAmazon.php';

$opcion_status="";
$xtipo=new UsuarioAmazon();
$xlistado=$xtipo->getStatus();
foreach ($xlistado as $detalle){
        $opcion_status.="<option value=".$detalle["idstatus"]." >".$detalle["nombre_status"]."</option>";
    }
