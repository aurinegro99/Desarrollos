<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../app/clases/UsuarioLocal.php';

include '../lib/meses_01.php';


$opcion_periodo="";
$xperiodo=new UsuarioLocal();
$xlistado=$xperiodo->getPeriodos();
if ($xlistado==null){
    }
    else{
    
    foreach ($xlistado as $detalle){
        if ((strlen($detalle["mes"]))==1)
            $xmes='0'.$detalle["mes"];
        else    
            $xmes=$detalle["mes"];
        $opcion_periodo.="<option value=".$detalle["periodo"].$xmes." >".$meses[$detalle["mes"]]."-->".$detalle["periodo"]."</option>";
    }

    }

