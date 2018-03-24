<?php
  session_start();
if ($_SERVER["REQUEST_METHOD"]==="POST")
{
   $idusuario = $_SESSION["usuario"];
   include "../lib/database.php";
   include "../lib/database_amazon.php";
   include "../lib/columnas_excel.php";
   include "../lib/meses_01.php";
   
   require_once '../phpexcel/Classes/PHPExcel.php';
   
   //require_once '../Excel\Spreadsheet\Excel\Writer.php';
   
   //$workbook = new Spreadsheet_Excel_Writer();
   //$workbook->send('detalle_compra.xls');
   //$libro =& $workbook->addWorksheet('Inversiones');

   error_reporting(E_ALL);

   $libro = new PHPExcel();
   
   
  
   $xfaena=$_POST["faena"];
   $xperiodo=$_POST["periodo"];
   $xgerencia=$_POST["gerencia"];
   
   
   // genero excel
   $fecha_dig=date('d/m/Y H:i:s');
  
    
   $libro->setActiveSheetIndex(0)->setCellValue('A2','Fecha y Hora Emision : '.$fecha_dig);
   $libro->setActiveSheetIndex(0)->setCellValue('d3','Presupuesto Inversiones '.$xperiodo);
 
   $libro->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setBold(true);   
   $libro->setActiveSheetIndex(0)->getStyle('A2')->getFont()->setBold(true);

   $libro->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setSize(8);
   $libro->setActiveSheetIndex(0)->getStyle('A2')->getFont()->setSize(8);

   $libro->setActiveSheetIndex(0)->getStyle('D3')->getFont()->setBold(true);
   $libro->setActiveSheetIndex(0)->getStyle('D3')->getFont()->setSize(14);
   
   
   // titulos
   
   $tot_inv=0;
   $y=0;
   
   $libro->setActiveSheetIndex(0)->getStyle('A5:AA5')->getFont()->setBold(true);

   $libro->setActiveSheetIndex(0)->setCellValue('A5','Faena');
   $libro->setActiveSheetIndex(0)->setCellValue('B5','Código');
   $libro->setActiveSheetIndex(0)->setCellValue('C5','Descripción');
   $libro->setActiveSheetIndex(0)->setCellValue('D5','Centro Costo');
   $libro->setActiveSheetIndex(0)->setCellValue('E5','Cantidad');
   $libro->setActiveSheetIndex(0)->setCellValue('F5','Valor USD');
   $libro->setActiveSheetIndex(0)->setCellValue('G5','Clase');
   $libro->setActiveSheetIndex(0)->setCellValue('H5','Nombre Clase');
   $libro->setActiveSheetIndex(0)->setCellValue('I5','Mes Compra');
   $libro->setActiveSheetIndex(0)->setCellValue('J5','Vida Util (años)');
   $libro->setActiveSheetIndex(0)->setCellValue('K5','Dep. Mensual (USD)');
   $libro->setActiveSheetIndex(0)->setCellValue('L5','Total Solicitado (USD)');
   $libro->setActiveSheetIndex(0)->setCellValue('M5','Total Activado (USD)');



   for ($i = 1; $i <= 12; $i++){
	
	if (($i>=1) and ($i<=9))
	    $ind=$i+3;
	else
	    $ind=$i-9;
	$libro->setActiveSheetIndex(0)->setCellValue($columna[13+$i].(5),$meses[$ind]);		
	
	}
   $libro->setActiveSheetIndex(0)->setCellValue($columna[13+$i].(5),'Total Dep.');		     
  

   $sql="select a.idfaena,a.idunidad,a.nombre_faena,b.nombre_unidad,b.cod_gerencia,d.ceco,d.activo from dim_faenas a 
             left join  dim_unidad b on a.idunidad=b.cod_unidad
             left join dim_faena_cebe c on a.idfaena=c.idfaena
	     left join dim_cebe_ceco d on c.cebe=d.cebe
             where  d.activo in ('S','N') ";
   if ($xfaena>0)
       $sql.=" and c.idfaena=$xfaena ";
   else
       $sql.=" and b.cod_gerencia='$xgerencia'";
   $sql.=" order by idunidad,a.idfaena ; ";
   //echo $sql;
   $resule=sqlsrv_query($amazon,$sql);
   while($obj = sqlsrv_fetch_object($resule))
   {
       $sqlinv = "select a.correlativo,a.descripcion,a.idcentro_costo,a.cantidad,a.valor_presupuesto,d.tipo_clase,d.nombre_clase,a.mes_compra,a.vida_util,a.status_codigo
        from presupuesto_inversion a
        left join clase_activo d on a.clase_activo=d.idclase
        where a.periodo=$xperiodo  and a.status_codigo='A' and a.idcentro_costo='$obj->ceco' and a.tipo_presupuesto in ('N','C') ";

       $sqlinv.=" order by a.correlativo ;";  
       //echo $sqlinv;
       $resulinv=sqlsrv_query($actf,$sqlinv);
       while($objinv = sqlsrv_fetch_object($resulinv))
       {
             $tot_inv+=$objinv->valor_presupuesto;
	 
	     if (($objinv->mes_compra>=1) and ($objinv->mes_compra<=9))
	        $xindmes=$objinv->mes_compra+3;
	     else
	        $xindmes=$objinv->mes_compra-9;
             
             // recuperar el total de compras del codigo
             $sql99="select sum(valor_compra) as compra ,sum(valor_real) as real from formulario_activo where codigo_presupuesto='$objinv->correlativo' and status_solicitud='A' ;";
	     //echo $sql99;
	     $resul99=sqlsrv_query($actf,$sql99);
             if ($resul99===false)
             {
                $xval1=0;
                $xval2=0;
             }
             else
             {
                while ($obj99 = sqlsrv_fetch_object($resul99))
                  {
                    $xval1=$obj99->compra;
                    $xval2=$obj99->real;        
                  }
             }
             $libro->setActiveSheetIndex(0)->setCellValue('A'.(6+$y), $obj->nombre_faena);  
	     $libro->setActiveSheetIndex(0)->setCellValue('B'.(6+$y),$objinv->correlativo);
    	     $libro->setActiveSheetIndex(0)->setCellValue('C'.(6+$y),$objinv->descripcion);
	     $libro->setActiveSheetIndex(0)->setCellValue('D'.(6+$y),$objinv->idcentro_costo);
	     $libro->setActiveSheetIndex(0)->setCellValue('E'.(6+$y),$objinv->cantidad);
	 //$d6=number_format($d6,'2','.',',');
             $libro->setActiveSheetIndex(0)->getStyle('F'.(6+$y))->getNumberFormat()->setFormatCode('###,###,##0.00'); 
	     $libro->setActiveSheetIndex(0)->setCellValue('F'.(6+$y),$objinv->valor_presupuesto);
	 //$d7=number_format($d7,'0','.',',');
	     $libro->setActiveSheetIndex(0)->setCellValue('G'.(6+$y),$objinv->tipo_clase);
	 
	 
	     $libro->setActiveSheetIndex(0)->setCellValue('H'.(6+$y),$objinv->nombre_clase);
	     $libro->setActiveSheetIndex(0)->setCellValue('I'.(6+$y),$meses[$xindmes]);
	     $libro->setActiveSheetIndex(0)->setCellValue('J'.(6+$y),$objinv->vida_util);
	 
	     if ($objinv->vida_util>0)
	        $dep_men=round($objinv->valor_presupuesto/($objinv->vida_util*12),2);
	     else
	        $dep_men=0;
	     $libro->setActiveSheetIndex(0)->setCellValue('K'.(6+$y),$dep_men);
	 
	 //  rescato lo comprado y activado para el c�digo
	     $libro->setActiveSheetIndex(0)->setCellValue('L'.(6+$y),$xval1);
	     $libro->setActiveSheetIndex(0)->setCellValue('M'.(6+$y),$xval2);
             
             $libro->setActiveSheetIndex(0)->setCellValue('AC'.(6+$y),$obj->activo);
             $libro->setActiveSheetIndex(0)->setCellValue('AD'.(6+$y),$objinv->status_codigo);
             
             
	   
             
             for ($i = $objinv->mes_compra ; $i <= 12; $i++)
             {
                $libro->setActiveSheetIndex(0)->getStyle($columna[13+$i].(6+$y))->getNumberFormat()->setFormatCode('###,###,##0.00');  
		$libro->setActiveSheetIndex(0)->setCellValue($columna[13+$i].(6+$y),$dep_men);
	     }
             $libro->setActiveSheetIndex(0)->getStyle('AA'.(6+$y))->getNumberFormat()->setFormatCode('###,###,##0.00'); 
	     $libro->setActiveSheetIndex(0)->setCellValue('AA'.(6+$y),'=SUM(O'.(6+$y).':Z'.(6+$y).')');
              
             
             $y++; 
           
           
       }
       
       
       
       
       
   }
    
    if ($y>0){
   
$libro->setActiveSheetIndex(0)->setCellValue('E'.(6+$y),'Total Inversion'); 

$libro->setActiveSheetIndex(0)->getStyle('F'.(6+$y))->getNumberFormat()->setFormatCode('###,###,##0.00'); 
$libro->setActiveSheetIndex(0)->setCellValue('F'.(6+$y),'=sum(F6:F'.(6+$y-1).')');

$libro->setActiveSheetIndex(0)->getStyle('K'.(6+$y))->getNumberFormat()->setFormatCode('###,###,##0.00'); 
$libro->setActiveSheetIndex(0)->setCellValue('K'.(6+$y),'=sum(K6:K'.(6+$y-1).')');


$libro->setActiveSheetIndex(0)->getStyle('L'.(6+$y))->getNumberFormat()->setFormatCode('###,###,##0.00'); 
$libro->setActiveSheetIndex(0)->setCellValue('L'.(6+$y),'=sum(L6:L'.(6+$y-1).')');

$libro->setActiveSheetIndex(0)->getStyle('M'.(6+$y))->getNumberFormat()->setFormatCode('###,###,##0.00'); 
$libro->setActiveSheetIndex(0)->setCellValue('M'.(6+$y),'=sum(M6:M'.(6+$y-1).')');
   
}

// sin presupuestos





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
$libro->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);   
$libro->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);   
$libro->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);   
$libro->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);   
$libro->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);   
$libro->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);   
$libro->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);   
$libro->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);   
$libro->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);   
$libro->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);   
$libro->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);   
$libro->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);   


   
   
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="listado_presupuesto_inversiones.xlsx"');
header('Cache-Control: max-age=0');



$objWriter = PHPExcel_IOFactory::createWriter($libro, 'Excel2007');
			
$objWriter->save('php://output'); 


//$workbook->close();



}


 