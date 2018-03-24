/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
  $(document).ready(function(){
        $("#limpiar").on("click", function(e){
          e.preventDefault();
          window.location.href='concilia_turno.php';
        })
        
        $("#cargar").on("click", function(e){
            e.preventDefault();
            if ($("#idfaena").val()<=0){
                $('#idfaena').css('border-color','#FF0000');
                alert('Debe Seleccionar Faena');
            return false; }
            if ($("#contrato").val()<=0){
                $('#contrato').css('border-color','#FF0000');
                alert('Debe Seleccionar Contrato');
            return false; }
            
            if ($("#inicio").val()===''){
                $('#inicio').css('border-color','#FF0000');
                alert('Debe Ingresar Fecha Inicio ');
            return false; }
        
            if ($("#termino").val()===''){
                $('#termino').css('border-color','#FF0000');
                alert('Debe Ingresar Fecha Termino ');
            return false; }
        
            // validar fechas
            
            var param={'inicio':$("#inicio").val(),'termino':$("#termino").val()};
            $.ajax({      
                       url:'../validar/validar_fechas.php',
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
                                    //alert('Fechas OK')
                                    //window.location.href='parametros_faena.php';
                                    
                                    $("#idfaena").attr('readonly', 'readonly');
                                    $("#contrato").attr('readonly', true);
                                    $("#inicio").attr('readonly', true);
                                    $("#termino").attr('readonly', 'readonly');
                                    
                                    carga_lineas();
                                    
                                    }
                       
           	       },
                  });
        
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
            
            if ($("#inicio").val()===''){
                $('#inicio').css('border-color','#FF0000');
                alert('Debe Ingresar Fecha Inicio ');
            return false; }
        
            if ($("#termino").val()===''){
                $('#termino').css('border-color','#FF0000');
                alert('Debe Ingresar Fecha Termino ');
            return false; }
            
             $("#fm_cabecera").attr('action', '../salidas/concilia/consumos_sin_conciliar.php');
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
                
                    
		//
		               },
         
                       });
            
        })
        
        $("#grabar_con").on('click',function(e){
            // confirmar
            if (confirm('Desea Conciliar Consumos ?')) {
            
            
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
            
            $("#carga").show();
            $("#f2").hide();
            $("#bgrabar").hide();
            $("#beditar").hide();
            $("#f3").hide();
            
            
            // grabar
             var datos={'idfaena': $("#idfaena").val(),'idcontrato':$("#contrato").val(),'ip':$("#ip").val(),'inicio':$("#inicio").val(),'termino':$("#termino").val(),'data':arrayGrab};
            $.ajax({
                      url:'../acciones/grabar_concilia_turno.php',
                      type:"POST",
                      data: datos, 
                      error: function(xhr, status, error)
				{
					alert("error: " + JSON.stringify(xhr));
				},
                      success: function(response){
                              // console.log(response);
                               if (response=='0'){
                                   alert('Consumos Conciliados OK ');
                                   carga_lineas();
                                   $("#carga").hide();
                                   $("#f2").show();
                                   $("#bgrabar").show();
                                   $("#beditar").show();
                                   $("#f3").show();
            
                                   
                               }
                               //console.log(st);
                               
		//
		               },
         
                       });
                   }
        })
        
        // listar conciliados
        $("#lista_con").on('click',function(e){
             $("#fm_cabecera").attr('action', '../salidas/concilia/consumos_conciliados.php');
             $("#fm_cabecera").submit();
            
            
            
        })
        
        
        
    })
    
function carga_lineas(){
    var iframeForm = document.getElementById("iframeForm");
    document.getElementById("ifrmx1").contentWindow.document.getElementById('loading').style.display = "";
    $("#bgrabar").show();
    
    iframeForm.reset();
    iframeForm.idfaena.value=$("#idfaena").val();
    iframeForm.idcontrato.value= $("#contrato").val();
    iframeForm.inicio.value= $("#inicio").val();
    iframeForm.termino.value= $("#termino").val();
    iframeForm.tipo.value=1;
    iframeForm.action = "../iframes/ifrm_aprobar_consumos.php";
    iframeForm.target = "ifrm1";
    iframeForm.submit ();
    
    
}  


function verstatus(){
     $("#ifrmx1").contents().find("input[type=checkbox]").each(function (index){
                
                   if ($(this).is(':checked'))
                       $(this).prop('checked',false);
                   else    
                     $(this).prop('checked',true);
                     
                             
            } )
    
    
}

