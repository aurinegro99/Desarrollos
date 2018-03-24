<?php
Class Usuarioamazon{
    
    // Base Amazon
    
   /* 
    private $_hosta="kcclbd12des";
    private $_dba="DB_Informe_Gestion";
    private $_usa="contrato";
    private $_pasa="contrato";
    
    */
    

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
    
    // otras
    
    public function getComparaFechas($inicio,$termino){
        
        $smtp=$this->_cna->prepare("select datediff(dd, convert(datetime,?,103),convert(datetime,?,103)) as dias ;");
        $smtp->bindParam(1,$inicio,PDO::PARAM_STR);
        $smtp->bindParam(2,$termino,PDO::PARAM_STR);
        $smtp->execute();
        $resul=$smtp->fetch(PDO::FETCH_ASSOC);
        return $resul["dias"];
        
    }
    
    
    // spp
    
    

    public function getAmazon(){
            
        // obtener todos los usarios de amazon 
        $smtp=$this->_cna->query("select usuario,Nombre_Usuario,mail_usuario,rut_usuario,usuario as accion from usuarios_informe ;");
        
        return $smtp->fetchAll();
        
    }
    
    
    public function getDatosUsuario($usuario){
        
        $xusuario="KCCL".chr(92).$usuario;
        $smtp=$this->_cna->query("select nombre_usuario,mail_usuario,rut_usuario,activo,usuario FROM usuarios_informe where usuario='$xusuario'");
        
        return $smtp->fetchAll();
    }
    
    
    public function setDatosUsario($datos){
        
        foreach($datos as $valor){
               $smtp=$this->_cna->query("update usuarios_informe 
                                         set nombre_usuario='$valor[1]',mail_usuario='$valor[2]',rut_usuario='$valor[3]',activo='$valor[4]',fecha_modificacion=getdate() 
                                         where usuario='$valor[0]' ;");
               
               //echo $smtp->debugDumpParams();
               
               $resul=$smtp->execute();                  

            
        }
        
    }
    
    public function setNewUsuario($datos){
        foreach($datos as $valor){
               $smtp=$this->_cna->query("insert into usuarios_informe 
                                         (usuario,nombre_usuario,mail_usuario,rut_usuario,activo,fecha_modificacion) 
                                         values('$valor[0]]','$valor[1]','$valor[2]','$valor[3]','$valor[4]',getdate()) ;");
                $resul=$smtp->execute();                  

            
        }
        
    }
    
    
    public function getUsuarioDup($id,$rut,$email){
        $sw=1;
        // reviso la U
        //$xusuario="KCCL".chr(92).$id;
        $smtp=$this->_cna->query("select count(*) as cuenta from Usuarios_Informe where usuario='$id' ;");
        $resul=$smtp->fetch(PDO::FETCH_ASSOC);
        if ($resul["cuenta"]>0)
           $sw=5;
        else
        {
            // reviso correo
            $smtp=$this->_cna->query("select count(*) as cuenta from Usuarios_Informe where mail_usuario='$email' ;");
            $resul=$smtp->fetch(PDO::FETCH_ASSOC);
            if ($resul["cuenta"]>0)
                $sw=6;
            else
            {
                // reviso rut
                $smtp=$this->_cna->query("select count(*) as cuenta from Usuarios_Informe where rut_usuario='$rut' ;");
                $resul=$smtp->fetch(PDO::FETCH_ASSOC);
                if ($resul["cuenta"]>0)
                    $sw=7;
                
            }
            
        }
        // reviso correo
        
        // reviso rut
        
        return $sw;
        
        
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
    
    
    public function getDimFaenas(){
           $smtp=$this->_cna->query("select idfaena,nombre_faena from dim_faenas where idunidad=2  order by nombre_faena");
        return $smtp->fetchAll();
        
    }
    
    
    
    // presupuesto y consumo
    
    
    public function getFaenasPCP(){
        
        $smtp=$this->_cna->query("select idfaena,nombre_faena from presupuesto.dbo.faenas where activa='A' order by nombre_faena");
        return $smtp->fetchAll();
    }
    
    public function getFaenaModelo($idfaena){
        $smtp=$this->_cna->query("select a.idmodelo,c.nombre_tipo from presupuesto.dbo.Faenas_Modelo a 
                                  left join presupuesto.dbo.modelo_equipo b on a.idmodelo=b.idmodelo
                                  left join presupuesto.dbo.tipo_equipo c on b.idtipo=c.idtipo
                                   where a.idfaena=$idfaena");
        return $smtp->fetchAll();
        
    }
     
    public function getClasificacionFaena($idfaena,$idcontrato){
        $smtp=$this->_cna->query("select idclasifica,descripcion from consumos.dbo.clasificacion_contrato where idfaena=$idfaena and idcontrato=$idcontrato and activa='S'");
        return $smtp->fetchAll();
        
    }	 
    
    
    public function getClasificacionRepuesto($idfaena){
        $smtp=$this->_cna->query("select b.numero_contrato,a.descripcion,a.moneda_pago,a.activa,a.idclasifica as accion  from consumos.dbo.clasificacion_contrato a 
                                  left join estado_pago.dbo.estado_pago_faena b on a.idcontrato=b.idestado
                                  where a.idfaena=$idfaena order by a.activa desc ;");
        return $smtp->fetchAll();
        
    }	 
    
    
    
    public function setNuevoContrato($data){
           foreach($data as $valor){
               $smtp=$this->_cna->prepare("insert into estado_pago.dbo.estado_pago_faena 
                                         (idfaena,numero_contrato,descripcion_trabajo,empresa_mandante,inicio_contrato,fecha_termino,vigente) 
                                         values(?,?,?,?,convert(datetime,?,103),convert(datetime,?,103),?) ;");
               $smtp->bindParam(1,$valor[1],PDO::PARAM_INT);
               $smtp->bindParam(2,$valor[2],PDO::PARAM_STR);
               $smtp->bindParam(3,$valor[3],PDO::PARAM_STR);
               $smtp->bindParam(4,$valor[4],PDO::PARAM_STR);
               $smtp->bindParam(5,$valor[5],PDO::PARAM_STR);
               $smtp->bindParam(6,$valor[6],PDO::PARAM_STR);
               $smtp->bindParam(7,$valor[7],PDO::PARAM_STR);
               
               //echo $smtp->debugDumpParams();
               
               $resul=$smtp->execute();                  
        }    
        
    }
    
    public function setModificaContrato($data){
           foreach($data as $valor){
               $smtp=$this->_cna->query("update estado_pago.dbo.estado_pago_faena 
                                         set numero_contrato='$valor[2]',descripcion_trabajo='$valor[3]',empresa_mandante='$valor[4]',inicio_contrato=convert(datetime,'$valor[5]',103),fecha_termino=convert(datetime,'$valor[6]',103),vigente='$valor[7]'
                                         where idestado=$valor[0] ; ");
               
               $resul=$smtp->execute();                  

            
        }    
        
    }
    
    public function getContratoFaena($idfaena){
            $smtp=$this->_cna->query("select numero_contrato,descripcion_trabajo,empresa_mandante,convert(varchar(10),inicio_contrato,103) as inicio,convert(varchar(10),fecha_termino,103) as termino,vigente,idestado as accion
            from estado_pago.dbo.estado_pago_faena where idfaena=$idfaena order by idestado ;");
            return $smtp->fetchAll();
    }
    
    public function getDatosContrato($idcontrato){
            $smtp=$this->_cna->query("select numero_contrato,descripcion_trabajo,empresa_mandante,convert(varchar(10),inicio_contrato,103) as inicio,convert(varchar(10),fecha_termino,103) as termino,vigente,idestado
            from estado_pago.dbo.estado_pago_faena where idestado=$idcontrato ;");
            return $smtp->fetchAll();
    }
    
    public function getDatosContratoActivos($idfaena){
            $smtp=$this->_cna->query("select idestado,numero_contrato,descripcion_trabajo
            from estado_pago.dbo.estado_pago_faena where idfaena=$idfaena and vigente='S' ;");
            return $smtp->fetchAll();
    }
    
    public function setNuevaClasificacion($data){
           foreach($data as $valor){
               $smtp=$this->_cna->prepare("insert into consumos.dbo.clasificacion_contrato 
                                         (idfaena,descripcion,activa,idcontrato,moneda_pago) 
                                          values(?,?,?,?,?) ;");
               
               
               $smtp->bindParam(1,$valor[1],PDO::PARAM_INT);  // idfaena
               $smtp->bindParam(2,$valor[3],PDO::PARAM_STR);   // descrip
               $smtp->bindParam(3,$valor[5],PDO::PARAM_STR);  // activa
               $smtp->bindParam(4,$valor[2],PDO::PARAM_INT);  // idcontrato
               $smtp->bindParam(5,$valor[4],PDO::PARAM_STR);   // moneda
               
               //echo $smtp->debugDumpParams();
               
               $resul=$smtp->execute();                  
        }    
    }
    
    public function setClasificacion($data){
           foreach($data as $valor){
            $smtp=$this->_cna->prepare("update consumos.dbo.clasificacion_contrato 
                                    set idfaena=$valor[1],descripcion='$valor[3]',activa='$valor[5]',idcontrato=$valor[2],moneda_pago='$valor[4]' 
                                    where idclasifica=$valor[0] ;");
                              //echo $smtp->debugDumpParams();
               
            $resul=$smtp->execute();                  
        }    
    }
    
    public function getDatosClasficacion($id){
           $smtp=$this->_cna->query("select descripcion,activa,idcontrato,moneda_pago,idclasifica
            from consumos.dbo.clasificacion_contrato where idclasifica=$id ;");
            return $smtp->fetchAll();
        
    } 
    
    
    public function getParametrosConsumo($idfaena,$idcontrato){
           $smtp=$this->_cna->prepare("select aprobar,tipo_aprobar,aprobado,convert(varchar(10),inicio_vigencia,103) as inicio,convert(varchar(10),termino_vigencia,103) as termino,ciclos,planificada from consumos.contrato.parametros_faena where idfaena=? and idcontrato=? ;");
           $smtp->bindParam(1,$idfaena,PDO::PARAM_INT);  // idfaena
           $smtp->bindParam(2,$idcontrato,PDO::PARAM_INT);   // idcontrato
           $smtp->execute();  
           return $smtp->fetchAll();                              
        
    }
    
    public function setParametrosFaena($data){
            $sw=0;
            foreach($data as $valor){
                $sw=$this->getComparaFechas($valor[0],$valor[1]);
                if ($sw>=0){
                   // eliminar
                    $smtp=$this->_cna->prepare("delete from Consumos.contrato.parametros_faena where idfaena=? and idcontrato=?  ;");
                    $smtp->bindParam(1,$valor[2],PDO::PARAM_INT);  // idfaena
                    $smtp->bindParam(2,$valor[3],PDO::PARAM_INT);   // idcontrato
                    $smtp->execute();
                    // grabar    
                    $smtp=$this->_cna->prepare("insert into Consumos.contrato.parametros_faena                      (idfaena,visualizar,ciclos,aprobar,tipo_aprobar,aprobado,usuario_modificacion,fecha_modificacion,inicio_vigencia,termino_vigencia,idcontrato,planificada)
                     values(?,1,?,?,?,?,?,getdate(),convert(datetime,?,103),convert(datetime,?,103),?,?) ;");
                    $smtp->bindParam(1,$valor[2],PDO::PARAM_INT);  // idfaena
                    $smtp->bindParam(2,$valor[4],PDO::PARAM_INT);   // ciclos
                    $smtp->bindParam(3,$valor[5],PDO::PARAM_STR);   // aprobar
                    $smtp->bindParam(4,$valor[6],PDO::PARAM_INT);   // tipo_aprobar
                    $smtp->bindParam(5,$valor[7],PDO::PARAM_STR);   // aprobado
                    $smtp->bindParam(6,$valor[8],PDO::PARAM_STR);   // usuario
                    $smtp->bindParam(7,$valor[0],PDO::PARAM_STR);   // inicio
                    $smtp->bindParam(8,$valor[1],PDO::PARAM_STR);   // termino
                    $smtp->bindParam(9,$valor[3],PDO::PARAM_INT);   // idcontrato
                    $smtp->bindParam(10,$valor[9],PDO::PARAM_INT);   // planificado
                    $smtp->execute();   
                       
                  
                }
           }
        return $sw;
        
    }
    
    
    public function  getParametrosVisualizacion($idfaena,$idc){
              $smtp=$this->_cna->prepare("select parametros,correlativo as editar,correlativo as borrar from consumos.contrato.parametros_varios where idfaena=? and idcontrato=? order by correlativo;");
               $smtp->bindParam(1,$idfaena,PDO::PARAM_INT);
               $smtp->bindParam(2,$idc,PDO::PARAM_INT);
               $smtp->execute();  
           return $smtp->fetchAll();
        
    }
    
    public function setDatosVisualizacion($data){
           foreach($data as $valor){
                    $smtp=$this->_cna->prepare("insert into Consumos.contrato.parametros_varios                      (tipo,idfaena,idcontrato,parametros,usuario,fecha_ingreso)
                     values(1,?,?,?,?,getdate()) ;");
                    $smtp->bindParam(1,$valor[2],PDO::PARAM_INT);  // faena
                    $smtp->bindParam(2,$valor[3],PDO::PARAM_INT);  // contrato
                    $smtp->bindParam(3,$valor[1],PDO::PARAM_STR);  // datos
                    $smtp->bindParam(4,$valor[4],PDO::PARAM_STR);  // usuario
                    $smtp->execute(); 
               
           }
        
    }
    
    
    public function modificaDatosVisualizacion($data){
           foreach($data as $valor){
                    $smtp=$this->_cna->prepare("update Consumos.contrato.parametros_varios
                                                set parametros=?,usuario=?,fecha_ingreso=getdate()
                                               where correlativo=? ;");
                    $smtp->bindParam(1,$valor[1],PDO::PARAM_STR);  // datos
                    $smtp->bindParam(2,$valor[4],PDO::PARAM_STR);  // usuario
                    $smtp->bindParam(3,$valor[0],PDO::PARAM_INT);  // correlativo
                    $smtp->execute(); 
               
           }
        
    }
    
    public function borrarParamatrosVisualiza($id){
            $smtp=$this->_cna->prepare("delete from  Consumos.contrato.parametros_varios
                                        where correlativo=? ;");
            $smtp->bindParam(1,$id,PDO::PARAM_INT);  // correlativo
            $smtp->execute();  
        
    }
    
    public function getParametrosVisualizar($id){
           $smtp=$this->_cna->prepare("select parametros from  Consumos.contrato.parametros_varios
                                        where correlativo=? ;");
            $smtp->bindParam(1,$id,PDO::PARAM_INT);  // correlativo
            $smtp->execute(); 
            return $smtp->fetchAll(); 
        
        
        
    }
    
    
    public function getHistorialCarga(){
           $smtp=$this->_cna->query("select convert(varchar(10),fecha_orden,103) as fecha,clase_orden,count(*) as cantidad from                      consumos.dbo.cabecera_ordenes 
           where (fecha_orden>=getdate()-10 and fecha_orden<=getdate()-1)
           group by fecha_orden,clase_orden
           order by fecha desc,clase_orden asc ;");
           return $smtp->fetchAll();
        
    }
    
    public function getUltimoIngreso(){
            $smtp=$this->_cna->query("select top 1 convert(varchar(10),fecha_orden+1,103) as fecha from consumos.dbo.cabecera_ordenes 
           order by fecha_orden desc ;");
           $resul=$smtp->fetch(PDO::FETCH_ASSOC);
                        
        return $resul["fecha"];
           
        
    }
    
    public function grabarCabeceraOs($inicio,$termino){
           $reg=0;
           // traer datos paso OS
           $smtpaso=$this->_cna->prepare("select clase_orden,numero_orden,equipo,texto_orden,fecha_orden,clase_actividad,cebe,centro_emplazamiento
           from paso_cabecera_ordenes where (convert(datetime,fecha_orden,103)>=convert(datetime,?,103) and
           convert(datetime,fecha_orden,103)<=convert(datetime,?,103))  order by fecha_orden ; ");
           $smtpaso->bindParam(1,$inicio,PDO::PARAM_INT);  // inicio
           $smtpaso->bindParam(2,$termino,PDO::PARAM_INT);  // termino
           $smtpaso->execute();
           $xlistado=$smtpaso->fetchAll();
           foreach($xlistado as $datos){
                   // borrar dato en base
                   $smtp=$this->_cna->prepare("delete from consumos.dbo.cabecera_ordenes where clase_orden=? and numero_orden=? ; ");
                   $smtp->bindParam(1,$datos["clase_orden"],PDO::PARAM_STR);
                   $smtp->bindParam(2,$datos["numero_orden"],PDO::PARAM_INT);
                   $smtp->execute();
                   // grabar dato en basename
                   $smtp=$this->_cna->prepare("insert into consumos.dbo.cabecera_ordenes
                                             (clase_orden,numero_orden,equipo,texto_orden,fecha_orden,clase_actividad,cebe,centro_emplazamiento)
                                             values(?,?,?,?,convert(datetime,?,103),?,?,?) ;");
                   $smtp->bindParam(1,$datos["clase_orden"],PDO::PARAM_STR);
                   $smtp->bindParam(2,$datos["numero_orden"],PDO::PARAM_INT);
                   $smtp->bindParam(3,$datos["equipo"],PDO::PARAM_STR);
                   $smtp->bindParam(4,$datos["texto_orden"],PDO::PARAM_STR);
                   $smtp->bindParam(5,$datos["fecha_orden"],PDO::PARAM_STR);
                   $smtp->bindParam(6,$datos["clase_actividad"],PDO::PARAM_STR);
                   $smtp->bindParam(7,$datos["cebe"],PDO::PARAM_STR);
                   $smtp->bindParam(8,$datos["centro_emplazamiento"],PDO::PARAM_STR);
                   $smtp->execute();
                   $reg++;    
           }
       
           // borrar datos paso
           $smtp=$this->_cna->prepare("delete from  paso_cabecera_ordenes where (convert(datetime,fecha_orden,103)>=convert(datetime,?,103) and
           convert(datetime,fecha_orden,103)<=convert(datetime,?,103))");
           $smtpaso->bindParam(1,$inicio,PDO::PARAM_INT);  // inicio
           $smtpaso->bindParam(2,$termino,PDO::PARAM_INT);  // termino
           $smtpaso->execute();
        
           return $reg;
        
        
    }
    
    
    public function getTipoEquipoFaena($idfaena){
           $smtp=$this->_cna->prepare("select a.idtipo,b.descripcion from Lista_Precios.dbo.Faenas_TipoEquipo a 
                                       left join Lista_Precios.dbo.Tipo_Equipo b on a.idtipo=b.idtipo
                                       where a.idfaena=? ;");
           $smtp->bindParam(1,$idfaena,PDO::PARAM_INT);  // inicio
           $smtp->execute(); 
         return $smtp->fetchAll();
        
    }
        
        
    
                                      
  
    // base equipos
    
    public function getEquipoSerie($modelo,$serie,$id){
        $sw=0;
        if ($id==0){
           $smtp=$this->_cna->prepare("select idequipo from base_equipos.dbo.tabla_equipos where idmodelo=? and numero_serie=? ;");
           $smtp->bindParam(1,$modelo,PDO::PARAM_STR);
           $smtp->bindParam(2,$serie,PDO::PARAM_STR);
        }
        else{
            $smtp=$this->_cna->prepare("select idequipo from base_equipos.dbo.tabla_equipos where idmodelo=? and numero_serie=? and idequipo<>? ;");
           $smtp->bindParam(1,$modelo,PDO::PARAM_STR);
           $smtp->bindParam(2,$serie,PDO::PARAM_STR);
            $smtp->bindParam(3,$id,PDO::PARAM_INT);
            
        }   
        //echo $modelo.' '.$serie.' '.$id.' '. $smtp->debugDumpParams();
        $smtp->execute();
        $resul=$smtp->fetch(PDO::FETCH_ASSOC);
                        
        return $resul["idequipo"];
    }
    
    public function getTipoEquipo($idequipo){
           $smtp=$this->_cna->prepare("select tipo_equipo from base_equipos.dbo.tabla_equipos where idequipo=? ;");
           $smtp->bindParam(1,$idequipo,PDO::PARAM_INT);
           $smtp->execute();
           $resul=$smtp->fetch(PDO::FETCH_ASSOC);
                  
           return $resul["tipo_equipo"];
    }
    
    
    public function getEquipoSap($sap,$id){
        $sw=0;
        if ($id==0){
           $smtp=$this->_cna->prepare("select idequipo from base_equipos.dbo.tabla_equipos where numero_sap=?  ;");
           $smtp->bindParam(1,$sap,PDO::PARAM_STR);
        }
        else{
            $smtp=$this->_cna->prepare("select idequipo from base_equipos.dbo.tabla_equipos where numero_sap=? and idequipo<>? ;");
            $smtp->bindParam(1,$sap,PDO::PARAM_STR);
            $smtp->bindParam(2,$id,PDO::PARAM_INT);
            
        }
        //echo $smtp->debugDumpParams();
        $smtp->execute();
        $resul=$smtp->fetch(PDO::FETCH_ASSOC);
        return $resul["idequipo"];
    }
    
    
    public function getTipoEquipoConsumo(){
           $smtp=$this->_cna->query("select idtipo,nombre_01 from base_equipos.dbo.tipo_equipo_consumo order by nombre_01 ;");
            return $smtp->fetchAll(); 
        
    }
    
    
    public function getModeloTipo($id){
        
           $smtp=$this->_cna->query("select idmodelo,idmodelo as accion from base_equipos.dbo.modelo_equipo where idtipo=$id order by idmodelo ;");
            return $smtp->fetchAll(); 
    }
    
    public function grabarModelo($data){
           foreach($data as $valor){
               // elimino
               $smtp=$this->_cna->query("delete from  base_equipos.dbo.modelo_equipo where idmodelo='$valor[1]' and idtipo=$valor[0] ;");
               $resul=$smtp->execute();                  
               // grabo
               
               $smtp=$this->_cna->prepare("insert into base_equipos.dbo.modelo_equipo 
                                         (idtipo,idmodelo) 
                                          values(?,?) ;");
               
               $smtp->bindParam(1,$valor[0],PDO::PARAM_INT);  // idfaena
               $smtp->bindParam(2,$valor[1],PDO::PARAM_STR);   // descrip
               
               $resul=$smtp->execute();                  
        }    
        
    }
    
    
    public function getClientes(){
        
           $smtp=$this->_cna->query("select idcliente,nombre_cliente from base_equipos.dbo.maestro_clientes order by nombre_cliente ;");
            return $smtp->fetchAll(); 
    }
    
    
    public function getStatus(){
        
            $smtp=$this->_cna->query("select idstatus,nombre_status from base_equipos.dbo.maestro_status  where tipo_status=1 order by idstatus ;");
            return $smtp->fetchAll(); 
    }
    
    
    public function getEquiposTipo($id){
            $smtp=$this->_cna->query(" select a.idmodelo,a.numero_serie,a.numero_sap,f.nombre_cliente,e.nombre_ubicacion,d.nombre_status,a.idequipo as accion from                      Base_Equipos.dbo.tabla_equipos a 
                                       left join base_equipos.dbo.modelo_equipo b on a.idmodelo=b.idmodelo
                                       left join base_equipos.dbo.tipo_equipo c on b.idtipo=c.idtipo
                                       left join Base_Equipos.dbo.Maestro_Status d on a.status_operativo=d.idstatus
                                       left join Base_Equipos.dbo.Cliente_Ubicacion e on a.idclte_ubicacion=e.idclte_ubicacion
                                       left join Base_Equipos.dbo.maestro_clientes f on e.idcliente=f.idcliente
                                       where c.idtipo=$id  order by idmodelo,Numero_Serie ;");
            return $smtp->fetchAll(); 
        
    }
    
    public function getUbicacionCliente($id){
        
           $smtp=$this->_cna->query("select idclte_ubicacion,nombre_ubicacion from Base_Equipos.dbo.cliente_ubicacion where idCliente=$id order by nombre_ubicacion ;");
            return $smtp->fetchAll(); 
    }
    
    
    public function grabarEquipo($data){
           $sw=0;
           foreach($data as $valor){
               // revisar serie y modelo
               $sw=$this->getEquipoSerie($valor[1],$valor[2],0);
               // revisar numero sap
               if ($sw<=0){
                    $sw=$this->getEquipoSap($valor[3],0);       
                    if ($sw<=0){
                       $smtp=$this->_cna->prepare('insert into base_equipos.dbo.tabla_equipos  '
                       .'(idmodelo,numero_serie,numero_sap,fabricante,procedencia,año_fabricacion,status_operativo,idclte_ubicacion,fecha_creacion,tipo_equipo)  '
                       .' values(?,?,?,?,?,?,?,?,getdate(),?);  ');
                       $smtp->bindParam(1,$valor[1],PDO::PARAM_STR);  // modelo
                       $smtp->bindParam(2,$valor[2],PDO::PARAM_STR);  // serie
                       $smtp->bindParam(3,$valor[3],PDO::PARAM_STR);  // sap
                       $smtp->bindParam(4,$valor[4],PDO::PARAM_STR);  // fabricante
                       $smtp->bindParam(5,$valor[5],PDO::PARAM_STR);  // procedencia
                       $smtp->bindParam(6,$valor[6],PDO::PARAM_INT);  // fabricacion
                       $smtp->bindParam(7,$valor[8],PDO::PARAM_INT);  // status
                       $smtp->bindParam(8,$valor[7],PDO::PARAM_INT);  // idclte_ubicacion
                       $smtp->bindParam(9,$valor[9],PDO::PARAM_INT);  // tipo_equipo
                      //echo $smtp->debugDumpParams();
                   
                       $smtp->execute();
                       $sw=0;    
                    }
               }       
               
           }
        
        return $sw;
        
    }
    
    
    public function modificaEquipo($data){
           $sw=0;
           
           foreach($data as $valor){
               // revisar serie y modelo
               $sw=$this->getEquipoSerie($valor[1],$valor[2],$valor[0]);
               // revisar numero sap
               if ($sw<=0){
                    $sw=$this->getEquipoSap($valor[3],$valor[0]);       
                    if ($sw<=0){    
                       $smtp=$this->_cna->prepare("update base_equipos.dbo.tabla_equipos 
                                      set idmodelo=?,numero_serie=?,numero_sap=?,fabricante=?,procedencia=?,año_fabricacion=?,status_operativo=?,idclte_ubicacion=?,tipo_equipo=?
                                      where idequipo=?");
                       $smtp->bindParam(1,$valor[1],PDO::PARAM_STR);  // modelo
                       $smtp->bindParam(2,$valor[2],PDO::PARAM_STR);  // serie
                       $smtp->bindParam(3,$valor[3],PDO::PARAM_STR);  // sap
                       $smtp->bindParam(4,$valor[4],PDO::PARAM_STR);  // fabricante
                       $smtp->bindParam(5,$valor[5],PDO::PARAM_STR);  // procedencia
                       $smtp->bindParam(6,$valor[6],PDO::PARAM_INT);  // fabricacion
                       $smtp->bindParam(7,$valor[8],PDO::PARAM_INT);  // status
                       $smtp->bindParam(8,$valor[7],PDO::PARAM_INT);  // idclte_ubicacion
                       $smtp->bindParam(9,$valor[9],PDO::PARAM_INT);  // tipo_equipo
                       $smtp->bindParam(10,$valor[0],PDO::PARAM_INT);  // idequipo
                    
                       $smtp->execute();
                       $sw=0;
                    }
               }
           }
        return $sw;
    }
    
    public function getDatosEquipo($id){
           $smtp=$this->_cna->query("select a.idequipo,a.idmodelo,a.numero_serie,a.numero_sap,a.fabricante,a.procedencia,a.año_fabricacion as fabricacion,a.status_operativo,a.idclte_ubicacion,b.idcliente,a.tipo_equipo from base_equipos.dbo.tabla_equipos a 
           left join base_equipos.dbo.cliente_ubicacion b on a.idclte_ubicacion=b.idclte_ubicacion
           where a.idequipo=$id  ;");
          
        
            return $smtp->fetchAll(); 
        
    }
    
    public function getEquiposOperativos($idfaena){
           $smtp=$this->_cna->query("select b.idmodelo,b.numero_serie,b.numero_sap,a.numero_interno,convert(varchar(10),a.fecha_inicio,103) as fecha_inicio,a.horometro_inicio,a.idequipo as editar, a.idequipo as borrar
           from Base_Equipos.dbo.operaciones_equipo a 
left join Base_Equipos.dbo.tabla_equipos b on a.idequipo=b.idequipo
where a.idfaena=$idfaena order by b.idmodelo,a.Numero_Interno, a.Fecha_Inicio  ;");
          
        
            return $smtp->fetchAll();
        
    }
     
    
    public function getSerieEquipos($idmodelo,$tipo){
        
            if ($tipo==0)
                $cadena=" and status_operativo > 0 ";
            else
                $cadena=" and status_operativo < $tipo ";
           
            $smtp=$this->_cna->query("select numero_serie,idequipo from Base_Equipos.dbo.tabla_equipos where idmodelo='$idmodelo' ".$cadena." order by numero_serie");
        
       // echo $smtp->debugDumpParams();
        return $smtp->fetchAll();
        
    }
    
   

    public function getEquipoInterno($idfaena,$idequipo,$interno){
          
         /*  if ($interno==0)    {
               $smtp=$this->_cna->prepare("select idequipo from base_equipos.dbo.operaciones_equipo where idfaena=? and numero_interno=? and operativo='S' ;");
               $smtp->bindParam(1,$idfaena,PDO::PARAM_INT);  // faenas
               $smtp->bindParam(2,$interno,PDO::PARAM_STR);   // equipo
               }
        
           else { */ 
              $smtp=$this->_cna->prepare("select idequipo from base_equipos.dbo.operaciones_equipo where idfaena=? and numero_interno=? and idequipo<>? and operativo='S' ;");
              $smtp->bindParam(1,$idfaena,PDO::PARAM_INT);  // faenas
              $smtp->bindParam(2,$interno,PDO::PARAM_STR);   // equipo
              $smtp->bindParam(3,$idequipo,PDO::PARAM_INT);   // equipo
             //  echo $smtp->debugDumpParams();
           
           $smtp->execute();
           $resul=$smtp->fetch(PDO::FETCH_ASSOC);
           $sw=$resul["idequipo"];            
           return $sw;
        
        
    }
    
    
    public function getDatosOperacionEquipo($id,$idfaena){
            $smtp=$this->_cna->prepare("select convert(varchar(10),a.fecha_inicio,103) as fecha,a.horometro_inicio,a.numero_interno,b.idmodelo,b.numero_serie,c.idtipo,a.idequipo from base_equipos.dbo.operaciones_equipo a 
            left join base_equipos.dbo.tabla_equipos b on a.idequipo=b.idequipo
            left join base_equipos.dbo.modelo_equipo c on b.idmodelo=c.idmodelo
           
            where a.idequipo=? and a.idfaena=? ;");
            $smtp->bindParam(1,$id,PDO::PARAM_INT);  // faenas
            $smtp->bindParam(2,$idfaena,PDO::PARAM_INT);   // equipo
            $smtp->execute();
         return $smtp->fetchAll();
    }
    
   
    public function grabaOperacionEquipo($data){
            $sw=0;
            $xtipo=0;
            $xpara='S';
            foreach($data as $valor){
                    $xtipo=$this->getTipoEquipo($valor[1]);
                    if ($xtipo==1)
                        $sw=$this->getEquipoInterno($valor[0],$valor[1],$valor[2]);
                    else 
                        $xpara='X'; 
                    if ($sw<=0){
                        $smtp=$this->_cna->prepare("insert into base_equipos.dbo.operaciones_equipo
                                                (idfaena,idequipo,fecha_inicio,horometro_inicio,idcontrato,numero_interno,operativo,usuario,fecha_creacion)
                                                values(?,?,convert(datetime,?,103),?,0,?,?,?,getdate()) ;");
                        $smtp->bindParam(1,$valor[0],PDO::PARAM_INT);  // faenas
                        $smtp->bindParam(2,$valor[1],PDO::PARAM_INT);   // equipo
                        $smtp->bindParam(3,$valor[4],PDO::PARAM_STR);  // fecha  
                        $smtp->bindParam(4,$valor[3],PDO::PARAM_INT);   // horometro  
                        $smtp->bindParam(5,$valor[2],PDO::PARAM_STR);   // Nro interno equipo
                        $smtp->bindParam(6,$xpara,PDO::PARAM_STR); // tipo equipo
                        $smtp->bindParam(7,$valor[5],PDO::PARAM_STR); // usuario
                        $smtp->execute();   
                        // cambiar a status 6
                        $smtp=$this->_cna->prepare("update base_equipos.dbo.tabla_equipos
                                                set status_operativo=6
                                                where idequipo=? ;");
                        
                        $smtp->bindParam(1,$valor[1],PDO::PARAM_INT);   // equipo
                        $smtp->execute();
                        }               
                                               
        
          }    
          return $sw;
        
    }
    
    public function modificaOperacionEquipo($data){
           $sw=0;
           foreach($data as $valor){
              
                if ($this->getTipoEquipo($valor[1])==1)
                    $sw=$this->getEquipoInterno($valor[0],$valor[1],$valor[2]);
                if (($sw<=0) or ($sw='')){
                    // actualizar
                    $smtp=$this->_cna->prepare("update base_equipos.dbo.operaciones_equipo 
                                                set fecha_inicio=convert(datetime,?,103),horometro_inicio=?,numero_interno=?
                                                where idfaena=? and idequipo=? ;");
                    $smtp->bindParam(1,$valor[4],PDO::PARAM_STR);   // fecha
                    $smtp->bindParam(2,$valor[3],PDO::PARAM_INT);   // horometro
                    $smtp->bindParam(3,$valor[2],PDO::PARAM_STR);   // interno
                    $smtp->bindParam(4,$valor[0],PDO::PARAM_INT);   // faena
                    $smtp->bindParam(5,$valor[1],PDO::PARAM_INT);   // idequipo
                    $smtp->execute();
                    $sw=0;
                }
           }
            return $sw;
    }
    
    public function borrarOperacionEquipo($id,$idfaena){
            $smtp=$this->_cna->prepare("delete from  base_equipos.dbo.operaciones_equipo where idfaena=? and idequipo=? ;");
            $smtp->bindParam(1,$idfaena,PDO::PARAM_INT);  // faenas
            $smtp->bindParam(2,$id,PDO::PARAM_INT);   // equipo
            //echo $smtp->debugDumpParams();
            $smtp->execute();
        
            // cambio status
            $smtp2=$this->_cna->prepare("update base_equipos.dbo.tabla_equipos set status_operativo=5 where idequipo=? ;");
            $smtp2->bindParam(1,$id,PDO::PARAM_INT);   // equipo
            $smtp2->execute();
            return '0';
    }
    
}
        
    
    