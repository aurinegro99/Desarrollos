<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

//echo count($_SESSION);

//echo 'usuario :'.$_SESSION["usuario"];

if (count($_SESSION)<=0){
    
     echo "<script language=Javascript> location.href=\"../index.html\"; </script>";
   
    
}
else{
    
    $xdato_usuario=$_SESSION['nombre_usuario'];
 

    include "../header/header_new.php"; 
}

