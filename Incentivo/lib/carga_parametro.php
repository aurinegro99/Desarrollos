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
    $xconvenio=$_GET["idconvenio"];
    //echo $xfaena;
    
    // rescatar daos del convenio
    $xdatos=new Convenio();
    $xlistado=$xdatos->getDatosConfiguracion($xconvenio);
    if ($xlistado){
        $data = array();
        $data[]=0;
        foreach($xlistado as $xdatos=>$valor){
                $data[]=$valor[0];
                $data[]=$valor[1];
                //$data[]=$xdatos;
        }
        
    }
        
    else{
        // crear
        $data = array('success' => false);
    }
       
    
    
    echo json_encode($data);
    
    
    
}
    