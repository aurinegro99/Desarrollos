<?php
session_start();
$usuario=$_SESSION["usuario"];
/** PHPExcel */
require_once '../../phpexcel/Classes/PHPExcel.php';

include_once '../lib/database.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
        sleep(5);
        $pic = $_FILES['planilla'];
        
	//Validamos si la copio correctamente 
	if(copy($pic['tmp_name'],'../subidos/'.$pic['name'])){
		$data = array('success' => true);
                 
                // borrar base paso
                $sql="delete from paso where usuario='$usuario' and campo14='10' ;";
                $resul=sqlsrv_query($actf,$sql);

        
                // procesar planilla
                $inputFileName='../subidos/'.$pic['name'];
                $libro1 = PHPExcel_IOFactory::load($inputFileName);
                $objWorksheet = $libro1->getActiveSheet(0);
                // recorrer los datos subidos
                $nfilas = $objWorksheet->getHighestRow()-1;
        
                
                for ($i = 2; $i <= $nfilas; $i++){
                      $colb=trim($objWorksheet->getCellByColumnAndRow(1, $i)->getValue());  // activo       0
                      $colm=$objWorksheet->getCellByColumnAndRow(12, $i)->getValue();  // valor          12
                      $colf=$objWorksheet->getCellByColumnAndRow(5, $i)->getValue();  // fecha  5
                      $colo=$objWorksheet->getCellByColumnAndRow(14, $i)->getValue();  // mes          14
                      $colp=$objWorksheet->getCellByColumnAndRow(15, $i)->getValue();  // año          15
                      // buscar en planilla si no existe grabar, si existe sumar valor
                      $sql="select numero1 from paso where campo1='$colb' and usuario='$usuario' and campo14='10'   ;";
                      //echo $sql;
                      $resul=sqlsrv_query($actf,$sql);
                      $rows = sqlsrv_has_rows( $resul );
                       
                       
                      if ($rows===false){
                          // grabar nuevo registro
                          $sql="insert into paso
                                (campo1,numero1,usuario,campo14,fecha1,numero5,numero6)
                                values('$colb',$colm,'$usuario','10',convert(datetime,$colf,103),$colo,$colp) ;";
                          //echo $sql;
                          $resul=sqlsrv_query($actf,$sql);
                          
                          
                      }   
                      else{
                          
                          
                           $obj = sqlsrv_fetch_object($resul);  
                           // update
                           $newvalor=$obj->numero1+$colm;    
                           $sql="update paso
                                 set numero1=$newvalor 
                                 where campo14='10' and campo1='$colb' and usuario='$usuario' ; ";
                           //echo $sql;
                           $resul=sqlsrv_query($actf,$sql);
                          
                      }
                     
                      
                      
                  }
        
                  // reviso si el activo existe y si existe cuando fue dado de alta
                  $sql="select campo1, numero1 from paso where usuario='$usuario' and campo14='10' ;";
                  $resul=sqlsrv_query($actf,$sql);
                  while($obj = sqlsrv_fetch_object($resul)){
                        // buscar activo en basename
                        $sqla="select idformulario,valor_real,activado,convert(varchar,fecha_activacion,103) as fecha from formulario_activo where numero_activo='$obj->campo1' ; ";
                        $resula=sqlsrv_query($actf,$sqla);
                        $rows = sqlsrv_has_rows( $resula );
                        if ($rows>0){
                             $sw='S';
                             $obj2 = sqlsrv_fetch_object($resula);
                             if ($obj2->activado=='S')  
                                 $xact='S';
                             else
                                 $xact='N';
                             
                             $xvalor= $obj2->valor_real;    
                             $xfecha= $obj2->fecha;  
                        }
                           
                        else{
                            $sw='N';
                            $xact='N';
                            $xvalor=0;
                            $xfecha='01/01/3000';
                        // granr en paso
                      }
                      
                        $sqlg="update paso
                               set campo2='$sw',numero2=$xvalor,campo3='$xact',fecha2=convert(datetime,'$xfecha',103)
                               where campo14='10' and usuario='$usuario' and campo1='$obj->campo1' ; ";
                        $resulg=sqlsrv_query($actf,$sqlg);
                        
                      
                  }
          
                 // revisar consistencia de datos
                 $rows=0;
                 $sql="select distinct(numero5) as filas from paso where numero5>0 and usuario='$usuario' and campo14='10' ;";
                 $resul=sqlsrv_query($actf,$sql);
                 while($obj = sqlsrv_fetch_object($resul)){
                        $rows++;
                      
                  }
                   
                 $swm=$rows;
                 $rows=0;
                 $sql="select distinct(numero6) as filas from paso where numero6>0 and usuario='$usuario' and campo14='10' ;";
                 $resul=sqlsrv_query($actf,$sql);
                 while($obj = sqlsrv_fetch_object($resul)){
                        $rows++;
                      
                  }   
                 $swp=$rows;  
                     
                 $data = array('success' => true,'mes'=>$swm,'periodo'=>$swp);  

	}
	
	//Codificamos el array a JSON (Esta sera la respuesta AJAX) 
	echo json_encode($data); 
