<?php
    session_start();
    require('helpers.php');
    require('conectar.php');


    $buscador = '';

    if(!empty($_GET['id']))
    {
       $var = $_GET['id'];
       $campo = $_GET['campo'];

       $buscador = "and $campo like '%$var%'";
    }

    $_pagi_sql = "select * from tbl_periodo ".$buscador." order by id_periodo asc ";
    
    $_pagi_cuantos = 5; 

    include("paginator.inc.php"); 

?>
<!DOCTYPE html>
<html lang="en">

<body>

    <?php $helpers->menu();?>
    
    <!-- Page Content -->
    <div class="container">
      <header class="jumbotron hero-spacer">
        <div class="row">
            <div class="col-lg-12" >
                <h3> Listado de Períodos </h3>
            </div>
        </div>

        <br>

      
        
        <table class="table table-hover">
           
            <tr>
              <th>#</th>
              <th>Año</th>
              <th>Fecha Registro</th>
              <th>Fecha Vencimiento</th>
              <th>
                  <div style="margin-top: -5px" class="btn-group">
                      <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="modal('agregar')">Agregar</a>
                  </div>
              </th>
            </tr>
        <?php
            if(@mysqli_num_rows($_pagi_result) == 0)
            {
          ?>
                    <tr>
                      <div class="alert alert-danger" align="center" role="alert">No existen registros</div>
                    </tr>
          <?php
              }
              else
          {
            while($fila = mysqli_fetch_array($_pagi_result))
            {
        ?>
            <tr>
              <td><?= $fila['id_periodo'];?></td>
              <td><?= $fila['ano_periodo'];?></td>
              <td><?= $fila['fecha_registro'];?></td>
              <td><?= $fila['fecha_vencimiento'];?></td>
              <td>
                  <div class="btn-group" style="margin-top: -5px" >
                    <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
                      Opciones <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      
                      <li><a href="#" id="<?= $fila['id_periodo'];?>" onclick="eliminar_periodo(id)">Inhabilitar </a></li>
                    </ul>
                  </div>
              </td>
            </tr>
        <?php
            } //fin while consulta
          }//fin else
        ?>
          </table>

           <div class="row">
              <div class="col-md-3"></div>
              <div class="col-md-4" align="center">   <ul class='pagination pagination-sm'><?= $_pagi_navegacion; ?></ul></div> 
              <div class="col-md-4"></div>
            </div>
          </header>
      
        
        <!-- DIV QUE MUESTRA FORMULARIO PARA AGREGAR NUEVO USUARIO -->
        <div id="agregar" class="ventana">
          <h3 align="center"> Registro de Período</h3>
            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_agregar_usuario" class="form-horizontal" role="form">
                          <div class="form-group">
                            <label class="col-md-3 control-label">Año Período</label>
                            <div class="col-md-7">
                               <input type="text" class="form-control" required  maxlength="4"  id="ano" placeholder="Ano Periodo">
                            </div>
                          </div>

                          <div class="form-group">
                            <label  class="col-md-3 control-label">Fecha Inicio</label>
                            <div class="col-md-3">
                              <input type="text" class="form-control" required  id="fecha_inicio" placeholder="Fecha Inicio">
                            </div>

                            <label class="col-md-2 control-label">Fecha Fin</label>
                            <div class="col-md-3">
                              <input type="text" class="form-control" required  id="fecha_fin" placeholder="Fecha Fin">
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="col-md-12" align="center">
                              <div id="enviar_periodo"><a  onclick="agregar_periodo()" class="btn  btn-default">Enviar</a></div>
                            </div>
                          </div>
                        </form>
                        <div id="respuesta_peri"></div>
                </div>
            </div>
        </div>    

        
        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div align="center" class="col-lg-12">
                    <p>Copyright &copy;  2014</p>
                </div>
            </div>
        </footer>

    </div>

    
</body>

<script type="text/javascript">
  
   
    $( "#fecha_inicio" ).datepicker({dateFormat: 'yy/mm/dd', changeMonth: true, changeYear: true});

    $( "#fecha_fin" ).datepicker({dateFormat: 'yy/mm/dd', changeMonth: true, changeYear: true});


    


</script>

</html>
