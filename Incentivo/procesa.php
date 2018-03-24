<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start(); 
print_r($_POST);
sleep(5);

if ($_POST['user']=='dani'){
    $_SESSION["correcto"] = 'BIENVENIDO';
}else{
   $_SESSION["correcto"] = 'SIN ACCESO';
}
 
echo $_SESSION["correcto"];
