<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../ini/inicial.php';
$usuario = $_SESSION["usuario"];

require_once '../rutinas/spp/carga_tipo_equipo.php';


?>

<script>
 $(document).ready(function(){
      // cancela
         $("#cancela").on("click", function(e)
          {
          e.preventDefault();
          window.location.href='modelos_equipo.php';	
            //alert('Cancelar')
          });
        // grabar
         $("#grabar").on("click", function(e)
          {
          
            if ($("#modelo").val().trim() === ''){
                $('#modelo').css('border-color','#FF0000');
                alert('Debe Ingresar Modelo Equipo');
                return false; }
            
            
             var datos={'idtipo': $("#tipo_equipo").val(),'modelo': $("#modelo").val()};
            
            
             $.ajax({
         
                 url:'../acciones/spp/grabar_modelo.php',
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
                     alert('Datos Actualizados');
                 window.location.href='modelos_equipo.php';
		//
		 },
         
               });
          
          
          });
     
     
 });

 function revisar(id){
     
       $('#modelo').attr('value', id) ;  // numero contrato
     
     
 }
</script>


<body>


    <div class="container">
        <div class="col-md-7">
            <h3 class="text-center "><strong>Gestión Modelo Equipo</strong></h3>
        </div>
    </div>
    
    <div class="container">
        <div class="col-md-7">  
            <div class="well">
                <form class="form-horizontal" role="form" id="form_datos" method="post">
                      <input type="hidden" value="0" id="idcontrato">

                    <div class="form-group">
                        <label for="tipo_equipo" class="col-sm-3 control-label">Tipo Equipo</label>
                        <div class="col-sm-7"><strong>
                            <select id="tipo_equipo" class="form-control" onchange="cargar_modelos()" >
                             <option value=-1></option>
                                <?php echo $opcion_tipo?>  
                            </select>
                            </strong>    
                        </div>
                    </div>
                    

                </form>
            </div>
        </div>
    </div>
    
      <div class="container" id="datos" style="display: none">
        <div class="col-md-7">  
            <div class="well">
                <form class="form-horizontal" role="form" id="form_datos" method="post">
                   
                      <div class="form-group">
                        <label for="modelo" class="col-sm-2 control-label">Modelo</label>
                        <div class="col-sm-9"><strong>
                                
                                <input type="text"  id="modelo" class="form-control" maxlength="15"  >
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
        <div class="col-md-7">
            <h3 class="text-center">Modelos</h3>
            <div class="well">
                <table class="table" id="lista-modelos">
                    <thead>
                        <tr>
                            <th>Modelo</th>
                            <th>Accion</th>
                        </tr>
                    </thead>


                </table>
            </div>
        </div>
    </div>

    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>  
      <script>
          function cargar_modelos(){
              
              //alert($("#inputidfaena").val());
              $("#tipo_equipo").prop('disabled', true);
              
              $("#lista").show();
              $("#datos").show();
              
              var xid=($("#tipo_equipo").val());
             
              $("#lista-modelos").DataTable({
                 paging : false,
                 language: {
                        url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                 },    
                 columns: [
                 {name :"Modelo", array :"numero_contrato"},
                 {name :"Accion", render : function(data, type, row){
            return `
                        <input type=button class="removeForum btn btn-info" onclick="revisar('${row.accion}')" value="Editar">
                    `
            }

            },
                 ],
                 ajax:{
                    url: "../rutinas/spp/carga_modelos.php?idtipo="+xid
                 }
               
             });
          } 
          
         
    </script>
    
</body>
