/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 $(document).ready(function(){
        $("#limpiar").on("click", function(e){
          e.preventDefault();
          window.location.href='aprobar_consumos.php';
        })
        
        
        
        $("#listar").on("click", function(e){
            e.preventDefault();
            if ($("#idfaena").val()<=0){
                $('#idfaena').css('border-color','#FF0000');
                alert('Debe Seleccionar Faena');
            return false; }
            if ($("#contrato").val()<=0){
                $('#contrato').css('border-color','#FF0000');
                alert('Debe Seleccionar Contrato');
            return false; }
            
            if ($("#estado_pago").val()<=0){
                $('#estado_pago').css('border-color','#FF0000');
                alert('Debe Seleccionar Estado Pago');
            return false; } 
            
             $("#fm_cabecera").attr('action', '../salidas/aprobar/consumos_sin_aprobar.php');
             $("#fm_cabecera").submit();
        
        
        })
        
        $("#idfaena").change(function(e){
             var datos={'idfaena': $("#idfaena").val()};
             $.ajax({
                      url:'../cargas/carga_contrato_faena.php',
                      type:"POST",
                      data: datos, 
                      error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                      success: function(response){
                               //console.log(response);
                               var st= JSON.parse(response);
                               //console.log(st);
                               $('#contrato').children('option:not(:first)').remove();
                               $.each(st, function(i,item){
                                 $("#contrato").append('<option value="' + st[i].idestado + '">' +st[i].descripcion_trabajo+'</option>'); 
                                 //  console.log(i+' '+st[i].idestado+'   '+st[i].descripcion_trabajo);
                               })
                
                               $("#datos").show();
		//
		               },
         
                       });
            
        })
        
        $("#contrato").change(function(e){
             var datos={'idcontrato': $("#contrato").val(),'tipo':'A'};
             $.ajax({
                      url:'../cargas/carga_estado_pago.php',
                      type:"POST",
                      data: datos, 
                      error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                      success: function(response){
                               //console.log(response);
                               var st= JSON.parse(response);
                               //console.log(st);
                               $('#estado_pago').children('option:not(:first)').remove();
                               $.each(st, function(i,item){
                                 $("#estado_pago").append('<option value="' + st[i].idperiodo + '">' +st[i].nombre+'</option>'); 
                                 //  console.log(i+' '+st[i].idestado+'   '+st[i].descripcion_trabajo);
                               })
                
                              
		//
		               },
         
                       });
            
        })
        
        $("#estado_pago").change(function(e){
             var datos={'idcontrato': $("#contrato").val(),'idestado':$("#estado_pago").val()};
             $.ajax({
                      url:'../cargas/carga_fecha_ep.php',
                      type:"POST",
                      data: datos, 
                      error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                      success: function(response){
                               
                              var st= JSON.parse(response);
                              
                             // console.log(response);
                               
                              $("#fec_inicio").attr('value',st.inicio);
                              $("#fec_termino").attr('value',st.termino);
                              
                              carga_totales();
                               
                               carga_lineas();
                               
                               
		               },
         
                       });
            
        })
        
        
        
        $("#grabar_con").on('click',function(e){
            // confirmar
            if (confirm('Desea Aprobar Consumos ?')) {
            
            
            var listaop=0;
            var arrayGrab = [];
            $("#ifrmx1").contents().find("input[type=checkbox]:checked").each(function (index){
                
                     listaop++;
                     arrayGrab.push($(this).val());
                     
                             
            } )
            
            if (listaop<=0){
                alert("No hay datos Seleccionados para Grabar, Revisar ");
                return false;
            }
            // grabar
            $("#carga").show();
            $("#f2").hide();
            $("#f3").hide();
            $("#barra_grabar").hide();
            $("#beditar").hide();
            
            
             var datos={'idfaena': $("#idfaena").val(),'idestado':$("#estado_pago").val(),'ip':$("#ip").val(),'inicio':$("#fec_inicio").val(),'termino':$("#fec_termino").val(),'idcontrato':$("#contrato").val(),'data':arrayGrab};
            $.ajax({
                      url:'../acciones/grabar_consumos_aprobados.php',
                      type:"POST",
                      data: datos, 
                      error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                      success: function(response){
                              //console.log(response);
                               if (response=='0'){
                                   alert('Consumos Grabados OK ');
                                   carga_lineas();
                                   $("#carga").hide();
                                   $("#f2").show();
                                   $("#f3").show();
                                   $("#barra_grabar").show();
                                   $("#beditar").show();
                                   
                               }
                               //console.log(st);
                               
		//
		               },
         
                       });
                   }
        })
        
        
        
    })
    
function carga_lineas(){
    //alert('cargar');
    
     
    
    var iframeForm = document.getElementById("iframeForm");
    document.getElementById("ifrmx1").contentWindow.document.getElementById('loading').style.display = "";
    $("#barra_grabar").show();
    
    iframeForm.reset();
    iframeForm.idfaena.value=$("#idfaena").val();
    iframeForm.idcontrato.value= $("#contrato").val();
    iframeForm.inicio.value= $("#fec_inicio").val();
    iframeForm.termino.value= $("#fec_termino").val();
    iframeForm.tipo.value= 'N';
    iframeForm.action = "../iframes/ifrm_aprobar_consumos.php";
    iframeForm.target = "ifrm1";
    iframeForm.submit ();
    
    
}  


function carga_totales(){
     var datos={'idestado':$("#estado_pago").val(),};
     $.ajax({
         url:'../cargas/cargar_totales.php',
         type:"POST",
         data: datos, 
         error: function(xhr, status, error)
		{
		alert("error: " + JSON.stringify(xhr));
		},
         success: function(response){
                  //console.log(response);
                   var st= JSON.parse(response);             
                               //console.log(st);
                      $("#total_aprobado_usd").attr('value',st.dolar);
                      $("#total_aprobado_euro").attr('value',st.euro);
		//
		      },
         
           });
    
    
    
    
}

function verstatus(){
     $("#ifrmx1").contents().find("input[type=checkbox]").each(function (index){
                
                   if ($(this).is(':checked'))
                       $(this).prop('checked',false);
                   else    
                     $(this).prop('checked',true);
                     
                             
            } )
    
    
}



