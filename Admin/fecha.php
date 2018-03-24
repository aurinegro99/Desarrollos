<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../general/app/clases/UsuarioAmazon.php';
$f1='01/03/2018';
$f2='01/03/2018';
$fecha=new UsuarioAmazon();

echo $fecha->getComparaFechas($f1,$f2);

