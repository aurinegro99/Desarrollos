<?php
   session_start();
   
   // grabar la salida
    require_once '../app/clases/AutoConsumo.php';
    $xvalida=new AutoConsumo();
    $xvalida->setIngresoLogin($_SESSION["usuario"],'Salida');
    
    
    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
    
    // destruirla
    session_destroy();
    
    echo "<script language=Javascript> location.href=\"../index.html\"; </script>"; 
    
//    echo 'hola';
    //header("Location : index.html");
    

?>
