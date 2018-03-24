<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../app/clases/UsuarioLocal.php';
require_once '../app/clases/UsuarioAmazon.php';

include '../lib/meses_01.php';

$periodo   = $_GET['periodo'];

require_once '../../phpexcel/Classes/PHPExcel.php';

error_reporting(E_ALL);

$libro = new PHPExcel();

$fecha_dig=date('d/m/Y H:i:s');                        


$libro->setActiveSheetIndex(0)->setCellValue('A1','Fecha y Hora Emision : '.$fecha_dig);
$libro->setActiveSheetIndex(0)->setCellValue('B3','Nomina Personal '.$meses[intval(substr($periodo,5,2))].'--'.substr($periodo,0,4));

$libro->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setBold(true);

$libro->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setSize(8);

$libro->setActiveSheetIndex(0)->getStyle('B3')->getFont()->setBold(true);
$libro->setActiveSheetIndex(0)->getStyle('B3')->getFont()->setSize(14);

// cabeceras

$libro->setActiveSheetIndex(0)->getStyle('A5:N5')->getFont()->setBold(true);

$libro->setActiveSheetIndex(0)->setCellValue('A5','Rut');
$libro->setActiveSheetIndex(0)->setCellValue('B5','Nombre');
$libro->setActiveSheetIndex(0)->setCellValue('C5','Ceco');
$libro->setActiveSheetIndex(0)->setCellValue('D5', 'Sucursal');
$libro->setActiveSheetIndex(0)->setCellValue('E5', 'Nombre Sucursal');
$libro->setActiveSheetIndex(0)->setCellValue('F5', 'Fecha Ingreso');
$libro->setActiveSheetIndex(0)->setCellValue('G5', 'Fecha Retiro');
$libro->setActiveSheetIndex(0)->setCellValue('H5', 'Cargo');
$libro->setActiveSheetIndex(0)->setCellValue('I5', 'Nombre Cargo');
$libro->setActiveSheetIndex(0)->setCellValue('J5', 'Numero Convenio');
$libro->setActiveSheetIndex(0)->setCellValue('K5', 'IDFaena');
$libro->setActiveSheetIndex(0)->setCellValue('L5', 'Nombre IDFaena');
$libro->setActiveSheetIndex(0)->setCellValue('M5', 'IDConvenio');
$libro->setActiveSheetIndex(0)->setCellValue('N5', 'Nombre IDConvenio');

// traer datos

$datos=new UsuarioLocal();
$listado=$datos->getDatosNominaPeriodo($periodo);


//$libro->setActiveSheetIndex(0)->setCellValue('z6', $listado);

$y=0;
foreach($listado as $campos){
       //$amazon=new UsuarioAmazon();    
       //$nombre=$amazon->getNombreFaenaId($campos["idfaena"]);
       //foreach($nombre as $xdetalle){
       //    $xnombre_faena=$xdetalle["nombre_faena"];
           
       //}
       
       $libro->setActiveSheetIndex(0)->setCellValue('A'.(6+$y), $campos["rut"]);  // rut
       $libro->setActiveSheetIndex(0)->setCellValue('B'.(6+$y), $campos["nombre"]);  // nombre
       $libro->setActiveSheetIndex(0)->setCellValue('C'.(6+$y), $campos["centro_costo"]);  // ceco
       $libro->setActiveSheetIndex(0)->setCellValue('D'.(6+$y), $campos["sucursal"]);  // sucursal
       $libro->setActiveSheetIndex(0)->setCellValue('E'.(6+$y), $campos["nombre_sucursal"]);  // nombre suc
       $libro->setActiveSheetIndex(0)->setCellValue('F'.(6+$y), $campos["fecha_ingreso"]);  // fec. ingreso
       $libro->setActiveSheetIndex(0)->setCellValue('G'.(6+$y), $campos["fecha_retiro"]);  // fec. retiro
       $libro->setActiveSheetIndex(0)->setCellValue('H'.(6+$y), $campos["cargo"]);  // cargo
       $libro->setActiveSheetIndex(0)->setCellValue('I'.(6+$y), $campos["nombre_cargo"]);  // nombre cargo
       $libro->setActiveSheetIndex(0)->setCellValue('J'.(6+$y), $campos["numero_convenio"]);  // num convenio
       $libro->setActiveSheetIndex(0)->setCellValue('K'.(6+$y), $campos["idfaena"]);  // num faena
      //$libro->setActiveSheetIndex(0)->setCellValue('L'.(6+$y), $xnombre_faena);  // nombre faena
       $libro->setActiveSheetIndex(0)->setCellValue('M'.(6+$y), $campos["idconvenio"]);  // num convenio
       $libro->setActiveSheetIndex(0)->setCellValue('N'.(6+$y), $campos["nombre_convenio_kcc"]);  // nombre convenio
       
       
       
       
       $y++;
    
    
    
}
$libro->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$libro->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$libro->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$libro->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$libro->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$libro->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$libro->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$libro->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$libro->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$libro->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$libro->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$libro->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$libro->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$libro->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$libro->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);



header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="nomina_mes.xlsx"');
header('Cache-Control: max-age=0');

			
$objWriter = PHPExcel_IOFactory::createWriter($libro, 'Excel2007');
			
$objWriter->save('php://output');


