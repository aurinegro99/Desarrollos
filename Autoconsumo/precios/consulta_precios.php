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
 <script src="../app/js/valida_carga_planilla.js" type="text/javascript" > </script>
 
 <body>

 <div class="container">
        <div class="col-md-10">
            <h4 class="text-center "><strong>Consulta Precios Lista</strong></h3>
        </div>
 </div>
     
     
 
 <form name='fm_cabecera' method="post" >
   
    
    <table width="1000" align="center" >
        <tr></tr>
        <tr>
            <td>
              <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">  
                <tr>
                    <td class="titledatos" width="150">Seleccione Faena</td>
                    <td width="2%"></td>
                    <td >
                        <select name='idfaena' id="idfaena">
                            <option value=-1></option>
                            <?=$opcion_faena?>
                        </select>
                    </td>
                </tr>
                <tr><td height="2"></td></tr>
                <tr>
                    <td class="titledatos" width="150">Tipo Equipo </td>
                    <td width="2%"></td>
                    <td >
                        <select name='tipo_equipo' id="tipo_equipo">
                        <option value=-1></option>
                        </select>  
                    <td>

                </tr>

                <tr><td height="2"></td></tr>

                <td class="titledatos" width="250">Fecha Consulta</td>
                    <td width="2%"></td>
                    <td> <input type="text" id="fecha" readonly="true" name="fecha"></td>
                       <script type="text/javascript">
                               var picker = new Pikaday(
                                    {
                               field: document.getElementById('fecha'),
                               toString: function(date, format) {
                               return dateFns.format(date, format);
                                 },
                              firstDay: 1,
                              minDate: new Date(2000,1,1),
                              maxDate: new Date(3000, 01, 01),
                              yearRange: [2000,3000]
                              });
        
                        </script>
      </tr>
     <tr></tr>     
                
                
               
				<tr></tr>
				
				<tr>
                    <td class="titledatos" width="150">Numero Parte</td>
                        <td width="2%"></td>
                    <td ><input name="parte" id="parte" value="" style="text-transform:uppercase;" size="20" maxlength="30"></td>
                </tr>
                <tr></tr>

               

                <tr> 
                    <td height="5"></td>
                </tr>
                <tr> 
                        <td colspan="3"><div align="center">
                         <button type="submit" class="btn btn-primary" id="buscar" >Buscar</button>
                         <button type="submit" class="btn btn-secondary" id="limpiar" >Limpiar</button>       
                                
                                
                        
                     </td>
                </tr> 

              </table>
            </td>
        </tr>
   </table>  
 </form>


<br>

<table width="1000" align="center" >
 
 <tr></tr>
 <tr>
   <td>
      <table width="95%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">  
          <form name="fm_subir" id="fm_subir" method="post" enctype="multipart/form-data" target="_self">
              <div id="new">
                  
              </div>
              <input type="hidden" name="phpMyAdmin" />
     
      <tr>
         <td class="titledatos" width="150">Archivo</td>
	     <td width="2%"></td>
             <td><input name="fileUpload" type="file" id="fileUpload" size="50" /> <input type="submit" value="Enviar" id="enviar" >
             
          </td>
          
           
           
             
      </tr>
      </form>
      </table>
   </td>
   </tr>   
</table>     
<br>
<br>

<table width="1000" height="0" border="0" align="center" cellspacing="0" style="table-layout:fixed;" class="tablaprincipal">
    <tr> 
	
    <td width="150"> 
    <div align="left">Material</div></td>
    <td width="300" > 
    <div align="left">Descripcion</div></td>
    <td width="100"> 
    <div align="left">Valor Lista</div></td>
	<td width="120"> 
    <div align="left">Moneda</div></td>
	<td width="120"> 
    <div align="left">Proveedor</div></td>
	<td width="150"> 
    <div align="left">Vigencia</div></td>
   

  </tr>
  </table>

<div align="center">
    <table width="1000" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;" class="tablaframe" >
        <tr>
            <td>
                <iframe name="ifrm1" id="ifrm1" width="100%" height="250" scrolling="yes" src="../iframes/ifrm_numero_parte.php"  frameborder="0" align="middle" ></iframe>
            </td>
        </tr>
    </table>
</div>

<form id="iframeForm" method="post" target="" action="">
        <input type="hidden" value="" name="parte">
	<input type="hidden" value="" name="faena">
	<input type="hidden" value="" name="fecha">
	<input type="hidden" value="" name="tipo">
	
  
</form>


     
     
     
     
 </body>
