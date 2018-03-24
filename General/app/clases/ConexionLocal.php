<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConexionLocal
 *
 * @author U1301142
 */
class ConexionLocal {
    //put your code here
    private $_hostl="kcclbd12des";
    private $_dbl="Incentivo";
    private $_usl="contrato";
    private $_pasl="contrato";
    private $_cnl;
    
    
    public function __construct(){
        try{
            
            //Local
            $this->_cnl=new PDO('sqlsrv:Server=' . $this->_hostl . ';Database='. $this->_dbl,$this->_usl,$this->_pasl);
            $this->_cnl->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            
          
        }
            catch(PDOException $ex){
                
                echo 'Problema de Conexión: '.$ex->getMessage();
                throw $ex;
            }
            
        }
        
    public function getPerfiles(){
        
        $smtp=$this->_cnl->query("select perfil,nombre_perfil from Perfiles ;");
        
        return $smtp->fetchAll();
        
    }
    
   
}
