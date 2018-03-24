<?php

    
    $_SESSION = array();

    // destruirla
    session_destroy();
    
    echo "<script language=Javascript> location.href=\"index.php\"; </script>"; 
    
//    echo 'hola';
    //header("Location : index.html");
    

?>
