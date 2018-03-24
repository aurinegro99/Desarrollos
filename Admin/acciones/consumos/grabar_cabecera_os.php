<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_SERVER["REQUEST_METHOD"]==="POST"){
    include_once '../../../general/app/clases/UsuarioAmazon.php';
    $grabar=new  UsuarioAmazon();
    
    $resul=$grabar->grabarCabeceraOs($_POST["inicio"],$_POST["termino"]);
    
    echo $resul;
    
}

