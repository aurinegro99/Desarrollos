<?php
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["REQUEST_METHOD"]==="GET"){
    include_once '../app/clases/UsuarioLocal.php';
    
        
    $usuario=$_SESSION["usuario"];
    
    $faena=$_GET["idfaena"];
    $numero=$_GET["numero"];
    $nombre=$_GET["nombre"];
    $inicio=$_GET["inicio"];
    $termino=$_GET["termino"];
    $habilita=$_GET["habilita"];
    $status=$_GET["status"];
    $id=$_GET["id"];
    
    // revisar fechas
    
    $convenio=new UsuarioLocal();
    
    //echo $convenio->validaFechas($inicio,$termino);
    
    if ($convenio->validaFechas($inicio,$termino)>=0){
        // crear objeto
        
        $dato= new ArrayObject();
        $dato->append(array($faena,$numero,$nombre,$inicio,$termino,$habilita,$usuario,$id));
               
        //
        if ($status=='C')
           $convenio->agregaConvenio($dato);
        else
           $convenio->setConvenio($dato); 
        
        echo '0';
        
        
    }
    else
         echo '9'; 
    
    

}
