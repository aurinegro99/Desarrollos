<?php
require_once '../ini/inicial.php';

require_once '../lib/carga_perfil.php';

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
	
 window.location.href='Habilitar.php';	 
}

function revisar(){
    
    var teclaASCII=event.keyCode 
     
    var xusu=document.getElementById('usuario').value;
    
    
    if (teclaASCII==13){

       if (xusu.length<=0){
          alert('Debe Ingresar Usuario');
          return false;
	
        }
        
        ajax = nuevoajax();
        ajax.onreadystatechange = refrescar_usuario;//Quien me procesa los 4 estados
        ajax.open('GET','../revision/revisa_usuario.php?musuario='+xusu, true);
        ajax.send(null);
    }
    
    
    
}


function refrescar_usuario(){
    
    if(ajax.readyState == 4){
        //alert(ajax.responseText)
        var out = ajax.responseText;
        if (out=='0'){
            alert('Uusario no Existe, revisar');
            Limpiar();
            return false;
            
        }
        else{
            
             var lista = out.split('*');
             
            // alert(lista[1]);
             
             document.fm_cabecera.nombre.value=lista[0];
             document.fm_cabecera.correo.value=lista[1];
             document.fm_cabecera.usuario.disabled=true;
             revisa_perfil();
   
                }
    }
    
}


function revisa_perfil(){
        
       var xusu=document.getElementById('usuario').value;
       ajax = nuevoajax();
       ajax.onreadystatechange = refrescar_perfil;//Quien me procesa los 4 estados
       ajax.open('GET','../revision/revisa_perfil.php?musuario='+xusu, true);
       ajax.send(null);
    
}

function refrescar_perfil(){
    
      if(ajax.readyState == 4){
          
         var out = ajax.responseText; 
         var lista = out.split('*');
         // activo perfil
         
         // ver si esta habilitado
         if (lista[1]=='0'){
             alert('Usuario No está Habilitado');
             document.fm_cabecera.habilitar.checked=false;
             document.fm_cabecera.inicial.value='N';
         }
         else{
             
             alert('Usuario Está Habilitado');
             document.fm_cabecera.habilitar.checked=true;
             document.fm_cabecera.inicial.value='S';
             document.getElementById('asignar').style.display="";
              carga_faenas();
             
         }
              
          
          
          
          
          // seteo el perfil
          
          var sel = document.getElementById("perfil"); 
          //alert(sel.length);
          for (var i = 0; i < sel.length; i++) {
               //  Aca haces referencia al "option" actual
               
               //alert(sel.options[i].value);
               if (sel.options[i].value==lista[0])
                   sel.selectedIndex=i;
           }
          
          
         
          
      }
    
}

function carga_faenas(){
    
    iframeForm.reset();
    iframeForm.usuario.value= document.fm_cabecera.usuario.value;
    iframeForm.action = "../iframes/ifrm_usuario.php";
    iframeForm.target = "ifrm1";
    iframeForm.submit ();  
    
}
     
function listar(){
    
     
     popUpWindow('../ventanas/asignar_faena.php?usuario='+document.fm_cabecera.usuario.value,100,0,800,400);
    
}  

function agregar(){
    var d=document.fm_cabecera;
    // revisar perfil
    if (d.perfil.value<=0){
        alert('Debe Seleccionar Perfil');
        return false;
        
    }
    
    // si inicial es N
    
    if (d.inicial.value=='N'){
        // esta deshabilitado
        if (habilitar.checked==true){
            // activar
             ajax = nuevoajax();
             ajax.onreadystatechange = refrescar_agregar;//Quien me procesa los 4 estados
             ajax.open('GET','../acciones/actualiza_perfil.php?usuario='+d.usuario.value+'&perfil='+d.perfil.value+'&habilita=S', true);
             ajax.send(null);
        }
            
        
            
        
    }
    else{
        // ya esta habilitado
         if (habilitar.checked==false){
             ajax = nuevoajax();
             ajax.onreadystatechange = refrescar_agregar;//Quien me procesa los 4 estados
             ajax.open('GET','../acciones/actualiza_perfil.php?usuario='+d.usuario.value+'&perfil='+d.perfil.value+'&habilita=N', true);
             ajax.send(null); 
             
             
         }
             
        
        
    }
        
    
    
}

function refrescar_agregar(){
    
     if(ajax.readyState == 4){
         
          var out = ajax.responseText; 
                             
          if (out=='0')
             alert('Datos Actualizados');
         else
             alert('Error al actualizar');
         Limpiar();
     }
}
     
    
    
    

</script>

<body >
<table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td class="titletable"><h4><strong>Administrar Usuarios</strong></h4></td>
    </tr>
 </table>


<br>

    
 <form name='fm_cabecera' method="post" >
     <input type="hidden" name="inicial">
     <table width="900" align="center" class="tablabase">
          <tr> <td height="5"></tr>
        <tr>
            <td>
              <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000066">  
                <tr>
                    <td class="titledatos" width="150">Usuario</td>
                        <td width="2%"></td>
                    <td ><input name="usuario" id="usuario" value="" size="10" maxlength="15" onkeydown="revisar()"></td>
                </tr>
                <tr></tr>

                <tr>
                    <td class="titledatos" width="150">Nombre</td>
                        <td width="2%"></td>
                        <td ><input name="nombre" id="nombre" value="" size="80" readonly="true"></td>
                </tr>
                <tr></tr>
                  
                 
                <tr>
                    <td class="titledatos" width="150">Correo</td>
                        <td width="2%"></td>
                    <td ><input name="correo" id="correo" value="" size="80" readonly="true"></td>
                </tr>
                <tr></tr>
                
                <tr>
                    <td class="titledatos" width="150">Perfil</td>
                        <td width="2%"></td>
                    <td ><select name="perfil"  id="perfil">
                                <option value=-1></option>
                                <?php echo $opcion_perfil?>
                                              
                        </select></td>
                </tr>
                
                <tr></tr>
                
                <tr>
                    <td class="titledatos" width="150">Habilitar</td>
                        <td width="2%"></td>
                        <td ><input name="habilitar" id="habilitar" type="checkbox"></td>
                </tr>
                
                <tr> 
                    <td height="5"></td>
                </tr>
                
                
                
                <tr id="asignar" style="display: none">
                    <td class="titledatos" width="150">Asignar Faenas</td>
                        <td width="2%"></td>
                        <td ><input name="boton" id="boton" size="100" type="button" value="Listado de Faenas" onclick="listar()"></td>
                </tr>
                <tr></tr>

                <tr> 
                    <td height="5"></td>
                </tr>
                <tr> 
                    <td colspan="3"><div align="center">
                        <img src="../img/nuevo.gif" align="right" title="Limpiar" border="2" style="cursor:hand" onClick="javascript:Limpiar();">
                                <!--<img src="../img/pdf_icono.gif" align="right" title="Imprime Solicitud" border="1" style="cursor:hand" onClick="javascript:imprime();">-->
                        <img src="../img/46.png" align="right" title="Grabar" border="2" style="cursor:hand" onClick="javascript:agregar();">
                        </div>
                     </td>
                </tr> 

              </table>
            </td>
        </tr>
   </table>  
      
    
 </form>     
    
<br>


<table width="900" height="0" border="0" align="center" cellspacing="0" style="table-layout:fixed;" class="tablaprincipal">
    <tr> 
	
    <td width="100"> 
    <div align="left">Idfaena</div></td>
    <td width="350" > 
    <div align="left">Nombre Faena</div></td>
    <td width="100">&nbsp;</td>

  </tr>
  </table>

<div align="center">
    <table width="900" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;" class="tablaframe" >
        <tr>
            <td>
                <iframe name="ifrm1" width="100%" height="250" scrolling="yes" src="../iframes/ifrm_usuario.php"  frameborder="0" align="middle" ></iframe>
            </td>
        </tr>
    </table>
</div>    
    
    
<form id="iframeForm" method="post" target="" action="">
    <input type="hidden" value="" name="usuario">
    
	
  
</form>    