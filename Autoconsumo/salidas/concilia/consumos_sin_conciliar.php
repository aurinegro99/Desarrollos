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
    
   require_once '../../phpexcel/Classes/PHPExcel.php';

    error_reporting(E_ALL);

    $libro = new PHPExcel();
    
    $fecha_dig=date('d/m/Y H:i:s');                        

    $libro->setActiveSheetIndex(0)->setCellValue('A1','Faena :'.$xnombre);
    $libro->setActiveSheetIndex(0)->setCellValue('A2','Fecha y Hora Emision : '.$fecha_dig); 
    $libro->setActiveSheetIndex(0)->setCellValue('F3','Informe Consumos sin Conciliacion');
    $libro->setActiveSheetIndex(0)->setCellValue('F4','Inicio '.$_POST["inicio"].' Termino '.$_POST["termino"]);

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
    $libro->setActiveSheetIndex(0)->setCellValue('J7', 'Total');
    $libro->setActiveSheetIndex(0)->setCellValue('K7', 'Moneda');
    $libro->setActiveSheetIndex(0)->setCellValue('L7', 'Docto.Material');
    $libro->setActiveSheetIndex(0)->setCellValue('M7', 'ACT.PM.');
    $libro->setActiveSheetIndex(0)->setCellValue('N7', 'Motivo Orden');
    $libro->setActiveSheetIndex(0)->setCellValue('O7', 'Jefe Turno KCH');
    $libro->setActiveSheetIndex(0)->setCellValue('P7', 'Fecha Aprob. KCH');
    $libro->setActiveSheetIndex(0)->setCellValue('Q7', 'IP computador');
    
    $xlista=$dato->getDatosListado($_POST["idfaena"], $_POST["contrato"], $_POST["inicio"], $_POST["termino"], 1);
    $y=0;
    foreach($xlista as $datos){
        
            $libro->setActiveSheetIndex(0)->getStyle('H'.(8+$y))->getNumberFormat()->setFormatCode('###,###,##0.00');
            $libro->setActiveSheetIndex(0)->getStyle('J'.(8+$y))->getNumberFormat()->setFormatCode('###,###,##0.00');  
            $libro->setActiveSheetIndex(0)->getStyle('I'.(8+$y))->getNumberFormat()->setFormatCode('##0.0000');
  
        
        
        
            $libro->setActiveSheetIndex(0)->setCellValue('A'.(8+$y), $xnombre);  
            $libro->setActiveSheetIndex(0)->setCellValue('B'.(8+$y), $datos["fecha_contable"]);
            $libro->setActiveSheetIndex(0)->setCellValue('C'.(8+$y), $datos["numero_orden"]);
            $libro->setActiveSheetIndex(0)->setCellValue('D'.(8+$y), $datos["numero_interno"]);
            $libro->setActiveSheetIndex(0)->setCellValue('E'.(8+$y), $datos["numero_parte"]);
            $libro->setActiveSheetIndex(0)->setCellValue('F'.(8+$y), $datos["nombre_material"]);
            $libro->setActiveSheetIndex(0)->setCellValue('G'.(8+$y), $datos["cantidad"]);
            $libro->setActiveSheetIndex(0)->setCellValue('H'.(8+$y), $datos["precio_lista"]);
            $libro->setActiveSheetIndex(0)->setCellValue('I'.(8+$y), $datos["factor"]);
            $libro->setActiveSheetIndex(0)->setCellValue('J'.(8+$y), '=round(G'.(8+$y).'*H'.(8+$y).'*I'.(8+$y).',2)');
            $libro->setActiveSheetIndex(0)->setCellValue('K'.(8+$y), $datos["moneda_pago"]);
            $libro->setActiveSheetIndex(0)->setCellValue('L'.(8+$y), $datos["docto_material"]);
            $libro->setActiveSheetIndex(0)->setCellValue('M'.(8+$y), $datos["clase_actividad"]);
            $libro->setActiveSheetIndex(0)->setCellValue('N'.(8+$y), $datos["texto_orden"]);
            
            if ($datos["usuario_aprobacion"]=='0')
                $libro->setActiveSheetIndex(0)->setCellValue('O'.(8+$y), 'Act. Planif. (Aprob. Automatica)');
            else    
              $libro->setActiveSheetIndex(0)->setCellValue('O'.(8+$y), $datos["nombre_usuario"]);
            $libro->setActiveSheetIndex(0)->setCellValue('P'.(8+$y), $datos["fecha_aprobacion"]);
            $libro->setActiveSheetIndex(0)->setCellValue('Q'.(8+$y), $datos["ip_computador"]);
            
        $y++;
        
    }
    
    
    
    



 header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 header('Content-Disposition: attachment;filename="Consumos_sin_Conciliar.xlsx"');
 header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($libro, 'Excel2007');
			
    $objWriter->save('php://output');
    
}