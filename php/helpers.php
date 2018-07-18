<?php

$helpers = new Helpers();
$helpers->meta();
$helpers->css();
$helpers->js();
$helpers->session();
$helpers->formulario_periodo();
@$hoy = date('Y-m-d');
$var = $helpers->comparaFecha('$hoy',$_SESSION['fecha_ven']);

if($var == "igual")
{
    ?>
        <script type="text/javascript">
            modal('per');
        </script>
    <?php
}

Class Helpers
{

    public $monto_bs;

    public function session()
    {
        if($_SESSION["rol_usuario"] == "")
        {
            header("Location:../");
        }
    }

    public function hoy()
    {
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                             
        return $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
    }
    public function encrypt($string, $key) 
    {
       $result = '';
       for($i=0; $i<strlen($string); $i++) {
          $char = substr($string, $i, 1);
          $keychar = substr($key, ($i % strlen($key))-1, 1);
          $char = chr(ord($char)+ord($keychar));
          $result.=$char;
       }
       return base64_encode($result);
    }

    public function decrypt($string, $key) 
    {
       $result = '';
       $string = base64_decode($string);
       for($i=0; $i<strlen($string); $i++) {
          $char = substr($string, $i, 1);
          $keychar = substr($key, ($i % strlen($key))-1, 1);
          $char = chr(ord($char)-ord($keychar));
          $result.=$char;
       }
       return $result;
    }

    public function calculaFecha($fecha,$meses)
    {
 
        return $dentro_de_un_mes=date("Y-m-d",strtotime($fecha.' + '.$meses.' month'));
     
    }

    public function comparaFecha($fecha1,$fecha2)
    {
     
            $datetime1 = date_create($fecha1);
            $datetime2 = date_create($fecha2);

            if($datetime1 > $datetime2)
            {
                return "exedio";
            }
            if($datetime1 == $datetime2)
            {
                return "igual";
            }
            if($datetime1 < $datetime2)
            {
                return "menor";
            }
         
    }


    public function declara_retencion($sueldo, $fecha_ingreso)
    {
            $dias_vacaciones = $this->CalculaEdad($fecha_ingreso) + 15;
            $sueldo_diario = number_format($sueldo/30, 2, '.', '');
            $vacaciones = number_format($sueldo_diario*$dias_vacaciones, 2, '.', '');
            $fin_ano = number_format($sueldo_diario*30, 2, '.', '');
            $sueldo_anual = $sueldo * 12;

            $total = $sueldo_anual + $fin_ano + $vacaciones;

            $unidad = $total / 150;

            return $unidad;

    }

    public function CalculaEdad( $fecha ) 
    {
        list($Y,$m,$d) = explode("-",$fecha);
        return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
    }

    public function meta()
    {
        ?>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>.:FRIMECAR:.</title>

        <?php
    }

    public function css()
    {
        ?>

        <!-- Bootstrap Core CSS -->
        <link href="../componentes/css/bootstrap.min.css" rel="stylesheet">

        <link href="../componentes/js/jquery-ui-1.10.3.custom.css" rel="stylesheet">

        <link href="../componentes/css/estilo.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="../componentes/css/modern-business.css" rel="stylesheet">


        <link href="../componentes/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet">
        
        <link href="../componentes/css/ripples.min.css" rel="stylesheet">
        <link href="../componentes/css/material-wfont.min.css" rel="stylesheet">
        <?php
    }

    public function js()
    {
        ?>

        
        <!-- jQuery Version 1.11.0 -->
        <script src="../componentes/js/jquery.js"></script>

        <script src="../componentes/js/jquery-ui-1.10.3.custom.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../componentes/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="../componentes/js/controller.js"></script>

        <script src="../componentes/js/ripples.min.js"></script>
        <script src="../componentes/js/material.min.js"></script>
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

        <?php
    }


    public function menu()
    {
        if(@$_SESSION["rol_usuario"] == 1)
        {
        ?>

        <!-- DIV QUE MUESTRA FORMULARIO PARA AGREGAR NUEVO USUARIO -->
        <div id="agregar_cestaticket" class="ventana">
          <h3 align="center"> Registro Día en Bs CestaTciket</h3>
            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_agregar_usuario" class="form-horizontal" role="form">
                          <div class="form-group">
                            <label class="col-md-3 control-label">Monto diario Bs</label>
                            <div class="col-md-7">
                               <input type="text" class="form-control" required   id="monto_bs" placeholder="Monto Bs">
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="col-md-12" align="center">
                              <div id="agregar_cesta"><a  onclick="agregar_cesta()" class="btn  btn-default">Enviar</a></div>
                            </div>
                          </div>
                        </form>
                        <div id="respuesta_cesta"></div>
                </div>
            </div>
        </div>    


        <!-- Navigation -->
        <nav class="navbar navbar-info navbar-fixed-top" role="navigation">
            <div class="container" >
            
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Inicio</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="tpl_personal.php">Personal</a>
                        </li>

                        <li>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Retenciones</a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="tpl_retencion_islr.php" title="2"><i class="fa fa-check fa-fw"></i> ISLR Sueldos y Salarios</a></li>
                                <li><a href="tpl_retencion_iva.php"  title="2"><i class="fa fa-check fa-fw"></i> IVA</a></li>
                            </ul>
                        </li>

                       <!-- <li>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Inventario</a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="tpl_inventario.php?get=MATANZA"><i class="fa fa-folder fa-fw"></i> Matanza</a></li>
                                <li><a href="tpl_inventario.php?get=MONDONGO" title="2"><i class="fa fa-folder fa-fw"></i> Mondongo</a></li>
                                <li><a href="tpl_inventario.php?get=CHINCHURRIA" title="2"><i class="fa fa-folder fa-fw"></i> Chinchurria</a></li>
                                <li><a href="tpl_inventario.php?get=CUEROS" title="2"><i class="fa fa-folder fa-fw"></i> Cueros</a></li>
                                <li><a href="tpl_inventario.php?get=CARNE-CUERO" title="2"><i class="fa fa-folder fa-fw"></i> Carne Cuero</a></li>
                                
                            </ul>
                        </li>-->

                        <li>
                            <a href="tpl_reportes.php">Reportes</a>
                        </li>

                        <li class="dropdown" >
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <?= "Usuario: ". strtoupper(@$_SESSION["username"]);?>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="tpl_perfil.php?id_usuario=<?= $this->encrypt($_SESSION['id_usuario'],'123');?>&control=<?= $this->encrypt('1','123');?>" ><i class="fa fa-user fa-fw"></i> Perfil</a></li>
                                <li><a href="tpl_usuarios.php" ><i class="fa fa-user fa-fw"></i> Usuarios</a></li>
                                <li><a href="tpl_periodo.php"  ><i class="fa fa-gear fa-fw"></i> Período</a></li>
                                <li><a href="#" onclick="modal('agregar_cestaticket')" ><i class="fa fa-gear fa-fw"></i> CestaTicket Bs</a></li>
                               
                                <li><a href="#" onclick="cerrar()" title="Cerrar Sesion"><i class="fa fa-sign-out fa-fw"></i>Cerrar</a></li>
                                <input type="hidden" id="monto_bs_cesta" value="<?= @$_SESSION["monto_bs"]?>">
                            </ul>
                            <!-- /.dropdown-user -->

                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

    
        <?php
        }
         if(@$_SESSION["rol_usuario"] == 2)
        {
        ?>

        <!-- Navigation -->
        <nav class="navbar navbar-info navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Inicio</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="tpl_personal.php">Personal</a>
                        </li>

                        <li>
                            <a href="tpl_reportes.php">Reportes</a>
                        </li>

                        <li class="dropdown" >
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <?= "User: ". strtoupper(@$_SESSION["username"]);?>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="tpl_perfil.php?id_usuario=<?= $this->encrypt($_SESSION['id_usuario'],'123');?>&control=<?= $this->encrypt('1','123');?>" title="1"><i class="fa fa-user fa-fw"></i> Perfil</a></li>
                                <li class="divider"></li>
                                <li><a href="#" onclick="cerrar()" title="Cerrar Sesion"><i class="fa fa-sign-out fa-fw"></i>Cerrar</a></li>
                            </ul>
                            <!-- /.dropdown-user -->
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

    
        <?php
        }
    }
    public function footer()
    {
        ?>
            <!-- Footer -->
            <footer>
                <div class="row ventana" id="per">
                    <div align="center" class="col-lg-12">
                        <p>Inversiones Frimecar, C.A J-29807443-4. Copyright &copy;  2015</p>
                    </div>
                </div>
            </footer>
        <?php
    }

    public function formulario_periodo()
    {
        ?>
        <!-- Formulario para CONSULTA AR-C -->
        <div id="per" class="ventana" title="Ingresar Nuevo Período">
            <div class="row">
                <div class="col-md-12" align="center" >
                    <h4> NUEVO PERÍODO </h4>
                </div>
            </div>

            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_grado" class="form-horizontal" role="form">
                          <div class="form-group">
                            <label class="col-md-5 control-label">Año: </label>
                            <div class="col-md-2" align="center" style="margin-top: 8px">
                              <input type="text" class="form-control"  required maxlength="4" autocomplete="off"  id="ano_periodo" >
                            </div>
                          </div>
                         
                          <div class="form-group">
                            <div class="col-md-12" align="center">
                              <a type="submit" onclick="guardar_periodo()" class="btn btn-md btn-primary">Guardar</a>
                            </div>
                          </div>
                        </form>
                        <div class="col-md-3"></div>
                        <div id="respuesta_periodo" class="col-md-6"></div>
                        <div class="col-md-3"></div>
                </div>
            </div>
        </div>
        <?php
    }
}
