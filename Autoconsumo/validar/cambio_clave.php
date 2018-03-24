<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../ini/inicial.php';
$usuario = $_SESSION["usuario"];


?>

 <script  type="text/javascript" > 
      $(document).ready(function(){
           $("#grabar").on("click", function(e){
             e.preventDefault();
             
             if($("#actual").val()==''){
                $('#actual').css('border-color','#FF0000');
                alert('Debe Ingresar Clave Actual');
                return false;
             }
             
             if($("#nueva").val()==''){
                $('#nueva').css('border-color','#FF0000');
                alert('Debe Ingresar Nueva Clave');
                return false;
             }
             
             if($("#repite").val()==''){
                $('#repite').css('border-color','#FF0000');
                alert('Debe Repetir Nueva Clave');
                return false;
             }
             
            
                         
             if ($("#nueva").val().length<4)  {
                 $("#nueva").css('border-color','#FF0000');
                  alert('Largo Nueva Clave debe ser Minimo 4 Caract.');
                return false;
                 
             }
             
             if ($("#repite").val().length<4)  {
                 $('#repite').css('border-color','#FF0000');
                  alert('Largo Nueva debe ser Minimo 4 Caract.');
                return false;
                 
             }
             
             
             if($("#nueva").val()!=$("#repite").val()){
                  $('#repite').css('border-color','#FF0000');
                 alert('Las Nuevas Claves deben ser Iguales, repetir');
                 return false;
             }
             
             var datos={'actual': $("#actual").val(),'nueva': $("#nueva").val(),'repite': $("#repite").val()};
             $.ajax({
                      url:'../acciones/actualiza_clave.php',
                      type:"POST",
                      data: datos, 
                      error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                      success: function(response){
                               console.log(response);
                               if (response>0){
                                   alert("ERROR, Clave actual no es la correcta, Reintentar");
                                   return false;
                                   
                               } 
                               else{
                                   alert('Clave Cambiada Exitosamente');
                                   window.location.href='../ini/logout.php';
                               
                                    }
                              
		//
		               },
         
                       });
             
            
             
        })
          
          
          
          
          
      })
 
 </script>


<div class="container">
        <div class="col-md-8">
            <h3 class="text-center "><strong>Cambiar Clave Acceso</strong></h3>

        </div>
</div>


<div class="container">
        <div class="col-md-9">  
            <div class="well">
                <form class="form-horizontal" role="form" id="form_datos" method="post">
                   

                    <div class="form-group">
                        <label for="actual" class="col-sm-4 control-label">Ingrese Clave Actual</label>
                        <div class="col-sm-6"><strong>
                                <input type="password" maxlength="10"  size="20" id="actual" class="form-control" placeholder="Min. 4 Max 10 Caract." </td>
                            </strong>    
                        </div>
                        
                        <label for="nueva" class="col-sm-4 control-label">Ingrese Nueva Clave</label>
                        <div class="col-sm-6"><strong>
                            <input type="password" maxlength="10" size="20" id="nueva" class="form-control" placeholder="Min. 4 Max 10 Caract." </td>
                            </strong>    
                        </div>
                        
                        <label for="repite" class="col-sm-4 control-label">Repita Nueva Clave</label>
                        <div class="col-sm-6"><strong>
                            <input type="password" maxlength="10" size="20" id="repite" class="form-control" placeholder="Min. 4 Max 10 Caract." </td>
                            </strong>    
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success" id="grabar" >Grabar</button>   
                            <button type="submit" class="btn btn-danger" id="cancela">Cancelar</button>
                        </div>
                    </div>

                </form>
                
                  
            </div>
        </div>
    </div>
