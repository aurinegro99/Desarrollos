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
    var tabla;
    
    $(document).ready(function (){
      $("#asignar").on('click', function(e){ 
        
        var form = this;

        
         var rows_selected = tabla.column(0).checkboxes.selected();
          console.log(tabla.column(0).checkboxes.selected());
          
          
          $.each(rows_selected, function(index, rowId){
              
               
               console.log(rowId);
                                   
                  
          }) 
           //
        
        })
        
        
        
        
        
    })
    
    
    
    
    
    
    
    
    
    
    
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
                      
                      //console.log(response);
                       
                       var st= JSON.parse(response);
                       //console.log(st);
                       
                       $.each(st, function(i,item){
                          $("#idcontrato").append('<option value="' + st[i].idestado + '">' + st[i].numero_contrato+'-->'+st[i].descripcion_trabajo+'</option>'); 
                           //console.log(i+' '+st[i].idestado);
                       });
                       
           	},
             });  
        
    }  
    
</script>
<body>


    <div class="container">
        <div class="col-md-12">
            <h3 class="text-center "><strong>Equipos Contrato</strong></h3>

        </div>
    </div>
    
        <div class="container">
        <div class="col-md-10">  
            <div class="well">
                <form class="form-horizontal" role="form" id="form_datos" method="post">
                    <input type="hidden" id="idcorr" value="0">

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
                            <select id="idcontrato" class="form-control" onchange="cargar_datos()" >
                             <option value=-1></option>
                            </select>
                            </strong>    
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
                            <th></th>
                            
                            
                            
                        </tr>
                    </thead>


                </table>
            </div>
        </div>
    </div>
    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-submit" id="asignar">Asignar</button>   
                             <input type="text"  id="seleccion"  >
                              <input type="text"  id="servidor"  >
                        </div>
                    </div>

    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
    <script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.min.js"></script>
    

    <script>
          function cargar_datos(){
              
              //alert($("#inputidfaena").val());
              $("#idfaena").prop('disabled', true);
              $("#idcontrato").prop('disabled', true);
              
              $("#lista").show();
              $("#datos").show();
              
              var xid=($("#idfaena").val());
              var param={'idfaena': xid};
              
              
             
              tabla = $("#lista-equipos").DataTable({
                 
                         ajax: {url: "../rutinas/spp/carga_equipos_operacion.php?idfaena="+xid},
      columnDefs: [
         {
            targets: 6,
            checkboxes: {
               selectRow: true
            }
         }
      ],
      select: {
         style: 'multi'
      },
      order: [[1, 'asc']]
                 
                 
                  /*
                 
                 
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
                 {name :"Accion", render : function(data, type, row){
            return `
                        <input type=checkbox name="aplica" value="'${row.editar}'">
                    `
            }

            },
                 ],
                 
                 ajax:{ url: "../rutinas/spp/carga_equipos_operacion.php?idfaena="+xid },
                 'columnDefs': [
                              {
                               'targets': 6,
                               'checkboxes': true
                              }
                             ],
                 select: {
                            'style': 'multi'
                           },
                  order: [[1, 'asc']]
               */
             });
              
          } 
    </script>
    
    
</body>