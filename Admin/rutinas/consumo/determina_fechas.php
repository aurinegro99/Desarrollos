<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// inicial
require_once '../../General/app/clases/UsuarioAmazon.php';

$dato=new UsuarioAmazon();

$fecha_inicial=$dato->getUltimoIngreso();
$fecha_final=date('d/m/Y', strtotime('-1 day'));