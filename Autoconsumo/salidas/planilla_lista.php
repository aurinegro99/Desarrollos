<?php

if ($_SERVER["REQUEST_METHOD"]==="POST"){
    
    require_once '../app/clases/AutoConsumo.php';

    $dato=new AutoConsumo();

  
    /** PHPExcel */
    require_once '../phpexcel/Classes/PHPExcel.php';
    error_reporting(E_ALL);

    // Script Que copia el archivo temporal subido al servidor en un directorio.
    $tipo = substr($_FILES['fileUpload']['type'], 0, 5);
    // Definimos Directorio donde se guarda el archivo

    /*echo '<script> alert(" Tipo Archivo '.$tipo .' ");</script>' ;*/
    $dir = '../subido/';
    // Intentamos Subir Archivo  
    // (1) Comprovamos que existe el nombre temporal del archivo
    if (isset($_FILES['fileUpload']['tmp_name'])) {
        // (2) - Comprovamos que se trata de un archivo de imágen
        if ($tipo == 'appli') {
            // (3) Por ultimo se intenta copiar el archivo al servidor.
            if (!copy($_FILES['fileUpload']['tmp_name'], $dir.$_FILES['fileUpload']['name']))
                echo '<script> alert("Error al Subir el Archivo");</script>';


            else{
                /*echo '<script> alert("El archivo '.$_FILES['fileUpload']['name'].' se ha copiado con Exito");</script>';*/

                //recibo los datos enviado

                $xfaena=$_POST["nfaena"];
                $xtipo=$_POST["ntipo"];
                $xfecha=$_POST["nfecha"];

                $inputFileName='../subido/'.$_FILES['fileUpload']['name'];

                // datos subidos
                $libro1 = PHPExcel_IOFactory::load($inputFileName);
                $objWorksheet = $libro1->getActiveSheet();


                 // datos de salida
                 $libro = new PHPExcel();

                 // recorrer los datos subidos

                 $nfilas = $objWorksheet->getHighestRow(); 

                 $libro->setActiveSheetIndex(0)->getStyle('A1:F1')->getFont()->setBold(true);

                 $libro->setActiveSheetIndex(0)->setCellValue('A1','Nro.Parte');
                 $libro->setActiveSheetIndex(0)->setCellValue('B1','Descripcion');
                 $libro->setActiveSheetIndex(0)->setCellValue('C1','P.Lista');
                 $libro->setActiveSheetIndex(0)->setCellValue('D1','Moneda');
                 $libro->setActiveSheetIndex(0)->setCellValue('E1','Proveedor');
                 $libro->setActiveSheetIndex(0)->setCellValue('F1','Vigencia');

                 for ($i = 1; $i <= $nfilas; $i++) {
              	        $swesta=0;
	   // rescato el dato
     	                $mcelda=$objWorksheet->getCellByColumnAndRow(0, $i)->getValue(); 
	   
	   // grabo el dato
	                $libro->setActiveSheetIndex(0)->setCellValue('A'.(1+$i), $mcelda); 
	   // reviso precios
                        $precio=$dato->getCriterioLista($xfaena,$xtipo);
                        
                        foreach($precio as $datos){
                                $vigencia=$dato->getVigenciaLista($xfaena,$datos["idlista"],$xfecha);
                                 foreach($vigencia as $xvigen){
                                       $xvalor=$dato->getValorLista($mcelda,$xvigen["idvigencia"]);
                                           foreach($xvalor as $xresp){
                                                    if ($xresp["precio_lista"]>0){
                                                        $swesta=1;
                                                        $libro->setActiveSheetIndex(0)->setCellValue('B'.(1+$i), $xresp["descripcion"]); 
						// precio lista
					 	        $libro->setActiveSheetIndex(0)->setCellValue('C'.(1+$i), $xresp["precio_lista"]); 
						// moneda
						        $libro->setActiveSheetIndex(0)->setCellValue('D'.(1+$i), $datos["moneda"]); 
						// fabricante
					       	        $libro->setActiveSheetIndex(0)->setCellValue('E'.(1+$i), $datos["fabricante"]);
						// fecha
						        $libro->setActiveSheetIndex(0)->setCellValue('F'.(1+$i), $xvigen["fecha"]);
						        break;
                                                        
                                                    }
                                               
                                           }
                                        if ($swesta==1)   
                                             break;
                                  }  
                            
                        }
                    }  // for
  
                   // entrega la salida
	 
                  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                  header('Content-Disposition: attachment;filename="consulta_precios.xlsx"');
                  header('Cache-Control: max-age=0');
		
                  $objWriter = PHPExcel_IOFactory::createWriter($libro, 'Excel2007');
			
                  $objWriter->save('php://output');
            }

        }
    }  //  else
else echo '<script> alert("El Archivo que se intenta subir NO ES del tipo Excel.");</script>';
  }
else echo '<script> alert("El Archivo no ha llegado al Servidor.");</script>'; 

?>


}