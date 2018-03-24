<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_SERVER["REQUEST_METHOD"]==="GET"){
    include_once '../app/clases/UsuarioLocal.php';
    
    $usuario=$_GET["usuario"];
    $faenas=$_GET["faenas"];
    $arr=array();
    $lista=explode(',',$faenas);
    if ($lista<=0)
       $arr[]=$faenas;
    else{
        $nlargo=count($lista);
        for ($i = 0; $i <= $nlargo-1; $i++){
            
            $arr[]=$lista[$i];
        }
        
        
    }
    
    
    
    $dbusuario=new UsuarioLocal();
   
    $dbusuario->grabaAccesos($usuario,$arr);
    
    echo '0';


}


