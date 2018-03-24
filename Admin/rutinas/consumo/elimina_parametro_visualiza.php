<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["REQUEST_METHOD"]==="POST"){
    //require_once '../ini/inicial.php';

    require_once "../../../general/app/clases/UsuarioAmazon.php";
     
    $xid=$_POST["correlativo"];
    
    
    $param=new UsuarioAmazon();
    
    //echo $idusuario;

     $param->borrarParamatrosVisualiza($xid);
     
     echo '0';
    
    //var_dump($listado);
    
    
   

}
