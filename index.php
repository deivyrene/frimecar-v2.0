<?php
    session_start();

    require('php/conectar.php');
?>
<!DOCTYPE html>
<html lang="en">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>.:FRIMECAR:. </title>

    <!-- Bootstrap Core CSS -->
    <link href="componentes/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="componentes/css/modern-business.css" rel="stylesheet">

    <link href="componentes/css/estilo.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="componentes/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="componentes/css/ripples.min.css" rel="stylesheet">
    <link href="componentes/css/material-wfont.min.css" rel="stylesheet">

<body >


    <div id="login_content" class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">

            <div ></div>
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                    <div ><center><img src="php/imagenes/frimecar_.png" class="img-responsive" alt="Responsive image"></center></div>
                    </div>
                    <div class="panel-body">
                        <form id="form_login" role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" id="user" autocomplete="off" placeholder="Usuario" required  type="text" >
                                </div>
                                <div class="form-group">
                                    <input class="form-control" id="pass"  autocomplete="off" placeholder="Contraseña" required  type="password" >
                                </div>
                                <div align="center">
                                    <button class="btn btn-success btn-flat" onclick="login()"><i class="mdi-navigation-check"></i> Ok</button>
                                    <button class="btn btn-danger btn-flat" onclick="volver()"><i class="mdi-navigation-close"></i> Cancel</button>
                                </div>
                            </fieldset>
                            
                        </form>
                        <div id="respuesta" ></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

    <!-- jQuery -->
    <script src="componentes/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="componentes/js/bootstrap.min.js"></script>
    <script src="componentes/js/controller.js"></script>
    <script src="componentes/js/ripples.min.js"></script>
    <script src="componentes/js/material.min.js"></script>
    <script>
        $(document).ready(function() {
             $.material.init();
        });
    </script>

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

</html>
