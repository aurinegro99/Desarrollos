<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../ini/inicial.php';
$usuario = $_SESSION["usuario"];

require_once '../rutinas/spp/carga_clientes.php';

require_once '../rutinas/spp/carga_tipo_equipo.php';
require_once '../rutinas/spp/carga_status.php';

?>

<script type="text/javascript">
      $(document).ready(function(){
         // cancela
         
         $('.input-number').on('input', function () { 
             this.value = this.value.replace(/[^0-9]/g,'');
            });
         
         $("#cancela").on("click", function(e)
          {
          e.preventDefault();
          window.location.href='gestion_equipos.php';	
            //alert('Cancelar')
          });
          
          
          $("#grabar").on("click", function(e)
          { 
             if ($("#idmodelo").val()<=0){
                $('#idmodelo').css('border-color','#FF0000');
                alert('Debe Ingresar Seleccionar Modelo');
                return false; }
            
            if ($("#idcliente").val()<0){
                $('#idcliente').css('border-color','#FF0000');
                alert('Debe Seleccionar Cliente');
                return false; }
            if ($("#ubicacion").val()<=0){
                $('#ubicacion').css('border-color','#FF0000');
                alert('Debe Seleccionar Ubicación');
                return false; }
            
            if ($("#status").val()<=0){
                $('#status').css('border-color','#FF0000');
                alert('Debe Seleccionar Status');
                return false; }
            
            if ($("#numero_serie").val().trim() === ''){
                $('#numero_serie').css('border-color','#FF0000');
                alert('Debe Ingresar Número Serie');
                return false; }
            
            if ($("#numero_sap").val().trim() === ''){
                $('#numero_sap').css('border-color','#FF0000');
                alert('Debe Ingresar Número SAP');
                return false; }
            
            if ($("#fabricante").val().trim() === ''){
                $('#fabricante').css('border-color','#FF0000');
                alert('Debe Ingresar Fabricante');
                return false; }
            
            if ($("#procedencia").val().trim() === ''){
                $('#procedencia').css('border-color','#FF0000');
                alert('Debe Ingresar Procedencia');
                return false; }
            
            if ($("#fabricacion").val()<=0){
                $('#fabricacion').css('border-color','#FF0000');
                alert('Debe Ingresar Año Fabricación');
                return false; }
            
            if ($("#tipo").val()<=0){
                $('tipo').css('border-color','#FF0000');
                alert('Debe Seleccionar Tipo Equipo');
                return false; }
            
            e.preventDefault();       
            var paramg={'idequipo':$("#idequipo").val() ,'idmodelo': $("#idmodelo").val(),'serie': $("#numero_serie").val(),'sap': $("#numero_sap").val(),'fabricante': $("#fabricante").val()
                        ,'procedencia': $("#procedencia").val(),'fabricacion': $("#fabricacion").val(),'ubicacion': $("#ubicacion").val(),'status': $("#status").val(),'tipo_equipo':$("#tipo").val()};
              
            //alert($("#ubicacion").val());  
              
            $.ajax({
                       url:'../acciones/spp/graba_equipo.php',
                       type:"POST",
                       data: paramg, 
                       
                       error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                       success: function(response){
                                   //alert(response);
                                   //console.log(response);
                                   if (response=='0'){
                                       alert("Datos Actualizados OK");
                                       window.location.href='gestion_equipos.php';
                                    }
                                    
                                    if (response>'0')
                                         alert("Revisar Numero serie y/o Equipo Sap, ya están ingresados ");
             	                }
                    });  
            
            
          });
 
      });
      
   function carga_ubicacion(){
            var param={'idcliente': $("#idcliente").val()};
             // modelos
             $.ajax({
                       url:'../rutinas/spp/carga_ubicacion.php',
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
                       
                       $('#ubicacion').children('option:not(:first)').remove();
                       
                       $.each(st, function(i,item){
                          $("#ubicacion").append('<option value="' + st[i].idclte_ubicacion + '">' + st[i].nombre_ubicacion+'</option>'); 
                           //console.log(i+' '+st.data[i].idmodelo);
                       })
             	},
             });  
       
   }
   
   function revisar(id){
       
       var param={'xid': id};
       $.ajax({
         
       url:'../rutinas/spp/carga_datos_equipo.php',
       type:"GET",
       data: param, 
       error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
       success: function(response){
           
               var st= JSON.parse(response);
               
               //console.log(st);
               
               
               $("#idmodelo option").each(function(){
                   //console.log($(this).val());
                    if($(this).val() == st[0].idmodelo){
                      $(this).val(st[0].idmodelo).attr("selected", "true");          
                    }
                });
                
                $("#idcliente option").each(function(){
                   
                    if($(this).val() == st[0].idcliente){
                      $(this).val(st[0].idcliente).attr("selected", "true");          
                    }
                });
           
              
               
               $('#numero_serie').attr('value', st[0].numero_serie) ;  // serie
               $('#numero_sap').attr('value', st[0].numero_sap) ;  // sap
               
               $('#fabricante').attr('value', st[0].fabricante) ;  // sap
               $('#procedencia').attr('value', st[0].procedencia) ;  // sap
               $('#fabricacion').attr('value', st[0].fabricacion) ;  // sap
               
                carga_ubicacion();
                
                
               
               
               $("#status option").each(function(){
                   //console.log($(this).val());
                    if($(this).val() == st[0].status_operativo){
                      $(this).val(st[0].status_operativo).attr("selected", "true");          
                    }
                });
              
               $('#idequipo').attr('value', st[0].idequipo); 
               
               $("#ubicacion option").each(function(){
                   //console.log($(this).val());
                    if($(this).val() == st[0].idclte_ubicacion){
                      $(this).val(st[0].idclte_ubicacion).attr("selected", "true");          
                    }
                });
                
                 $("#tipo option").each(function(){
                   //console.log($(this).val());
                    if($(this).val() == st[0].tipo_equipo){
                      $(this).val(st[0].tipo_equipo).attr("selected", "true");          
                    }
                });
               
               
               },
         
     });
       
       
       
   }
   
   
</script>



<body>


    <div class="container">
        <div class="col-md-12">
            <h3 class="text-center "><strong>Gestión Equipos</strong></h3>

        </div>
    </div>
    
    <div class="container">
        <div class="col-md-12">  
            <div class="well">
                <form class="form-horizontal" role="form" id="form_datos" method="post">
                    <input type="hidden" id="idequipo" value="0">

                    <div class="form-group">
                        <label for="tipo_equipo" class="col-sm-2 control-label">Tipo Equipo</label>
                        <div class="col-sm-9"><strong>
                            <select id="tipo_equipo" class="form-control" onchange="cargar_datos()" >
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
        <div class="col-md-12">  
            <div class="well">
                <form class="form-horizontal" role="form" id="form_datos" method="post">
                   
                    
                    <div class="form-group">
                        <label for="idmodelo" class="col-sm-2 control-label">Modelo</label>
                        <div class="col-sm-9"><strong>
                            <select id="idmodelo" class="form-control"  >
                             <option value=""></option>
                            </select>
                            </strong>
                        </div>
                      </div>   
                    
                      <div class="form-group">
                        <label for="numero_serie" class="col-sm-2 control-label">Número Serie</label>
                        <div class="col-sm-9"><strong>
                                <input type="text"  id="numero_serie" class="form-control" maxlength="50"  >
                            </strong>
                        </div>
                      </div>
                    
                      <div class="form-group">
                        <label for="numero_sap" class="col-sm-2 control-label">Número SAP</label>
                        <div class="col-sm-9"><strong>
                                <input type="text"  id="numero_sap" class="form-control" maxlength="10"  >
                            </strong>
                        </div>
                      </div>
                    
                      <div class="form-group">
                        <label for="fabricante" class="col-sm-2 control-label">Fabricante</label>
                        <div class="col-sm-9"><strong>
                                <input type="text"  id="fabricante" class="form-control" maxlength="40"  >
                            </strong>
                        </div>
                      </div>
                    
                      <div class="form-group">
                        <label for="procedencia" class="col-sm-2 control-label">Procedencia</label>
                        <div class="col-sm-9"><strong>
                                <input type="text"  id="procedencia" class="form-control" maxlength="40"  >
                            </strong>
                        </div>
                      </div>
                    
                      <div class="form-group">
                        <label for="fabricacion" class="col-sm-2 control-label">Año Fabricación</label>
                        <div class="col-sm-9"><strong>
                                <input type="number"  id="fabricacion" class="form-control" maxlength="4"  >
                            </strong>
                        </div>
                      </div>
                    
                     <div class="form-group">
                        <label for="idcliente" class="col-sm-2 control-label">Cliente</label>
                        <div class="col-sm-9"><strong>
                                <select id="idcliente" class="form-control" onchange="carga_ubicacion()"  >
                                <option value=-1></option>
                                    <?php echo $opcion_cliente?>  
                                </select>
                            </strong>
                        </div>
                      </div>   
                    
                    
                      <div class="form-group">
                        <label for="ubicacion" class="col-sm-2 control-label">Ubicación Cliente</label>
                        <div class="col-sm-5"><strong>
                            <select id="ubicacion" class="form-control"  >
                             <option value=-1></option>
                            </select>
                            </strong>
                        </div>
                      </div>  
                    
                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Status Equipo</label>
                        <div class="col-sm-3"><strong>
                            <select id="status" class="form-control" >
                             <option value=-1></option>
                                <?php echo $opcion_status?>  
                            </select>
                            </strong>    
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="tipo" class="col-sm-2 control-label">Tipo Equipo</label>
                        <div class="col-sm-3"><strong>
                            <select id="tipo" class="form-control" >
                             <option value=0></option>
                             <option value=1>Equipo Propio</option>
                             <option value=2>Equipo Tercero</option>
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
        <div class="col-md-12">
            <h3 class="text-center">Modelos</h3>
            <div class="well">
                <table class="table" id="lista-equipos">
                    <thead>
                        <tr>
                            <th>Modelo</th>
                            <th>Numero Serie</th>
                            <th>Equipo SAP</th>
                            <th>Cliente</th>
                            <th>Ubicacion</th>
                            <th>Status</th>
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
          function cargar_datos(){
              
              //alert($("#inputidfaena").val());
              $("#tipo_equipo").prop('disabled', true);
              
              $("#lista").show();
              $("#datos").show();
              
              var xid=($("#tipo_equipo").val());
              var param={'idtipo': xid};
              
              
             
              $("#lista-equipos").DataTable({
                 paging : false,
                 language: {
                        url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                 },    
                 columns: [
                 {name :"Modelo", array :"idmodelo"},    
                 {name :"Numero Serie", array :"numero_serie"},
                 {name :"Equipo SAP", array :"numero_sap"},
                 {name :"Cliente", array :"nombre_cliente"},
                 {name :"Ubicacion", array :"nombre_ubicacion"},
                 {name :"Status", array :"nombre_status"},
                 {name :"Accion", render : function(data, type, row){
            return `
                        <input type=button class="removeForum btn btn-info" onclick="revisar('${row.accion}')" value="Editar">
                    `
            }

            },
                 ],
                 ajax:{
                 url: "../rutinas/spp/carga_equipos_modelo.php?idtipo="+xid
                 }
               
             });
             
         
             var param={'idtipo': xid};
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
                       //console.log(st);
                       
                       $.each(st, function(i,item){
                             $.each(item,function(j,datos){
                                 //console.log(item[j].idmodelo);
                                 $("#idmodelo").append('<option value="' + item[j].idmodelo + '">' + item[j].idmodelo+'</option>'); 
                           })
                       })
             	},
             });  
              
           
              
          } 
    </script>

    
    
    
    
</body>    
    

