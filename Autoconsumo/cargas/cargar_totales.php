<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_SERVER["REQUEST_METHOD"]==="POST"){
    
    require_once '../app/clases/AutoConsumo.php';
 
    $datos=new AutoConsumo();
    $lista=$datos->getTotalesAprobados($_POST["idestado"]);
    $dolar=0;
    $euro=0;
    foreach ($lista as $datos){
           // echo $datos["moneda_pago"];
            $mtot=round($datos["cantidad"]*$datos["valor_pago"]*$datos["factor"]*$datos["descuento"],2);
            if ($datos["moneda_pago"]=="Euro")
                $euro+=$mtot;
            if ($datos["moneda_pago"]=="Dolar") 
               $dolar+=$mtot;
    }
     $data = array('dolar'=>$dolar,'euro'=>$euro);
  echo json_encode($data);
    
    
}

