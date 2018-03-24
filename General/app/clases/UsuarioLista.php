<?php
Class UsuarioLista{
    
    private $_hosta="CVWDSQL12";
    private $_dba="Lista_Precios";
    private $_usa="contrato ";
    private $_pasa="contrato";
    private $_cna;
    
     
    
    public function __construct(){
        try{
            
            
            
            // amazon
            $this->_cna=new PDO('sqlsrv:Server=' . $this->_hosta . ';Database='. $this->_dba,$this->_usa,$this->_pasa);
            $this->_cna->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            
       
          
        }
            catch(PDOException $ex){
                
                echo 'Problema de Conexión: '.$ex->getMessage();
                throw $ex;
            }
            
        }

    
    public function getListas(){
            
        // obtener todos los usarios de amazon 
        $smtp=$this->_cna->query("select idlista,fabricante,moneda from listas_precio where vigente='S' ;");
        
        return $smtp->fetchAll();
        
    }







}