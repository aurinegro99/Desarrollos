<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["REQUEST_METHOD"]==="POST"){
    
    
   
    require_once '../app/clases/AutoConsumo.php';
    
    
    $dato=new AutoConsumo();
        
    
    echo $dato->getComparaFechas($_POST["inicio"],$_POST["termino"]);
    
    
}