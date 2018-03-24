<?php

/**
 * Description of AutoConsumo
 *
 * @author U1301142
 */
class AutoConsumo {
    //put your code here
   
    
    private $_hosta="kcclbd12des";
    private $_dba="Consumos";
    private $_usa="contrato";
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
        
    public function setIngresoLogin($id,$motivo){
           $smtp=$this->_cna->prepare("insert into login_usuario
                                       (idusuario,tipo,fecha_mov)
                                       values(?,?,getdate()) ;");
           $smtp->bindParam(1,$id,PDO::PARAM_INT);
           $smtp->bindParam(2,$motivo,PDO::PARAM_STR);
           $smtp->execute();
        
    }    
    public function setNuevaClaveAcceso($usuario,$clave){
           $new=md5($clave);
           $smtp=$this->_cna->prepare("update maestro_usuarios set clave=? where idusuario=? ;");
           $smtp->bindParam(1,$new,PDO::PARAM_STR);
           $smtp->bindParam(2,$usuario,PDO::PARAM_INT);
           $smtp->execute();
        
        return '0';
    }    
        
    public function getComparaFechas($inicio,$termino){
        
        $smtp=$this->_cna->prepare("select datediff(dd, convert(datetime,?,103),convert(datetime,?,103)) as dias ;");
        $smtp->bindParam(1,$inicio,PDO::PARAM_STR);
        $smtp->bindParam(2,$termino,PDO::PARAM_STR);
        $smtp->execute();
        $resul=$smtp->fetch(PDO::FETCH_ASSOC);
        return $resul["dias"];
        
    }  
    
   public function validaClave($id){
         $smtp=$this->_cna->prepare("select clave from maestro_usuarios where idusuario=? and tipo_usuario=2 and activo='S';");
         $smtp->bindParam(1,$id,PDO::PARAM_INT);
            //echo $smtp->debugDumpParams();
         $smtp->execute();
         return $smtp->fetchAll();
       
   }
    
    public function validaIngreso($usuario,$clave){
            
            $smtp=$this->_cna->prepare("select idusuario,clave,nombre_usuario,correo_electronico,nivel_usuario from maestro_usuarios where login=? and tipo_usuario=2 and activo='S';");
            $smtp->bindParam(1,$usuario,PDO::PARAM_STR);
            //echo $smtp->debugDumpParams();
            $smtp->execute();
            return $smtp->fetchAll();
           
    }   
    
    
    public function getFaenaUsuario($id){
            $smtp=$this->_cna->prepare("select a.idfaena,b.nombre_faena from usuarios_faena a 
                                        left join presupuesto.dbo.faenas b on a.idfaena=b.idfaena
                                         where a.idusuario=? order by b.nombre_faena ;");
            $smtp->bindParam(1,$id,PDO::PARAM_INT);
            $smtp->execute();
            return $smtp->fetchAll();
    }
    
    
    public function getContratoFaena($id){
           $smtp=$this->_cna->prepare("select idestado,descripcion_trabajo from estado_pago.dbo.Estado_pago_faena where idfaena=? and vigente='S' ;");
            $smtp->bindParam(1,$id,PDO::PARAM_INT);
            $smtp->execute();
            return $smtp->fetchAll();
        
    }
    
    
    public function getParametros1($id,$contrato,$inicio,$termino){
        $smtp=$this->_cna->prepare("select aprobar,tipo_aprobar,aprobado from contrato.parametros_faena where idfaena=? and idcontrato=? 
                                   and (inicio_vigencia<=convert(datetime,?,103)  and termino_vigencia>=convert(datetime,?,103)) and visualizar=1 ;");

        $smtp->bindParam(1,$id,PDO::PARAM_INT);
        $smtp->bindParam(2,$contrato,PDO::PARAM_INT);
        $smtp->bindParam(3,$inicio,PDO::PARAM_STR);
        $smtp->bindParam(4,$termino,PDO::PARAM_STR);
        $smtp->execute();
        return $smtp->fetchAll();
    }
  
    public function getParametros2($id,$contrato){
        $smtp=$this->_cna->prepare("select idfaena,parametros from contrato.parametros_varios where idfaena=? and idcontrato=? and tipo=1 order by correlativo ;");
        $smtp->bindParam(1,$id,PDO::PARAM_INT);
        $smtp->bindParam(2,$contrato,PDO::PARAM_INT);
        $smtp->execute();
        return $smtp->fetchAll();
    }
    
    public function getDatosAprobacion($data){
           foreach($data as $valor){
               
                  //echo $valor[2];
                  //echo $valor[3];
                  $query="select a.numero_orden,a.numero_interno,convert(varchar(10),a.fecha_contable,103) as fecha_contable,a.numero_parte,a.cantidad,a.idconsumo,a.docto_material,b.texto_orden,b.clase_actividad,a.precio_lista,a.factor,a.idlista,a.descuento,
                          a.ceco_cliente,a.campo_10,a.valor_pago,a.moneda_pago,d.descripcion,e.nombre_material,m.moneda
		          from consumo_ordenes a
		          left join cabecera_ordenes b on a.numero_orden=b.numero_orden 
                          left join clasificacion_contrato d on a.clasificacion_contrato=d.idclasifica 
	                  left join gestion.dbo.maestro_material e on a.numero_parte=e.material and e.idioma='S'
		          left join lista_precios.dbo.listas_precio m on a.idlista=m.idlista
                	  where (a.fecha_contable>=convert(datetime,'$valor[5]',103) and fecha_contable<=convert(datetime,'$valor[6]',103) ) 
                          and a.aprobado in ('$valor[3]') and b.clase_actividad in (".$valor[2].")  and d.idcontrato=$valor[0] and a.idfaena=$valor[1] ";
                  if ($valor[4]==0)
                      $query.=" order by a.fecha_contable,a.numero_orden,a.docto_material,a.posicion ;";
                  else
                      $query.="order by a.fecha_contable,a.docto_material,a.numero_orden,a.posicion ;";
               
               
                   //echo $query;
                  
                   $smtp=$this->_cna->query($query);
                   
                   return $smtp->fetchAll();
               
           }
    }
    
    
    public function grabaConciliaTurno($data){
       foreach ($data as $lineas){
            if (($lineas[0]=='R') and ($lineas[1]==0))
                 $query="select idconsumo from consumo_ordenes
                         where numero_orden=$lineas[2]  and aprobado='1' and cantidad>0 and (fecha_contable>=convert(datetime,'$lineas[3]',103) and fecha_contable<=convert(datetime,'$lineas[4]',103)) ;";
            if (($lineas[0]=='R') and ($lineas[1]==1))
                 $query="select idconsumo from consumo_ordenes 
                         where docto_material='$lineas[2]' and aprobado='1' and cantidad>0 and (fecha_contable>=convert(datetime,'$lineas[3]',103) and fecha_contable<=convert(datetime,'$lineas[4]',103)) ;";
            if ($lineas[0]=='D')
               $query="select idconsumo from consumo_ordenes where aprobado='1' and idconsumo=$lineas[2] ";
            $smtp=$this->_cna->query($query);
             while(list($id) = $smtp->fetch(PDO::FETCH_NUM) ){
                   // borro registro
                    $smtp2=$this->_cna->prepare("delete from registro_aprobaciones_usuario where idlinea=? and tipo_aprobacion=2 ");
	            $smtp2->bindParam(1,$id,PDO::PARAM_INT);
                    $smtp2->execute();
	   	    // grabo dato 
 	            $smtp2=$this->_cna->prepare("insert into registro_aprobaciones_usuario
                                                 (idlinea,fecha_aprobacion,usuario_aprobacion,tipo_aprobacion,ip_computador)
	                                         values(?,getdate(),?,2,?) ;");
                    $smtp2->bindParam(1,$id,PDO::PARAM_INT); //id
                    $smtp2->bindParam(2,$lineas[6],PDO::PARAM_INT); //idusuario 
                    $smtp2->bindParam(3,$lineas[5],PDO::PARAM_STR); //ip
                    $smtp2->execute();
                    
	            // actualizao base
                   $smtp2=$this->_cna->prepare("update consumo_ordenes set aprobado='2' where idconsumo=?");
	           $smtp2->bindParam(1,$id,PDO::PARAM_INT); //id
	           $smtp2->execute();
             }
        }
    }
    
    
    public function grabaAprobacionConsumo($data){
       foreach ($data as $lineas){
            if (($lineas[0]=='R') and ($lineas[1]==0))
                 $query="select idconsumo from consumo_ordenes
                         where numero_orden=$lineas[2]  and aprobado='N' and cantidad>0 and (fecha_contable>=convert(datetime,'$lineas[3]',103) and fecha_contable<=convert(datetime,'$lineas[4]',103)) ;";
            if (($lineas[0]=='R') and ($lineas[1]==1))
                 $query="select idconsumo from consumo_ordenes 
                         where docto_material='$lineas[2]' and aprobado='N' and cantidad>0 and (fecha_contable>=convert(datetime,'$lineas[3]',103) and fecha_contable<=convert(datetime,'$lineas[4]',103)) ;";
            if ($lineas[0]=='D')
               $query="select idconsumo from consumo_ordenes where aprobado='N' and idconsumo=$lineas[2] ";
            $smtp=$this->_cna->query($query);
             while(list($id) = $smtp->fetch(PDO::FETCH_NUM) ){
                   // borro registro
                    $smtp2=$this->_cna->prepare("delete from registro_aprobaciones_usuario where idlinea=? and tipo_aprobacion=4 ");
	            $smtp2->bindParam(1,$id,PDO::PARAM_INT);
                    $smtp2->execute();
	   	    // grabo dato 
 	            $smtp2=$this->_cna->prepare("insert into registro_aprobaciones_usuario
                                                 (idlinea,fecha_aprobacion,usuario_aprobacion,tipo_aprobacion,ip_computador)
	                                         values(?,getdate(),?,4,?) ;");
                    $smtp2->bindParam(1,$id,PDO::PARAM_INT); //id
                    $smtp2->bindParam(2,$lineas[6],PDO::PARAM_INT); //idusuario 
                    $smtp2->bindParam(3,$lineas[5],PDO::PARAM_STR); //ip
                    $smtp2->execute();
                    
                    // consumos x estado pago
                       // delete
                    $smtp2=  $this->_cna->prepare("delete from estado_pago.dbo.consumos_aprobados where idconsumo=? and idperiodo=? ;");
                    $smtp2->bindParam(1,$id,PDO::PARAM_INT); //id
                    $smtp2->bindParam(2,$lineas[7],PDO::PARAM_INT); //idusuario 
                    $smtp2->execute();
                       // grabar
                    $smtp2=  $this->_cna->prepare("insert into estado_pago.dbo.consumos_aprobados  
                                                   (idconsumo,idperiodo)
                                                   values(?,?) ;");
                    $smtp2->bindParam(1,$id,PDO::PARAM_INT); //id
                    $smtp2->bindParam(2,$lineas[7],PDO::PARAM_INT); //idusuario 
                    $smtp2->execute();
                    
                    $smtp2=  $this->_cna->prepare("insert into estado_pago.dbo.historico_aprobacion  
                                                  (idlinea,status,fecha_movimiento,usuario,comentarios,ip_computador)
                                                   values(?,'A',getdate(),?,'Aprobación Normal',?) ;");
                    
                    $smtp2->bindParam(1,$id,PDO::PARAM_INT); //id
                    $smtp2->bindParam(2,$lineas[6],PDO::PARAM_INT); //idusuario 
                    $smtp2->bindParam(3,$lineas[5],PDO::PARAM_STR); //idusuario 
                    $smtp2->execute();
                    
                    // actualizao tabla consumos
                    
	            // actualizao base
                   $smtp2=$this->_cna->prepare("update consumo_ordenes set aprobado='S',fecha_aprobacion=getdate(),idusuario_aprobacion=?
                                                where idconsumo=?");
                   
                   $smtp2->bindParam(1,$lineas[6],PDO::PARAM_INT); //id
	           $smtp2->bindParam(2,$id,PDO::PARAM_INT); //id
	           $smtp2->execute();
             }
        }
    }
    
    public function getNombreFaena($id){
        $smtp=$this->_cna->prepare("select nombre_faena from presupuesto.dbo.faenas where idfaena=? ;");
        $smtp->bindParam(1,$id,PDO::PARAM_INT); //id
	$smtp->execute();
        $resul=$smtp->fetch(PDO::FETCH_ASSOC);
        return $resul["nombre_faena"];
        
    }
    
    
    public function getDatosListado($idfaena,$idcontrato,$inicio,$termino,$tipo){
           $smtp=$this->_cna->prepare("select a.numero_orden,a.numero_interno,convert(varchar(10),a.fecha_contable,103) as fecha_contable,a.numero_parte,a.cantidad,a.idconsumo,a.docto_material,b.texto_orden,b.clase_actividad,a.precio_lista,a.factor,a.idlista,a.descuento,
                          a.ceco_cliente,a.campo_10,a.valor_pago,a.moneda_pago,d.descripcion,e.nombre_material,m.moneda,p.fecha_aprobacion,p.ip_computador,q.nombre_usuario,p.usuario_aprobacion
		          from consumo_ordenes a
		          left join cabecera_ordenes b on a.numero_orden=b.numero_orden 
                          left join clasificacion_contrato d on a.clasificacion_contrato=d.idclasifica 
	                  left join gestion.dbo.maestro_material e on a.numero_parte=e.material and e.idioma='S'
		          left join lista_precios.dbo.listas_precio m on a.idlista=m.idlista
                          left join registro_aprobaciones_usuario p on a.idconsumo=p.idlinea and tipo_aprobacion=?
                          left join maestro_usuarios q on p.usuario_aprobacion=q.idusuario
                	  where (a.fecha_contable>=convert(datetime,?,103) and fecha_contable<=convert(datetime,?,103) ) 
                          and a.aprobado in ('$tipo') and d.idcontrato=? and a.idfaena=?
                          order by a.fecha_contable,a.numero_orden,a.docto_material,a.posicion ; ");
           $smtp->bindParam(1,$tipo,PDO::PARAM_INT); //id
           $smtp->bindParam(2,$inicio,PDO::PARAM_STR); //id
           $smtp->bindParam(3,$termino,PDO::PARAM_STR); //id
           
           $smtp->bindParam(4,$idcontrato,PDO::PARAM_INT); //id
           $smtp->bindParam(5,$idfaena,PDO::PARAM_INT); //id
	   $smtp->execute();
           return $smtp->fetchAll();
    }
    
    
    public function getDatosListadoSinAprobar($idfaena,$idcontrato,$inicio,$termino){
           $smtp=$this->_cna->prepare("select a.numero_orden,a.numero_interno,convert(varchar(10),a.fecha_contable,103) as fecha_contable,a.numero_parte,a.cantidad,a.idconsumo,a.docto_material,b.texto_orden,b.clase_actividad,a.precio_lista,a.factor,a.idlista,a.descuento,
                          a.ceco_cliente,a.campo_10,a.valor_pago,a.moneda_pago,d.descripcion,e.nombre_material,m.moneda,p.fecha_aprobacion,p.ip_computador,q.nombre_usuario,p.usuario_aprobacion
		          from consumo_ordenes a
		          left join cabecera_ordenes b on a.numero_orden=b.numero_orden 
                          left join clasificacion_contrato d on a.clasificacion_contrato=d.idclasifica 
	                  left join gestion.dbo.maestro_material e on a.numero_parte=e.material and e.idioma='S'
		          left join lista_precios.dbo.listas_precio m on a.idlista=m.idlista
                          left join registro_aprobaciones_usuario p on a.idconsumo=p.idlinea and tipo_aprobacion=?
                          left join maestro_usuarios q on p.usuario_aprobacion=q.idusuario
                	  where (a.fecha_contable>=convert(datetime,?,103) and fecha_contable<=convert(datetime,?,103) ) 
                          and a.aprobado='N' and a.clase_movimiento in ('Z21','Z22','Z27','Z28','Z261','Z262','Z15','Z16') and d.idcontrato=? and a.idfaena=?
                          order by a.fecha_contable,a.numero_orden,a.docto_material,a.posicion ; ");
           $smtp->bindParam(1,$tipo,PDO::PARAM_INT); //id
           $smtp->bindParam(2,$inicio,PDO::PARAM_STR); //id
           $smtp->bindParam(3,$termino,PDO::PARAM_STR); //id
           
           $smtp->bindParam(4,$idcontrato,PDO::PARAM_INT); //id
           $smtp->bindParam(5,$idfaena,PDO::PARAM_INT); //id
	   $smtp->execute();
           return $smtp->fetchAll();
    }
    
    public function getDatosListadoAprobados($idfaena,$idestado){
           $smtp=  $this->_cna->prepare("select convert(varchar(10),b.fecha_contable,103)as fecha_contable ,b.numero_orden,convert(varchar(10),e.fecha_orden,103),b.numero_interno,b.numero_parte,b.cantidad,b.precio_lista,b.factor,b.clase_movimiento,f.moneda,convert(varchar(10),b.fecha_aprobacion,103) as fecha_aprobacion,c.nombre_material,b.aprobado,b.centro,b.idlista,c.grupo_articulo,e.equipo,
                                         b.docto_material,e.texto_orden,e.clase_actividad,m.descripcion,convert(varchar,b.fecha_aprobacion,108) as hora_aprobacion ,b.campo_10,b.descuento,b.valor_pago,b.moneda_pago,b.idusuario_aprobacion,a.idconsumo,n.nombre_usuario
                                         from estado_pago.dbo.consumos_aprobados a
                                         left join consumo_ordenes b on a.idconsumo=b.idconsumo
	                                 left join cabecera_ordenes e on b.numero_orden=e.numero_orden 
                                         left join lista_precios.dbo.listas_precio f on b.idlista=f.idlista 
                                   	 left join gestion.dbo.maestro_material c on b.numero_parte=c.material and c.idioma='S'
	                                 left join clasificacion_contrato m on b.clasificacion_contrato=m.idclasifica and m.idfaena=b.idfaena
                                         left join maestro_usuarios n on b.idusuario_aprobacion=n.idusuario
	                                 where a.idperiodo=? and b.aprobado='S'  and  b.idfaena=? 
                                         order by b.fecha_contable,b.numero_interno,b.numero_orden,b.posicion ;");
            $smtp->bindParam(1,$idestado,PDO::PARAM_INT); //id
            $smtp->bindParam(2,$idfaena,PDO::PARAM_STR); //id
            $smtp->execute();
          return $smtp->fetchAll();
          
    }
    
    public function getRegistroAprobacion($id,$tipo){
            $smtp=$this->_cna->prepare("select a.fecha_aprobacion,a.ip_computador,b.nombre_usuario,a.usuario_aprobacion from registro_aprobaciones_usuario a 
                                    left join maestro_usuarios b on a.usuario_aprobacion=b.idusuario
                                    where a.idlinea=? and a.tipo_aprobacion=? ;");
            $smtp->bindParam(1,$id,PDO::PARAM_INT); //id
            $smtp->bindParam(2,$tipo,PDO::PARAM_INT); //id
            $smtp->execute();
          return $smtp->fetchAll();
        
    }
    
    public function getFechaContrato($id){
        
          $smtp=$this->_cna->prepare("select convert(varchar,inicio_contrato,103) as fecha from estado_pago.dbo.estado_pago_faena where idestado=? ;");
          $smtp->bindParam(1,$id,PDO::PARAM_INT); //id
          $smtp->execute();
          $resul=$smtp->fetch(PDO::FETCH_ASSOC);
        return $resul["fecha"];
          
    }
    
    public function getFechasEp($id){
        
          $smtp=$this->_cna->prepare("select convert(varchar,fecha_inicio,103) as inicio ,convert(varchar,fecha_termino,103) as termino from estado_pago.dbo.periodos_estado_pago where idperiodo=? ;");
          $smtp->bindParam(1,$id,PDO::PARAM_INT); //id
          $smtp->execute();
          
        return $smtp->fetchAll();
          
    }
    
    public function getEstadoPago($contrato,$tipo){
           
           $query="select idperiodo,nombre from estado_pago.dbo.periodos_estado_pago where idestado=? ";
           if ($tipo=='A')
               $query.=" and status_periodo='A'  ";
           $query.=" order by idperiodo ";
               
           $smtp=  $this->_cna->prepare($query);
           $smtp->bindParam(1,$contrato,PDO::PARAM_INT); //id
           $smtp->execute();
          return $smtp->fetchAll();
          
    }
    
    public function getEstadoPagoId($estado){
           
           $query="select nombre from estado_pago.dbo.periodos_estado_pago where idperiodo=? ";
               
           $smtp=  $this->_cna->prepare($query);
           $smtp->bindParam(1,$estado,PDO::PARAM_INT); //id
           $smtp->execute();
           $resul=$smtp->fetch(PDO::FETCH_ASSOC);
           return $resul["nombre"];
           
          
    }
    
    
    
     public function getDatosPeriodoEp($idcontrato){
               
           $smtp=$this->_cna->prepare("select min(idperiodo) as periodo,convert(varchar,fecha_inicio,103) as fecha from estado_pago.dbo.periodos_estado_pago
                                         where idestado=? and status_periodo='A' group by fecha_inicio ;");
           $smtp->bindParam(1,$idcontrato,PDO::PARAM_INT); //id
           $smtp->execute();
          return $smtp->fetchAll();
    }
    
    
    public function getTotalesAprobados($id){
        
           $smtp=$this->_cna->prepare("select b.cantidad,b.valor_pago,b.factor,b.idlista,b.moneda_pago,b.descuento
                                       from estado_pago.dbo.consumos_aprobados a
                                       left join consumos.dbo.consumo_ordenes b on a.idconsumo=b.idconsumo
	 	                       where a.idperiodo=? and b.aprobado='S' ;");
           $smtp->bindParam(1,$id,PDO::PARAM_INT); //id
           $smtp->execute();
           return $smtp->fetchAll();
    }
   
    public function getTipoEquipoFaena($idfaena){
           $smtp=$this->_cna->prepare("select a.idtipo,b.descripcion from lista_precios.dbo.faenas_tipoequipo  a
                                       left join lista_precios.dbo.tipo_equipo b on a.idtipo=b.idtipo
                                       where a.idfaena=? ;");
           $smtp->bindParam(1,$idfaena,PDO::PARAM_INT); //id
           $smtp->execute();
           return $smtp->fetchAll();
    }
    
    public function getCriterioLista($idfaena,$idtipo){
           $smtp=  $this->_cna->prepare("select a.idlista,c.fabricante,c.moneda from lista_precios.dbo.criterio_busqueda a
                                         left join lista_precios.dbo.faenas_tipoequipo b on b.idcorr=a.idcorr
               		                 left join lista_precios.dbo.listas_precio c on a.idlista=c.idlista
                                         where b.idfaena=? and b.idtipo=?
                                         order by a.orden");
           $smtp->bindParam(1,$idfaena,PDO::PARAM_INT); //id
           $smtp->bindParam(2,$idtipo,PDO::PARAM_INT); //id
           $smtp->execute();
           return $smtp->fetchAll();
    }
    
    public function getVigenciaLista($faena,$lista,$fecha){
           $smtp=  $this->_cna->prepare("SELECT a.idvigencia,convert(varchar(10),b.fecha_vigencia,103) as fecha from lista_precios.dbo.listas_faena a
                                         left join lista_precios.dbo.vigencia_listas b on a.idvigencia=b.idvigencia	 
				         where a.idfaena=? and b.idlista=? and fecha_vigencia<=convert(datetime,?,103) order by b.fecha_vigencia desc");
           
           $smtp->bindParam(1,$faena,PDO::PARAM_INT); //id
           $smtp->bindParam(2,$lista,PDO::PARAM_INT); //id
           $smtp->bindParam(3,$fecha,PDO::PARAM_STR); //id
           $smtp->execute();
           return $smtp->fetchAll();
        
    }
    
    public function getValorLista($parte,$vigencia){
           $smtp=  $this->_cna->prepare("select numero_parte,descripcion,precio_lista from lista_precios.dbo.detalle_precios where numero_parte=? and idvigencia=?");
           $smtp->bindParam(1,$parte,PDO::PARAM_STR); //id
           $smtp->bindParam(2,$vigencia,PDO::PARAM_INT); //id
           $smtp->execute();        
           return $smtp->fetchAll();
        
    }
    
    
    
    
}
