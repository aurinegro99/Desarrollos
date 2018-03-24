<?php
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["REQUEST_METHOD"]==="POST"){
    
    
    require_once '../app/clases/AutoConsumo.php';
    
       
    $xvalida=new AutoConsumo();
    $xdatos=$xvalida->validaClave($_SESSION["usuario"]);
    
    
    
    $x=9;
    foreach ($xdatos as $xusuario){
        //echo $_POST["actual"];
        $mclave=md5($_POST["actual"]);
        if ($mclave<>$xusuario["clave"])
            $x=8;
        else
            
            $x=$xvalida->setNuevaClaveAcceso($_SESSION["usuario"],$_POST["nueva"]);
        
    }
    
    echo $x;
}
