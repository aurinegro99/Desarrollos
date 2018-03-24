<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../ini/inicial.php';
require_once '../cargas/carga_faenas.php';

?>

<script src="../app/js/valida_reporte.js"  type="text/javascript" > </script>

<body>

 <div class="container">
        <div class="col-md-10">
            <h4 class="text-center "><strong>Reporte Consumo Aprobados Estado Pago</strong></h3>
        </div>
 </div>
 
   <table width="850" align="center" >
 <tr></tr>
   <tr>
   <td>
     <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">  
         <form id="fm_cabecera" method="post" >
            
     <tr>
     <td class="titledatos" width="250">Seleccione Faena</td>
	 <td width="2%"></td>
         <td ><select id='idfaena' name="idfaena">
     <option value=-1></option>
     <?php echo $opcion_faena?>
     </select></td>
     </tr>
     <tr></tr>
     <tr>
     <td class="titledatos" width="250">Seleccione Contrato</td>
     <td width="2%"></td>
     <td ><select id='contrato' name="contrato">
           <option value=-1></option>
   
           </select></td>
      </tr>
     <tr></tr> 
     <tr>
      <td class="titledatos" width="250">Seleccione Estado Pago</td>
      <td width="2%"></td>
       <td ><select id='estado_pago' name="estado_pago">
           <option value=-1></option>
   
           </select></td>
      
     </tr>       
     
     </form>
         
     <tr></tr>
   
   
     
     <tr> <td height="5"></td></tr> 
        
         
    <tr> 
       
    
        <td colspan="4"><div align="right" id="beditar">
                         <button type="submit" class="btn btn-success" id="listar"  >Listar</button>
                         
                           <button type="submit" class="btn btn-secondary" id="limpiar" >Limpiar</button>
       
	</td>
       
       
	</tr> 
         
     </table>
 </table>    
