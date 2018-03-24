<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../ini/inicial.php';
$usuario = $_SESSION["usuario"];

require_once '../rutinas/spp/carga_faenas.php';
require_once '../rutinas/spp/carga_tipo_equipo.php';

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/date-fns/1.28.5/date_fns.min.js"></script>
<script src="../../General/js/pikaday.js"></script>
<script>
    
     $(document).ready(function(){
         
         $("#cancela").on("click", function(e)
          {
          e.preventDefault();
          window.location.href='operaciones_equipo.php';	
            //alert('Cancelar')
          });
        // grabar
         $("#grabar").on("click", function(e)
          {
              e.preventDefault();
            if ($("#idtipo").val()<=0){
                $('#idtipo').css('border-color','#FF0000');
                alert('Debe Seleccionar Tipo Equipo');
                return false; }
            if ($("#idmodelo").val()===''){
                $('#idmodelo').css('border-color','#FF0000');
                alert('Debe Seleccionar Modelo Equipo');
                return false; }
            if ($("#numero_serie").val()===''){
                $('#numero_serie').css('border-color','#FF0000');
                alert('Debe Seleccionar Número Serie');
                return false; }
            if ($("#horometro").val()<0){
                $('#horometro').css('border-color','#FF0000');
                alert('Debe Ingresar Horómetro inicio');
                return false; }
            if ($("#fecha_inicio").val()===''){
                $('#fecha_inicio').css('border-color','#FF0000');
                alert('Debe Ingresar Fecha Inicio');
                return false; }
            if ($("#numero_interno").val()<=0){
                $('#numero_interno').css('border-color','#FF0000');
                alert('Debe Ingresar Número Interno');
                return false; }
            
        var datos={'idfaena': $("#idfaena").val(),'idequipo': $("#numero_serie").val(),'numero_interno':$("#numero_interno").val(),'horometro':$("#horometro").val(),'fecha':$("#fecha_inicio").val(),'interno':$("numero_interno").val(),'accion':$("#accion").val()};
        
        $.ajax({
         
                 url:'../acciones/spp/graba_operacion_equipo.php',
                 type:"POST",
                 data: datos, 
                 error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                 success: function(data){
                          //console.log(data);
                          if (data=='0'){
                             alert('Datos Actulizados');
                             window.location.href='operaciones_equipo.php';
                           }
                           if (data>'0')
                              alert("Error Numero Interno,ya esta asignado a otro equipo ");  
                     
                 }
                 
		  
         
               });
        
        
        
        
          });
         
         
         
         
     })
    
function carga_modelo(){
    var param={'idtipo': $("#idtipo").val()};
             // modelos
             $.ajax({
                       url:'../rutinas/spp/carga_modelos.php',
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
                            $.each(item,function(j,datos){
                           
                          $("#idmodelo").append('<option value="' + item[j].idmodelo + '">' + item[j].idmodelo+'</option>'); 
                           //console.log(i+' '+st.data[i].idmodelo);
                            })
                       })
             	},
             });  
    
    
}

function carga_serie(){
    var param={'idmodelo': $("#idmodelo").val(),'tipo': 6};
             // modelos
             $.ajax({
                       url:'../rutinas/spp/carga_serie_equipo.php',
                       type:"GET",
                       data: param, 
                       error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                       success: function(response){
                      
                      //console.log(response);
                       
                       var st= JSON.parse(response);
                       //console.log(st);
                       
                       $.each(st, function(i,item){
                          $("#numero_serie").append('<option value="' + st[i].idequipo + '">' + st[i].numero_serie+'</option>'); 
                           //console.log(i+' '+st[i].idserie);
                       })
             	},
             });  
    
    
}


function borrar(id){
        
    if(confirm('Desea Eliminar Equipo ')){
         var param={'idequipo': id,'idfaena':$("#idfaena").val()};
        $.ajax({
                       url:'../rutinas/spp/elimina_equipo_operacion.php',
                       type:"POST",
                       data: param, 
                       error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                       success: function(response){
                      //console.log(response);
                       if (response=='0')
                           alert('Dato Eliminado OK ');
                      
                        window.location.href='operaciones_equipo.php';
             	},
             });  
     }
     
}

function revisar(id){
     var param={'idequipo': id,'idfaena':$("#idfaena").val()};
     $.ajax({
                       url:'../rutinas/spp/rescata_datos_operacion.php',
                       type:"POST",
                       data: param, 
                       error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                      success: function(response){
                      var st= JSON.parse(response);    
                      //console.log(st);
                      
                      
                      $("#idtipo option").each(function(){
                   //console.log($(this).val());
                    if($(this).val() == st[0].idtipo){
                      $(this).val(st[0].idtipo).attr("selected", "true");          
                    }
                });
                
                    //carga_modelo();
                    
                     $('#idmodelo').children('option:not(:first)').remove();
                     $("#idmodelo").append('<option value="' + st[0].idmodelo + '" selected >' + st[0].idmodelo+'</option>'); 
                     
                     
                     $('#numero_serie').children('option:not(:first)').remove();
                     $("#numero_serie").append('<option value="' + st[0].idequipo + '" selected >' + st[0].numero_serie+'</option>'); 
                      
                      
                     
                      
                      $("#fecha_inicio").attr('value',st[0].fecha);
                      $("#horometro").attr('value',st[0].horometro_inicio);
                      $("#numero_interno").attr('value',st[0].numero_interno);
                      
                      // llenar los campos
                      
                      $("#accion").attr('value',1);
                      
                      //console.log($("#horometro").val());
                      $("#idtipo").prop('disabled', true); 
                      $("#idmodelo").prop('disabled', true); 
                      $("#numero_serie").prop('disabled', true); 
                      
             	},
             });  
        
     
     
 }   
</script>


<div class="container">
        <div class="col-md-12">
            <h3 class="text-center "><strong>Operacion Equipos</strong></h3>

        </div>
    </div>
    
    <div class="container">
        <div class="col-md-12">  
            <div class="well">
                <form class="form-horizontal" role="form" id="form_datos" method="post">
                    <input type="hidden" id="accion" value="0">

                    <div class="form-group">
                        <label for="idfaena" class="col-sm-2 control-label">Faena</label>
                        <div class="col-sm-9"><strong>
                            <select id="idfaena" class="form-control" onchange="cargar_datos()" >
                             <option value=-1></option>
                                <?php echo $opcion_faena?>  
                            </select>
                            </strong>    
                        </div>
                    </div>
                    

                </form>
            </div>
        </div>
    </div>


<div class="container" id="datos" style="display: none">
        <div class="col-md-12">  
            <div class="well">
                <form class="form-horizontal" role="form" id="form_datos" method="post">
                   
                    
                    <div class="form-group">
                        <label for="idtipo" class="col-sm-2 control-label">Tipo Equipo</label>
                        <div class="col-sm-9"><strong>
                                <select id="idtipo" class="form-control" onchange="carga_modelo()"  >
                            <option value="0"></option>
                             <?php echo $opcion_tipo?> 
                            </select>
                            </strong>
                        </div>
                      </div>   
                    
                    <div class="form-group">
                        <label for="idmodelo" class="col-sm-2 control-label">Modelo</label>
                        <div class="col-sm-9"><strong>
                                <select id="idmodelo" class="form-control" onchange="carga_serie()"  >
                             <option value=""></option>
                            </select>
                            </strong>
                        </div>
                      </div>   
                    
                      <div class="form-group">
                        <label for="numero_serie" class="col-sm-2 control-label">Número Serie</label>
                        <div class="col-sm-3"><strong>
                             <select id="numero_serie" class="form-control"  >
                             <option value=""></option>
                            </select> 
                            </strong>
                        </div>
                      </div>
                    
                      <div class="form-group">
                        <label for="numero_interno" class="col-sm-2 control-label">Número Interno</label>
                        <div class="col-sm-2"><strong>
                                <input type="text"  id="numero_interno" class="form-control" maxlength="10"  >
                            </strong>
                        </div>
                      </div>
                    
                      <div class="form-group">
                        <label for="horometro" class="col-sm-2 control-label">Horometro Inicio</label>
                        <div class="col-sm-2"><strong>
                                <input type="number"  id="horometro" class="form-control" step="0.01">
                            </strong>
                        </div>
                      </div>
                    
                      <div class="form-group">
                        <label for="fecha_inicio" class="col-sm-2 control-label">Inicio Operación</label>
                        <div class="col-sm-2"><strong>
                            <input type='text' class="form-control" id="fecha_inicio" readonly="true" >
                            </strong>
                        </div>
                        
                        <script type="text/javascript">
                               var picker = new Pikaday(
                                    {
                               field: document.getElementById('fecha_inicio'),
                               toString: function(date, format) {
                               return dateFns.format(date, format);
                                 },
                              firstDay: 1,
                              minDate: new Date(2000,1,1),
                              maxDate: new Date(2100, 12, 31),
                              yearRange: [2000,2020]
                              });
        
                        </script> 
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
        <div class="col-md-12">
            <h3 class="text-center">Equipos Operativos</h3>
            <div class="well">
                <table class="table" id="lista-equipos">
                    <thead>
                        <tr>
                            <th>Modelo</th>
                            <th>Numero Serie</th>
                            <th>Numero Sap</th>
                            <th>Nro.Interno</th>
                            <th>Fecha Ingreso</th>
                            <th>Horometro</th>
                            <th>Editar</th>
                            <th>Borrar</th>
                            
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
              $("#idfaena").prop('disabled', true);
              
              $("#lista").show();
              $("#datos").show();
              
              var xid=($("#idfaena").val());
              var param={'idfaena': xid};
              
              
             
              $("#lista-equipos").DataTable({
                 paging : true,
                 searching: true,
                 language: {
                        url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                 },    
                 columns: [
                 {name :"Modelo", array :"idmodelo"},    
                 {name :"Numero Serie", array :"numero_serie"},
                 {name :"Numero Sap", array :"numero_sap"},
                 {name :"Nro. Interno", array :"numero_interno"},
                 {name :"Fecha Ingreso", array :"fecha_inicio"},
                 {name :"Horometro", array :"horometro_inicio"},
                 {name :"Editar", render : function(data, type, row){
            return `
                        <input type=button class="removeForum btn btn-info" onclick="revisar('${row.editar}')" value="Editar">
                    `
            }

            },
                 {name :"Borrar", render : function(data, type, row){
            return `
                        <input type=button class="removeForum btn btn-danger" onclick="borrar('${row.borrar}')" value="Borrar">
                    `
            }

            },
                 ],
                 ajax:{
                 url: "../rutinas/spp/carga_equipos_operacion.php?idfaena="+xid
                 }
               
             });
              
          } 
    </script>






</body>    