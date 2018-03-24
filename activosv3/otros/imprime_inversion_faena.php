<?php

if ($_SERVER["REQUEST_METHOD"]==="POST")
{

   include "../lib/database.php";
   include "../lib/database_amazon.php";
   include "../lib/meses_01.php";
    
   $idfaena=$_REQUEST["idfaena"];
   $idperiodo=$_REQUEST["idperiodo"];
   
   require_once '../phpexcel/Classes/PHPExcel.php';
   
   error_reporting(E_ALL);

   $libro = new PHPExcel();    
   
  // genero excel
   $fecha_dig=date('d/m/Y H:i:s');
  
    
   $libro->setActiveSheetIndex(0)->setCellValue('A1','Fecha y Hora Emision : '.$fecha_dig);
 
 
   $libro->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setBold(true);   
   $libro->setActiveSheetIndex(0)->getStyle('A2')->getFont()->setBold(true);

   $libro->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setSize(8);
   $libro->setActiveSheetIndex(0)->getStyle('A2')->getFont()->setSize(8);
    
   // titulo
    
    
   // nombre faena

   $sql="select nombre_faena from dim_faenas where idfaena=$idfaena ";
   $resule=sqlsrv_query($amazon,$sql);      
   $obj = sqlsrv_fetch_object($resule);    
    
   $libro->setActiveSheetIndex(0)->setCellValue('B3','Presupuesto Inversiones '.$idperiodo);
   $libro->setActiveSheetIndex(0)->setCellValue('B4','Faena '.$obj->nombre_faena);
    
   $libro->setActiveSheetIndex(0)->getStyle('B3:B4')->getFont()->setSize(15);
   $libro->setActiveSheetIndex(0)->getStyle('B3:B4')->getFont()->setBold(true);
    
   
   //  rescatar datos
  $sql = "select * from inversiones_presupuesto where idfaena=$idfaena and idperiodo=$idperiodo order by ceco,idclase ;";
  $resule=sqlsrv_query($actf,$sql);      

  $y=0;

    $libro->setActiveSheetIndex(0)->setCellValue('A6','Centro Costo');
    $libro->setActiveSheetIndex(0)->setCellValue('B6','Descripcion Activo');
    $libro->setActiveSheetIndex(0)->setCellValue('C6','Clase Activo');
    $libro->setActiveSheetIndex(0)->setCellValue('D6','Nombre Clase');
    $libro->setActiveSheetIndex(0)->setCellValue('E6','Cant. Presup');
    $libro->setActiveSheetIndex(0)->setCellValue('F6','Valor Unitario');
    $libro->setActiveSheetIndex(0)->setCellValue('G6','Total Presupuesto');
    $libro->setActiveSheetIndex(0)->setCellValue('H6','Mes Compra');
    $libro->setActiveSheetIndex(0)->setCellValue('I6','Mes Activacion');
    $libro->setActiveSheetIndex(0)->setCellValue('J6','Proyecto');
    $libro->setActiveSheetIndex(0)->setCellValue('K6','Motivo');
    $libro->setActiveSheetIndex(0)->setCellValue('L6','Activados');
    $libro->setActiveSheetIndex(0)->setCellValue('M6','Solicitados');
    $libro->setActiveSheetIndex(0)->setCellValue('N6','V/Util (Meses)');
    
    $libro->setActiveSheetIndex(0)->getStyle('A6:Z6')->getFont()->setBold(true);  
    
    while ($obj = sqlsrv_fetch_object($resule))
    {
	
	       if ($obj->mes_compra<=9)
		       $inc=$obj->mes_compra+3;
		   if ($obj->mes_compra>=10)
		       $inc=$obj->mes_compra-9;
			   
			if ($obj->mes_activacion<=9)
		       $ina=$obj->mes_activacion+3;
		   if ($obj->mes_activacion>=10)
		       $ina=$obj->mes_activacion-9;   
           // clase activo
	       $sqlg="select tipo_clase,nombre_clase,vida_util from clase_activo where idclase=$obj->idclase ;";
	       $resulg=sqlsrv_query($actf,$sqlg);
           $objg = sqlsrv_fetch_object($resulg);
           $xtipo=$objg->tipo_clase;
           $nombre_clase=$objg->nombre_clase;
           $xutil=$objg->vida_util;
        

		   // naturaleza
		  // $sqlg="select naturaleza from centros_costos where centro_costo='$d4' ;";
	       //$resulg=mssql_query($sqlg,$act);
	       //list($xnaturaleza)=mssql_fetch_row($resulg); 
		   
		   //proyecto
		   $sqlg="select nombre_proyecto from proyecto_inversion where idproyecto=$obj->proyecto ;";
	       $resulg=sqlsrv_query($actf,$sqlg);
           $objg = sqlsrv_fetch_object($resulg);
	       $xproyecto=$objg->nombre_proyecto;
		   
		   
		   // motivo
		   $sqlg="select nombre_motivo from motivo_inversion where idmotivo=$obj->motivo ;";
	       $resulg=sqlsrv_query($actf,$sqlg);
           $objg = sqlsrv_fetch_object($resulg);
	       $xmotivo=$objg->nombre_motivo;
	       		   
		    // buscar las activados
	        $tot_act=0;
			$tot_sol=0;
	        $sqlg="select count(*) as total from formulario_activo 
			       where idfaena=$idfaena and activado='S' and idclase=$obj->idclase ;";
            //echo $sqlg;
 	        $resulg=sqlsrv_query($actf,$sqlg);
            $objg = sqlsrv_fetch_object($resulg);
	        $tot_act=$objg->total;
			
			$sqlg="select count(*) as total from formulario_activo 
			       where idfaena=$idfaena and activado='N' and idclase=$obj->idclase and fecha_solicitud>=convert(datetime,'01/04/2014',103) and status_solicitud='A' ;";
 	        $resulg=sqlsrv_query($actf,$sqlg);
            $objg = sqlsrv_fetch_object($resulg);
	        $tot_sol=$objg->total;
        
            // imprimir datos
            $libro->setActiveSheetIndex(0)->setCellValue('A'.(7+$y),$obj->ceco);
            $libro->setActiveSheetIndex(0)->setCellValue('B'.(7+$y),$obj->descripcion_bien);
            $libro->setActiveSheetIndex(0)->setCellValue('C'.(7+$y),$xtipo);
            $libro->setActiveSheetIndex(0)->setCellValue('D'.(7+$y),$nombre_clase);
            
            $libro->setActiveSheetIndex(0)->setCellValue('E'.(7+$y),$obj->cantidad);
            $libro->setActiveSheetIndex(0)->setCellValue('F'.(7+$y),$obj->valor_unitario);
            $libro->setActiveSheetIndex(0)->setCellValue('G'.(7+$y),$obj->valor_unitario*$obj->cantidad);
            $libro->setActiveSheetIndex(0)->setCellValue('H'.(7+$y),$meses[$inc]);
            $libro->setActiveSheetIndex(0)->setCellValue('I'.(7+$y),$meses[$ina]);
            $libro->setActiveSheetIndex(0)->setCellValue('J'.(7+$y),$xproyecto);
            $libro->setActiveSheetIndex(0)->setCellValue('K'.(7+$y),$xmotivo);
            $libro->setActiveSheetIndex(0)->setCellValue('L'.(7+$y),$tot_act);
            $libro->setActiveSheetIndex(0)->setCellValue('M'.(7+$y),$tot_sol);
            $libro->setActiveSheetIndex(0)->setCellValue('N'.(7+$y),$xutil*12);
        
            // formatos
            $libro->setActiveSheetIndex(0)->getStyle('F'.(7+$y))->getNumberFormat()->setFormatCode('###,###,##0.00');
            $libro->setActiveSheetIndex(0)->getStyle('G'.(7+$y))->getNumberFormat()->setFormatCode('###,###,##0.00');

            $y++; 
}
    
    if ($y>0){
        // totales
         $libro->setActiveSheetIndex(0)->setCellValue('F'.(7+$y),'Total Inversion ');
         $libro->setActiveSheetIndex(0)->setCellValue('G'.(7+$y),'=SUM(G7:G'.(7+$y-1).')');
         $libro->setActiveSheetIndex(0)->getStyle('G'.(7+$y))->getNumberFormat()->setFormatCode('###,###,##0.00');
         $libro->setActiveSheetIndex(0)->getStyle('G'.(7+$y))->getFont()->setBold(true); 
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

   
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="listado_presupuesto_inversiones.xlsx"');
header('Cache-Control: max-age=0');



$objWriter = PHPExcel_IOFactory::createWriter($libro, 'Excel2007');
			
$objWriter->save('php://output'); 

    
    }


 