/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

  $(document).ready(function(){
              $("#limpiar").on("click", function(e){
                 e.preventDefault();
                 window.location.href='consulta_precios.php';
               })  
               
              $("#idfaena").change(function(e){
                 var datos={'idfaena': $("#idfaena").val()};
                 $.ajax({
                      url:'../cargas/carga_tipo_equipo.php',
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
                               $('#tipo_equipo').children('option:not(:first)').remove();
                               $.each(st, function(i,item){
                                 $("#tipo_equipo").append('<option value="' + st[i].idtipo + '">' +st[i].descripcion+'</option>'); 
                                 //  console.log(i+' '+st[i].idestado+'   '+st[i].descripcion_trabajo);
                               })
                
                    
		//
		               },
         
                       });
            
               })
               
               $("#buscar").on('click',function(e){
                     e.preventDefault();
                     if ($("#idfaena").val()<=0){
                           $('#idfaena').css('border-color','#FF0000');
                          alert('Debe Seleccionar Faena');
                      return false; }
                  
                      if ($("#tipo_equipo").val()<=0){
                           $('#tipo_equipo').css('border-color','#FF0000');
                          alert('Debe Seleccionar Tipo Equipo');
                      return false; }
                      if ($("#fecha").val()<=0){
                           $('#fecha').css('border-color','#FF0000');
                          alert('Debe Ingresar Fecha');
                      return false; }
                  
                      if ($("#parte").val()===''){
                           $('#parte').css('border-color','#FF0000');
                          alert('Debe Ingresar Número de Parte');
                      return false; }
                  
                      carga_precios()
                   
               })
               
               $("#enviar").on('click',function(e){
                     e.preventDefault();
                     if ($("#idfaena").val()<=0){
                           $('#idfaena').css('border-color','#FF0000');
                          alert('Debe Seleccionar Faena');
                      return false; }
                  
                      if ($("#tipo_equipo").val()<=0){
                           $('#tipo_equipo').css('border-color','#FF0000');
                          alert('Debe Seleccionar Tipo Equipo');
                      return false; }
                      if ($("#fecha").val()<=0){
                           $('#fecha').css('border-color','#FF0000');
                          alert('Debe Ingresar Fecha');
                      return false; }
                  
                      if ($("#fileUpload").val()===''){
                           $('#fileUpload').css('border-color','#FF0000');
                          alert('Debe Seleccionar archivo');
                      return false; } 
                     var exten = $("#fileUpload").val().substring($("#fileUpload").val().lastIndexOf("."));
                     
                     if(exten != ".xls" && exten!= ".xlsx"){
                          alert("El archivo de tipo " + exten + "  no es válido, debe ser Excel(xls,xlsx) ");
                         return    
                     }
                     
                     $("#nfaena").remove();
                     $("#ntipo").remove();
                     $("#nfecha").remove();
                     
                     
                     $("#fm_subir").append("<input type='hidden' name='nfaena' id='nfaena'>");
                     $("#fm_subir").append("<input type='hidden' name='ntipo' id='ntipo'>");
                     $("#fm_subir").append("<input type='hidden' name='nfecha' id='nfecha'>");
                     
                     $("#nfaena").attr('value',$("#idfaena").val());
                     $("#ntipo").attr('value',$("#tipo_equipo").val());
                     $("#nfecha").attr('value',$("#fecha").val());
                     
                      $("#fm_subir").attr('action', '../salidas/planilla_lista.php');
                      $("#fm_subir").submit();

                   
                   
               })
               
             
             
             
         })
 
 
 function carga_precios(){
     
     var iframeForm = document.getElementById("iframeForm");
    document.getElementById("ifrm1").contentWindow.document.getElementById('loading').style.display = "";
  
    
    iframeForm.reset();
    iframeForm.faena.value=$("#idfaena").val();
    iframeForm.tipo.value= $("#tipo_equipo").val();
    iframeForm.fecha.value= $("#fecha").val();
    iframeForm.parte.value= $("#parte").val();
    
    iframeForm.action = "../iframes/ifrm_numero_parte.php";
    iframeForm.target = "ifrm1";
    iframeForm.submit ();
     
     
 }
