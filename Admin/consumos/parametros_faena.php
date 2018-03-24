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
      $("#cancela").on("click", function(e)
          {
          e.preventDefault();
          window.location.href='parametros_faena.php';	
            //alert('Cancelar')
          });
       $("#grabar").on("click", function(e)
          {
            e.preventDefault();
            if ($("#ciclo").val()<=0){
                $('#ciclo').css('border-color','#FF0000');
                alert('Debe Seleccionar Ciclo Aprobación');
            return false; }
        
            if ($("#aprobacion").val()<=0){
                $('#aprobacion').css('border-color','#FF0000');
                alert('Debe Seleccionar Tipo Aprobación');
            return false; }
        
            if ($("#agrupacion").val()<0){
                $('#agrupacion').css('border-color','#FF0000');
                alert('Debe Seleccionar Agrupación');
            return false; }
        
            if ($("#chequeado").val()===''){
                $('#chequeado').css('border-color','#FF0000');
                alert('Debe Seleccionar Datos PreChequeados');
            return false; }
            
            if ($("#inicio").val()===''){
                $('#inicio').css('border-color','#FF0000');
                alert('Debe Ingresar Fecha Inicio Vigencia');
            return false; }
        
            if ($("#termino").val()===''){
                $('#termino').css('border-color','#FF0000');
                alert('Debe Ingresar Fecha Termino Vigencia');
            return false; }
        
            if ($("#programado").val()<=0){
                 $('#programado').css('border-color','#FF0000');
                alert('Debe Seleccionar Act. Planificadas');
            return false;
                
            }
        
            // validar fechas
            var param={'inicio':$("#inicio").val(),'termino':$("#termino").val(),'idfaena':$("#idfaena").val(),'idcontrato':$("#idcontrato").val(),'ciclo':$("#ciclo").val(),'aprobacion':$("#aprobacion").val(),'agrupacion':$("#agrupacion").val(),'chequeado':$("#chequeado").val(),'planificada':$("#programado").val()};
            $.ajax({      
                       url:'../acciones/consumos/graba_parametros_faena.php',
                       type:"POST",
                       data: param, 
                       error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                       success: function(response){
                                //console.log(response);
                                //alert(response);
                                if (response<0){
                                    alert('Error en Fechas, revisar');
                                    return false;
                                    }
                                else{
                                    alert('Datos Grabados OK')
                                    window.location.href='parametros_faena.php';
                                    }
                       
           	       },
                  });
          
          });
    
    
    });
    
    
    
    function cargar_contrato(){
        
           $('#idcontrato').children('option:not(:first)').remove();
           var param={'idfaena': $("#idfaena").val()}
           $.ajax({      
                       url:'../rutinas/consumo/carga_contrato.php',
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
                          $("#idcontrato").append('<option value="' + st[i].idestado + '">' + st[i].numero_contrato+'-->'+st[i].descripcion_trabajo+'</option>'); 
                           //console.log(i+' '+st[i].idestado);
                       })
           	},
             });  
        
    }
    
    function cargar_parametros(){
             var param={'idfaena': $("#idfaena").val(),'idcontrato':$('#idcontrato').val()}
           $.ajax({      
                       url:'../rutinas/consumo/carga_parametros.php',
                       type:"GET",
                       data: param, 
                       error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                       success: function(response){
                      
                       var st= JSON.parse(response);
                       //console.log(st);
                       //console.log(st[0].inicio);
                       $("#idfaena").prop('disabled', true);
                       $("#idcontrato").prop('disabled', true);
                       
                       $("#ciclo option").each(function(){
                   //console.log($(this).val());
                          if($(this).val() == st[0].ciclos){
                             $(this).val(st[0].ciclos).attr("selected", "true");          
                          }
                        });
                        
                        $("#aprobacion option").each(function(){
                         if($(this).val() == st[0].aprobar){
                          $(this).val(st[0].aprobar).attr("selected", "true");          
                         }
                         });
                       
                         $("#agrupacion option").each(function(){
                         if($(this).val() == st[0].tipo_aprobar){
                          $(this).val(st[0].tipo_aprobar).attr("selected", "true");          
                         }
                         });
                         
                         $("#chequeado option").each(function(){
                         if($(this).val() == st[0].aprobado){
                          $(this).val(st[0].aprobado).attr("selected", "true");          
                         }
                         });
                         
                         $("#inicio").attr('value',st[0].inicio);
                         $("#termino").attr('value',st[0].termino);
                         
                         $("#programado option").each(function(){
                         if($(this).val() == st[0].planificada){
                          $(this).val(st[0].planificada).attr("selected", "true");          
                         }
                         });
                         
                         if (st[0].ciclos==4){
                             $("#programado").prop('disabled', true); 
                             
                         }
                       
                        
                       
           	},
             });
             
              $("#datos").show();
        
        
    }
    
    function aprobados(){
        if ($("#ciclo").val()==1){
                $("#programado option").each(function(){
                   //console.log($(this).val());
                    if($(this).val() == 1){
                      $(this).val(1).attr("selected", "true");          
                    }
                });
            
            
             $("#programado").prop('disabled', true); 
        }
        else{
            
             $("#programado").prop('disabled', false);
            
        }
        
    }
    
</script>

<body>


    <div class="container">
        <div class="col-md-12">
            <h3 class="text-center "><strong>Parametros Faena Consumo</strong></h3>

        </div>
    </div>
    
        <div class="container">
        <div class="col-md-10">  
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
                            <select id="idcontrato" class="form-control" onchange="cargar_parametros()" >
                             <option value=-1></option>
                            </select>
                            </strong>    
                        </div>
                    </div>
                    
                    
                    

                </form>
            </div>
        </div>
        </div>
    
    
    <div class="container" id="datos" style="display: none">
        <div class="col-md-10">  
            <div class="well">
                <form class="form-horizontal" role="form"  >
                   
                    
                    <div class="form-group">
                        <label for="ciclo" class="col-sm-3 control-label">Ciclo Aprobación</label>
                        <div class="col-sm-7"><strong>
                                <select id="ciclo" class="form-control" onchange="aprobados()"   >
                            <option value="0"></option>
                            <option value="1">1 Ciclo Aprobación </option>
                            <option value="4">4 Ciclos Aprobación</option>
                            </select>
                            </strong>
                        </div>
                      </div>   
                    
                    <div class="form-group">
                        <label for="aprobacion" class="col-sm-3 control-label">Tipo Aprobación</label>
                        <div class="col-sm-7"><strong>
                            <select id="aprobacion" class="form-control"   >
                            <option value="0"></option>
                            <option value="R">Agrupado </option>
                            <option value="D">Linea x Linea</option>
                            </select>
                            </strong>
                        </div>
                      </div>
                    
                    <div class="form-group">
                        <label for="agrupacion" class="col-sm-3 control-label">Tipo Agrupación</label>
                        <div class="col-sm-7"><strong>
                            <select id="agrupacion" class="form-control"   >
                            <option value="-1"></option>
                            <option value="0">Orden Servicio </option>
                            <option value="1">Documento Material</option>
                            </select>
                            </strong>
                        </div>
                      </div>
                    <div class="form-group">
                        <label for="chequeado" class="col-sm-3 control-label">Datos Pre-Chequeados</label>
                        <div class="col-sm-3"><strong>
                            <select id="chequeado" class="form-control"   >
                            <option value=""></option>
                            <option value="S">Sí </option>
                            <option value="N">No</option>
                            </select>
                            </strong>
                        </div>
                      </div>
                    
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Inicio Vigencia</label>
                        <div class="col-sm-2"><strong>
                                <input type="text" id="inicio" readonly="true">
                            </strong>
                        </div>
                     </div>
                    <script type="text/javascript">
                               var picker = new Pikaday(
                                    {
                               field: document.getElementById('inicio'),
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
                        <label for="" class="col-sm-3 control-label">Término Vigencia</label>
                        <div class="col-sm-2"><strong>
                                <input type="text" id="termino" readonly="true">
                            </strong>
                        </div>
                      </div> 
                        
                      <script type="text/javascript">
                               var picker = new Pikaday(
                                    {
                               field: document.getElementById('termino'),
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
                        <label for="programado" class="col-sm-3 control-label">Act.Planificadas</label>
                        <div class="col-sm-3"><strong>
                            <select id="programado" class="form-control"   >
                            <option value="0"></option>
                            <option value="1">Bandeja Inicial </option>
                            <option value="2">Segunda Bandeja</option>
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

    
    
</body>


