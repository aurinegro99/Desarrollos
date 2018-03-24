<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../General/app/clases/UsuarioAmazon.php';

$opcion_tipo="";
$xtipo=new UsuarioAmazon();
$xlistado=$xtipo->getTipoEquipoConsumo();
foreach ($xlistado as $detalle){
        $opcion_tipo.="<option value=".$detalle["idtipo"]." >".$detalle["nombre_01"]."</option>";
    }
