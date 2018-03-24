<?php
  session_start();
if ($_SERVER["REQUEST_METHOD"]==="POST")
{
	
	sleep(5);

    // recuperar datos session
    $xusuario=$_SESSION["usuario"]; 
    $xcorreo=$_SESSION["correo"]; 
    // recuperar variables
    $d1=$_REQUEST["d1"];    // solicita
    $d2=$_REQUEST["d2"];    //aprueba
    $d3=$_REQUEST["d3"];    // clase
    $d4=$_REQUEST["d4"];    // descrip
    $d5=$_REQUEST["d5"];    // marca
    $d6=$_REQUEST["d6"];    //modelo
    $d7=$_REQUEST["d7"];    // nro. serie
    $d8=$_REQUEST["d8"];    // pais
    $d9=$_REQUEST["d9"];    // patente
    $d10=$_REQUEST["d10"];  //responsable
    $d11=$_REQUEST["d11"];  // faena
    $d12=$_REQUEST["d12"];  //sucursal
    $d13=$_REQUEST["d13"];   // codigo_ppto
    $d14=$_REQUEST["d14"];    // cebtro_costo
    $d15=$_REQUEST["d15"];  // valor pesos
    $d16=$_REQUEST["d16"];  // lugar uso
    
    $d18=$_REQUEST["d18"];  // valor dolar
    $d19=$_REQUEST["d19"];  // tipo cambio
    $rut_sol=$_REQUEST["rut_sol"];  // soliictante
    $idemplaza=$_REQUEST["idemplaza"];  // emplazamiento
    
    $comenta=$_REQUEST["comenta"];  // comentarios
    
    $d18=round($d18,2);
    
    // empresa
    include "../lib/database_amazon.php";
    $sql="select e.cod_empresa from dim_cebe_ceco a 
          left join dim_faena_cebe b on a.cebe=b.cebe
          left join dim_faenas c on b.idfaena=c.idfaena
          left join dim_unidad d on c.idunidad=d.cod_unidad
          left join dim_gerencia e on d.cod_gerencia=e.cod_gerencia
          where a.ceco='$d14' ;";
    $resul=sqlsrv_query($amazon,$sql);
    $obj = sqlsrv_fetch_object($resul);
    $xempresa=$obj->cod_empresa;
    
    include "../lib/database.php";
    
    
    
    
    // clase activo

    $sql="select tipo_clase,nombre_clase from clase_activo where idclase=$d3 ";
    $resul=sqlsrv_query($actf,$sql);
    $obj = sqlsrv_fetch_object($resul);
    $xtipo=$obj->tipo_clase;
    $xnombre_c=$obj->nombre_clase;
    
    // codigo emplazamiento
    $sql="select idcentro from centro_logistico where idemplazamiento='$idemplaza' ;";
    $resul=sqlsrv_query($actf,$sql);
    $obj = sqlsrv_fetch_object($resul);
    $xidemplaza=$obj->idcentro;
    
    //obteneer gerencia
    $sql="select b.cod_gerencia from dim_faenas a
          left join dim_unidad b on  a.idunidad=b.cod_unidad 
          where a.idfaena=$d11 ;";
    $resul=sqlsrv_query($amazon,$sql);
    $obj = sqlsrv_fetch_object($resul);
    $xgerencia=$obj->cod_gerencia;
    
    // nombre centro costo
    $sql="select nombre_ceco from dim_cebe_ceco from ceco='$d14' ;";
    $resul=sqlsrv_query($amazon,$sql);
    $obj = sqlsrv_fetch_object($resul);
    $xnombre_ceco=$obj->nombre_ceco;
    
    // descripcion inveriosn
    
    $sql="select descripcion,cantidad from presupuesto_inversion where correlativo='$d13' ;";
    $resul=sqlsrv_query($actf,$sql);
    $obj = sqlsrv_fetch_object($resul);
    $xdetalle_inversion=$obj->descripcion;
    $xcant_p=$obj->cantidad;
    
    // cantidad de compras del codifo
    
    $sql="select sum(cantidad) as cantidad from formulario_activo where codigo_presupuesto='$d13'  and status_solicitud='A'";
    $resul=sqlsrv_query($actf,$sql);
    $obj = sqlsrv_fetch_object($resul);
    $xtotal_compras=$obj->cantidad+1;
    
    
    
    
    // grabar
    $sql="insert into formulario_activo           
          (fecha_solicitud,
	  solicitante,
	  aprobador,
	  sociedad,
	  idclase,
	  cantidad,
	  descripcion_bien,
	  marca,
	  modelo,
	  numero_serie,
	  pais_origen,
	  patente,
	  responsable_activo,
	  idfaena,
	  sucursal,
	  idcentro_costo,
	  valor_compra,
	  codigo_presupuesto,
	  lugar_uso,
	  usuario,
	  valor_pesos,
	  tipo_cambio,status_solicitud,emplazamiento,observaciones,tipo_solicitud,numero_activo,saldo_presupuesto,valor_real,activado,fecha_activacion)
	  values (getdate(),'$d1','$d2','$xempresa',$d3,1,upper('$d4'),'$d5','$d6','$d7','$d8','$d9','$d10','$d11','$d12','$d14',$d18,'$d13','$d16','$xusuario',$d15,$d19,'A',$xidemplaza,'$comenta','N',0,0,0,'N',convert(datetime,'01/01/3000',103)) ;";
    //echo $sql;
    $resul=sqlsrv_query($actf,$sql);
    if ($resul)
       {
        $sql=" select @@IDENTITY as id";
        $resul=sqlsrv_query($actf,$sql);
        $obj = sqlsrv_fetch_object($resul);
        $xnew_formulario=$obj->id;
        // envizar correos
        $lista_mail='';
        $lista_mail=$xcorreo; 
        // anexo correo;
	if ($d11==1)  //   collahuasui
  	    $lista_mail=$lista_mail.',sergio.ponce@komatsu.cl,cesar.varela@komatsu.cl,andrea.rojas@komatsu.cl';
	if ($d11==2)  //   QB
	   $lista_mail=$lista_mail.',jorge.paez@komatsu.cl,jaime.ara@komatsu.cl,andrea.rojas@komatsu.cl';   
	if ($d11==112)  //   Sierra Gorda
	   $lista_mail=$lista_mail.',francisco.correa@komatsu.cl,edgard.lorca@komatsu.cl';   
	if ($d11==100)    // mhales
	   $lista_mail=$lista_mail.',camila.corvacho@komatsu.cl,francisco.correa@komatsu.cl';   
	if ($d11==3)  // RT
           $lista_mail=$lista_mail.',david.milla@komatsu.cl,francisco.correa@komatsu.cl';       	
	if ($d11==12)  // chuqui
            $lista_mail=$lista_mail.',marcela.bartolo@komatsu.cl,francisco.correa@komatsu.cl';       	  
	if ($d11==4)  // msur
           $lista_mail=$lista_mail.',camila.corvacho@komatsu.cl,francisco.correa@komatsu.cl';   
	if ($d11==5)   //  zona 6   gaby
	    $lista_mail=$lista_mail.',gonzalo.kusch@komatsu.cl,sebastian.duarte@komatsu.cl,francisco.correa@komatsu.cl';	   
	if ($d11==8)    //  andina
	    $lista_mail=$lista_mail.',walter.pizarro@komatsu.cl,sandra.campillay@komatsu.cl';
	if ($d11==6)   //  pelambres
	    $lista_mail=$lista_mail.',cristian.cornejo@komatsu.cl,fidel.hinojos@komatsu.cl,walter.pizarro@komatsu.cl';		
	if ($d11==113)   //  caserones
	    $lista_mail=$lista_mail.',aldo.chapilla@komatsu.cl,ricardo.tobar@komatsu.cl,walter.pizarro@komatsu.cl';	
	if ($d11==109)   //  cnn
	    $lista_mail=$lista_mail.',walter.pizarro@komatsu.cl,estephanie.rodriguez@komatsu.cl,jose.parra@komatsu.cl';
	if (($d11==170) or ($d11==196))  // esperanza -  centinela
	    $lista_mail=$lista_mail.',joaquin.carrera@komatsu.cl,walter.pizarro@komatsu.cl,ariel.rivera@komatsu.cl'; 	 
	if ($d11==201)   // Antucoya
	    $lista_mail=$lista_mail.',hector.tirado@komatsu.cl,walter.pizarro@komatsu.cl,ariel.rivera@komatsu.cl'; 	  	 
	if ($d11==198)   //  Escondida AT
	    $lista_mail=$lista_mail.',wilson.alfaro@komatsu.cl,flavio.aranguiz@komatsu.cl,nelson.glavez@komatsu.cl';	
	if ($d11==18)
	    $lista_mail=$lista_mail.',carolina.contreras@komatsu.cl';    
	if (($d11==124) or ($d11==200) or ($d11==15) or ($d11==124) or ($d11==106) or ($d11==25) or ($d11==42))   //  zona 3
	    $lista_mail=$lista_mail.',elena.alvarado@komatsu.cl';
	// herramientas especiales
	if (($d3==81) or ($d3==84) or ($d3==82)or ($d3==83)or ($d3==87)or ($d3==85)or ($d3==86))	
	    $lista_mail=$lista_mail.',alejandro.santana@komatsu.cl,barbara.villarroel@komatsu.cl,catalina.castillo@komatsu.cl'; 
	if (($d3==10) or ($d3==80))	//   componente
	   $lista_mail=$lista_mail.',rene.tapia@komatsu.cl,francisco.wells@komatsu.cl';
	//if ($d3==81)
	//    $lista_mail=$lista_mail.',elizabeth.pizarro@komatsu.cl';  
	if ((($d3==10) or ($d3==80)) and (($d11==1) or ($d11==2)))	//   componente   
	    $lista_mail=$lista_mail.',rolando.saavedra@komatsu.cl,patricio.veasv@komatsu.cl,marcelo.leal@komatsu.cl';
        
	if ((($d3==10) or ($d3==80)) and (($d11==201) or ($d11==112) or ($d11==170) or ($d11==196) ))	
            $lista_mail=$lista_mail.',miguel.vicentela@komatsu.cl,alexander.winstanley@komatsu.cl';
	
        if ((($d3==10) or ($d3==80)) and (($d11==3) or ($d11==4) or ($d11==5) or ($d11==12) or ($d11==100) ))	
            $lista_mail=$lista_mail.',sergio.fuentes@komatsu.cl,pedro.barraza@komatsu.cl,cristian.calderon@komatsu.cl';
	
        if ((($d3==10) or ($d3==80)) and (($d11==8) or ($d11==113) or ($d11==6) or ($d11==109) ))	
	    $lista_mail=$lista_mail.',jorge.abalos@komatsu.cl,cristian.krause@komatsu.cl,pedro.gonzalezj@komatsu.cl,patricio.lopez@komatsu.cl,eduardo.caimanque@komatsu.cl';
	
         // crear correo con informe
         // formatear datos
	 // valor compra dolar
	 //$d18=number_format($d18,2,'.',',');
         
	// $d15=number_format($d15,0,'',',');
	 //$d17=number_format($d17,2,'.',',');
	$mensaje=" <p>";
	$mensaje.="Se ha ingresado solicitud de creacion de Activo Fijo <p>";
        $mensaje.="Numero Formulario: $xnew_formulario <p>";
        $mensaje.="Solicitante  : $d1 <p>";
        $mensaje.="Aprobado por : $d2 <p>";
        $mensaje.="Responsable Activo : $d10 <p>";
	$mensaje.="Descripcion Bien : $d4 <p>";
	$mensaje.="Centro Costo : $d14    $xnombre_ceco <p>";
	if ($xgerencia=='GOPER')
	   $mensaje.="Código Presupuesto : $d13   $xdetalle_inversion <p>";
	else  
	   $mensaje.="Código Presupuesto : $xdetalle_inversion <p>";
	$mensaje.="Clase Activo : $xtipo   $xnombre_c   <p>";   
	$mensaje.="Valor Compra Pesos : $d15 <p>";
	$mensaje.="Valor Compra Dolar : $d18 <p>";
	//$mensaje.="Saldo Presupuesto : $d17 <p>";
	$mensaje.="Cant.Presupuestada : $xcant_p  Total Compras : $xtotal_compras  <p>";
	if  ($xgerencia=='GOPER')
        {
	     $mensaje.="Komatsu Chile S.A.";
	     $headers  = "MIME-Version: 1.0\r\n";
	     $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	     $headers .= "From:  Unidad Contratos <presupuesto@komatsu.cl>    \r\n";
	     mail($lista_mail.',maria.aguilar@komatsu.cl,camila.pinto@komatsu.cl,jacqueline.orellana@komatsu.cl,marcela.villegas@komatsu.cl','Ingreso Solicitud Activo Fijo',$mensaje,$headers);
             
             //mail('mmorgado@komatsu.cl','Ingreso Solicitud Activo Fijo ',$mensaje,$headers);
	 }
	else
         {
	     //   buscar correo x centro
	     //$sqlc="select correo from correos_centro where centro_costo='$d14' ";
	     //$resulp=mssql_query($sqlc);
	     //while(list($mdato)=mssql_fetch_row($resulp))
             // {
	     //      $lista_mail=$lista_mail.','.$mdato;
	     // }
              
              if ($xgerencia=='GC&F')
                  $lista_mail=$lista_mail.',rodrigo.herrera@komatsu.cl' ;
              
	      $mensaje.="Area Negocio : $nombre_area <p>";
	      $mensaje.="Komatsu Chile S.A.";
	      $headers  = "MIME-Version: 1.0\r\n";
	      $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	      $headers .= "From: Gerencia Control Gesti�n <presupuesto@komatsu.cl>    \r\n";
 	      mail($lista_mail.',camila.pinto@komatsu.cl,guido.gaete@komatsu.cl,marcela.villegas@komatsu.cl','Ingreso Solicitud Activo Fijo',$mensaje,$headers);
	  }
  
        //  copiar el id en la base antigua para mantener
        include "../lib/database_sauce.php";  
         $sql="insert into formulario_activo
              (idformulario,fecha_solicitud)
              values($xnew_formulario,getdate())";
          
         $resul=$pdoGestion->query($sql);
         if ($resul)
            echo $xnew_formulario;
         
        }
    else    
        var_dump(sqlsrv_errors());
    
    
}

