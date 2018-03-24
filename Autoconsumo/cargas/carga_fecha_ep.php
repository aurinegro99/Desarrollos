<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_SERVER["REQUEST_METHOD"]==="POST"){
    
     
    require_once '../app/clases/AutoConsumo.php';
    
    $xfec1=new AutoConsumo();
    
    $xfecha_inicioContrato=$xfec1->getFechaContrato($_POST["idcontrato"]);
    
    $xfechas=$xfec1->getFechasEp($_POST["idestado"]);
    foreach($xfechas as $datos){
        $xfecha_inicioEp=$datos["inicio"];
        $fecha_terminoEp=$datos["termino"];
      }
      
    $xdatos=$xfec1->getDatosPeriodoEp($_POST["idcontrato"]);
    
    foreach($xdatos as $zdatos){
           $num=$zdatos["periodo"];
           
        
    }


if ($num==$_POST["idestado"])
    $fecha=$xfecha_inicioEp;
else
    $fecha=$xfecha_inicioContrato;
    
    
    // devocler fecha y fecha_termino



  $data = array('inicio'=>$fecha,'termino'=>$fecha_terminoEp);
  echo json_encode($data);   
}