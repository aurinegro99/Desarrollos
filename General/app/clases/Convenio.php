<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Convenio
 *
 * @author U1301142
 */
class Convenio {
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
        
    public function getIdConfig($idconvenio){
        $smtp=$this->_cnl->query("select idconfig from configura_convenio where idconvenio=$idconvenio ;");
        $resul=$smtp->fetch(PDO::FETCH_OBJ);
         if ($resul==null){
             //  crear y rescatar id creado
             $smtp=$this->_cnl->query("insert into configura_convenio "
                                      ."(idconvenio,formula_calculo,fecha_creacion) "
                                      . "values($idconvenio,'',getdate()) ;");
             $smtp->execute();
             // recupera
             $smtp=$this->_cnl->query("select @@IDENTITY as id");
             $resul=$smtp->fetch(PDO::FETCH_OBJ);
             $xid=$resul->id;
             
         }
         else
           $xid=$resul->idconfig;
         
         return $xid;
             
    }    
        
    public function getConvenioFaena($id){
        $smtp=$this->_cnl->query("select idconvenio,nombre_convenio_kcc FROM convenios_faena where idfaena=$id and status_convenio='S' ;");
        return $smtp->fetchAll();
        
        
    }
    
    
    public function getParametros(){
        $smtp=$this->_cnl->query("select idparametro,nombre_parametro,clave,nombre_variable FROM parametros_kpi ;");
        return $smtp->fetchAll();
    }
    
    public function getParametrosFaena($id){
        $smtp=$this->_cnl->query("select idconvenio,nombre_convenio_kcc FROM convenios_faena where idfaena=$id ;");
        return $smtp->fetchAll();
    }
    
    public function getDatosConfiguracion($id){
        $smtp=$this->_cnl->query("select idconfig,formula_calculo FROM configura_convenio where idconvenio=$id ;");
        return $smtp->fetchAll();
    }
    
    public function grabarParametros($idfaena,$idconf,$param){
           $xid=$this->getIdConfig($idconf);
            foreach($param as $xdatos=>$valor){
                    $smtp=$this->_cnl->prepare("insert into parametros_configuracion "
                                             ."(idconfig,idparam,fecha_creacion)"
                                             ."values(?,$valor[0],getdate() ); ");
                  
                  $smtp->bindParam(1,$xid,PDO::PARAM_INT); // nombre
                  
                  
                  //echo $smtp->debugDumpParams();
                  $smtp->execute();
                
                
            }
           
        
    }
    
    public function getParametrosConvenio($idconfig){
           $smtp=$this->_cnl->query("select a.idparam,b.nombre_parametro,b.nombre_variable FROM parametros_configuracion a
                                   left join parametros_kpi b on a.idparam=b.idparametro
                                   where a.idconfig=$idconfig ;");
           //echo $smtp->debugDumpParams();
           return $smtp->fetchAll();
        
    }
    
    public function setConfiguracion($id,$formula){
           $smtp=$this->_cnl->query("update configura_convenio 
                                     set formula_calculo='$formula' where idconfig=$id ;");
           $smtp->execute();
    }
        
}
