<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once '../app/clases/AutoConsumo.php';

// parametros de faena
$param1=new AutoConsumo();
$lista_1=$param1->getParametros1($_REQUEST["idfaena"], $_REQUEST["idcontrato"], $_REQUEST["inicio"],$_REQUEST["termino"]);
//var_dump($lista_1);
foreach ($lista_1 as $param_v){
        
        $xpar1=$param_v["aprobar"];
        $xpar2=$param_v["tipo_aprobar"];
        $xpar3=$param_v["aprobado"];
      
    
}
// visualizacion
$param2=new AutoConsumo();
$lista_2=$param2->getParametros2($_REQUEST["idfaena"], $_REQUEST["idcontrato"]);

// hago consulta
$xcont=0;
foreach ($lista_2 as $datos){
         $dato= new ArrayObject();
         $dato->append(array($_REQUEST["idcontrato"],$_REQUEST["idfaena"],$datos["parametros"],$xparam,$xpar2,$_REQUEST["inicio"],$_REQUEST["termino"]));
         $rescate=new AutoConsumo();
         $xlista=$rescate->getDatosAprobacion($dato);
         $xpaso_os=0;
         $newreg=0;      
         $xcolor='';
         $nlinea=0;
        // var_dump($xlista);
         foreach($xlista as $valores){
                 $xcont++;
                 
                 if ($xpar1=='R'){ 
                               //$d1 os  d6 docto material
                     if ($xpar2==0)
                         $zagrupa=$valores["numero_orden"];
                     else
                         $zagrupa=$valorres["docto_material"];
                     }
                 else 
                    $zagrupa=$valores["idconsumo"];    
                 if ($newreg!==$zagrupa){
                      if ($xcolor=="#FFFFCC")
                          $xcolor="#85929E";
                      else
                          $xcolor="#FFFFCC";
                      $newreg=$zagrupa;
                    }
                  $mdescto=round(100-($valores["descuento"]*100),2);
		  // valor repuesto
                  $tot_linea=number_format($valores["cantidad"]*$valores["precio_lista"]*$valores["factor"]*$valores["descuento"],2,'.',',');
		  $vta=number_format($valores["precio_lista"],2,'.',',');
		  $pago=number_format($valores["valor_pago"],2,'.',',');
		  $tot_pago=number_format($valores["cantidad"]*$valores["valor_pago"]*$valores["factor"]*$valores["descuento"],2,'.',',');   
                    
                 
                  ?>
                    <tr bgcolor= "<?php echo $xcolor ?>" onMouseOver="this.bgColor= '#EEEEEE'" onMouseOut="this.bgColor='<?php echo $xcolor?>'"  > 
                         <td width="30"  > <div align="left"> <?php echo $xcont?></div> </td>
                         
                         <td width="80" > <div align="left"> <?php echo $valores["fecha_contable"] ?></div> </td>
                              <?php 
                             if ($xpaso_os!=$zagrupa)
                                 {
                             ?>
                             <td width="65" > <div align="left"> <?php echo $valores["numero_orden"] ?></div> </td>
                             <td width="80" > <div align="left"> <?php echo $valores["docto_material"] ?></div> </td>  <!--- 100  ---->
                             <?php  
                             }
                             else { 
                                 if ($xpar2==0)
                                 {// por os
                             ?>
                                    <td width="65" > <div align="left"> </div> </td>
                                    <td width="80" > <div align="left"> <?php echo $valores["docto_material"]?></div> </td>
                             <?php  }
                                else { 
                             ?>
                                    <td width="65" > <div align="left"> <?php echo $valores["numero_orden"]?></div> </td>
                                    <td width="80" > <div align="left"> </div> </td>    
                             <?php       
                                    }
                             }
                             ?>
                          
                                 
                             <td width="40"><div algn="left"><?php echo $valores["descripcion"] ?></div></td>    
                             <td width="70" > <div align="left"> <?php echo $valores["numero_interno"]?></div> </td> <!--- 90  ---->  
                             <td width="90" > <div align="left"> <?php echo $valores["numero_parte"]?></div> </td>
			     <td width="200" > <div align="left"><?php echo $valores["nombre_material"]?></div> </td>   <!--- 200  ---->
                             <td width="90" > <div align="right"><?php echo $valores["cantidad"]?></div> </td>  <!-- cantidad -->
                             <td width="70" > <div align="right"><?php echo $pago?></div> </td> <!-- Moneda pago -->
                             <td width="70" > <div align="right"><?php echo $valores["factor"]?></div> </td> <!-- Moneda pago -->
                             <td width="40" > <div align="right"><?php echo $mdescto.' %' ?></div> </td> <!--% descto  -->
                             <td width="80" title="<?=$zmon_pago?>"> <div align="right"><?php echo $tot_pago?></div> </td> <!--total --> 
			      <td width="40" > <div align="center"><?php echo $valores["moneda_pago"]?></div> </td> <!-- Moneda pago -->
                             
                             <td width="30" > <div align="center"><?php echo $valores["clase_actividad"]?></div> </td> <!--Clase actividad -->  
                             <td width="160" > <div align="center"><?php echo $valores["texto_orden"]." (".$valores["campo_10"]." )" ?></div> </td> <!--Motivo Os -->
                             <?php 
                             if ($xpaso_os!=$zagrupa){
				$nlinea++;
                                $xpaso_os=$zagrupa; ?>
                             <td width="30"><div align="center"><input id="libera" type="checkbox" value="<?php echo $zagrupa ?>" <?php ; if ($xpar3=='S') { echo 'checked="true"' ; }   ?>  ></div></td>
                             <?php  } 
                             else {
                             ?>
                             <td width="30"><div align="center"></div></td>
                             <?php  }  ?>
                        </tr>
                <?php
            }               
         }
         

    


