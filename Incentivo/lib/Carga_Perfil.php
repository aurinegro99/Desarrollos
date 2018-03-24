<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../app/clases/ConexionLocal.php';

$xperfil=new ConexionLocal();

$listado=$xperfil->getPerfiles();

$opcion_perfil='';

foreach($listado as $lista){
    
    $opcion_perfil.="<option value=".$lista["perfil"]." >".$lista["nombre_perfil"]."</option>";
    
    
}



