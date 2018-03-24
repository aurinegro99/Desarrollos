<?php

    require_once('app/init.php');
    require_once('app/clases/GoogleAuth.php');

 
    $_SESSION = array();

    // destruirla
    session_destroy();
    $auth=new GoogleAuth();
    $auth->logout();
    
    echo "<script language=Javascript> location.href=\"index.php\"; </script>"; 
    
//    echo 'hola';
    //header("Location : index.html");
    

?>
