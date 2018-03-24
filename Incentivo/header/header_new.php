
<html>
	<head>
		<title>Intranet DOP Komatsu Chile </title>
		<script src="https://code.jquery.com/jquery-3.1.1.js" integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="sha384-VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/css/tether-theme-arrows-dark.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/css/tether-theme-arrows.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/css/tether-theme-basic.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/css/tether.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="sha384-2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../assets/css/bootstrap.css">
        <link rel="stylesheet" href="../assets/css/font-awesome.css">
        <link rel="stylesheet" href="../assets/css/bootstrap-social.css">
        <script src="../assets/js/jquery.js" charset="utf-8"></script>
	

		<style>
			.dropdown-submenu {
			    position: relative;
			}

			.dropdown-submenu > .dropdown-menu {
			    top: 0;
			    left: 100%;
			    margin-top: -6px;
			    margin-left: 0;
			    border-radius: 0.25rem;
			}

			.dropdown-submenu:hover > .dropdown-menu {
			    display: block;
			}

			.dropdown-submenu > a::after {
				border-bottom: 0.3em solid transparent;
				border-left-color: inherit;
				border-left-style: solid;
				border-left-width: 0.3em;
				border-top: 0.3em solid transparent;
				content: " ";
				display: block;
				float: right;
				height: 0;
				margin-right: -0.6em;
				margin-top: -0.95em;
				width: 0;
			}

			.dropdown-submenu.pull-left {
			    float: none;
			}

			.dropdown-submenu.pull-left > .dropdown-menu {
			    left: -75%;
			}

			.dropdown-menu .divider {
				background-color: #e5e5e5;
				height: 1px;
				margin: 9px 0;
				overflow: hidden;
			}
            
            .navbar {
                
                margin-bottom :0px;
            }
            
            .tablaprincipal {
	         font-family: Arial, Helvetica, sans-serif;
	        font-size: 3mm;
	        font-weight: bold;
	       background-color: #FFCC00;
            }
            
            .tablaframe {
	         border: 0.3mm solid #666666;
            }
            
            .titletable {
	font-size: 14px;
	font-weight: bold;
	text-align: center;
	color: #000000;
	font-family: Calibri;
	background-color: #FFCC00;
}
.titledatos {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-style: normal;
	font-weight: bold;
	color: #000000;
	text-align: left;
	background-color: #FFFF99;
	border: 0.2mm solid #000000;
	text-indent: 1mm;
}
.tablabase {
	background-color: #EEEEEE;
	border: 0.2mm solid #666666;
	
}

		</style>
	</head>
    
  
	<body>
<div class="navbar navbar-light fixed-top " role="navigation" style="background-color:#FFFFFF;">
	<a class="navbar-brand" href="#" >
              <img src="../img/komatsu3.png" width="180" height="40"   alt="" align="center">
              
           </a>

          <a class="navbar-brand font-weight-bold" href="#">DOP - Komatsu Chile</a>
        <p class="navbar-brand text-center font-weight-bold">GESTIÓN INCENTIVOS MENSUALES </p>
        <p class="text-right font-weight-bold"><?php echo $xdato_usuario ?> </p>
        <p class="text-right font-weight-bold" ><a class="btn btn-primary" href="../logout.php">Cerrar Sesión</a>  </p>
<!--       <a class="btn btn-primary text-right" href="#" role="button">Link</a>-->
 
   
</div>
 
<nav class="navbar fixed-top" style="background-color: #0000FF ">
    <ul class="nav navbar-nav mr-auto" align="center">
                
        <li class="nav-item dropdown">
            <a href="#" class="dropdown-toggle nav-link font-weight-bold " data-toggle="dropdown" aria-haspopup="false" aria-expanded="false" id="001" style="color: white; background : blue"  >Mantención</a>
            <ul class="nav navbar-nav dropdown-menu " style="color: white; background : #CED8F6"  >
                <li><a class="dropdown-item " href="../accesos/valida_acceso.php?id=1" ><strong>Crear Periodo</strong></a></li>
                <li><a class="dropdown-item " href="../accesos/valida_acceso.php?id=2" ><strong>Cargar Datos Planilla</strong></a></li>
                <li><a class="dropdown-item " href="../accesos/valida_acceso.php?id=3" ><strong>Mantener Convenio Faena</strong></a></li>
                <li><a class="dropdown-item " href="../accesos/valida_acceso.php?id=4" ><strong>Administrar Usuarios</strong></a></li>
                <li><a class="dropdown-item " href="../accesos/valida_acceso.php?id=5" ><strong>Mantención Parámetros KPI</strong></a></li>
                <li><a class="dropdown-item " href="../accesos/valida_acceso.php?id=6" ><strong>Parametros Convenio</strong></a></li>
                
                
                
                
            </ul>
        </li>
        
        <li class="nav-item dropdown">
            <a href="#" class="dropdown-toggle nav-link font-weight-bold" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="001" style="color: white; background: blue" >Reportes</a>
            <ul class="nav navbar-nav dropdown-menu"style="color: white; background : #CED8F6" >
                <li><a class="dropdown-item" href="../reportes/reporte_nomina_mes.php"><strong>Reporte Nomina Mes</strong></a></li>
                
            </ul>
        </li>
          
         
    </ul>  
</nav>
    
    
