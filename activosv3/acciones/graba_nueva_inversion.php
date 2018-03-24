<?
session_start();
if ($_SERVER["REQUEST_METHOD"]==="POST")
{
     $xusuario=$_SESSION["usuario"]; 
     include "../lib/database.php";
    
    
     $idperiodo=$_REQUEST["idperiodo"];    // periodo
     $idfaena=$_REQUEST["idfaena"];    // faena
     $idcentro=$_REQUEST["idcentro"];    // centro_costo
     $idclase=$_REQUEST["idclase"];    // clase
     $descripcion=$_REQUEST["descripcion"];    // descrip
     $cantidad=$_REQUEST["cantidad"];    // cantidad
     $valor=$_REQUEST["valor"];    // valor
     $mes_c=$_REQUEST["mes_c"];    // mes _c
     $mes_a=$_REQUEST["mes_a"];    // mes_a
     $proyecto=$_REQUEST["proyecto"];    // proyecto
     $motivo=$_REQUEST["motivo"];    // moitvo
     $prioridad=$_REQUEST["prioridad"];    // prioridad
    

$sql="insert into inversiones_presupuesto
      (idperiodo,idfaena,ceco,idclase,descripcion_bien,cantidad,valor_unitario,mes_compra,mes_activacion,proyecto,motivo,prioridad,usuario,fecha_ingreso)
	  values($idperiodo,$idfaena,'$idcentro',$idclase,'$descripcion',$cantidad,$valor,$mes_c,$mes_a,$proyecto,$motivo,'$prioridad','$xusuario',getdate())";
 
//echo $sql;    
$resul=sqlsrv_query($actf,$sql);
    

if ($resul)
   echo '0';
else
   echo '1';   	  


    
}
