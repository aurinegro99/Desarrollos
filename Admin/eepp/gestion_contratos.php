<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../ini/inicial.php';
$usuario = $_SESSION["usuario"];

require_once '../rutinas/consumo/carga_faenas.php';

?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/date-fns/1.28.5/date_fns.min.js"></script>
  <script src="../../General/js/pikaday.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
         // cancela
         $("#cancela").on("click", function(e)
          {
          e.preventDefault();
          window.location.href='gestion_contratos.php';	
            //alert('Cancelar')
          });
        // grabar
        $("#grabar").on("click", function(e)
           {
              if ($("#contrato").val().trim() === ''){
                $('#contrato').css('border-color','#FF0000');
                alert('Debe Ingresar Nro. Contrato');
                return false; }
            
              if ($("#nombre_contrato").val().trim() === ''){
                $('#nombre_contrato').css('border-color','#FF0000');
                alert('Debe Ingresar Nombre Contrato');
                return false; }
            
              if ($("#mandante").val().trim() === ''){
                $('#mandante').css('border-color','#FF0000');
                alert('Debe Ingresar Nombre Mandante');
                return false; }
            
              if ($("#fecha_inicio").val().trim() === ''){
                $('#fecha_inicio').css('border-color','#FF0000');
                alert('Debe Ingresar Fecha Inicio Contrato');
                return false; }
            
              if ($("#fecha_termino").val().trim() === ''){
                $('#fecha_termino').css('border-color','#FF0000');
                alert('Debe Ingresar Fecha Termino Contrato');
                return false; }
            
             var xactivo='';
             if( $('#vigente').prop('checked') )     
                 xactivo='S';
             else
                 xactivo='N';
             
            
             var datos={'idfaena': $("#inputidfaena").val(),'idcontrato': $("#idcontrato").val(),'contrato':$("#contrato").val(),'nombre':$("#nombre_contrato").val(),'mandante':$("#mandante").val(),'fechainicio':$("#fecha_inicio").val(),'fechatermino':$("#fecha_termino").val(),'activo':xactivo};
     
             
             
             $.ajax({
         
                 url:'../acciones/eepp/actualiza_contratos.php',
                 type:"POST",
                 data: datos, 
                 error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                 success: function(data){
                //console.log(data);
                // alert(data);
                 if (data=='0')
                     alert('Datos Actulizados');
                 window.location.href='gestion_contratos.php';
		//
		  },
         
               });
           });
        
    });
    
    function revisar(id){
         
             
       var param={'xid': id};
       
       $.ajax({
         
       url:'../acciones/eepp/carga_datos_contrato.php',
       type:"GET",
       data: param, 
       error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
       success: function(response){
           
               var st= JSON.parse(response);
               
               //console.log(response);
           
               $('#contrato').attr('value', st.numero) ;  // numero contrato
               $('#nombre_contrato').attr('value', st.nombre) ;  // descripcion trabajo
               $('#mandante').attr('value', st.empresa) ;  // empresa
               $('#fecha_inicio').attr('value', st.inicio) ;  // mail
               $('#fecha_termino').attr('value', st.termino) ;  // mail
               
               if (st.vigente=='S')
                    $('#vigente').attr('checked', true);
               else 
                    $('#vigente').attr('checked', false);
                
               $('#idcontrato').attr('value', st.id); 
               
               
               },
         
     });  
       
   }
    
</script>    
    


<body>


    <div class="container">
        <div class="col-md-12">
            <h3 class="text-center "><strong>Gestión Contratos Operaciones</strong></h3>
        </div>
    </div>
    
    <div class="container">
        <div class="col-md-12">  
            <div class="well">
                <form class="form-horizontal" role="form" id="form_datos" method="post">
                      <input type="hidden" value="0" id="idcontrato">

                    <div class="form-group">
                        <label for="inputidfaena" class="col-sm-2 control-label">Faena</label>
                        <div class="col-sm-9"><strong>
                            <select name="inputidfaena" id="inputidfaena" class="form-control" onchange="cargar_datos()" >
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
                        <label for="contrato" class="col-sm-2 control-label">Nro.Contrato</label>
                        <div class="col-sm-9"><strong>
                                
                                <input type="text" name="contrato" id="contrato" class="form-control" maxlength="15"  >
                            </strong>
                        </div>
                      </div>   
                    
                      <div class="form-group">
                        <label for="nombre_contrato" class="col-sm-2 control-label">Nombre Conrato</label>
                        <div class="col-sm-9"><strong>
                                <input type="text" name="nombre_contrato" id="nombre_contrato" class="form-control" maxlength="80"  >
                            </strong>
                        </div>
                      </div> 
                    
                      <div class="form-group">
                        <label for="mandante" class="col-sm-2 control-label">Mandante</label>
                        <div class="col-sm-9"><strong>
                                <input type="text" name="mandante" id="mandante" class="form-control" maxlength="60"  >
                            </strong>
                        </div>
                      </div>
                    
                      <div class="form-group">
                        <label for="fecha_inicio" class="col-sm-2 control-label">Inicio Contrato</label>
                        <div class="col-sm-2">
                            <input type='text' class="form-control" id="fecha_inicio" readonly="true" name="fecha_inicio">
                           
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
                        <label for="fecha_termino" class="col-sm-2 control-label">Termino Conrato</label>
                        <div class="col-sm-2"><strong>
                                <input type="text" name="fecha_termino" id="fecha_termino" class="form-control" readonly="true" value="01/01/3000"  >
                            </strong>
                        </div>
                      </div> 
                    
                    <script type="text/javascript">
                               var picker = new Pikaday(
                                    {
                               field: document.getElementById('fecha_termino'),
                               toString: function(date, format) {
                               return dateFns.format(date, format);
                                 },
                              firstDay: 1,
                              minDate: new Date(2000,1,1),
                              maxDate: new Date(3000, 01, 01),
                              yearRange: [2000,3000]
                              });
        
                        </script> 
                    
                    
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="vigente"><strong> Contrato Vigente</strong>
                                </label>
                            </div>

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
            <h3 class="text-center">Contratos Faena</h3>
            <div class="well">
                <table class="table" id="contratos-dop">
                    <thead>
                        <tr>
                            <th>Contrato</th>
                            <th>Descripcion</th>
                            <th>Mandante</th>
                            <th>Inicio</th>
                            <th>Termino</th>
                            <th>Vigente</th>
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
              $("#inputidfaena").prop('disabled', true);
              
              $("#lista").show();
              $("#datos").show();
              
              var xid=($("#inputidfaena").val());
             
              $("#contratos-dop").DataTable({
                 paging : false,
                 language: {
                        url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                 },    
                 columns: [
                 {name :"Contrato", array :"numero_contrato"},
                 {name :"Descripcion", array :"descripcion_trabajo"},
                 {name :"Mandante", array :"empresa_mandante"},
                 {name :"Inicio", array :"inicio"},
                 {name :"Termino", array :"termino"},
                 {name :"Vigente", array :"vigente"},
                 {name :"Accion", render : function(data, type, row){
            return `
                        <input type=button class="removeForum btn btn-info" onclick="revisar('${row.accion}')" value="Editar">
                    `
            }

            },
                 ],
                 ajax:{
                    url: "../rutinas/eepp/carga_contratos.php?idfaena="+xid
                 }
               
             });
          } 
          
         
    </script>

    
    
</body>   

