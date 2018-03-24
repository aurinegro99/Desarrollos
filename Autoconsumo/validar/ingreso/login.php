<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["REQUEST_METHOD"]==="POST"){
    require_once '../../app/clases/AutoConsumo.php';

   
    
    $xvalida=new AutoConsumo();
    $xdatos=$xvalida->validaIngreso($_POST["usuario"],$_POST["clave"]);
    
    $x=9;
    foreach ($xdatos as $xusuario){
        $mclave=md5($_POST["clave"]);
        if ($mclave<>$xusuario["clave"])
           $x=8;
        else{
        
            session_start();
            $_SESSION['correo']=$xusuario["correo_electronico"] ;	
	    $_SESSION['usuario']=$xusuario["idusuario"] ;	
	    $_SESSION['nombre_usuario']=$xusuario["nombre_usuario"] ;
	    $_SESSION['nivel']=$xusuario["nivel_usuario"];
            $x=0;
            
            // grabar ingreso
            $xvalida->setIngresoLogin($xusuario["idusuario"],'Ingreso');
        }
        
    }
    
    echo $x; 
}
