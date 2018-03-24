
<link rel="stylesheet" type="text/css" href="../css/estilo.css" />




<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#FFFFCC" onLoad="">

    
<div id="loading"  style="text-align: center; padding: 100px; font-size: 14px; display: none ">
    <img src="../img/loading.gif" align="absmiddle"> Cargando...
</div>

    <table width="1000" border="0" align="center" cellspacing="0" style="table-layout:fixed;" class="tablalistado" id="100"> 
    
    
    <?php

         //echo 'Valor Faena '.$_REQUEST["idfanea"];
    
           if ($_REQUEST["faena"]>0) {

              
              require_once '../cargas/cargar_numero_parte.php';

?>    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    </table>   
    
      <?php
      
      if ($xvalor==0){
		
		   echo "<script language='JavaScript' type='text/JavaScript'>";
		   echo "alert('Numero Parte No Existe, Consulte Por Cambio de Número')";
		   echo "</script>";
		
		
		}
      
    
}  // endif
  
    
    