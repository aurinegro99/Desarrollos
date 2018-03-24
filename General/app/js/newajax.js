/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function validar(){
         if(window.XMLHttpRequest) {
		var Req = new XMLHttpRequest();
	  }else if(window.ActiveXObject) {
		var Req = new ActiveXObject("Microsoft.XMLHTTP");
	  } 
         if (document.getElementById("correo").value==""){
		alert('Debe Ingresar su usuario Corporativo');
		return false;
	}
        var Data = new FormData(document.frm_parametros);
        
	Req.open("POST", "../acciones/valida_ingreso.php", true);
        
        Req.onload = function(Event) {
		//Validamos que el status http sea  ok
		if (Req.status == 200) {
			/*Como la info de respuesta vendrá en JSON 
			la parseamos */ 
                        alert(Req.responseText);
             		var st = Req.responseText;
             	
			if(st=='0'){
				/* Código si el return fue true */
                                 alert('Datos Ok');
                       }else{
				/* Código si el return fue false */
                            
                                    alert('Error en Datos Ingreso ');
			}
                         
                        //document.getElementById("carga").style.display="none";
                        //document.getElementById("form").style.display="";
                        //document.subir.planilla.value="";
                        
                         //window.location.href='carga_planilla.php';
		}
	};	  
	
	//Enviamos la petición
	Req.send(Data);

}        
        

