<?php

?>



<script src="../general/app/js/valida_ingreso.js" type="text/javascript" ></script>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html40/loose.dtd">
<html><head>
        <title>Administrar Aplicaciones</title>
        <script src="https://code.jquery.com/jquery-3.1.1.js" integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="sha384-VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/css/tether-theme-arrows-dark.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/css/tether-theme-arrows.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/css/tether-theme-basic.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/css/tether.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="sha384-2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">

        <link rel="stylesheet" href="assets/css/bootstrap.css">
        <link rel="stylesheet" href="assets/css/font-awesome.css">
        <link rel="stylesheet" href="assets/css/bootstrap-social.css">
        <script src="assets/js/jquery.js" charset="utf-8"></script>


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

        </style>
    </head>

    <div class="navbar navbar-light " role="navigation" style="background-color: #e3f2fd;">

        <a class="navbar-brand" href="#">Dirección Operaciones - SubGerencia Control Gestión - Komatsu Chile</a>

    </div>    

        <div class="container-fluid" align="center" >
            <div class="card bg-light border-dark   mb-3" style="max-width: 80rem;" >
                <img class="card-img-top" src="img/komatsu2.png" width="250" >
                <div class="card-body text-dark" >
                    <h2 class="card-title">Adminsitración Aplicaciones DOP-KCH </h2>
                    <h3 class="card-title" >Ingreso Usuario </h3>
                </div>



            </div>
        </div>

        <br />


 <form name="frm_datos"  method="post" >
        <div class="container-fluid" align="center" >
            <div class="card bg-light border-dark   mb-3" style="max-width: 80rem;" >

                <table width=400 align="center">

                    <tr>
                       
                        <td> <input type="input" name="correo" maxlength="10" size="20" id="correo"class="form-control" placeholder="Usuario U1XXXXX"> </td>
                    </tr>     
                    <tr>
                        
                        <td> <input type="password" name="clave" maxlength="60" size="20" id="clave" class="form-control"placeholder="Clave Corporativa"> </td>
                        <td align="center"> <input type="button" class="btn btn-primary" value="Login" onClick="validar()">

                    </tr>

                </table>    

            </div>
        </div>
    </form>


        <br>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

    </body>
</html>