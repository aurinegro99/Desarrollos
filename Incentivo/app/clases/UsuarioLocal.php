<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuarioLocal
 *
 * @author U1301142
 */
class UsuarioLocal {
    //put your code here
     // base CVWDSQL12
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
        
        
        
   public function getUsuarioFaena($usuario){
       $smtp=$this->_cnl->query("select idfaena FROM usuario_faena where usuario='$usuario'");
           
       return $smtp->fetchAll();
   }   
   
   public function getPerfil($usuario){
        $smtp=$this->_cnl->query("select perfil FROM perfil_usuario where usuario='$usuario'");
        $resul=$smtp->fetch(PDO::FETCH_OBJ);
        if ($resul==null)
            $perfil=1;
        else
            $perfil=$resul->perfil;
         
        return $perfil;
        
    }
    
    public function getHabilita($usuario){
        $smtp=$this->_cnl->query("select perfil FROM perfil_usuario where usuario='$usuario'");
        $resul=$smtp->fetch(PDO::FETCH_OBJ);
        if ($resul==null)
            $habilita=0;
        else
            $habilita=1;
         
        return $habilita;
        
    }
    
   public function grabaAccesos($usuario,$faenas){
          foreach($faenas as $lista){
              
              $smtp=$this->_cnl->prepare('insert into usuario_faena'
                                       . '(usuario,idfaena,fecha_creacion)'
                                       . 'values(?,?,getdate()) ;');
              $smtp->bindParam(1,$usuario,PDO::PARAM_STR);
              $smtp->bindParam(2,$lista,PDO::PARAM_INT);
              $smtp->execute();
              
          }
       
   }
   
   public function eliminaFaena($usuario,$faena){
       $smtp=$this->_cnl->prepare('delete from usuario_faena where usuario=? and idfaena=? ;');
       $smtp->bindParam(1,$usuario,PDO::PARAM_STR);
       $smtp->bindParam(2,$faena,PDO::PARAM_INT);
       $smtp->execute();
       
   }
   
   public function eliminaAllFaena($usuario){
       $smtp=$this->_cnl->prepare('delete from usuario_faena where usuario=?  ;');
       $smtp->bindParam(1,$usuario,PDO::PARAM_STR);
       $smtp->execute();
       
   }
   
   public function crearPerfil($usuario,$perfil){
          $smtp=$this->_cnl->prepare('insert into perfil_usuario'
                                       . '(usuario,perfil,fecha_creacion)'
                                       . 'values(?,?,getdate()) ;');
          $smtp->bindParam(1,$usuario,PDO::PARAM_STR);
          $smtp->bindParam(2,$perfil,PDO::PARAM_INT);
          $smtp->execute();
       
   }
   
   public function eliminaUsuario($usuario){
          $smtp=$this->_cnl->prepare('delete from perfil_usuario where usuario=?  ;');
          $smtp->bindParam(1,$usuario,PDO::PARAM_STR);
          $smtp->execute();
       
   }
   
   public function validaFechas($fecha1,$fecha2){
          $smtp=$this->_cnl->prepare('select datediff(dd,convert(datetime,?,103),convert(datetime,?,103)) as dias  ;');
          $smtp->bindParam(1,$fecha1,PDO::PARAM_STR);
          $smtp->bindParam(2,$fecha2,PDO::PARAM_STR);
          $smtp->execute();
          $resul=$smtp->fetch(PDO::FETCH_ASSOC);
          return $resul["dias"];
       
   }
   
   public function agregaConvenio($datos){
       foreach ($datos as $xdatos) {
            $smtp=$this->_cnl->prepare('insert into convenios_faena'
                                       . '(idfaena,numero_convenio_kcc,nombre_convenio_kcc,fecha_creacion,fecha_inicio_convenio,fecha_termino_convenio,status_convenio,usuario_creacion)'
                                       . 'values(?,?,?,getdate(),convert(datetime,?,103),convert(datetime,?,103),?,?) ;');
            $smtp->bindParam(1,$xdatos[0],PDO::PARAM_INT);
            $smtp->bindParam(2,$xdatos[1],PDO::PARAM_STR);
            $smtp->bindParam(3,$xdatos[2],PDO::PARAM_STR);
            $smtp->bindParam(4,$xdatos[3],PDO::PARAM_STR);
            $smtp->bindParam(5,$xdatos[4],PDO::PARAM_STR);
            $smtp->bindParam(6,$xdatos[5],PDO::PARAM_STR);
            $smtp->bindParam(7,$xdatos[6],PDO::PARAM_STR);
            $smtp->execute();  
           
       }
   }
   
   public function getConvenios($idfaena){
           $smtp=$this->_cnl->query("select * FROM convenios_faena where idfaena=$idfaena");
   return $smtp->fetchAll();
        }
        
   public function getConveniosId($id){
           $smtp=$this->_cnl->query("select idconvenio,numero_convenio_kcc,nombre_convenio_kcc,convert(varchar,fecha_inicio_convenio,103) as inicio "
                   . ",convert(varchar,fecha_termino_convenio,103) as termino,status_convenio FROM convenios_faena where idconvenio=$id");
           return $smtp->fetchAll();
        }
   
   public function getConveniosNro($idfaena,$nro){
           $smtp=$this->_cnl->query("select idconvenio FROM convenios_faena where numero_convenio_kcc='$nro' and idfaena=$idfaena  ;");
           return $smtp->fetchAll();
           
        }     
        
   public function setConvenio($datos){
          foreach ($datos as $xdatos) {
            $smtp=$this->_cnl->prepare('update convenios_faena '
                                       . 'set numero_convenio_kcc=?,nombre_convenio_kcc=?,fecha_ultima_mod=getdate(),fecha_inicio_convenio=convert(datetime,?,103),'
                                       . 'fecha_termino_convenio=convert(datetime,?,103),status_convenio=?,usuario_mod=? '
                                       . 'where idconvenio=? ;');
            $smtp->bindParam(1,$xdatos[1],PDO::PARAM_STR);  // numero
            $smtp->bindParam(2,$xdatos[2],PDO::PARAM_STR);   // nombre
            $smtp->bindParam(3,$xdatos[3],PDO::PARAM_STR);  // fecha inicio
            $smtp->bindParam(4,$xdatos[4],PDO::PARAM_STR);  // fecha termino
            $smtp->bindParam(5,$xdatos[5],PDO::PARAM_STR); //status
            $smtp->bindParam(6,$xdatos[6],PDO::PARAM_STR); // usuaroi
            $smtp->bindParam(7,$xdatos[7],PDO::PARAM_INT); // id
            $smtp->execute();  
       }
   }     
   
   // periodod
   
   public function getUltimoPeriodo(){
          $smtp=$this->_cnl->query("select top 1 periodo,mes,status,usuario_creacion,convert(varchar,fecha_creacion,103) as fecha,convert(varchar,fecha_creacion,108) as hora FROM periodos_incentivo order by periodo,mes desc ;");
       return $smtp->fetchAll();
   }
   
   public function getPeriodos(){
          $smtp=$this->_cnl->query("select periodo,mes FROM periodos_incentivo order by periodo,mes desc ;");
       return $smtp->fetchAll();
   }

   public function cierraPeriodo($usuario){
          $smtp=$this->_cnl->query("select top 1 periodo,mes FROM periodos_incentivo where status='A' order by periodo,mes desc ;");
          $resul=$smtp->fetch(PDO::FETCH_ASSOC);
          $xperiodo=$resul["periodo"];
          $xmes=$resul["mes"];
          //$xusuario=$usuario;
          
          $smtp2=$this->_cnl->query("update periodos_incentivo "
                                   ."set usuario_cierre='$usuario' ,fecha_cierre=getdate(),status='C'  "
                                   . "where periodo=$xperiodo and mes=$xmes and status='A' ;   ");
                    
          $resul2=$smtp2->execute();
          if ($resul2==true)
              return '0';
          else
              return '9'; 
          //echo $smtp2->debugDumpParams();
                     
          //return $resul['periodo']+' '+$resul['mes'];
   }
   
   public function abrePeriodo($usuario){
          $smtp=$this->_cnl->query("select top 1 periodo,mes FROM periodos_incentivo where status='C' order by periodo,mes desc ;");
          $resul=$smtp->fetch(PDO::FETCH_ASSOC);
          if ($resul["mes"]==12){
              $newmes=1;
              $newper=$resul["periodo"]+1;
          }
          else{
              $newmes=$resul["mes"]+1;
              $newper=$resul["periodo"];
          }
          
          $smtp2=$this->_cnl->query("insert into periodos_incentivo "
                                    ."(periodo,mes,usuario_creacion,fecha_creacion,status)   "
                                    . "values ($newper,$newmes,'$usuario',getdate(),'A') ;");
          
          $resul2=$smtp2->execute();
          if ($resul2==true)
              return '1';
          else
              return '9';  
       
   }
   
   public function eliminaDatosPeriodo($periodo){
           $smtp=$this->_cnl->query("delete FROM Nomina_Personal_Mes where periodo='$periodo' ;");  
           $smtp->execute();
   }
   
   public function grabaPlanilla($datos){
       
       //var_dump($datos);
         foreach($datos as $xdatos=>$valor){
                 $smtp=$this->_cnl->prepare("insert into Nomina_Personal_Mes "
                                           . "(periodo,rut,nombre,sociedad,fecha_ingreso,fecha_retiro,sucursal,nombre_sucursal,unidad,nombre_unidad,"
                                           . "centro_costo,cargo,nombre_cargo,categoria,nombre_categoria,tipo_contrato,numero_convenio,fecha_carga,usuario_carga,idfaena,idconvenio) "
                                           . "values(?,?,?,?,convert(datetime,?,103),convert(datetime,?,103),?,?,?,?,?,?,?,?,?,?,?,getdate(),?,?,?) ;");
                  
                 $smtp->bindParam(1,$valor[14],PDO::PARAM_STR); // periodo
                 $smtp->bindParam(2,$valor[0],PDO::PARAM_STR); // rut
                 $smtp->bindParam(3,$valor[1],PDO::PARAM_STR); // nombre
                 $smtp->bindParam(4,$valor[2],PDO::PARAM_STR); // sociedad
                 $smtp->bindParam(5,$valor[3],PDO::PARAM_INT); // fec. ing
                 $smtp->bindParam(6,$valor[4],PDO::PARAM_INT); // fec. salida
                 $smtp->bindParam(7,$valor[5],PDO::PARAM_STR); // sucursal
                 $smtp->bindParam(8,$valor[6],PDO::PARAM_STR); // nombre sucursal
                 $smtp->bindParam(9,$valor[7],PDO::PARAM_STR); // unidad
                 $smtp->bindParam(10,$valor[8],PDO::PARAM_STR); // nombre unidad
                 $smtp->bindParam(11,$valor[9],PDO::PARAM_STR); // ceco
                 $smtp->bindParam(12,$valor[10],PDO::PARAM_STR); // cargo
                 $smtp->bindParam(13,$valor[11],PDO::PARAM_STR); // nombre cargo
                 $smtp->bindParam(14,$valor[12],PDO::PARAM_STR); // categoria
                 $smtp->bindParam(15,$valor[13],PDO::PARAM_STR); //nombre_ cat
                 $smtp->bindParam(16,$valor[15],PDO::PARAM_STR); // tipo contrato
                 $smtp->bindParam(17,$valor[16],PDO::PARAM_STR); // num. convenio
                 $smtp->bindParam(18,$valor[17],PDO::PARAM_STR); // usuario
                 
                 $smtp->bindParam(19,$valor[18],PDO::PARAM_INT); // idfaena
                 $smtp->bindParam(20,$valor[19],PDO::PARAM_INT); // idconvenio
                 
                 
                 
                 
                 //echo $smtp->debugDumpParams();
                 
                 $smtp->execute(); 
          }
         
       //return $datos;
   }
   
   public function getDatosNominaPeriodo($periodo){
           $smtp=$this->_cnl->query("select a.idfaena,a.idconvenio,a.rut,a.nombre,convert(varchar,a.fecha_ingreso,103) as fecha_ingreso,convert(varchar,a.fecha_retiro,103) as fecha_retiro,"
                                    ."a.sucursal,a.nombre_sucursal,a.cargo,a.nombre_cargo,a.numero_convenio,a.centro_costo,b.nombre_convenio_kcc FROM Nomina_Personal_Mes a  "
                                    ."left join convenios_faena b on a.idconvenio=b.idconvenio "
                                    . "where a.periodo='$periodo' order by a.idfaena,a.nombre ;");  
           //echo $smtp->debugDumpParams();
   return $smtp->fetchAll();
       
       
       
   }
   
   public function grabaHistorialCarga($usuario,$archivo,$periodo){
          $smtp=$this->_cnl->prepare("insert into Historial_Carga "
                                     . "(usuario,nombre_archivo,fecha_carga,periodo)"
                                     . "values(?,?,getdate(),?) ;");
           $smtp->bindParam(1,$usuario,PDO::PARAM_STR); // usuario
           $smtp->bindParam(2,$archivo,PDO::PARAM_STR); // archivo
           $smtp->bindParam(3,$periodo,PDO::PARAM_STR); // periodo
           
           $smtp->execute(); 
       
   }
   
   
   public function ultimaCarga($periodo,$mes){
          $zperiodo=$periodo.$mes;
          $smtp=$this->_cnl->query("select top 1 convert(varchar,fecha_carga,103) as fecha,convert(varchar,fecha_carga,108) as hora "
                                   . " from historial_carga where periodo='$zperiodo' order by fecha_carga desc; ");
           
       return $smtp->fetchAll();
   }
   
   
   public function getCecosPeriodo($periodo){
          $smtp=$this->_cnl->query("select distinct(centro_costo) from Nomina_Personal_Mes where periodo='$periodo' ; ");
          return $smtp->fetchAll();
       
   }
   
   public function grabaFaena($periodo,$ceco,$idfaena){
          $smtp=$this->_cnl->prepare("update Nomina_Personal_Mes "
                                    ." set idfaena=$idfaena "
                                    ." where periodo='$periodo' and centro_costo='$ceco'; ");
          $smtp->execute(); 
                  
   }
   
   
   public function getDatosConvenio($periodo){
          $smtp=$this->_cnl->query("select distinct(idfaena),numero_convenio from Nomina_Personal_Mes where periodo='$periodo' ");
           return $smtp->fetchAll();
       
   }
   
   public function setConvenioNomina($periodo,$idfaena,$convenio,$id){
           $smtp=$this->_cnl->prepare("update Nomina_Personal_Mes "
                                      . " set idconvenio=$id "
                                      . " where periodo='$periodo' and idfaena=$idfaena and numero_convenio='$convenio'" );
           $smtp->execute();
       
   }
 
 
   public function grabaParametro($datos){
           //var_dump($datos);
           foreach($datos as $xdatos=>$valor){
                  $smtp=$this->_cnl->prepare("insert into parametros_kpi "
                                             ."(nombre_parametro,clave,nombre_variable,usuario,fecha_cambio)"
                                             ."values(?,?,?,?,getdate() ); ");
                  
                  $smtp->bindParam(1,$valor[0],PDO::PARAM_STR); // nombre
                  $smtp->bindParam(2,$valor[1],PDO::PARAM_STR); // clave
                  $smtp->bindParam(3,$valor[2],PDO::PARAM_STR); // variable
                  $smtp->bindParam(4,$valor[3],PDO::PARAM_STR); // usuario
                  //echo $smtp->debugDumpParams();
                  
                  $smtp->execute();
           }
       
       
   }
   
   
   public function revisaDatosParametro($clave,$var){
          $smtp=$this->_cnl->query("select idparametro from parametros_kpi where clave='$clave' or nombre_variable='$var' ;");
          $resul=$smtp->fetch(PDO::FETCH_ASSOC);
          if ($resul["idparametro"]>0)
              return '1';
          else
              return '0';  
       
       
   }
   
   public function getParametros(){
          $smtp=$this->_cnl->query("select * from parametros_kpi order by idparametro ;");
          return $smtp->fetchAll();
   }
   
}
