<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

if (count($_SESSION)<=0){
    
     echo "<script language=Javascript> location.href=\"../index.php\"; </script>";
   
    
}
else{
    
    $xdato_usuario=$_SESSION['usuario'].': '.$_SESSION['nombre'];
 

    include "../header/header_new.php"; 
}

