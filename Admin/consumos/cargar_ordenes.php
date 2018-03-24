<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../ini/inicial.php';

require_once '../rutinas/consumo/determina_fechas.php';


?>

<script type="text/javascript">
    
    var tabla;
    
    
        $(document).ready(function(){
          $("#grabar").on("click", function(e)
           {
            e.preventDefault();
            if ($("#fecha_inicio").val().trim() === ''){
                alert('No hay Fecha Inicio');
                return false; }
            if ($("#fecha_termino").val().trim() === ''){
                alert('No existe Fecha Termino');
                return false; }
            
            // ajax
            var datos={'inicio': $("#fecha_inicio").val(),'termino':$("#fecha_termino").val()};
             $.ajax({
         
             url:'../acciones/consumos/grabar_cabecera_os.php',
             type:"POST",
             data: datos,
             beforeSend: function(){
                 
                 $("#carga").show();
                 $("#lista").hide();
             },
              error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
              success: function(data){
                //console.log(data);
                alert(data);
                alert('Datos Actualizados : '+data+' Reg.');
                
               $("#carga").hide();
               $("#lista").show(); 
               tabla.ajax.reload();
		//
		},
        });  
        });
    })  

function mandaForm(){
    alert('subir archivo');
    
    
}

</script>


 <div class="container">
        <div class="col-md-10">
            <h3 class="text-center "><strong>Cargar Cabecera Ordenes Servicio</strong></h3>
        </div>
 </div>

 <div class="container" id="datos" align="center"  >
        <div class="col-md-10" >  
            <div class="well">
                 <form class="form-inline"  >
                     <div class="form-group mb-2" ><strong>
                             <label for="fecha_inicio" class="col-sm-2 control-label">Inicio</label>
                           <input type="text" class="form-control" id="fecha_inicio" 
                                  placeholder="Fecha Inicio" readonly="true" value="<?php echo $fecha_inicial?>">
                         </strong>
                           </div>
                     
                     
                     <div class="form-group mx-sm-3 mb-2">
                         <label for="fecha_termino" class="col-sm-2 control-label">Termino</label>
                         <strong>
                           <input type="text" class="form-control" id="fecha_termino" 
                                  placeholder="Fecha Termino" readonly="true" value="<?php echo $fecha_final?>">                    
                         </strong>
                       </div>
                     
                  <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success" id="grabar" >Cargar Ordenes</button>   
                           
                        </div>
                    </div>   
                        
  
                 </form>
                
                
             </div>
        </div>
 </div>

<div class="container" id="archivo" align="center"  >
        <div class="col-md-10" >  
            <div class="well">
                 <form class="form-horizontal" id="subir" action="javascript:mandaForm(this)" >
                     <div class="form-group mb-5" ><strong>
                             <label for="archivo_os" class="col-sm-5 control-label">Subir Archivo Excel</label>
                           <input type="file" class="form-control" id="archivo_os" 
                                  placeholder="Seleccionar Archivo" >
                         </strong>
                      </div>
                      <button type="submit" class="btn btn-success" id="grabar" >Subir Archivo</button>   
                     
                     
  
                 </form>
                
                
             </div>
        </div>
 </div>




<div id="carga" style="display:none" align="center" >
    <img src="../img/ajax-loader.gif" />
</div>
                
<div class="container" id="lista" style="">
        <div class="col-md-10">
            <h3 class="text-center">Historial Carga</h3>
            <div class="well">
                <table class="table" id="historial-carga">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Clase OS</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>


                </table>
            </div>
        </div>
    </div>

    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>  
    <script>
         var tabla=$("#historial-carga").DataTable({
                 paging : false,
                 language: {
                        url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                 },    
                 columns: [
                 {name :"Fecha", array :"fecha"},
                 {name :"Clase OS", array :"clase_orden"},
                 {name :"Cantidad", array :"cantidad"},
                
                 
                 ],
                 ajax:{
                    url: "../rutinas/consumo/carga_historial_os.php"
                 }
               
             });
    </script>
    
    </body>   