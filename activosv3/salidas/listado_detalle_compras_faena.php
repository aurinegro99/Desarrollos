<?php
  session_start();
  
ob_start();
if ($_SERVER["REQUEST_METHOD"]==="POST")
{
   $idusuario = $_SESSION["usuario"];
   include "../lib/database.php";
   include "../lib/database_amazon.php";
   include "../lib/columnas_excel.php";
   include "../lib/meses_01.php";
   include "../lib/database_sauce.php"; 
   
   require_once '../phpexcel/Classes/PHPExcel.php';

   //error_reporting(E_ALL);

   $libro = new PHPExcel();
     
    
   $xfaena=$_POST["faena"];
   $xperiodo=$_POST["periodo"];
   $xgerencia=$_POST["gerencia"];
   
   // obtener rabgo del periodo
   
   $xfec1='';
   $xfec2='';
   
   $sql="select convert(varchar,incio,103) as inicio,convert(varchar,termino,103) as termino from Periodos_inversion where idperiodo=$xperiodo";
   //echo $sql;
   $resul=sqlsrv_query($actf,$sql);
   $obj = sqlsrv_fetch_object($resul);
   $xinicio=$obj->inicio;
   $xtermino=$obj->termino;
   
   
   
   // genero excel
   $fecha_dig=date('d/m/Y H:i:s');
  
   
   
   $libro->setActiveSheetIndex(0)->setCellValue('A2','Fecha y Hora Emision : '.$fecha_dig);
   $libro->setActiveSheetIndex(0)->setCellValue('d3','Detalle Compras x Faena '.$xperiodo);

   $libro->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setBold(true);   
   $libro->setActiveSheetIndex(0)->getStyle('A2')->getFont()->setBold(true);

   $libro->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setSize(8);
   $libro->setActiveSheetIndex(0)->getStyle('A2')->getFont()->setSize(8);

   $libro->setActiveSheetIndex(0)->getStyle('D3')->getFont()->setBold(true);
   $libro->setActiveSheetIndex(0)->getStyle('D3')->getFont()->setSize(14);
   
   // titulos
  
   $y=0;
   
   $libro->setActiveSheetIndex(0)->getStyle('A5:AA5')->getFont()->setBold(true);

   $libro->setActiveSheetIndex(0)->setCellValue('A5','Faena');
   $libro->setActiveSheetIndex(0)->setCellValue('B5','Area');
   $libro->setActiveSheetIndex(0)->setCellValue('C5','Solicitud');
   $libro->setActiveSheetIndex(0)->setCellValue('D5','Fecha Solicitud');
   $libro->setActiveSheetIndex(0)->setCellValue('E5','Cod. Presupuesto');
   $libro->setActiveSheetIndex(0)->setCellValue('F5','Descripción');
   $libro->setActiveSheetIndex(0)->setCellValue('G5','Articulo Comprado');
   $libro->setActiveSheetIndex(0)->setCellValue('H5','Valor Solicitus USD ');
   $libro->setActiveSheetIndex(0)->setCellValue('I5','Valor Solicitud Pesos');
   $libro->setActiveSheetIndex(0)->setCellValue('J5','Activo Fijo');
   $libro->setActiveSheetIndex(0)->setCellValue('K5','Solpe');
   $libro->setActiveSheetIndex(0)->setCellValue('L5','Pedido');
   $libro->setActiveSheetIndex(0)->setCellValue('M5','Activado');
   $libro->setActiveSheetIndex(0)->setCellValue('N5','Fecha Activación');
   $libro->setActiveSheetIndex(0)->setCellValue('O5','Valor Activación');
   $libro->setActiveSheetIndex(0)->setCellValue('P5','Comentarios');
   $libro->setActiveSheetIndex(0)->setCellValue('Q5','Workflow');
   $libro->setActiveSheetIndex(0)->setCellValue('R5','Fecha Creación WorkFlow');
   $libro->setActiveSheetIndex(0)->setCellValue('S5','Fecha Creación Activo');
   $libro->setActiveSheetIndex(0)->setCellValue('T5','Clase Activo');
   $libro->setActiveSheetIndex(0)->setCellValue('U5','Nombre Clase');
   $libro->setActiveSheetIndex(0)->setCellValue('V5','Centro Costo');
    
   
   
   
   $sql="select a.idfaena,a.idunidad,a.nombre_faena,b.nombre_unidad,b.cod_gerencia from dim_faenas a 
             left join  dim_unidad b on a.idunidad=b.cod_unidad
             where  ";
   if ($xfaena>0)
       $sql.=" a.idfaena=$xfaena ";
   else
       $sql.=" b.cod_gerencia='$xgerencia'";
   $sql.=" order by a.idunidad,a.idfaena ; ";
   //echo $sql;
   $resule=sqlsrv_query($amazon,$sql);
   $xlista='';
   $xnombre_unidad='';
   while($obj = sqlsrv_fetch_object($resule))
   {
         
          $sqlinv = "select a.idformulario,convert(varchar(10),a.fecha_solicitud,103) as fecha,a.codigo_presupuesto,d.descripcion,a.descripcion_bien,a.valor_compra,a.valor_pesos,a.numero_activo,a.activado,a.numero_solpe,a.numero_pedido,convert(varchar,a.fecha_activacion,103) as fecha2,a.valor_real,a.comentarios,convert(varchar,a.fecha_creacion_activo,103) as fecha3,c.tipo_clase,c.nombre_clase,a.idcentro_costo
                 from formulario_activo a 
         	 left join presupuesto_inversion d on a.codigo_presupuesto=d.correlativo 
             left join clase_activo c on a.idclase=c.idclase
	      	 where a.idfaena ='$obj->idfaena'  and a.status_solicitud='A'  and (a.fecha_solicitud>=convert(datetime,'$xinicio',103) and a.fecha_solicitud<=convert(datetime,'$xtermino',103))
		 order by a.idformulario ;";  
       //echo $sqlinv;
          $resulinv=sqlsrv_query($actf,$sqlinv);
          while($objinv = sqlsrv_fetch_object($resulinv))
             {
              
              // buscar adtso workflow
              $sqlwf="select idworkflow,convert(varchar,fecha_creacion,103) as fechawf  from  flujo_solicitud where idsolicitud=$objinv->idformulario ";
              //echo $sqlwf;
              $resulwf=$pdoGestion->query($sqlwf);
              $xidwf='';
              $xfechawf='';
              if ($resulwf)
                 list($xidwf,$xfechawf) = $resulwf->fetch(PDO::FETCH_NUM);
              
              
              if ($objinv->activado=='S')
                  $xact='S';
             else
                  $xact='N'; 
              
              //
           
             $libro->setActiveSheetIndex(0)->setCellValue('A'.(6+$y), $obj->nombre_faena); 
             $libro->setActiveSheetIndex(0)->setCellValue('B'.(6+$y), $obj->nombre_unidad); 
             
	     $libro->setActiveSheetIndex(0)->setCellValue('C'.(6+$y),$objinv->idformulario);
    	     $libro->setActiveSheetIndex(0)->setCellValue('D'.(6+$y),$objinv->fecha);
	     $libro->setActiveSheetIndex(0)->setCellValue('E'.(6+$y),$objinv->codigo_presupuesto);
	     $libro->setActiveSheetIndex(0)->setCellValue('F'.(6+$y),$objinv->descripcion);
	 //$d6=number_format($d6,'2','.',',');
           
	     $libro->setActiveSheetIndex(0)->setCellValue('G'.(6+$y),$objinv->descripcion_bien);
	 //$d7=number_format($d7,'0','.',',');
             $libro->setActiveSheetIndex(0)->getStyle('H'.(6+$y))->getNumberFormat()->setFormatCode('###,###,##0.00'); 
	     $libro->setActiveSheetIndex(0)->setCellValue('H'.(6+$y),$objinv->valor_compra);
	 

             $libro->setActiveSheetIndex(0)->getStyle('I'.(6+$y))->getNumberFormat()->setFormatCode('###,###,##0'); 
	     $libro->setActiveSheetIndex(0)->setCellValue('I'.(6+$y),$objinv->valor_pesos);
	     $libro->setActiveSheetIndex(0)->setCellValue('J'.(6+$y),$objinv->numero_activo);
	     $libro->setActiveSheetIndex(0)->setCellValue('K'.(6+$y),$objinv->numero_solpe);
	 
	     $libro->setActiveSheetIndex(0)->setCellValue('L'.(6+$y),$objinv->numero_pedido);
	 
	 //  rescato lo comprado y activado para el c�digo
             $libro->setActiveSheetIndex(0)->setCellValue('M'.(6+$y),$xact);
	     $libro->setActiveSheetIndex(0)->setCellValue('N'.(6+$y),$objinv->fecha2);
             $libro->setActiveSheetIndex(0)->getStyle('O'.(6+$y))->getNumberFormat()->setFormatCode('###,###,##0.00'); 
	     $libro->setActiveSheetIndex(0)->setCellValue('O'.(6+$y),$objinv->valor_real);
             $libro->setActiveSheetIndex(0)->setCellValue('P'.(6+$y),$objinv->comentarios);
             
             $libro->setActiveSheetIndex(0)->setCellValue('Q'.(6+$y),$xidwf);
             $libro->setActiveSheetIndex(0)->setCellValue('R'.(6+$y),$xfechawf);
             
             
             $libro->setActiveSheetIndex(0)->setCellValue('S'.(6+$y),$objinv->fecha3);
              
        $libro->setActiveSheetIndex(0)->setCellValue('T'.(6+$y),$objinv->tipo_clase);
        $libro->setActiveSheetIndex(0)->setCellValue('U'.(6+$y),$objinv->nombre_clase);
        $libro->setActiveSheetIndex(0)->setCellValue('V'.(6+$y),$objinv->idcentro_costo);      
	   
            
             
             $y++; 
           
           
       }
       
   }  
       
    if ($y>0){
    
    $libro->setActiveSheetIndex(0)->getStyle('A'.(6+$y).':S'.(6+$y))->getFont()->setBold(true);   
       
   $libro->setActiveSheetIndex(0)->getStyle('H'.(6+$y))->getNumberFormat()->setFormatCode('###,###,##0.00'); 
   $libro->setActiveSheetIndex(0)->setCellValue('H'.(6+$y),'=sum(H6:H'.(6+$y-1).')');
   $libro->setActiveSheetIndex(0)->getStyle('I'.(6+$y))->getNumberFormat()->setFormatCode('###,###,##0'); 
   $libro->setActiveSheetIndex(0)->setCellValue('I'.(6+$y),'=sum(I6:I'.(6+$y-1).')');
   $libro->setActiveSheetIndex(0)->getStyle('O'.(6+$y))->getNumberFormat()->setFormatCode('###,###,##0.00'); 
   $libro->setActiveSheetIndex(0)->setCellValue('O'.(6+$y),'=sum(O6:O'.(6+$y-1).')');
   


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
 

header( "Content-type: application/vnd.ms-excel; charset=UTF-8" );
header("Content-Disposition: attachment; filename=\"listado_compras_faena.xls\"");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Pragma: public");
		
ob_end_clean();

$objWriter = PHPExcel_IOFactory::createWriter($libro, 'Excel5');
			
			
$objWriter->save('php://output');
}
?>


 