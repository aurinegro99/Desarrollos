<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../ini/inicial.php';
$usuario = $_SESSION["usuario"];
?>

<script type="text/javascript">
    
   
    $(document).ready(function(){
    $("#grabar").on("click", function(e)
    {
    e.preventDefault();
            if ($("#inputidU").val().length <= 0){
    alert('Debe Ingresar ID Usuario');
            return false; }
    if ($("#nombreUsuario").val().length <= 0){
    alert('Debe Ingresar Nombre Usuario');
            return false; }
    if ($("#inputEmail").val().indexOf('@', 0) == - 1 || $("#inputEmail").val().indexOf('.', 0) == - 1) {
    alert('El correo electrónico introducido no es correcto.');
            return false;
    }
    if ($("#rutUsuario").val().length <= 0){
       alert('Debe Ingresar rut Usuario');
       return false; }

    var xactivo='';
    if( $('#activo').prop('checked') )     
        xactivo='S';
    else
        xactivo='N';
     
    //alert($("#tipo").val()); 
    var datos={'tipo': $("#tipo").val(),'inputidU':$("#inputidU").val(),'nombreUsuario':$("#nombreUsuario").val(),'rutUsuario':$("#rutUsuario").val(),'inputEmail':$("#inputEmail").val(),'activo':xactivo};
     
     // alert(datos);     
     
     $.ajax({
         
       url:'../acciones/actualiza_usuario.php',
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
                
                
                if (data==5){
                    alert('Hay error en el Usuario, ya esta asignado a otra persona');
                    return false;
                }
                
                if (data==6){
                    alert('Hay error en el Correo, ya esta asignado a otra persona');
                    return false;
                }
                
                if (data==7){
                    alert('Hay error en el Rut, ya esta asignado a otra persona');
                    return false;
                }
                
                if (data=='1')
                    alert('Usuario Creado');
                
                
                window.location.href='gestion_usuarios.php';
		//
		},
         
     });
     
    });
    
    
    $("#cancela").on("click", function(e)
    {
          e.preventDefault();
          window.location.href='gestion_usuarios.php';	
            //alert('Cancelar')
    });
    });


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
              // console.log(st.usuario);
               
           
                //var st = JSON.parse(data.responseText);
                
                //alert(st.nombre_usuario);
		//console.log(data);
                //$.each(response.data, function(key, value){
                //   var dato=value['nombre_usuario']; 
                    
                //})
                //console.log(response.data.nombre_usuario);
                
                //
		},
         
     });  
       
   }
  

</script>

<body>


    <div class="container">
        <div class="col-md-12">
            <h3 class="text-center "><strong>Mantenedor Usuarios SPP/EPP</strong></h3>

        </div>
    </div>

    <div class="container">
        <div class="col-md-12">  
            <div class="well">
                <form class="form-horizontal" role="form" id="form_datos" method="post">
                    <input type="hidden" id="tipo" value="N">

                    <div class="form-group">
                        <label for="inputidU" class="col-sm-2 control-label">Usuario</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputidU" placeholder="Id Usuario" maxlength="15" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nombreUsuario" class="col-sm-2 control-label">Nombre Usuario</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nombreUsuario" placeholder="Apellido Paterno Materno, Nombres" maxlength="60">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="rutUsuario" class="col-sm-2 control-label">Rut Usuario</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="rutUsuario" placeholder="RUT" maxlength="10">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="activo"><strong> Usuario Activo</strong>
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

    <div class="container">
        <div class="col-md-20">
            <h3 class="text-center">Listado Usuarios Activos</h3>
            <div class="well">
                <table class="table" id="usuarios-spp">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Rut</th>
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
            jQuery(document).ready(function($){
    $("#usuarios-spp").DataTable({
    paging : false,
            language: {
            url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },    
            columns: [
            {name :"Usuario", array :"usuario"},
            {name :"Nombre", array :"Nombre_Usuario"},
            {name :"Correo", array :"mail_usuario"}, 
            {name :"Rut", array :"rut_usuario"},
            {name :"Accion", render : function(data, type, row){
            return `
                        <input type=button class="removeForum btn btn-info" onclick="revisar('${row.usuario}')" value="Editar">
                    `
            }

            },
            ],
            ajax:{

            url: "carga_usuarios.php"
            }


    });
    })
    </script>

</body>
