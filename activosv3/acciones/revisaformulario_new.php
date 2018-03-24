<?php


if ($_SERVER["REQUEST_METHOD"]==="POST")
    {
       $formulario=$_GET["formulario"];
       // revisar que no tenga solicitud generada
       include "../lib/database_sauce.php"; 
       $nreg=0;
       $sql="select idworkflow from flujo_solicitud where idsolicitud=$formulario";
       $resul=$pdoGestion->query($sql);
       $nreg = $resul->rowCount();
       if ($nreg>0)
           echo $nreg;
    
       else
       {
        include "../lib/database.php"; 
        $sql="select idformulario,numero_activo from formulario_activo where idformulario=$formulario and status_solicitud='A' ";
        //echo $sql;
        $resul=sqlsrv_query($actf,$sql);
        $obj = sqlsrv_fetch_object($resul); 
        //echo sqlsrv_num_rows($resul);
        //if (sqlsrv_num_rows($resul)===TRUE)
            
        //{
           $xformulario=$obj->idformulario;
           $xactivo=$obj->numero_activo;
      	   if (strlen($xactivo)>5)
	       echo $xactivo;
	    else
	        echo $xformulario;   
        //}
        //else
          //  echo '0';
        
        /*
        $nreg=0;$xactivo=0;
        $nreg=sqlsrv_num_rows($resul);
        echo $nreg;
        if ($nreg>0)
            {
    	   $xformulario=$obj->idformulario;
           $xactivo=$obj->numero_activo;
	   if (strlen($xactivo)>5)
	      echo $xactivo;
	   else
	      echo $xformulario;   
            }
	
	else
            echo $nreg; */

}
    }
?>