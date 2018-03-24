<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#form').submit(function(event) {
     var datos = $(this).serialize();   
      event.preventDefault()
      $.ajax(
        {
            url:'procesa.php',
            type:'POST',
            data:datos,
            beforeSend:function(objeto){ 
                $('#carga').css({display:'block'});
                $('#formulario').css('display','none');
            },
            success:function(data){
                      alert(data);
             },
            complete:function(){$('#carga').css('display','none');
                                $('#formulario').css('display','')
                            }
        });
    });
});
</script>
</head>
<body>
    
<div id="carga" style="display:none" align="center" >
    <img src="ajax-carga2.gif" />
</div>    
    
    <div id="formulario" style=""     >
    <form method="post" id="form" action="procesa.php">
        <fieldset>
            <legend>Registrarse</legend>
            <div class="medidas">
                <label for="user">Usuario:</label>
                <input id="user" name="user">
            </div>
            <div class="medidas">
                <label for="pass">Contraseña:</label>
                <input type="password" id="pass" name="pass">
            </div>
            <div class="check">
                <input type="checkbox" id="remember" name="remember">
                <label for="recordar">Recordar mi nombre de usuario</label>
            </div>
        </fieldset>
        <div>
        <input type="submit" value="Enviar" />
        </div>
    </form>
</div>

<?php 
session_start();
if ($_SESSION["correcto"]){ 
    echo "SESION RECIBIDA"; 
}else{ 
    echo "NINGUNA RECIBIDA"; 
}
?>
 
</body>
</html>
 
