<?php
session_start();
$usuario=$_SESSION["usuario"];
/** PHPExcel */
require_once '../../phpexcel/Classes/PHPExcel.php';
include_once '../app/clases/UsuarioLocal.php';
include_once '../app/clases/UsuarioAmazon.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
        sleep(5);
        $pic = $_FILES['planilla'];
        $periodo= $_REQUEST['xperiodo'];
        $mes=$_REQUEST['xmes'];
        
        if (strlen($mes)==1)
            $mes='0'.$mes;
	$data = array('success' => false,'datos'=>0);
	
        $sw_soc=0;
        $sw_mes=0;
	//Validamos si la copio correctamente 
	if(copy($pic['tmp_name'],'../subidos/'.$pic['name'])){
		$data = array('success' => true);
                // procesar planilla
                $inputFileName='../subidos/'.$pic['name'];
                $libro1 = PHPExcel_IOFactory::load($inputFileName);
                $objWorksheet = $libro1->getActiveSheet(2);
                // recorrer los datos subidos
                $nfilas = $objWorksheet->getHighestRow()-1;
                $lin1=0;$lin2=0;
                for ($i = 2; $i <= $nfilas; $i++){
                    // reviso periodo y sociedad
                     $mper=$objWorksheet->getCellByColumnAndRow(20, $i)->getValue(); 
                     $soc=$objWorksheet->getCellByColumnAndRow(3, $i)->getValue(); 
                     if (($soc<>'3002')or ($soc<>'3001')){
                         $sw_soc=1;
                         $lin1=$i;
                     }
                     if ($mper<>$periodo.$mes){
                         $sw_mes=1;
                         $lin2=$i;
                     }
                    
                }  
                
                if (($sw_soc>0) or ($sw_mes>0))
                    
                   $data = array('success' => false,'datos'=>999,'sociedad'=>$sw_soc,'periodo'=>$sw_mes,'LSoc'=>$lin1,'LPer'=>$lin2);
               
                
                // grabar datos
                $lista=new UsuarioLocal();
                $zamazon= new Usuarioamazon();
                
                $zperiodo=$periodo.$mes;
                $lista->eliminaDatosPeriodo($zperiodo);
                
                 $dato= new ArrayObject();
                  for ($i = 2; $i <= $nfilas+1; $i++){
                      $cola=trim($objWorksheet->getCellByColumnAndRow(0, $i)->getValue());  // rut
                      $colb=trim($objWorksheet->getCellByColumnAndRow(1, $i)->getValue());  // nombre
                      $cold=$objWorksheet->getCellByColumnAndRow(3, $i)->getValue();  // sociedad
                      $cole=$objWorksheet->getCellByColumnAndRow(4, $i)->getValue();  // fecha ingreso
                      $colf=$objWorksheet->getCellByColumnAndRow(5, $i)->getValue();  // fecha salida
                      $colj=$objWorksheet->getCellByColumnAndRow(9, $i)->getValue();  // sucursal
                      $colk=$objWorksheet->getCellByColumnAndRow(10, $i)->getValue();  // nomb. suc
                      $coll=$objWorksheet->getCellByColumnAndRow(11, $i)->getValue();  // unidad
                      $colm=$objWorksheet->getCellByColumnAndRow(12, $i)->getValue();  // nombre unidad
                      $coln=trim($objWorksheet->getCellByColumnAndRow(13, $i)->getValue());  // ceco
                      $colp=$objWorksheet->getCellByColumnAndRow(15, $i)->getValue();  // cargo
                      $colq=$objWorksheet->getCellByColumnAndRow(16, $i)->getValue();  // nomb. cargo
                      $colr=$objWorksheet->getCellByColumnAndRow(17, $i)->getValue();  // cateogira
                      $cols=$objWorksheet->getCellByColumnAndRow(18, $i)->getValue();  // nomb. cat.
                      $colu=$objWorksheet->getCellByColumnAndRow(20, $i)->getValue();  // periodo
                      $colz=$objWorksheet->getCellByColumnAndRow(25, $i)->getValue();  // contrato
                      $colaa=$objWorksheet->getCellByColumnAndRow(26, $i)->getValue();  // convenio
                      
                      // obtener datoa de faena
                     // $idfaena=$zamazon->getIdFaena(trim($coln));
                      
                       $zid=0;
                       $idconv=0;
                      
                     /* foreach ($idfaena as $xid){
                          
                             $zid=$xid[0];  
                          
                      }
                      
                     
                      if ($zid>0){
                          $idconv=0;
                          $zconv=$lista->getConveniosNro($zid, trim($colaa));
                          foreach($zconv as $zdato){
                              $idconv=$zdato[0];
                          }
                          
                      }
                      else
                         $idconv=0;  */
                      $dato->append(array($cola,$colb,$cold,$cole,$colf,$colj,$colk,$coll,$colm,$coln,$colp,$colq,$colr,$cols,$colu,$colz,$colaa,$usuario,$zid,$idconv));
                      
                  }
                  
                  // echo var_dump($dato);
                  
                  $resul=$lista->grabaPlanilla($dato);
                  
                 
                  
                  
                  // reporcesa faena y convenio
                  
                  $xlista=$lista->getCecosPeriodo($zperiodo);
                  //echo var_dump($xlista);
                  foreach($xlista as $xcecos ){
                         $zfaena=$zamazon->getIdFaena($xcecos[0]);
                         foreach ($zfaena as $xid){
                             $zid=$xid[0];  
                         }
                         $lista->grabaFaena($zperiodo, $xcecos[0], $zid);
                         
                  } 
                  
                  // periodo
                  $xlista2=$lista->getDatosConvenio($zperiodo);
                  //echo var_dump($xlista2);
                  foreach($xlista2 as $xdatos ){
                          //echo $xdatos["idfaena"].' '. $xdatos["numero_convenio"];
                         $zconv=$lista->getConveniosNro($xdatos["idfaena"], $xdatos["numero_convenio"]);
                         //echo var_dump($zconv);
                         foreach($zconv as $zdato){
                              $idconv=$zdato[0];
                          }
                         if ($idconv>0) 
                             $lista->setConvenioNomina ($zperiodo, $xdatos[0], $xdatos[1], $idconv);
                  }
                  
                 
                  // historial
                  $lista->grabaHistorialCarga($usuario,$pic['name'],$zperiodo); 
                  
                  $data = array('success' => true,'datos'=>$nfilas);

	}
	
	//Codificamos el array a JSON (Esta sera la respuesta AJAX) 
	echo json_encode($data); 
