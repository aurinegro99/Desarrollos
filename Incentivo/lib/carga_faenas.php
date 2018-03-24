<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../app/clases/UsuarioLocal.php';
require_once '../app/clases/UsuarioAmazon.php';

$opcion_faena="";
$xfaena=new UsuarioLocal();
$xlistado=$xfaena->getUsuarioFaena($usuario);
if ($xlistado==null){
    
}
    else{
    $xfaenas= new Usuarioamazon();
    $xlistanombre=$xfaenas->getNombreFaenas($xlistado);
    
    foreach ($xlistanombre as $detalle){
        $opcion_faena.="<option value=".$detalle["idfaena"]." >".$detalle["nombre_faena"]."</option>";
    }

    }