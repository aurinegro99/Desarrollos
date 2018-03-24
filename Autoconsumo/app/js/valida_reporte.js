/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
        $("#limpiar").on("click", function(e){
          e.preventDefault();
          window.location.href='consumos_estado_pago.php';
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
            
             $("#fm_cabecera").attr('action', '../salidas/aprobar/consumos_aprobados_ep.php');
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
        
       
        
    })

