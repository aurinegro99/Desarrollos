<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["REQUEST_METHOD"]==="GET")
{
    require_once '../app/clases/Convenio.php';
   
    $xconvenio=$_GET["idconfig"];
    //echo $xfaena;
     $xml='';
    $xml.="<parametros>";
    // rescatar daos del convenio
    $xdatos=new Convenio();
    $xlistado=$xdatos->getParametrosConvenio($xconvenio);
    if ($xlistado){
        
        foreach($xlistado as $detalle){
                $xml.="<idparametro>".$detalle["idparam"]."</idparametro>";  
   	        $xml.="<nombre>".$detalle["nombre_parametro"]."</nombre>";
                $xml.="<variable>".$detalle["nombre_variable"]."</variable>";
                //$data[]=$xdatos;
        }
        
    }
     $xml.="</parametros>";
 
echo $xml;
header('Content-Type: text/xml');
    
        
    
    
}
    