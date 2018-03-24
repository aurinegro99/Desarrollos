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
    
     $(document).ready(function(){ 
       $("#cancela").on("click", function(e)
          {
          e.preventDefault();
          window.location.href='visualizar_faena.php';	
            //alert('Cancelar')
          }); 
          
       $("#grabar").on("click", function(e)
          {
            e.preventDefault();
            if ($("#parametros").val().trim()===''){
                $('#parametros').css('border-color','#FF0000');
                alert('Debe Ingresar Datos');
            return false; }
        
            var param={'correlativo':$("#idcorr").val(),'datos':$("#parametros").val(),'idfaena':$("#idfaena").val(),'idcontrato':$("#idcontrato").val()};
            $.ajax({      
                       url:'../acciones/consumos/graba_visualiza_faena.php',
                       type:"POST",
                       data: param, 
                       error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                       success: function(response){
                                console.log(response);
                                //alert(response);
                                if (response=='0'){
                                   alert('Datos Grabados OK')
                                   
                                   //var tabla = $('#parametros-dop').DataTable( {} );
                                   tabla.ajax.reload();
                                    //window.location.href='visualizar_faena.php';
                                    }
                                
                       
           	       },
                  });
        })   
    
    
    
    })
    
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
                       });
                       
           	},
             });  
        
    }
    
    function revisar(id){
        var param={'correlativo': id};
        $("#idcorr").attr('value',id);
        $.ajax({
                       url:'../rutinas/consumo/carga_parametro_visualiza.php',
                       type:"POST",
                       data: param, 
                       error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                       success: function(response){
                       console.log(response);
                       var st= JSON.parse(response);
                       $("#parametros").attr('value',st[0].parametros);
                       
                       
             	},
             });
        
        
    }
    
    function borrar(id){
        if(confirm('Desea Eliminar Parametros ')){
         var param={'correlativo': id};
        $.ajax({
                       url:'../rutinas/consumo/elimina_parametro_visualiza.php',
                       type:"POST",
                       data: param, 
                       error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                       success: function(response){
                       //console.log(response);
                       if (response=='0'){
                           alert('Dato Eliminado OK ');
                           dt.ajax.reload();
                           
                           window.location.href='visualizar_faena.php';
                       }
             	},
             });  
     }
        
    }
</script>

<body>


    <div class="container">
        <div class="col-md-12">
            <h3 class="text-center "><strong>Parametros Visualización Consumo</strong></h3>

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
    
    <div class="container" id="datos" style="display: none">
        <div class="col-md-10">  
            <div class="well">
                <form class="form-horizontal" role="form"  >
                   
                    
                     <div class="form-group">
                        <label for="datos" class="col-sm-2 control-label">Datos</label>
                        <div class="col-sm-10"><strong>
                                <input type="text" id="parametros" maxlength="100" class="form-control" placeholder="Datos Separados por coma y entre comilla simple">
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
            <h3 class="text-center">Parametros Visualización</h3>
            <div class="well">
                <table class="table" id="parametros-dop">
                    <thead>
                        <tr>
                            <th>Datos</th>
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
               
               $("#idfaena").prop('disabled', true);
               $("#idcontrato").prop('disabled', true);
               $("#datos").show();
               $("#lista").show();
               
               var xidf=($("#idfaena").val());
               var xidc=($("#idcontrato").val());
             
              tabla= $("#parametros-dop").DataTable({
                 paging : false,
                 language: {
                        url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                 },    
                 columns: [
                 {name :"Datos", array :"parametros"},
                 
                 {name :"Editar", render : function(data, type, row){
            return `
                        <input type=button class="removeForum btn btn-info" onclick="revisar('${row.editar}')" value="Editar">
                    `
            }

            },{name :"Borrar", render : function(data, type, row){
            return `
                        <input type=button class="removeForum btn btn-danger" onclick="borrar('${row.borrar}')" value="Borrar">
                    `
            }

            },
                 ],
                 ajax:{
                    url: "../rutinas/consumo/carga_param_visualizar.php?idfaena="+xidf+"&idcontrato="+xidc
                 }
               
             });
               
               
           }
    </script>
    
    </body>
