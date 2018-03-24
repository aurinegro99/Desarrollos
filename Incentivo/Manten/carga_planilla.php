<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../ini/inicial.php';
$usuario=$_SESSION["usuario"];

require_once '../app/clases/UsuarioLocal.php';

include '../lib/meses_01.php';


// rescata periodo

$zperiodo=new UsuarioLocal();
$lista=$zperiodo->getUltimoPeriodo();
foreach($lista as $datos){
    
    $xperiodo=$datos["periodo"];
    $xmes=$datos["mes"];
    $xstatus=$datos["status"];
     if (strlen($xmes)==1)
            $pmes='0'.$xmes;
     else
         $pmes=$xmes;
    
    
}

$lista=$zperiodo->ultimaCarga($xperiodo,$pmes);
$ult='No registra Cargas para el Periodo';

foreach($lista as $datos){
       $ult = 'Ultima Carga Periodo '.$datos[0].' '.$datos[1];
}



?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script language="JavaScript" type="text/JavaScript">
    
    
    
function mandaForm(){
    var d=document.subir; 
    
    
    if (d.planilla.value==""){
        alert('Debe seleccionar archivo');
        return false;
    }
    
    var extension_archivo = d.planilla.value.split(".");
    var extension = extension_archivo[extension_archivo.length-1];
    
	
	//alert(extension)
    if( !extension.match(/(xls)|(XLS) |(XLSX) | (xlsx)/) )
	{
        alert ( "Sólo se permite subir Planillas Excel " );
        return false;
    }
    
    // buscar acentos
     posicion=d.planilla.value.indexOf("áéíóúÁÉÍÓÚ");
     if (posicion>0){
         alert ( "nombre Planilla no debe tener palabras acentuadas " );
        return false;
     }
     
    
    var Data = new FormData(document.subir);
	
	/* Creamos el objeto que hara la petición AJAX al servidor, debemos de validar si existe el 	objeto “ XMLHttpRequest” ya que en internet explorer viejito no esta, y si no esta usamos 
	“ActiveXObject” */
	//alert(Data); 
	
	
	//Pasándole la url a la que haremos la petición
	Req.open("POST", "subir_planilla.php", true);
        
        
        document.getElementById("carga").style.display=""; 
        
        document.getElementById("form").style.display="none";
        
	
	/* Le damos un evento al request, esto quiere decir que cuando
	termine de hacer la petición, se ejecutara este fragmento de
	código */
	
	Req.onload = function(Event) {
		//Validamos que el status http sea  ok
		if (Req.status == 200) {
			/*Como la info de respuesta vendrá en JSON 
			la parseamos */ 
                        //alert(Req.responseText);
            
			var st = JSON.parse(Req.responseText);
                        
                       // alert(st);
			
			if(st.success){
				/* Código si el return fue true */
                                 alert('Datos Ok');
                                 
                                
			}else{
				/* Código si el return fue false */
                                if (st.datos==999)
                                    alert('Error en datos de Periodo o Sociedad en Planilla ('+st.LSoc+'/'+st.LPer+')');
			}
                         
                        //document.getElementById("carga").style.display="none";
                        //document.getElementById("form").style.display="";
                        //document.subir.planilla.value="";
                        
                         window.location.href='carga_planilla.php';
		} else {
		    	console.log(Req.status); //Vemos que paso.
		}
	};	  
	
	//Enviamos la petición
	Req.send(Data);
    
    
}
</script>

<body >
<table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td class="titletable"><h4><strong>Carga Planilla Datos</strong></h4></td>
    </tr>
 </table>
    
<br>

<table width="800" align="center" class="tablabase">
       <tr> <td height="5"></tr>
        <tr>
            <td>
             <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">  
     <form name='frm_cabecera'  >
     <input type="hidden" name="xperiodo" value="<?php echo $xperiodo?>">
     <input type="hidden" name="xmes" value="<?php echo $xmes?>">
     
     
     <tr>
     <td class="titledatos" width="150">Periodo</td>
	 <td width="2%"></td>
         <td ><input type="text" name="periodo" value="<?php echo $meses[$xmes].' / '.$xperiodo?>" size="20" readonly > </td>
     </tr>
     <tr></tr>
    
     <tr> <td height="5"></td></tr>
   
     </form>
     </table>
   </td>
   </tr>
</table>  

<div id="carga" style="display:none" align="center" >
    <img src="../img/ajax-loader.gif" />
</div>  

<div id="form" style=""     >

<?php
   if ($xstatus=='A') { ?>
      <table width="800" align="center" class="tablabase">
         <tr> <td height="5"></tr>
         <tr>
           <td>
              <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">  
                  <form id="subir" action="javascript:mandaForm(this)" name="subir" >
                      <input type="hidden" name="xperiodo" value="<?php echo $xperiodo?>">
                      <input type="hidden" name="xmes" value="<?php echo $xmes?>">
                   <tr>
                    <td class="titledatos" width="150">Archivo</td>
	            <td width="2%"></td>
                    <td><input name="planilla" type="file" id="planilla" ></td>
                    <td><input type="submit" value="Enviar" ></td>
                  </tr>
              </form>
              </table>
          </td>
        </tr>   
      </table> 
  
  <?php     
   }
  ?> 
    <div align="center">
       <td>  <h4><?php echo $ult ?></td>
    </div>    
</div>   
 
</body>


