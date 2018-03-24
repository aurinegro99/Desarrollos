<?php
session_start();

$faena = $_REQUEST["faena"];
$periodo = $_REQUEST["periodo"];


?>
<link rel="stylesheet" type="text/css" href="../css/estilo.css" />


<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#FFFFCC" onLoad="parent.carga_resumen();">
<table width="1150" border="0" align="center" cellspacing="0" style="table-layout:fixed;" class="tablalistado" id="100">

<?php

include "../lib/database.php"; 
include "../lib/meses_01.php"; 

if(!isset($periodo))
	$periodo=0;

if(!isset($faena))
	$faena=0;
	
if (($faena>0) and ($periodo>0)){
	
	$sql="select * from inversiones_presupuesto where idfaena=$faena and idperiodo=$periodo order by ceco,idclase";
    $resule=sqlsrv_query($actf,$sql);
    //echo $sql;
    while($obj = sqlsrv_fetch_object($resule))
    {
         // buscar la clase
        $sqlg="select tipo_clase,nombre_clase from clase_activo where idclase=$obj->idclase ;";
        $resulg=sqlsrv_query($actf,$sqlg);
        $objg = sqlsrv_fetch_object($resulg);
        $xtipo=$objg->tipo_clase;
        $nombre_clase=$objg->nombre_clase;
        // busco motivo
	    $sqlg="select nombre_motivo from motivo_inversion where idmotivo=$obj->motivo ;";
        $resulg=sqlsrv_query($actf,$sqlg);
        $objg = sqlsrv_fetch_object($resulg);
	    $nombre_motivo=$objg->nombre_motivo;
        // busco proyecto
	 
	    $sqlg="select nombre_proyecto from proyecto_inversion where idproyecto=$obj->proyecto ;";
        $resulg=sqlsrv_query($actf,$sqlg);
        $objg = sqlsrv_fetch_object($resulg);
	    $nombre_proyecto=$objg->nombre_proyecto;
	 	 // naturaleza
	 	//$sqlg="select naturaleza from centros_costos where centro_costo='$obj->ceco' ;";
        //$resulg=sqlsrv_query($actf,$sqlg);
        //$objg = sqlsrv_fetch_object($resulg);
        //$nombre_naturaleza=$obj->naturaleza;
        // determinar el mes
        
        if ($obj->mes_compra<=9)
	       $indc=$obj->mes_compra+3;
	    else
	        $indc=$obj->mes_compra-9;  
	    if ($obj->mes_activacion<=9)
	        $inda=$obj->mes_activacion+3;
	    else
	        $inda=$obj->mes_activacion-9;    
        
        
   
	 
	  ?>
           <tr bgcolor= "#FFFFCC" onMouseOver="this.bgColor= '#EEEEEE'" onMouseOut="this.bgColor='#FFFFCC'"  > 
                   <td width="90"  style="cursor:hand" onClick="parent.ver_inversion(<?php echo $obj->correlativo?>)" > <div align="left"> <?php echo $obj->ceco?></div> </td>  
                   <td width="200" > <div align="left"> <?php echo $xtipo.'-'.$nombre_clase ?></div> </td> 
                   <td width="300" ><div align="left" title="Proy:<?php echo $nombre_proyecto?> "> <?php  echo $obj->descripcion_bien ?></div> </td>
				   <td width="50" ><div align="right"> <?php echo $obj->cantidad ?></div> </td>
                   <td width="80" ><div align="right"> <?php echo number_format($obj->valor_unitario,2,'.',',')?></div> </td> 
                   <td width="80" ><div align="right"> <?php echo number_format($obj->valor_unitario*$obj->cantidad,2,'.',',')?></div> </td> 
				                   
                   <td width="100" ><div align="center"> <?php echo $meses[$indc] ?></div> </td>
                   <td width="100" ><div align="center"> <?php echo $meses[$inda] ?></div> </td>
                   
                   <td width="70" ><div align="left"> <?php echo $nombre_motivo ?></div> </td> 
                   <!--<td width="30" style="cursor:hand" > <div align="center"><img src="../img/folio01.gif" border="0" title="Duplicar" onClick="parent.duplicar(<?php //echo $obj->correlativo ?>)" ></div> </td> 
                   <td width="30" style="cursor:hand" > <div align="center"><img src="../img/basket.gif" border="0" title="Borrar" onClick="parent.borrar(<?php //echo $obj->correlativo?>)" ></div> </td> -->
                   
                   
                  
                </tr>

<?
   				  
  } //   while
  
  // cargar real sin ppto
  
   
  

}   //if 
?>
</table>
</body> 

