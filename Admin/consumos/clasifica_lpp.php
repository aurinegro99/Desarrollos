<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../ini/inicial.php';
$usuario = $_SESSION["usuario"];

require_once '../rutinas/consumo/carga_faenas.php';
require_once '../rutinas/consumo/carga_listas.php';
?>

<script type="text/javascript">
    
   
    $(document).ready(function(){
        
         $("#cancela").on("click", function(e)
          {
          e.preventDefault();
          window.location.href='clasifica_lpp.php';	
            //alert('Cancelar')
          });
          
          
          $("#idcontrato").change(function(e){
              
              // cargar tipos de equipo
              
               let datos={'idfaena': $("#idfaena").val()};
              
              $.ajax({
                      url:'../rutinas/consumo/carga_tipo_equipo.php',
                      type:"POST",
                      data: datos, 
                      error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                      success: function(response){
                               let st= JSON.parse(response);
                               //console.log(st);
                               $('#idtipo_equipo').children('option:not(:first)').remove();
                               $.each(st, function(i,item){
                                 $("#idtipo_equipo").append('<option value="' + st[i].idtipo + '">' +st[i].descripcion+'</option>'); 
                           //console.log(i+' '+st[i].idestado);
                               })
                
                               $("#datos").show();
		//
		               },
         
                       });
              
              
          })
          
          
          // tipo equipo
          
           $("#idtipo_equipo").change(function(e){
                  
                  var param={'idfaena': $("#idfaena").val(),'idcontrato':$("#idcontrato").val()};
                   $.ajax({
                       url:'../rutinas/consumo/carga_clasificacion.php',
                       type:"POST",
                       data: param, 
                       error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                       success: function(response){
                      
                       console.log(response);
                       
                       var st= JSON.parse(response);
                       //console.log(st);
                       
                       $.each(st, function(i,item){
                          $("#inputclasifica").append('<option name="' + st[i].idclasifica + '">' + st[i].descripcion+'</option>'); 
                          // console.log(i+' '+st[i].idmodelo);
                       })
            	},
         
     });  
                  
                  
                  
              })
          
        
        
          $("#grabar").on("click", function(e)
           {
            e.preventDefault();
            if ($("#inputmodelo").val().trim() === ''){
                $('#inputmodelo').css('border-color','#FF0000');
                alert('Debe Seleccionar Modelo Equipo');
                return false; }
            if ($("#inputlista").val() <= 0){
                $('#inputlista').css('border-color','#FF0000');
                alert('Debe Seleccionar Lista Precios');
                return false; }
            if ($("#inputclasifica").val() <= 0){
                $('#inputclasifica').css('border-color','#FF0000');
                alert('Debe Seleccionar Clasificacion Contrato');
                return false; }  
             if ($("#inputMoneda").val() <= 0){
                  $('#inputMoneda').css('border-color','#FF0000');
                alert('Debe Seleccionar Moneda');
                return false; }  inputMoneda
             if ($("#inputfactor").val().length <= 0){
                  $('#inputfactor').css('border-color','#FF0000');
                  alert('Debe Ingresar Factor');
             return false; }
         
             if (isNaN($('#inputfactor').val())){
                $('#inputfactor').css('border-color','#FF0000');
                alert('Datos Factor debe ser Numerico y distinto a cero')
             }

         //alert($("#tipo").val()); 
             var datos={'tipo': $("#tipo").val(),'inputidU':$("#inputidU").val(),'nombreUsuario':$("#nombreUsuario").val(),'rutUsuario':$("#rutUsuario").val(),'inputEmail':$("#inputEmail").val(),'activo':xactivo};
     
     // alert(datos);     
     
             $.ajax({
         
             url:'../acciones/consumos/actualiza_lpp.php',
             type:"POST",
              data: datos, 
              error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
              success: function(data){
                //console.log(data);
                //alert(data);
                if (data=='0')
                    alert('Datos Actulizados');
                
                window.location.href='clasifica_lpp.php';
		//
		},
         
     });
     
    });
  
  
  
  
    });
    
    
     function cargar_contrato(){
        
           $('#idcontrato').children('option:not(:first)').remove();
           var param={'idfaena': $("#idfaena").val()}
           $.ajax({      
                       url:'../rutinas/consumo/carga_contrato.php',
                       type:"POST",
                       data: param, 
                       error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                       success: function(response){
                                          
                       var st= JSON.parse(response);
                       //console.log(st);
                       
                       $.each(st, function(i,item){
                          $("#idcontrato").append('<option value="' + st[i].idestado + '">' + st[i].numero_contrato+'-->'+st[i].descripcion_trabajo+'</option>'); 
                           //console.log(i+' '+st[i].idestado);
                       })
           	},
             });  
        
    }
    
    
    
    function carga_clasif(){
        
        var xid=($("#inputidfaena").val());
       
        
        
    }


   function revisar(id){
         
       var xid=id.substr(4,10);  
         
       var param={'xid': xid};
       
       $.ajax({
         
       url:'../acciones/carga_usuario.php',
       type:"GET",
       data: param, 
       error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
       success: function(response){
           
               var st= JSON.parse(response);
               
               //console.log(response);
           
               $('#inputidU').attr('value', st.usuario) ;  //usuario
               $('#nombreUsuario').attr('value', st.nombre_usuario) ;  // nombre
               $('#rutUsuario').attr('value', st.rut_usuario) ;  // rut
               $('#inputEmail').attr('value', st.mail_usuario) ;  // mail
               
               if (st.activo=='S')
                    $('#activo').attr('checked', true);
               else 
                    $('#activo').attr('checked', false);
                
               $('#tipo').attr('value', 'S'); 
               
               $("#inputidU").prop('disabled', true);
              
		},
         
     });  
       
   }
  

</script>

<body>


    <div class="container">
        <div class="col-md-12">
            <h3 class="text-center "><strong>Clasificación Faena LPP</strong></h3>

        </div>
    </div>

    <div class="container">
        <div class="col-md-12">  
            <div class="well">
                <form class="form-horizontal" role="form" id="form_datos" method="post">
                   

                    <div class="form-group">
                        <label for="idfaena" class="col-sm-2 control-label">Faena</label>
                        <div class="col-sm-9"><strong>
                            <select id="idfaena" class="form-control" onchange="cargar_contrato()" >
                             <option value=-1></option>
                                <?php echo $opcion_faena?>  
                            </select>
                            </strong>    
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="idcontrato" class="col-sm-2 control-label">Contrato</label>
                        <div class="col-sm-9"><strong>
                                <select id="idcontrato" class="form-control"  >
                             <option value=-1></option>
                              
                            </select>
                            </strong>    
                        </div>
                    </div>
                    

                </form>
            </div>
        </div>
    </div>
    
    
    <div class="container" id="datos" style="display:none">
        <div class="col-md-12">  
            <div class="well">
                <form class="form-horizontal" role="form" id="form_datos" method="post">
                   

                    <div class="form-group">
                        <label for="idtipo_equipo" class="col-sm-2 control-label">Tipo Equipo</label>
                        <div class="col-sm-9"><strong>
                                <select  id="idtipo_equipo" class="form-control" onchange="carga_clasif()"  >
                             <option value="-1"></option>
                              
                            </select>
                            </strong>      
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="inputlista" class="col-sm-2 control-label">Lista Precios</label>
                        <div class="col-sm-9"><strong>
                            <select name="inputlista" id="inputlista" class="form-control"  >
                             <option value=-1></option>
                                <?php echo $opcion_lista?>  
                            </select>
                            </strong>    
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputclasifica" class="col-sm-2 control-label">Clasificación Contrato</label>
                        <div class="col-sm-9"><strong>
                            <select name="inputclasifica" id="inputclasifica" class="form-control"  >
                             <option value=-1></option>
                                <?php echo $opcion_clasif?>  
                            </select>
                            </strong>     
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputfactor" class="col-sm-2 control-label">Factor</label>
                        <div class="col-sm-9"><strong>
                            <input type="text" name="inputfactor" id="inputfactor" class="form-control"  >
                            </strong>
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="inputMoneda" class="col-sm-2 control-label">Moneda Pago</label>
                        <div class="col-sm-9"><strong>
                            <select name="inputMoneda" id="inputMoneda" class="form-control"  >
                             <option value=-1></option>
                                <?php echo $opcion_moenda?>  
                            </select>
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
    
    
    
    
    <div class="container" id="lista" style="display:none">
        <div class="col-md-20">
            <h3 class="text-center">Clasificacion Faena</h3>
            <div class="well">
                <table class="table" id="faenas-lpp">
                    <thead>
                        <tr>
                            <th>Modelo</th>
                            <th>Lista</th>
                            <th>Clasificación</th>
                            <th>Factor</th>
                            <th>Moneda</th>
                        </tr>
                    </thead>


                </table>
            </div>
        </div>
    </div>

    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>    

    <script>
          function cargar_datos(){
              
              //alert($("#inputidfaena").val());
              $("#inputidfaena").prop('disabled', true);
              
              $("#lista").show();
              $("#datos").show();
              
              var xid=($("#inputidfaena").val());
              var param={'idfaena': xid};
              
              
             
              $("#faenas-lpp").DataTable({
                 paging : false,
                 language: {
                        url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                 },    
                 columns: [
                 {name :"Modelo", array :"usuario"},
                 {name :"Lista", array :"Nombre_Usuario"},
                 {name :"Clasificacion", array :"mail_usuario"},
                 {name :"Factor", array :"rut_usuario"},
                 {name :"Moneda", array :"rut_usuario"},
                 ],
                 //ajax:{
                 //url: "../rutinas/consumo/carga_usuarios.php?idfaena="
                 //}
               
             });
             
             // modelos
             $.ajax({
                       url:'../rutinas/consumo/carga_modelo.php',
                       type:"GET",
                       data: param, 
                       error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                       success: function(response){
                      
                       //console.log(response);
                       
                       var st= JSON.parse(response);
                      // console.log(st);
                       
                       $.each(st, function(i,item){
                          $("#inputmodelo").append('<option name="' + st[i].idmodelo + '">' + st[i].idmodelo+'--->' + st[i].nombre_tipo+'</option>'); 
                          // console.log(i+' '+st[i].idmodelo);
                       })
                 
           
           	},
         
     });  
              
              
              
          } 
    </script>

</body>
