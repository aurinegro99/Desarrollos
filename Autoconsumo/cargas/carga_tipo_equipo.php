<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_SERVER["REQUEST_METHOD"]==="POST"){
    
    
    require_once '../app/clases/AutoConsumo.php';
    $datos=new AutoConsumo();
    $xlista=$datos->getTipoEquipoFaena($_POST["idfaena"]);
    echo json_encode($xlista);
    
    
}