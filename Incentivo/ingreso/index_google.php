<?php
    require_once('../app/init.php');
    
    require_once('../vendor/autoload.php');
    require_once('../app/clases/GoogleAuth.php');
  
    
    $googleClient = new Google_Client();
    $auth= new GoogleAuth($googleClient);
//include "header/cabecera2.php"; 

 if ($auth->checkRedirectCode()){
        //die($_GET['code']);
        //header('Location : index.php');
       // var_dump($auth->getPayLoad()); 
        echo "<script language=Javascript> location.href=\"index.php\"; </script>"; 
    }

?>


<script language="JavaScript" type="text/JavaScript">

</script>

<html>
<head>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
        <link rel="stylesheet" href="../assets/css/font-awesome.css">
        <link rel="stylesheet" href="../assets/css/bootstrap-social.css">
        <script src="../assets/js/jquery.js" charset="utf-8"></script>    
    
</head>    
<body>    



         <table width="200" border="0" cellspacing="0" cellpadding="0" align="center" >
					   <tr>
					   <h2>Ingreso Usuario </h2>
					  </tr>
		    </table>
            <br />
    
        <table width=500 align="center">
            <tr>
              <td>
                  <?php if (!$auth->isLoggedIn()): ?>
<!--                          <div class="col-md-4">-->
                          <a href="<?php echo $auth->getAuthUrl(); ?>" class="btn btn-block btn-social btn-google"><span class="fa fa-google" align="right"></span> Inicia sesion con Google</a>
            
<!--                  </div>-->
                 <?php 
                         
                       else:
                            $auth->logout();
                            echo "<script language=Javascript> location.href=\"index.php\"; </script>"; 
                           
                  
                           
                  endif ;?>
              </td>              
    
             
 
       </tr>
          </table>
            

<br>
   
  

</body>
</html>