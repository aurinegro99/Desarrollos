<?php


//incluimos la clase

//require_once "app/clases/UsuarioLocal.php";
//require_once "app/clases/UsuarioAmazon.php";
//require_once '../phpexcel/Classes/PHPExcel.php';
// creamos el objeto
//$dbusuario=new UsuarioLocal();


//echo $dbusuario->cierraPeriodo('U1301142');


//  $libro1 = PHPExcel_IOFactory::load('subidos/planilla.xlsx');
//  $objWorksheet = $libro1->getActiveSheet(2);
                // recorrer los datos subidos
 // $nfilas = $objWorksheet->getHighestRow()-1;
  
  //$usuario='U1301142';
  
  
  
  
  //$lista=new UsuarioLocal();
  // $zamazon= new UsuarioAmazon();
  
 //  $xlista=$zamazon->getNombreFaenas(1,2);
 
 
 $formula='($var1*0.30)+($var2*0.70)';
 
 $var1=15000;
 $var2=30000;
 
 eval("\$var = $formula;");

   
   echo $var;
   
   //var_dump($xlista);
   
   //             $zperiodo='201709';
   //             $campos=$lista->getDatosNominaPeriodo($zperiodo);
    //            echo var_dump($campos);
                
                /*
                
                 $dato= new ArrayObject();
                  for ($i = 2; $i <= $nfilas; $i++){
                      $cola=$objWorksheet->getCellByColumnAndRow(0, $i)->getValue();  // rut
                      $colb=$objWorksheet->getCellByColumnAndRow(1, $i)->getValue();  // nombre
                      $cold=$objWorksheet->getCellByColumnAndRow(3, $i)->getValue();  // sociedad
                      $cole=$objWorksheet->getCellByColumnAndRow(4, $i)->getValue();  // fecha ingreso
                      $colf=$objWorksheet->getCellByColumnAndRow(5, $i)->getValue();  // fecha salida
                      $colj=$objWorksheet->getCellByColumnAndRow(9, $i)->getValue();  // sucursal
                      $colk=$objWorksheet->getCellByColumnAndRow(10, $i)->getValue();  // nomb. suc
                      $coll=$objWorksheet->getCellByColumnAndRow(11, $i)->getValue();  // unidad
                      $colm=$objWorksheet->getCellByColumnAndRow(12, $i)->getValue();  // nombre unidad
                      $coln=$objWorksheet->getCellByColumnAndRow(13, $i)->getValue();  // ceco
                      $colp=$objWorksheet->getCellByColumnAndRow(15, $i)->getValue();  // cargo
                      $colq=$objWorksheet->getCellByColumnAndRow(16, $i)->getValue();  // nomb. cargo
                      $colr=$objWorksheet->getCellByColumnAndRow(17, $i)->getValue();  // cateogira
                      $cols=$objWorksheet->getCellByColumnAndRow(18, $i)->getValue();  // nomb. cat.
                      $colu=$objWorksheet->getCellByColumnAndRow(20, $i)->getValue();  // periodo
                      $colz=$objWorksheet->getCellByColumnAndRow(25, $i)->getValue();  // contrato
                      $colaa=$objWorksheet->getCellByColumnAndRow(26, $i)->getValue();  // convenio
                      
                       // obtener datoa de faena
                      $idfaena=$zamazon->getIdFaena(trim($coln));
                      $zid=0;
                      
                      foreach ($idfaena as $xid){
                          
                             $zid=$xid[0];  
                          
                      }
                      
                      if ($zid>0)
                          $idconv=$lista->getConveniosNro($zid, trim($colaa));
                      
                      else
                         $idconv=0; 
                      
                      $dato->append(array($cola,$colb,$cold,$cole,$colf,$colj,$colk,$coll,$colm,$coln,$colp,$colq,$colr,$cols,$colu,$colz,$colaa,$usuario,$zid,$idconv));
                      
                  }
                  
                   echo var_dump($dato);
                  
                  $lista->grabaPlanilla($dato);
*/


/*
$arr = array(10, 20, 30, 40);


$dbusuario->grabaAccesos('U1301142',$arr);

$lista=$dbusuario->getUsuarioFaena('U1301142');

foreach ($listado as $lista){
    
    echo $lista["idfaena"]."<br>";
    
    
}
 * 
 *
 */