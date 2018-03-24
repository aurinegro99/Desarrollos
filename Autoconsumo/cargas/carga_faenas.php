<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once '../app/clases/AutoConsumo.php';
$faenas=new AutoConsumo();
$datos=$faenas->getFaenaUsuario($_SESSION["usuario"]);
$opcion_faena="";
foreach ($datos as $detalle){
        $opcion_faena.="<option value=".$detalle["idfaena"]." >".$detalle["nombre_faena"]."</option>";
    
}