<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_SERVER["REQUEST_METHOD"]==="POST"){
    include_once '../app/clases/Convenio.php';
    
    $idconfig=$_REQUEST["idconf"];
    $formula=$_REQUEST["formula"];
       
    
    $xconvenio=new Convenio();
   
    $xconvenio->setConfiguracion($idconfig, $formula);
    
    
    echo '0';
}


