<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../ini/inicial.php';

// nivel usuario
$xnivel=$_SESSION["nivel"];

$opc=$_GET["opc"];


if ($opc==201){
    if ($xnivel>=20) 
       header('location:..\precios\consulta_precios.php');
else
       header('location:acceso_denegado.html');

}




if ($opc==301){
    if (($xnivel<=7) or ($xnivel==99))
       header('location:..\aprobar\concilia_turno.php');
else
       header('location:acceso_denegado.html');

} 


if ($opc==302){
    if (($xnivel<=5) or ($xnivel==99))
      header('location:..\aprobar\aprobar_consumos.php');
else
     header('location:acceso_denegado.html');
    
}


if ($opc==303){
    if (($xnivel<=5) or ($xnivel==99))
      header('location:..\aprobar\consumos_estado_pago.php');
else
     header('location:acceso_denegado.html');
    
}
// aprobar



    

    
