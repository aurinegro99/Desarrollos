<link rel="stylesheet" type="text/css" href="../css/estilo.css" />




<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" bgcolor="#FFFFCC" onLoad="">

    
<div id="loading"  style="text-align: center; padding: 100px; font-size: 14px; display: none ">
    <img src="../img/loading.gif" align="absmiddle"> Cargando...
</div>
    
     <table width="1340" border="0" align="center" cellspacing="0" style="table-layout:fixed;" class="tablalistado" id="tablalistado">
     
     <?php

           if ($_REQUEST["idfaena"]>0) {

              $xparam=$_REQUEST["tipo"];

              require_once '../cargas/cargar_consumo.php';

?>    
         
     
     </table>   
    
    
    <?php
    
    
    
}  // endif
