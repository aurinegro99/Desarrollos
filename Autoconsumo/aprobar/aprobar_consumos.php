<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../ini/inicial.php';
require_once '../cargas/carga_faenas.php';

// ip
$ip='';
$ip= $_SERVER['HTTP_X_FORWARDED_FOR'];

if ($ip<=0)
    $ip=$_SERVER['REMOTE_ADDR'];



?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/date-fns/1.28.5/date_fns.min.js"></script>
 <script src="../app/js/pikaday.js"></script>

 <script src="../app/js/valida_aprobar.js"  type="text/javascript" > </script>

<body>

 <div class="container">
        <div class="col-md-10">
            <h4 class="text-center "><strong>Aprobar Consumo Repuestos</strong></h3>
        </div>
 </div>
   
    <table width="850" align="center" >
 <tr></tr>
   <tr>
   <td>
     <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">  
         <form id="fm_cabecera" method="post" >
             <input type="hidden" name="ip" id="ip" value="<?php echo $ip ?>" >
             <input type="hidden" name="fec_inicio" id="fec_inicio"  >
             <input type="hidden" name="fec_termino" id="fec_termino"  >
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
     <tr></tr>  
        <tr>
           <td class="titledatos" width="250">Total Aprobado USD</td>
           <td width="2%"></td>
           <td> <input type="text" id="total_aprobado_usd" readonly="true" name="total_aprobado"></td>
      </tr>
     <tr></tr>  
        <tr>
           <td class="titledatos" width="250">Total Aprobado EUR</td>
           <td width="2%"></td>
           <td> <input type="text" id="total_aprobado_eur" readonly="true" name="total_aprobado"></td>
      </tr>
     
     </form>
         
     <tr></tr>
   
   
     
     <tr> <td height="5"></td></tr> 
        
         
    <tr> 
       
        <td colspan="4" id="barra_grabar" style="display: none"  ><div align="left">
                
                <button type="submit" class="btn btn-danger" id="grabar_con"  >Grabar</button>
	</td>
        
        <td colspan="4"><div align="right" id="beditar">
                         <button type="submit" class="btn btn-success" id="listar"  >Listar</button>
                         
                           <button type="submit" class="btn btn-secondary" id="limpiar" >Limpiar</button>
       
	</td>
	   
	
      
		
        
       
	</tr> 
         
     </table>
 </table> 
    
    
     <div id="carga" style="display:none" align="center" >
    <img src="../img/ajax-loader.gif" />
</div>  
    
    
   
<table width="1350" height="0" border="0" align="center" cellspacing="0" style="" class="tablaprincipal" id="f2" style="display:none">
    <tr> 
	
  <td width="30"> 
    <div align="left">Linea</div></td>
    <td width="70"> 
    <div align="left">Fec. Contable</div></td>
    <td width="60" > 
    <div align="left">O./Servicio</div></td>
    <td width="80" > 
    <div align="left">Docto.Material</div></td>
    <td width="70"> 
    <div align="left">Equipo</div></td>
    <td width="80"> 
    <div align="left">Nro.Parte</div></td>
    <td width="200"> 
    <div align="left">Material</div></td>
    <td width="60"> 
    <div align="left">Cantidad</div></td>
    <td width="70"> 
    <div align="left">Precio Lista</div></td>
    <td width="50"> 
    <div align="rigth">Factor </div></td>
    <td width="50"> 
    <div align="rigth">Descto</div></td>
    <td width="80"> 
    <div align="left">Total Repto.</div></td>
    <td width="40"> 
    <div align="left">Moneda</div></td>
    <td width="100"> 
    <div align="rigth"> Motivo OS</div></td>
    <td width="60" style="cursor:hand" onClick="verstatus()"> 
    <div align="rigth">Aprueba</div></td>

  </tr>
  </table>
    <div align="center" id="f3">
	<table width="1350" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;" class="tablaframe" >
		<tr>
			<td style="" id="f3" style="">
			   
                            <iframe name="ifrm1" id="ifrmx1" width="100%" height="500" scrolling="yes" src="../iframes/ifrm_aprobar_consumos.php"  frameborder="0" align="middle" ></iframe>
			</td>
		</tr>
	</table>
</div>

<form id="iframeForm" method="post" target="" action="">
    <input type="hidden" value="" name="idfaena">
    <input type="hidden" value="" name="idcontrato">
    <input type="hidden" value="" name="inicio">
    <input type="hidden" value="" name="termino">
     <input type="hidden" value="" name="tipo">
   
</form>
   

    
</body>

