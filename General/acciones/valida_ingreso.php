<?php
session_start();

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$musuario = $_REQUEST['correo'];
$clave = $_REQUEST['clave'];


$wsdlurl = "http://wskcl.kcl.cl/service.asmx?WSDL";
$wsUser = "";
$wsPassword = "";

$client = new SoapClient($wsdlurl, array('login' => $wsUser,
    'password' => $wsPassword,
    'trace' => true,
    'exceptions' => true));

$param = array("p1" => "a", "p2" => "b", "u" => $musuario, "p" => $clave);

$response = $client->Authenticate($param);

$subXml = new SimpleXMLElement($response->AuthenticateResult->any);

$res = $subXml->Result["res"];

$data = array();

if ($res == 'OK') {
    // rescatar el correo
    include_once '../app/clases/UsuarioAmazon.php';
    $xbusca=new Usuarioamazon();
    $xlista=$xbusca->getDatosUsuario($musuario);
    if ($xlista){
        
        $data=0;
       foreach($xlista as $datos){
           $xcorreo=$datos["mail_usuario"];
       }    
        //$data[]=$xcorreo;
        //$data[]=$res;
        $_SESSION["correo_verif"]=$xcorreo;
    }
        
    else
        $data=9; 
    
} else{
      $data=1; 
      //$data[]=$res; 
      
}

 echo $data;

