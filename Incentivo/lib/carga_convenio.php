<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["REQUEST_METHOD"]==="GET")
{
    require_once '../app/clases/Convenio.php';
    $xfaena=$_GET["idfaena"];
    //echo $xfaena;
    $xml='';
    $xml.="<convenios>";
    $xconvenio=new Convenio();
    $xlistado=$xconvenio->getConvenioFaena($xfaena);
    //var_dump($xlistado);
    if ($xlistado==null){
    }
    else{
        foreach ($xlistado as $detalle){
                $xml.="<idconvenio>".$detalle["idconvenio"]."</idconvenio>";  
   	        $xml.="<nombre>".$detalle["nombre_convenio_kcc"]."</nombre>";  
        }
    }
    
    $xml.="</convenios>";
 
echo $xml;
header('Content-Type: text/xml');

}
    