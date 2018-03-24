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

<script type="text/javascript">
    $(document).ready(function(){
       $("#cancela").on("click", function(e)
          {
          e.preventDefault();
          window.location.href='clasificacion_contrato.php';	
            //alert('Cancelar')
          });
       $("#grabar").on("click", function(e)
           {
           
           if ($("#contrato").val()<=0){
                $('#contrato').css('border-color','#FF0000');
                alert('Debe Seeleccionar Contrato');
                return false; }  
           if ($("#descripcion").val().trim() === ''){
                $('#descripcion').css('border-color','#FF0000');
                alert('Debe Ingresar Descripción Clasificacion');
                return false; }
           if ($("#moneda").val().trim() === ''){
                $('#moneda').css('border-color','#FF0000');
                alert('Debe Selccionar Moneda de Pago');
                return false; } 
            
            var xactivo='';
             if( $('#vigente').prop('checked') )     
                 xactivo='S';
             else
                 xactivo='N';
             
             
                         
             var datos={'idclasif':$("#idclasif").val(),'idfaena': $("#inputidfaena").val(),'idcontrato': $("#contrato").val(),'descripcion':$("#descripcion").val(),'moneda':$("#moneda").val(),'vigente':xactivo};
             $.ajax({
         
                 url:'../acciones/consumos/actualiza_clasificacion.php',
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
                 window.location.href='clasificacion_contrato.php';
		//
		  },
         
               });
            
           });
            
    });
    
function revisar(id){
    
    var param={'xid': id};
    $.ajax({
         
       url:'../acciones/consumos/carga_datos_clasificacion.php',
       type:"GET",
       data: param, 
       error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
       success: function(response){
           
               var st= JSON.parse(response);
               
               //console.log(response);
           
               $('#descripcion').attr('value', st.nombre) ;  // numero contrato
               
               if (st.vigente=='S')
                    $('#vigente').attr('checked', true);
               else 
                    $('#vigente').attr('checked', false);
               
               // recorrer select contrato
               $("#contrato option").each(function(){
                   //console.log($(this).val());
                    if($(this).val() == st.idcontrato){
                      $(this).val(st.idcontrato).attr("selected", "true");          
                    }
                });
               
               // recorrer select moneda
                $("#moneda option").each(function(){
                   //console.log($(this).val());
                    if($(this).val() == st.moneda_pago){
                      $(this).val(st.moneda_pago).attr("selected", "true");          
                    }
                });
               // asignar id a variable
               $('#idclasif').attr('value', id); 
               
               },
         
     }); 
    
}    
</script>
<body>


    <div class="container">
        <div class="col-md-12">
            <h3 class="text-center "><strong>Clasificación Repuestos Contratos</strong></h3>
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
                    <input type="hidden" id="idclasif" value="0">
                      <div class="form-group">
                        <label for="contrato" class="col-sm-2 control-label">Contrato</label>
                        <div class="col-sm-5"><strong>
                                
                                <select name="contrato" id="contrato" class="form-control"  >
                                  <option value=-1></option>
                               
                            </select>
                            </strong>
                        </div>
                      </div>   
                    
                      <div class="form-group">
                        <label for="descripcion" class="col-sm-2 control-label">Descripción</label>
                        <div class="col-sm-9"><strong>
                                <input type="text" name="descripcion" id="descripcion" class="form-control" maxlength="50"  >
                            </strong>
                        </div>
                      </div> 
                    
                      <div class="form-group">
                        <label for="moneda" class="col-sm-2 control-label">Moneda Pago</label>
                        <div class="col-sm-2"><strong>
                               <select name="moneda" id="moneda" class="form-control"  >
                                  <option value=""></option>
                                  <option value="Dolar">Dolar</option>
                                  <option value="Euro">Euro</option>
                                  <option value="Pesos">Pesos</option>
                            </select>
                            </strong>
                        </div>
                      </div>
                    
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="vigente"><strong> Clasificación Vigente</strong>
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
            <h3 class="text-center">Clasificaciones Faena</h3>
            <div class="well">
                <table class="table" id="clasificacion-rep">
                    <thead>
                        <tr>
                            <th>Contrato</th>
                            <th>Descripcion</th>
                            <th>Moneda Pago</th>
                            <th>Activo</th>
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
             
              $("#clasificacion-rep").DataTable({
                 paging : false,
                 language: {
                        url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                 },    
                 columns: [
                 {name :"Contrato", array :"numero_contrato"},
                 {name :"Descripcion", array :"descripcion"},
                 {name :"Moneda Pago", array :"moneda_pago"},
                 {name :"Activo", array :"activa"},
                 {name :"Accion", render : function(data, type, row){
            return `
                        <input type=button class="removeForum btn btn-info" onclick="revisar('${row.accion}')" value="Editar">
                    `
            }

            },
                 ],
                 ajax:{
                    url: "../rutinas/consumo/Clasificacion_faena.php?idfaena="+xid
                 }
               
             });
             
             var xid=($("#inputidfaena").val());
              var param={'idfaena': xid};
             
             // cargar contrato por faena
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
                          $("#contrato").append('<option value="' + st[i].idestado + '">' + st[i].numero_contrato+'</option>'); 
                           //console.log(i+' '+st[i].idestado);
                       })
           	},
             });  
             
             
          } 
          
         
    </script>

    
    
</body>   


  
