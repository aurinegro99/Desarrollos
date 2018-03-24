<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../ini/inicial.php';
$usuario=$_SESSION["usuario"];
require_once '../lib/carga_faenas.php';


?>

<script language="JavaScript" type="text/JavaScript">
    
var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
  if(popUpWin)
  {
    if(!popUpWin.closed) popUpWin.close();
  }
  popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}    
    
function nuevoajax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false;
	try
	{
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{
		try
		{
			// Creacion del objet AJAX para IE
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E)
		{
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
		} 
	}
	return xmlhttp;  
}     

function Limpiar()
{
	 
 window.location.href='Parametros_convenio.php';	 
}



   
function carga_convenio(){   
        var d= document.frm_cabecera; 
        ajax = nuevoajax();
        ajax.onreadystatechange = refrescar_carga;//Quien me procesa los 4 estados
        ajax.open('GET','../lib/carga_convenio.php?idfaena='+d.faena.value, true);
        ajax.send(null);
} 

function refrescar_carga(){
    if(ajax.readyState == 4){
      var xml = ajax.responseXML;
      //alert(xml);
      var largo = xml.getElementsByTagName('idconvenio').length;
      //alert(largo);
   
      var jmodelo = xml.getElementsByTagName('idconvenio');
      var jnombre = xml.getElementsByTagName('nombre'); 
   
      var select = document.getElementById("convenio");
  
      select.length=0;
   
      for (i = 0; i < largo; i++){
   
          select.options[i+1] = new Option(jnombre[i].firstChild.nodeValue, jmodelo[i].firstChild.nodeValue);
   
      }  

    }
 }

 function carga_parametros(){
        var d= document.frm_cabecera; 
        ajax = nuevoajax();
        ajax.onreadystatechange = refrescar_parametro;//Quien me procesa los 4 estados
        ajax.open('GET','../lib/carga_parametro.php?idfaena='+d.faena.value+'&idconvenio='+d.convenio.value, true);
        ajax.send(null);
     
 }   
 
function refrescar_parametro(){
    if(ajax.readyState == 4){
       //alert(ajax.responseText); 
      var st = JSON.parse(ajax.responseText);  
      //alert(st);
      if (st[0]=='0'){
          document.frm_parametros.idconf.value=st[1];
          document.frm_parametros.formula.value=st[2];
          ajax = nuevoajax();
          ajax.onreadystatechange = refrescar_muestra;//Quien me procesa los 4 estados
          ajax.open('GET','../lib/muestra_parametro_config.php?idconfig='+st[1], true);
          ajax.send(null);
          
      }
          
      else    
          document.frm_parametros.idconf.value=0;
      document.getElementById("paramet1").style.display="";
    }
 }
 
 function refrescar_muestra(){
      if(ajax.readyState == 4){
         var xml = ajax.responseXML;
      //alert(xml);
         var largo = xml.getElementsByTagName('idparametro').length;
      //alert(largo);
         var jid = xml.getElementsByTagName('idparametro');
         var jnombre = xml.getElementsByTagName('nombre'); 
         var jvar = xml.getElementsByTagName('variable'); 
         var select = document.getElementById("parametro");
         select.length=0;
   
         for (i = 0; i < largo; i++){
   
             select.options[i+1] = new Option(jnombre[i].firstChild.nodeValue+'==> Var : '+jvar[i].firstChild.nodeValue, jid[i].firstChild.nodeValue);
            }   
          
        }
     
 }
 
 
 function agregar(){
      var d= document.frm_cabecera; 
       popUpWindow('../ventanas/agregar_parametro.php?idfaena='+d.faena.value+'&idconvenio='+d.convenio.value,100,0,400,400);
  
 }


function grabar(){
    // revisar formula
    if (document.getElementById("formula").value==""){
        alert('Debe ingresar Formula de calculo');
        return false;
    }
          
    // recorre el select
    var xformula=document.getElementById("formula").value;
    var xlargo=document.getElementById("parametro").length;
    var sw=0;
    for(var z = 1; z < xlargo; z++)
       {
           t = document.getElementById('parametro').options[z].text;
           pos=t.search('$');
           //s=t.substr(pos,2);
           xvar=t.substr(pos-5,5);
           
           //alert(xformula);
           pos2=xformula.indexOf(xvar);
           //console.log(pos2);
           if (pos2<0){
               alert('Variable '+xvar+', No esta en la fórmula, revisar');
               sw=1;  
           }
         }
          
     if (sw==0){
         //
         if(window.XMLHttpRequest) {
		var Req = new XMLHttpRequest();
	}else if(window.ActiveXObject) {
		var Req = new ActiveXObject("Microsoft.XMLHTTP");
	} 
	
	//Pasándole la url a la que haremos la petición
        
        var Data = new FormData(document.frm_parametros);
        
	Req.open("POST", "../acciones/actualiza_configuracion.php", true);
        
        Req.onload = function(Event) {
		//Validamos que el status http sea  ok
		if (Req.status == 200) {
			/*Como la info de respuesta vendrá en JSON 
			la parseamos */ 
                        //alert(Req.responseText);
             
			var st = Req.responseText;
                        
                       // alert(st);
			
			if(st=='0'){
				/* Código si el return fue true */
                                 alert('Datos Ok');
                       }else{
				/* Código si el return fue false */
                            
                                    alert('Error en Grabar datos ');
			}
                         
                        //document.getElementById("carga").style.display="none";
                        //document.getElementById("form").style.display="";
                        //document.subir.planilla.value="";
                        
                         //window.location.href='carga_planilla.php';
		} else {
		    	console.log(Req.status); //Vemos que paso.
		}
	};	  
	
	//Enviamos la petición
	Req.send(Data);
        
        
         
         
         
     }
         
     else
         alert('No Grabar');
    
    
}



</script>

<body >
<table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td class="titletable"><h4><strong>Parametros Convenio</strong></h4></td>
    </tr>
 </table>
    
<br>

<form name='frm_cabecera' method="post" >
    <input type="hidden" name="status" value="C">
     <input type="hidden" name="id" value="0">
          
      
      <table width="800" align="center" class="tablabase">
          <tr> <td height="5"></tr>
        <tr>
            <td>
              <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">  
                <tr>
                   
                    <td class="titledatos" width="150">Faena</td>
                        <td width="2%"></td>
                        <td ><select name="faena"  id="faena" onchange="carga_convenio()">
                                <option value=-1></option>
                                <?php echo $opcion_faena?>
                                              
                        </select></td>
                </tr>
                
                <tr></tr>
                
                <tr>
                    <td class="titledatos" width="150">Nro.Convenio</td>
                        <td width="2%"></td>
                        <td ><select name="convenio"  id="convenio" onchange="carga_parametros()" >
                                              
                        </select></td>
                        
                        
                </tr>
                <tr></tr>
                
                              
                <tr> 
                    <td height="5"></td>
                </tr>
                <tr> 
                    <td colspan="3"><div align="center">
                        <img src="../img/nuevo.gif" align="right" title="Limpiar" border="2" style="cursor:hand" onClick="Limpiar();">
                       
                        </div>
                     </td>
                </tr> 
               
                 
                

              </table>
            </td>
        </tr>
   </table>   
  
    
</form>



<form name='frm_parametros' method="post" >
    <input type="hidden" name="idconf" >
    <table width="800" align="center" class="tablabase" id="paramet1" style="display: none">
          <tr> <td height="5"></tr>
        <tr>
            <td>
              <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">  
                
                <tr>
                    <td class="titledatos" width="150">Parametros</td>
                    <td width="2%"></td>
                    <td ><select name="parametro" multiple  id="parametro" >
                                                                  
                        </select></td>
                    <td width="2%"></td>
                    <td><input type="button" value="Agregar Parametros" onclick="javascript:agregar()"> </td>
                    
                        
                </tr>
                 <tr> 
                    <td height="5"></td>
                </tr>
                
                
                
                <tr>
                    <td class="titledatos" width="150">Formula</td>
                        <td width="2%"></td>
                        <td ><input name="formula" id="formula" maxlength="50" size="20" ></td>
                </tr>
                
                <tr> 
                    <td height="5"></td>
                </tr>
                <tr> 
                    <td colspan="3"><div align="center">
                      
                        <img src="../img/46.png" align="right" title="Grabar" border="2" style="cursor:hand" onClick="grabar();">
                        </div>
                     </td>
                </tr> 
               

              </table>
            </td>
        </tr>
   </table>   
  
    
</form>

<br>

