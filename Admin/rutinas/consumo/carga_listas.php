<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../General/app/clases/UsuarioLista.php';

$opcion_lista="";
$xlista=new UsuarioLista();
$xlistado=$xlista->getListas();
foreach ($xlistado as $detalle){
        $opcion_lista.="<option value=".$detalle["idlista"]." >".$detalle["fabricante"]."--->".$detalle["moneda"]."</option>";
    }
