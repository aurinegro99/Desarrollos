<?php
session_start();
$usuario=$_SESSION["usuario"];
include_once '../lib/database.php';

// rescatar mes y periodo para borrar
$sql="select distinct(numero5) as mes, numero6 from paso where (numero5>0 and numero6>0) and usuario='$usuario' and campo14='10' ";
$resul=sqlsrv_query($actf,$sql);
$obj = sqlsrv_fetch_object($resul);
$xmes=$obj->mes;
$xperiodo=$obj->numero6;

// resetear todos los activos del mes periodo

$sql="update formulario_activo
      set activado='N', fecha_activacion=convert(datetime,'01/01/3000',103), valor_real=0 
      where  month(fecha_activacion)=$xmes and year(fecha_activacion)=$xperiodo and activado='S' ;";
//echo $sql;
$resul=sqlsrv_query($actf,$sql);


// rescatar datos


$sql="select  campo1,numero1,campo2,numero2,convert(varchar,fecha1,103) as fecha,campo2,campo3,convert(varchar,fecha2,103) as alta from paso where usuario='$usuario' and campo14='10'  and campo2='S' and (((month(fecha2)=$xmes) and (year(fecha2)=$xperiodo)) or (campo3='N')) ;";

//echo $sql;
$resul=sqlsrv_query($actf,$sql);
 while($obj = sqlsrv_fetch_object($resul)){
     
     // actualizar datos
     $sqla="update formulario_activo 
            set fecha_activacion=convert(datetime,'$obj->fecha',103),activado='S', valor_real=$obj->numero1
            where numero_activo='$obj->campo1'";
     //echo $sqla;
     $resula=sqlsrv_query($actf,$sqla);
 }


echo '0';