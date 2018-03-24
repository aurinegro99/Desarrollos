<?php
  session_start();
if ($_SERVER["REQUEST_METHOD"]==="POST")
{
   $idusuario = $_SESSION["usuario"];
   include "../lib/database.php";
   include "../lib/database_amazon.php";
   include "../lib/columnas_excel.php";
   include "../lib/meses_01.php";
   include "../lib/meses_02.php";
   
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
   
    $libro->setActiveSheetIndex(0)->getStyle('A6:AZ6')->getFont()->setBold(true);
    $libro->setActiveSheetIndex(0)->setCellValue('A6','Clase');
    $libro->setActiveSheetIndex(0)->setCellValue('B6','Descripcion Clase');
    $libro->setActiveSheetIndex(0)->setCellValue('C6','Cantidad');
    $libro->setActiveSheetIndex(0)->setCellValue('D6','Detalle Inversion');
    $libro->setActiveSheetIndex(0)->setCellValue('E6','Centro Costo');
    $libro->setActiveSheetIndex(0)->setCellValue('F6','Descrip. Ceco');
    $libro->setActiveSheetIndex(0)->setCellValue('G6','Mes Compra');
    $libro->setActiveSheetIndex(0)->setCellValue('H6','Mes Activacion');
    $libro->setActiveSheetIndex(0)->setCellValue('I6','Tipo Proyecto');
    $libro->setActiveSheetIndex(0)->setCellValue('J6','Clasificacion Balance');
    $libro->setActiveSheetIndex(0)->setCellValue('K6','Valor USD');
    $libro->setActiveSheetIndex(0)->setCellValue('L6','Comprobacion');
    $libro->setActiveSheetIndex(0)->setCellValue('M6','Vida Util meses');
    $libro->setActiveSheetIndex(0)->setCellValue('N6','Cuenta Depreciacion');
    $libro->setActiveSheetIndex(0)->setCellValue('O6','Nombre Cta Deprec.');
    $libro->setActiveSheetIndex(0)->setCellValue('P6','Abril '.$xperiodo);
    $libro->setActiveSheetIndex(0)->setCellValue('Q6','Mayo '.$xperiodo);
    $libro->setActiveSheetIndex(0)->setCellValue('R6','Junio '.$xperiodo);
    $libro->setActiveSheetIndex(0)->setCellValue('S6','Julio '.$xperiodo);
    $libro->setActiveSheetIndex(0)->setCellValue('T6','Agosto '.$xperiodo);
    $libro->setActiveSheetIndex(0)->setCellValue('U6','Septiembre '.$xperiodo);
    $libro->setActiveSheetIndex(0)->setCellValue('V6','Octubre '.$xperiodo);
    $libro->setActiveSheetIndex(0)->setCellValue('W6','Noviembre '.$xperiodo);
    $libro->setActiveSheetIndex(0)->setCellValue('X6','Diciembre '.$xperiodo);
    $libro->setActiveSheetIndex(0)->setCellValue('Y6','Enero '.$xperiodo);
    $libro->setActiveSheetIndex(0)->setCellValue('Z6','Febrero '.$xperiodo);
    $libro->setActiveSheetIndex(0)->setCellValue('AA6','Marzo '.$xperiodo);
    $libro->setActiveSheetIndex(0)->setCellValue('AB6','Depreciacion');
    $libro->setActiveSheetIndex(0)->setCellValue('AC6','Depr. Mensual');
    $libro->setActiveSheetIndex(0)->setCellValue('AD6','Tipo Inversion');
    $libro->setActiveSheetIndex(0)->setCellValue('AE6','Prioridad');
    
	     
  

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
       $sqlinv = "select a.*,b.nombre_clase,b.tipo_clase,b.vida_util,c.nombre_motivo,d.nombre_proyecto from Inversiones_Presupuesto a
                  left join Clase_Activo b on a.idclase=b.idclase
                  left join Motivo_inversion c on a.motivo=c.idmotivo
                  left join Proyecto_inversion d on a.proyecto=d.idproyecto
                  where a.idperiodo=$xperiodo  and a.ceco=$obj->ceco order by a.correlativo ";
       //echo $sqlinv;
       $resulinv=sqlsrv_query($actf,$sqlinv);
       if ($resulinv){
          $rows = sqlsrv_has_rows( $resulinv );
          if ($rows==true){ 
              while($objinv = sqlsrv_fetch_object($resulinv))
              {
             
             if ($objinv->mes_compra<=9)
		       $inc=$objinv->mes_compra+3;
		     if ($objinv->mes_compra>=10)
		       $inc=$objinv->mes_compra-9;
			   
             if ($objinv->mes_activacion<=9)
		       $ina=$objinv->mes_activacion+3;
		     if ($objinv->mes_activacion>=10)
		       $ina=$objinv->mes_activacion-9; 
           
           // nombre ceco
             $sqlce=" select nombre_ceco,naturaleza from dim_cebe_ceco where ceco='$objinv->ceco' ;" ;
             $resulceco=sqlsrv_query($amazon,$sqlce);
             $objceco=sqlsrv_fetch_object($resulceco);
           
           // linea bañance
             $sqlb="select * from clase_balance where clase='$objinv->tipo_clase' and naturaleza='$objceco->naturaleza' ;";
             //echo $sqlb;
		     $resulb=sqlsrv_query($actf,$sqlb);
             
             if ($resulb){
                 $rows = sqlsrv_has_rows( $resulb );
                 if ($rows==true){
                    $objb=sqlsrv_fetch_object($resulb);
                   $zcuenta_dep=$objb->cuenta;
                   $znombre_dep=$objb->nombre_cuenta;  
                     
                     
                 }
                 else{
                      $zcuenta_dep='';
                      $znombre_dep='';
                 }
             }
             $libro->setActiveSheetIndex(0)->setCellValue('A'.(7+$y), $objinv->tipo_clase);  
	         $libro->setActiveSheetIndex(0)->setCellValue('B'.(7+$y),$objinv->nombre_clase);
    	     $libro->setActiveSheetIndex(0)->setCellValue('C'.(7+$y),$objinv->cantidad);
	         $libro->setActiveSheetIndex(0)->setCellValue('D'.(7+$y),$objinv->descripcion_bien);
	         $libro->setActiveSheetIndex(0)->setCellValue('E'.(7+$y),$objinv->ceco);
	         $libro->setActiveSheetIndex(0)->setCellValue('F'.(7+$y),$objceco->nombre_ceco);   // nombre ceco
             if ($inc>=4)
	             $xfecha=$meses_02[$inc].$xperiodo;
	         else
	             $xfecha=$meses_02[$inc].($xperiodo+1);
	         $libro->setActiveSheetIndex(0)->setCellValue('G'.(7+$y),$xfecha);
             if ($ina>=4)
	             $xfecha=$meses_02[$ina].$xperiodo;
	         else
	             $xfecha=$meses_02[$ina].($xperiodo+1);
	 	     $libro->setActiveSheetIndex(0)->setCellValue('H'.(7+$y),$xfecha);
           
             $libro->setActiveSheetIndex(0)->setCellValue('I'.(7+$y),$objinv->nombre_proyecto);
           // nombre balance   J
             $libro->setActiveSheetIndex(0)->setCellValue('J'.(7+$y),$objb->linea_balance);
             $libro->setActiveSheetIndex(0)->getStyle('K'.(7+$y))->getNumberFormat()->setFormatCode('###,###,##0.00');
             $libro->setActiveSheetIndex(0)->setCellValue('K'.(7+$y),$objinv->cantidad*$objinv->valor_unitario);  // valor
           
             $libro->setActiveSheetIndex(0)->setCellValue('M'.(7+$y),$objinv->vida_util*12);  // vida util
             $libro->setActiveSheetIndex(0)->setCellValue('N'.(7+$y),$zcuenta_dep);  
             $libro->setActiveSheetIndex(0)->setCellValue('O'.(7+$y),$znombre_dep);    
                  
             if ($objinv->motivo==1)
                $libro->setActiveSheetIndex(0)->setCellValue('AD'.(7+$y),'Nuevo'); 
             if ($objinv->motivo==2)
                $libro->setActiveSheetIndex(0)->setCellValue('AD'.(7+$y),'Reemplazo');       
             $libro->setActiveSheetIndex(0)->setCellValue('AE'.(7+$y),$objinv->prioridad);    
                  
                  
           
           
           
	 
             
             $y++; 
           
           
       }
       
          }
       }
       
       
       
   }
    
    if ($y>0){
         
       $libro->setActiveSheetIndex(0)->getStyle('J'.(7+$y).':AD'.(7+$y))->getFont()->setBold(true);    
   
       $libro->setActiveSheetIndex(0)->setCellValue('J'.(7+$y),'Total Inversion'); 
       $libro->setActiveSheetIndex(0)->getStyle('K'.(7+$y))->getNumberFormat()->setFormatCode('###,###,##0.00'); 
       $libro->setActiveSheetIndex(0)->setCellValue('K'.(7+$y),'=sum(K6:K'.(6+$y-1).')');

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
$libro->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
$libro->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
$libro->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
$libro->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
    


   
   
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="listado_inversiones_faena.xlsx"');
header('Cache-Control: max-age=0');



$objWriter = PHPExcel_IOFactory::createWriter($libro, 'Excel2007');
			
$objWriter->save('php://output'); 


//$workbook->close();



}


 