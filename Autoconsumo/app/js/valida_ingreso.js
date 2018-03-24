/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 $(document).ready(function(){
            $("#idlogin").on("click", function(e){
                // revisar login y clave
                e.preventDefault();
                if ($("#usuario").val().trim() === ''){
                    $('#usuario').css('border-color','#FF0000');
                    alert('Debe Ingresar Usuario');
                return false; }
                if ($("#clave").val().trim() === ''){
                    $('#clave').css('border-color','#FF0000');
                    alert('Debe Ingresar Clave');
                return false; }
                
                var param={'usuario': $("#usuario").val(),'clave':$("#clave").val()};
                
                $.ajax({
                       url:'validar/ingreso/login.php',
                       type:"POST",
                       data: param, 
                       error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                       success: function(response){
                       //console.log(response);
                       var st= JSON.parse(response);    
                       
                       if (response==0) {
                          // alert('ingreso ok');
                           window.location.href='inicial/principal.php';
                       } 
                       else
                           alert('Error en datos Ingreso, revisar');
                      	},
                });  
                
                
                
            })  // login
        })  // docuemnto
        

