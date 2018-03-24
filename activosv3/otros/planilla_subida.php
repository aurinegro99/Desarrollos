<?php
   session_start();
   $usuario=$_SESSION["usuario"];
   
   include_once '../lib/database.php';

   require_once '../../phpexcel/Classes/PHPExcel.php';
   error_reporting(E_ALL);
   $libro = new PHPExcel();
   $fecha_dig=date('d/m/Y H:i:s');
   $libro->setActiveSheetIndex(0)->setCellValue('A2','Fecha y Hora Emision : '.$fecha_dig);
   $libro->setActiveSheetIndex(0)->getStyle('A2')->getFont()->setBold(true);

   $libro->setActiveSheetIndex(0)->getStyle('A2')->getFont()->setSize(8);

   $libro->setActiveSheetIndex(0)->setCellValue('d3','Listado de Activos ');

   $libro->setActiveSheetIndex(0)->getStyle('D3')->getFont()->setBold(true);
   $libro->setActiveSheetIndex(0)->getStyle('D3')->getFont()->setSize(14);

   $libro->setActiveSheetIndex(0)->getStyle('A5:AA5')->getFont()->setBold(true);

   $libro->setActiveSheetIndex(0)->setCellValue('A5','Activo');
   $libro->setActiveSheetIndex(0)->setCellValue('B5','Valor Alta');
   $libro->setActiveSheetIndex(0)->setCellValue('C5','Fecha Activación');
   $libro->setActiveSheetIndex(0)->setCellValue('D5','Encontrado');
   $libro->setActiveSheetIndex(0)->setCellValue('E5','Activado');
   $libro->setActiveSheetIndex(0)->setCellValue('F5','Valor Acum.');
   $libro->setActiveSheetIndex(0)->setCellValue('G5','Fecha Alta');

   $sql="select campo1,numero1,campo2,numero2,convert(varchar,fecha1,103) as fecha,campo2,campo3,convert(varchar,fecha2,103) as alta from paso where usuario='$usuario' and campo14='10'";
   $resul=sqlsrv_query($actf,$sql);
   $y=0;
   while($obj = sqlsrv_fetch_object($resul)){
          $libro->setActiveSheetIndex(0)->setCellValue('A'.(6+$y), $obj->campo1);  // nro activo
          $libro->setActiveSheetIndex(0)->setCellValue('B'.(6+$y), $obj->numero1);  // valor
          $libro->setActiveSheetIndex(0)->setCellValue('C'.(6+$y), $obj->fecha);  // fecha
          $libro->setActiveSheetIndex(0)->setCellValue('D'.(6+$y), $obj->campo2);  // encontrado
          $libro->setActiveSheetIndex(0)->setCellValue('E'.(6+$y), $obj->campo3);  // activado
          $libro->setActiveSheetIndex(0)->setCellValue('F'.(6+$y), $obj->numero2);  // valor acum
          $libro->setActiveSheetIndex(0)->setCellValue('G'.(6+$y), $obj->alta);  // nro activo
       
          $libro->setActiveSheetIndex(0)->getStyle('B'.(6+$y))->getNumberFormat()->setFormatCode('###,###,##0.00'); 
          $libro->setActiveSheetIndex(0)->getStyle('F'.(6+$y))->getNumberFormat()->setFormatCode('###,###,##0.00'); 
       
       
         $y++;
       
       
   }
   

   $libro->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);   
$libro->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);   
$libro->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);   
$libro->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);   
$libro->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);   
$libro->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);   
$libro->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        
   header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
   header('Content-Disposition: attachment;filename="Planilla_Activacion.xlsx"');
   header('Cache-Control: max-age=0');

   $objWriter = PHPExcel_IOFactory::createWriter($libro, 'Excel2007');
			
   $objWriter->save('php://output'); 
        