<?php
 session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_SERVER["REQUEST_METHOD"]==="POST"){
   
    
    require_once '../app/clases/AutoConsumo.php';
    
    $xparam=new AutoConsumo();
    $xlista=$xparam->getParametros1($_POST["idfaena"], $_POST["idcontrato"], $_POST["inicio"], $_POST["termino"]);
    foreach($xlista as $datos){
        $xpar1=$datos[0];  //aprobar
        $xpar2=$datos[1];   // tipo_aprobar
        $xpar3=$datos[2];  //aprobado
    }
    //var_dump($_POST["data"]);
    $dato= new ArrayObject();
    $xgraba=new AutoConsumo();
    // dataobject
    foreach($_POST["data"] as $lineas){
           
            $dato->append(array($xpar1,$xpar2,$lineas,$_POST["inicio"],$_POST["termino"],$_POST["ip"],$_SESSION["usuario"],$_POST["idestado"]));
            
    }
    $xgraba->grabaAprobacionConsumo($dato);
    echo '0';
    
    
    
    
    
    

}
