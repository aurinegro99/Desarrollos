<?
    $sql="select idpresupuesto,periodo from presupuesto where (status='P' or status='A')";

    $resul = $pdoGestion->query($sql);

   while (list($d1,$d2) = $resul->fetch(PDO::FETCH_NUM))
   {
     $opcion_periodo.="<option value=$d1 >$d2</option>";
   }
?>
