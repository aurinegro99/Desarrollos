<?php
Class Usuarioamazon{
    
    // Base Amazon
    
    private $_hosta="kch-1ano-sql-de.czvz6jrh66tt.us-west-2.rds.amazonaws.com";
    private $_dba="DB_Informe_Gestion";
    private $_usa="master_user";
    private $_pasa="komatsu2016";
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
    

    public function getAmazon(){
            
        // obtener todos los usarios de amazon 
        $smtp=$this->_cna->query("select * from usuarios_informe ;");
        
        return $smtp->fetchAll();
        
    }
    
    
    public function getDatosUsuario($usuario){
        
        $xusuario="KCCL".chr(92).$usuario;
        $smtp=$this->_cna->query("select nombre_usuario,mail_usuario FROM usuarios_informe where usuario='$xusuario'");
        
        return $smtp->fetchAll();
    }
    
    public function getUsuarioCorreo($xcorreo){
        $smtp=$this->_cna->query("select nombre_usuario,usuario,rut_usuario,mail_usuario FROM usuarios_informe where mail_usuario='$xcorreo'");
        
        return $smtp->fetchAll();
    }
       
    
    public function getNombreFaenas($idfaenas){
        $cadena="";
            
            foreach($idfaenas as $lista){
                   if (strlen($cadena)<=0)
                       $cadena=$lista["idfaena"];
                   else
                       $cadena.=','.$lista["idfaena"]; 
            
            }
      
        $smtp=$this->_cna->query("select idfaena,nombre_faena from dim_faenas where idfaena in (".$cadena.") order by nombre_faena");
        return $smtp->fetchAll();
        
    }
    
    public function getNombreFaenaId($idfaena){
        $smtp=$this->_cna->query("select nombre_faena from dim_faenas where idfaena=$idfaena order by nombre_faena");
        return $smtp->fetchAll();
        
    }
    
    public function getNombreFaenasExc($idfaenas){
        //$zlista=explode(',',$idfaenas);
        //$nlargo=count($zlista);
        
        //if ($nlargo<=1)
        //    $cadena=$idfaenas;
        //else{
         $cadena="";
            foreach($idfaenas as $lista){
                 if (strlen($cadena)<=0)
                    $cadena=$lista["idfaena"];
                 else
                    $cadena.=','.$lista["idfaena"]; 
            
             }
        //}
        $smtp=$this->_cna->query("select idfaena,nombre_faena from dim_faenas where idunidad=2 and idfaena not in (".$cadena.") order by nombre_faena");
        return $smtp->fetchAll();
        
    }
    
    public function getIdFaena($ceco){
        $smtp=$this->_cna->query("select c.idfaena from dim_cebe_ceco a  "
                                ."left join dim_faena_cebe b on a.cebe=b.cebe "
                                ."left join dim_faenas c on b.idfaena=c.idfaena "
                                ."where a.ceco='$ceco' ;");
        return $smtp->fetchAll();
        
    }
        
        
}
    
    
        
        
    