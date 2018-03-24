<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER["REQUEST_METHOD"]==="POST"){
    
   require_once '../../app/clases/AutoConsumo.php';
   $dato=new AutoConsumo();
   $xnombre=$dato->getNombreFaena($_POST["idfaena"]);
   
   $xnombre_ep=$dato->getEstadoPagoId($_POST["estado_pago"]);
    
   require_once '../../phpexcel/Classes/PHPExcel.php';

    error_reporting(E_ALL);

    $libro = new PHPExcel();
    
    $fecha_dig=date('d/m/Y H:i:s');                        

    $libro->setActiveSheetIndex(0)->setCellValue('A1','Faena :'.$xnombre);
    $libro->setActiveSheetIndex(0)->setCellValue('A2','Fecha y Hora Emision : '.$fecha_dig); 
    $libro->setActiveSheetIndex(0)->setCellValue('F3','Informe Consumos sin Aprobar');
    $libro->setActiveSheetIndex(0)->setCellValue('F4','Estado Pago '.$xnombre_ep);

    $libro->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setBold(true);
    $libro->setActiveSheetIndex(0)->getStyle('A2')->getFont()->setBold(true);

    $libro->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setSize(8);
    $libro->setActiveSheetIndex(0)->getStyle('A2')->getFont()->setSize(8);

    $libro->setActiveSheetIndex(0)->getStyle('F3:F4')->getFont()->setBold(true);
    $libro->setActiveSheetIndex(0)->getStyle('F3')->getFont()->setSize(16);  
    $libro->setActiveSheetIndex(0)->getStyle('F4')->getFont()->setSize(10);
    
  
     
    $libro->setActiveSheetIndex(0)->getStyle('A7:AN7')->getFont()->setBold(true);
    
    $libro->setActiveSheetIndex(0)->setCellValue('A7','Faena');
    $libro->setActiveSheetIndex(0)->setCellValue('B7','Fecha Contable');
    $libro->setActiveSheetIndex(0)->setCellValue('C7', 'Orden Servicio');
    $libro->setActiveSheetIndex(0)->setCellValue('D7', 'Equipo');
    $libro->setActiveSheetIndex(0)->setCellValue('E7', 'Nro. Parte');
    $libro->setActiveSheetIndex(0)->setCellValue('F7', 'Material');
    $libro->setActiveSheetIndex(0)->setCellValue('G7', 'Cantidad');
    $libro->setActiveSheetIndex(0)->setCellValue('H7', 'Precio Lista');
    $libro->setActiveSheetIndex(0)->setCellValue('I7', 'Factor');
    $libro->setActiveSheetIndex(0)->setCellValue('J7', 'Descto');
    $libro->setActiveSheetIndex(0)->setCellValue('K7', 'Total');
    $libro->setActiveSheetIndex(0)->setCellValue('L7', 'Moneda');
    $libro->setActiveSheetIndex(0)->setCellValue('M7', 'Docto.Material');
    $libro->setActiveSheetIndex(0)->setCellValue('N7', 'ACT.PM.');
    $libro->setActiveSheetIndex(0)->setCellValue('O7', 'Texto Orden');
    
    
    $xlista=$dato->getDatosListadoSinAprobar($_POST["idfaena"], $_POST["contrato"], $_POST["fec_inicio"], $_POST["fec_termino"]);
    $y=0;
    foreach($xlista as $datos){
        
            $mdescto=1-$datos["descuento"];
        
            $libro->setActiveSheetIndex(0)->getStyle('H'.(8+$y))->getNumberFormat()->setFormatCode('###,###,##0.00');
            $libro->setActiveSheetIndex(0)->getStyle('K'.(8+$y))->getNumberFormat()->setFormatCode('###,###,##0.00');  
            $libro->setActiveSheetIndex(0)->getStyle('I'.(8+$y))->getNumberFormat()->setFormatCode('##0.0000');
            $libro->setActiveSheetIndex(0)->getStyle('J'.(8+$y))->getNumberFormat()->setFormatCode('##0.00%');
  
            $libro->setActiveSheetIndex(0)->setCellValue('A'.(8+$y), $xnombre);  
            $libro->setActiveSheetIndex(0)->setCellValue('B'.(8+$y), $datos["fecha_contable"]);
            $libro->setActiveSheetIndex(0)->setCellValue('C'.(8+$y), $datos["numero_orden"]);
            $libro->setActiveSheetIndex(0)->setCellValue('D'.(8+$y), $datos["numero_interno"]);
            $libro->setActiveSheetIndex(0)->setCellValue('E'.(8+$y), $datos["numero_parte"]);
            $libro->setActiveSheetIndex(0)->setCellValue('F'.(8+$y), $datos["nombre_material"]);
            $libro->setActiveSheetIndex(0)->setCellValue('G'.(8+$y), $datos["cantidad"]);
            $libro->setActiveSheetIndex(0)->setCellValue('H'.(8+$y), $datos["precio_lista"]);
            $libro->setActiveSheetIndex(0)->setCellValue('I'.(8+$y), $datos["factor"]);
            $libro->setActiveSheetIndex(0)->setCellValue('J'.(8+$y), $mdescto);
            $libro->setActiveSheetIndex(0)->setCellValue('K'.(8+$y), '=round(G'.(8+$y).'*H'.(8+$y).'*I'.(8+$y).'*if(J'.(8+$y).'=0,1,J'.(8+$y).'),2)');
            $libro->setActiveSheetIndex(0)->setCellValue('L'.(8+$y), $datos["moneda_pago"]);
            $libro->setActiveSheetIndex(0)->setCellValue('M'.(8+$y), $datos["docto_material"]);
            $libro->setActiveSheetIndex(0)->setCellValue('N'.(8+$y), $datos["clase_actividad"]);
            $libro->setActiveSheetIndex(0)->setCellValue('O'.(8+$y), $datos["texto_orden"]);
            
            
            
        $y++;
        
    }
   // total
    
   $libro->setActiveSheetIndex(0)->setCellValue('J'.(8+$y),"Total Dolar");
   $libro->setActiveSheetIndex(0)->setCellValue('J'.(8+$y+1),"Total Euro");
   $libro->setActiveSheetIndex(0)->setCellValue('J'.(8+$y+2),"Total Pesos");

   // formulas
   $libro->setActiveSheetIndex(0)->setCellValue('K'.(8+$y), "=SUMIF(L8:L".(8+$y-1).",".chr(34).'Dolar'.chr(34).",K8:K".(8+$y-1).")");
   $libro->setActiveSheetIndex(0)->setCellValue('K'.(8+$y+1), "=SUMIF(L8:L".(8+$y-1).",".chr(34).'Euro'.chr(34).",K8:K".(8+$y-1).")");
   $libro->setActiveSheetIndex(0)->setCellValue('K'.(8+$y+2), "=SUMIF(L8:L".(8+$y-1).",".chr(34).'Pesos'.chr(34).",K8:K".(8+$y-1).")");

   $libro->setActiveSheetIndex(0)->getStyle('K'.(8+$y))->getNumberFormat()->setFormatCode('###,###,##0.00');
   $libro->setActiveSheetIndex(0)->getStyle('K'.(8+$y+1))->getNumberFormat()->setFormatCode('###,###,##0.00');
   $libro->setActiveSheetIndex(0)->getStyle('K'.(8+$y+2))->getNumberFormat()->setFormatCode('###,###,##0');
   
   $libro->setActiveSheetIndex(0)->getStyle('J'.(8+$y).':K'.(8+$y+2))->getFont()->setBold(true);
    
    
    



 header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 header('Content-Disposition: attachment;filename="Consumos_sin_Aprobar.xlsx"');
 header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($libro, 'Excel2007');
			
    $objWriter->save('php://output');
    
}

