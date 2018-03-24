<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_SERVER["REQUEST_METHOD"]==="GET"){
    include_once '../app/clases/Convenio.php';
    
    $idfaena=$_GET["idfaena"];
    $idconvenio=$_GET["idconvenio"];
    $param=$_GET["param"];
    
    $arr=array();
    $lista=explode(',',$param);
    if ($lista<=0)
       $arr[]=$param;
    else{
        $nlargo=count($lista);
        for ($i = 0; $i <= $nlargo-1; $i++){
            
            $arr[]=$lista[$i];
        }
        
    $xgrabar=new Convenio();
    $xgrabar->grabarParametros($idfaena, $idconvenio, $arr);
    
    echo '0';
        
        
    }
    


}


