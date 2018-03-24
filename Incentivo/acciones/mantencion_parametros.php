<?php
session_start();
$usuario=$_SESSION["usuario"];
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_SERVER["REQUEST_METHOD"]==="POST"){
    include_once '../app/clases/UsuarioLocal.php';
    
    $status=$_POST["status"];
    $nombre=$_POST["nombre"];
    $clave=$_POST["clave"];
    $variable=$_POST["nombre_variable"];
            
    
    $param=new UsuarioLocal();
    
    if ($status==""){
        if ($param->revisaDatosParametro($clave, $variable)=='1')
            $data = array('success' => false, 'datos'=>$param->revisaDatosParametro($clave, $variable));
        else{
            $dato= new ArrayObject();
            $dato->append(array($nombre,$clave,$variable,$usuario));
            $param->grabaParametro($dato);
            $data = array('success' => true);
        }
    }
    
    echo json_encode($data); 
    
    
}


