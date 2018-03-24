<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_SERVER["REQUEST_METHOD"]==="POST"){
    //require_once '../ini/inicial.php';

    require_once "../../../general/app/clases/UsuarioAmazon.php";
     
    $xid=$_POST["idequipo"];
    $xfaena=$_POST["idfaena"];
    
    $equipo=new UsuarioAmazon();
    
    //echo $idusuario;

     $equipo->borrarOperacionEquipo($xid,$xfaena);
     
     return '0';
    
    //var_dump($listado);
    
    
   

}