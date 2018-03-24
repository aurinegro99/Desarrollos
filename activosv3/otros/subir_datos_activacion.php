<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
include "../header/header.php"; 
$usuario=$_SESSION["usuario"];


//require_once '../lib/carga_faenas.php';


//include '../lib/meses_01.php';


// rescata periodo
/*
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

//$lista=$zperiodo->ultimaCarga($xperiodo,$pmes);
$ult='No registra Cargas para el Periodo';

//foreach($lista as $datos){
//       $ult = 'Ultima Carga Periodo '.$datos[0].' '.$datos[1];
//}

*/

?>

<script language="JavaScript" type="text/JavaScript">
    

function imprime_planilla(){
    //alert('imprimir planilla');
    
     document.getElementById("grabar").style.display="";
    var d=document.planilla;
    d.action='planilla_subida.php';
    d.submit();
  }    
  
function grabar(){
    if(window.XMLHttpRequest) {
		var Req = new XMLHttpRequest();
	}else if(window.ActiveXObject) {
		var Req = new ActiveXObject("Microsoft.XMLHTTP");
	} 
	
	//Pasándole la url a la que haremos la petición
	Req.open("POST", "grabar_activos.php", true);
    
    document.getElementById("salvar").style.display="";
    
    Req.onload = function(Event) {
		//Validamos que el status http sea  ok
		if (Req.status == 200) {
			/*Como la info de respuesta vendrá en JSON 
			la parseamos */
                    //    alert(Req.responseText);
            
			var st = Req.responseText;
                        
            if (st=='0')
               alert('Datos Grabados OK');
            else
               alert('Error al grabar') ; 
            
            document.getElementById("salvar").style.display="none";
            document.getElementById("planilla").value="";
            
		} 
	};	  
	
	//Enviamos la petición
	Req.send();
    
    
}    
    
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
	if(window.XMLHttpRequest) {
		var Req = new XMLHttpRequest();
	}else if(window.ActiveXObject) {
		var Req = new ActiveXObject("Microsoft.XMLHTTP");
	} 
	
	//Pasándole la url a la que haremos la petición
	Req.open("POST", "carga_datos_activacion.php", true);
        
        
        document.getElementById("carga").style.display="";
        
        
        
	
	/* Le damos un evento al request, esto quiere decir que cuando
	termine de hacer la petición, se ejecutara este fragmento de
	código */
	
	Req.onload = function(Event) {
		//Validamos que el status http sea  ok
		if (Req.status == 200) {
			/*Como la info de respuesta vendrá en JSON 
			la parseamos */
                        //alert(Req.responseText);
            //console.log(Req.responseText);
            
			var st = JSON.parse(Req.responseText);
                        
                    //alert(st.success);
                    //alert(st.mes);
                    //alert(st.periodo);
			
			if(st.success){
				/* Código si el return fue true */
                
                // confirmar carga y procesa
               // window.location.href='planilla_subida.php';
                document.getElementById("carga").style.display="none";
                
                if ((st.mes>1)||(st.mes<=0))
                    {
                        alert('Error en datos del Mes, revisar');
                        return false;
                    }
                if ((st.periodo>1)||(st.periodo<=0))
                    {
                        alert('Error en datos del Periodo, revisar');
                        return false;
                    }
                alert('Planilla Procesada');
                imprime_planilla();
                                 
                                
			}
                      
            
		} else {
		    	console.log(Req.status); //Vemos que paso.
		}
	};	  
	
	//Enviamos la petición
	Req.send(Data);
    
    
}
</script>

<body >
<table width="200" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td class="titletable"><h4><strong>Carga Datos Activación </strong></h4></td>
    </tr>
 </table>
    
<br>



<div id="carga" style="display:none" align="center" >
    <img src="../img/ajax-loader.gif" />
</div>  
<div id="salvar" style="display:none" align="center" >
    <img src="../img/saving.gif" />
</div>      
    

<div id="form" style=""     >

      <table width="700" align="center" class="tablabase">
         <tr> <td height="5"></tr>
         <tr>
           <td>
              <table width="650" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">  
                  <form id="subir" action="javascript:mandaForm(this)" name="subir" >
                     
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
  
    <div align="center">
    </div>    
</div>
    
<br>
    
    <div id="grabar" style="display:none" align="center" >
    
    <table width="100" align="center" class="tablabase" >
          <form name="planilla" method="post" >
              <tr>
                 <td align="center" ><input type="submit" value="Grabar" onclick="grabar();"  ></td>
              </tr>
              </form> 
    </table>
    </div>
    
 
</body>


