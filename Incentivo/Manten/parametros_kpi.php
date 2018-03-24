<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../ini/inicial.php';
$usuario=$_SESSION["usuario"];

?>

<script language="JavaScript" type="text/JavaScript">
    
    

function Limpiar()
{
	  
 window.location.href='parametros_kpi.php';	 
}

function isBlanco(texto){
      largo = texto.length
      for (i=0; i < largo ; i++ )
          if ( texto.charAt(i) !=" ")
             return false;
      return true
   }
   

function agregar(){
    var d = document.frm_cabecera;
    if (isBlanco(d.nombre.value)){
        alert('Debe Ingresar Nombre Parametro');
        return false;
    }
    
    if (isBlanco(d.clave.value)){
        alert('Debe Ingresar Clave Parametro');
        return false;
    }
    
    if (isBlanco(d.nombre_variable.value)){
        alert('Debe Ingresar Nombre Variable');
        return false;
    }
    
    // validar que clave =$nombre clave
    var ini= d.nombre_variable.value.charAt(0);
    if  (ini!='$'){
         alert('Nombre Varibale debe empezar con $');
         return false;
     }
    
    var Data = new FormData(document.frm_cabecera);
    
    /* Creamos el objeto que hara la petición AJAX al servidor, debemos de validar si existe el 	objeto “ XMLHttpRequest” ya que en internet explorer viejito no esta, y si no esta usamos 
	“ActiveXObject” */
	//alert(Data);
    if(window.XMLHttpRequest) {
       var Req = new XMLHttpRequest();
    }else if(window.ActiveXObject) {
	var Req = new ActiveXObject("Microsoft.XMLHTTP");
	} 
	
	//Pasándole la url a la que haremos la petición
    Req.open("POST", "../acciones/mantencion_parametros.php", true);
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
           alert('Datos Grabados Ok');
        }else{
	   /* Código si el return fue false */
             alert('Error, no se graba');
	} 
                        
        window.location.href='parametros_kpi.php';
} else {
		    	console.log(Req.status); //Vemos que paso.
		}
	};	  
	
	//Enviamos la petición
	Req.send(Data);
    
}   

function modifica(id){
    
    //alert('modifica '+id);
    
     document.frm_cabecera.id.value=id;
     document.frm_cabecera.faena.disabled=true;
     
     ajax = nuevoajax();
     ajax.onreadystatechange = refrescar_rescata;//Quien me procesa los 4 estados
     ajax.open('GET','../acciones/rescata_convenio.php?id='+id, true);
     ajax.send(null);
    
    
}


function refrescar_rescata(){
    if(ajax.readyState == 4){
        var out = ajax.responseText; 
       // alert(out);
        var lista = out.split('*');
        var d=document.frm_cabecera;
        d.nro_convenio.value=lista[0];
        d.nombre_convenio.value=lista[1];
        d.inicio.value=lista[2];
        d.termino.value=lista[3];
        if (lista[4]=='S')
           d.activo.checked=true;  
        else    
           d.activo.checked=false;  
         
        // status   modifica; 
       d.status.value='M';
    }
    
}


</script>

<script language="JavaScript" src="../js/popcalendar.js"></script>


<body >
<table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td class="titletable"><h4><strong>Mantención Parametros KPI</strong></h4></td>
    </tr>
 </table>
    
<br>

<form name='frm_cabecera' method="post" >
    <input type="hidden" name="status" value="">
    
          
      
      <table width="500" align="center" class="tablabase">
          <tr> <td height="5"></tr>
        <tr>
            <td>
              <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">  
                <tr>
                   
                    <td class="titledatos" width="150">Nombre Parametro</td>
                        <td width="2%"></td>
                        <td ><input name="nombre" id="nombre" maxlength="50" size="20" ></td>
                
                <tr></tr>
                
                <tr>
                    <td class="titledatos" width="150">Clave</td>
                        <td width="2%"></td>
                        <td ><input name="clave" id="clave" maxlength="5" size="10" ></td>
                </tr>
                <tr></tr>
                
                <tr>
                    <td class="titledatos" width="150">Nombre Variable</td>
                    <td width="2%"></td>
                    <td ><input name="nombre_variable" id="nombre_variable" maxlength="10" size="10" ></td>
                </tr>
                
                <tr></tr>
                              
                <tr> 
                    <td height="5"></td>
                </tr>
                <tr> 
                    <td colspan="3"><div align="center">
                        <img src="../img/nuevo.gif" align="right" title="Limpiar" border="2" style="cursor:hand" onClick="Limpiar();">
                        <img src="../img/46.png" align="right" title="Grabar" border="2" style="cursor:hand" onClick="agregar();">
                        </div>
                     </td>
                </tr> 

              </table>
            </td>
        </tr>
   </table>   
  
    
</form>

<br>
<br>

<table width="500" height="0" border="0" align="center" cellspacing="0" style="table-layout:fixed;" class="tablaprincipal">
    <tr> 
	
    <td width="200"> 
    <div align="left">Nombre Parametro</div></td>
    <td width="70" > 
    <div align="left">Clave</div></td>
    <td width="100"> 
    <div align="left">Nombre Varibale</div></td>
    
  </tr>
  </table>

<div align="center">
    <table width="500" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;" class="tablaframe" >
        <tr>
            <td>
                <iframe name="ifrm1" width="100%" height="250" scrolling="yes" src="../iframes/ifrm_parametros.php"  frameborder="0" align="middle" ></iframe>
            </td>
        </tr>
    </table>
</div>    
    
 

