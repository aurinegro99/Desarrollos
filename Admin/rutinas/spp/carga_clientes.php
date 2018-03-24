<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../General/app/clases/UsuarioAmazon.php';

$opcion_cliente="";
$xtipo=new UsuarioAmazon();
$xlistado=$xtipo->getClientes();
foreach ($xlistado as $detalle){
        $opcion_cliente.="<option value=".$detalle["idcliente"]." >".$detalle["nombre_cliente"]."</option>";
    }
    
    
    //echo $opcion_cliente;