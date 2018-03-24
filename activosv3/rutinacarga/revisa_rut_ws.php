<?php

$rut='12442587-5';
//if ($_SERVER["REQUEST_METHOD"]==="GET")
//{    

  // $rut=$_GET["rut"];

$wsdlurl= "http://arrayanv2:50000/WS_INFOPUBLISHER/Config1?wsdl&style=document" ; // productivo
//$wsdlurl  ="http://10.4.52.50:51000/WS_INFOPUBLISHER/Config1?wsdl&style=document"; //  desarrollo

$login    = "";
$password = "";
$client = new SoapClient($wsdlurl,
			array('login'      => $login,
				  'password'   => $password,
				  'trace'	   => true,
				  'exceptions' => true));
//var_dump($client->__getFunctions());

$param = array("rut"=>"$rut");

$result = $client -> datosEmpleado($param);


//print_r($result);


$xnombre=$result->Response->nombre;

//echo $xnombre;



if ($result->Response->codcompania!=='3002')
    echo '0';
else	
     echo $xnombre;

//}
