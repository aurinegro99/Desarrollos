<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once '../app/clases/AutoConsumo.php';

$dato=new AutoConsumo();

$precio=$dato->getCriterioLista($_REQUEST["faena"],$_REQUEST["tipo"]);



$xvalor=0;
$sw=0;

foreach($precio as $datos){
       //echo $datos["idlista"];
       
        $vigencia=$dato->getVigenciaLista($_REQUEST["faena"],$datos["idlista"],$_REQUEST["fecha"]);
        foreach($vigencia as $xvigen){
               // consulto precios egun vigencia
               
               $xvalor=$dato->getValorLista($_REQUEST["parte"],$xvigen["idvigencia"]);
               foreach($xvalor as $xresp){
                    if ($xresp["precio_lista"]>0){
                          $sw=1;
                          ?>
                            <tr bgcolor= "#FFFFCC" onMouseOver="this.bgColor= '#EEEEEE'" onMouseOut="this.bgColor='#FFFFCC'"  > 
      		            <td width="100"  > <div align="left"> <?php echo $_REQUEST["parte"] ?></div> </td>
    	                    <td width=" 350" > <div align="left"> <?php echo $xresp["descripcion"] ?></div> </td> 
                            <td width="100" ><div align="left"> <?php echo $xresp["precio_lista"] ?></div> </td> 
            	            <td width="100" ><div align="left"> <?php echo $datos["moneda"]?></div> </td> 
                            <td width="200" ><div align="left"> <?php echo $datos["fabricante"]?></div> </td> 
                            <td width="80" ><div align="left"> <?php echo $xvigen["fecha"]?></div> </td> 
                            </tr>
		          <?php
		         break;
                                    
                    }        
                   
                   
                   
               }
               
            if ($sw==1)
                  break;
             
        }
    
}



