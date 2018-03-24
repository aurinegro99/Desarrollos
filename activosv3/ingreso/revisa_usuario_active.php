<?php

    $musuario= $_REQUEST['musuario'];
    $clave= $_REQUEST['clave'];
	
	
    $wsdlurl  = "http://wskcl.kcl.cl/service.asmx?WSDL";
    $wsUser    = "";
    $wsPassword =   "";
	
    $client = new SoapClient($wsdlurl,
                        array('login'      => $wsUser,
                              'password'   => $wsPassword,
                              'trace'	   => true,
                              'exceptions' => true));

    $param = array("p1"=>"a","p2"=>"b","u"=>$musuario,"p"=>$clave);

    $response = $client -> Authenticate($param);        

    $subXml = new SimpleXMLElement($response->AuthenticateResult->any);

    $res = $subXml->Result["res"];

    echo $res; 
    //return $res == "OK"; 

?>