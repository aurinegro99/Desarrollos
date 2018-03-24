<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../ini/inicial.php';
$usuario=$_SESSION["usuario"];

require_once '../lib/carga_periodos.php';

// rescata periodo




?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script language="JavaScript" type="text/JavaScript">

function Limpiar(){
    window.location.href='reporte_nomina_mes.php';
    
}

function imprimir(){
    var d=document.frm_cabecera; 
    if (d.periodo.value<=0){
        alert('Debe Seleccionar Periodo');
        return false;
    }
    
    d.action='excel_nomina_mes.php';
    d.submit();
    
    
}
    

</script>

<body >
<table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td class="titletable"><h4><strong>Reporte Nomina Mes</strong></h4></td>
    </tr>
 </table>
    
<br>

<form name="frm_cabecera" action="">

<table width="500" align="center" class="tablabase">
       <tr> <td height="5"></tr>
        <tr>
            <td>
             <table width="400" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">  

     <tr>
     <td class="titledatos" width="150">Periodo</td>
	 <td width="2%"></td>
         <td ><select name="periodo"  id="periodo"  >
                                <option value=-1></option>
                                <?php echo $opcion_periodo?>
                                              
                        </select> </td>
     </tr>
     <tr></tr>
    
     <tr> <td height="5"></td></tr>
    <tr> 
      <td colspan="5"><div align="center">
              
              <img src="../img/nuevo.gif" title="Limpiar" width="16" height="16" border="1" align="right" style="cursor:hand" onClick="Limpiar();" >
              <img src="../img/excel_icono.gif" title="Genera Informe" width="16" height="16" border="1" align="right" style="cursor:hand" onClick="imprimir();" >
		
		
        
	  </td>
	</tr> 
   
     </form>
     </table>
   </td>
   </tr>
</table>  
</form>

 
</body>


