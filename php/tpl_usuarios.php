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

    $_pagi_sql = "select * from tbl_usuario ".$buscador." order by id_usuario asc ";
    
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
                <h3> Listado de Usuarios </h3>
            </div>
        </div>

        <div class="input-group" align="center">
                <input class="form-control" type="text"  id="buscador" placeholder="Ingrese Datos para Consultar">
                <span class="input-group-addon" ><span class="mdi-notification-sync" ></span></span>
                <select  class="form-control" id="var_busqueda" onchange="consulta('tpl_usuarios')" >
                        <option value="">--Seleccione--</option>
                        <option value="cedula">Cédula</option>
                        <option value="nombre">Nombre</option>
                        <option value="apellido">Apellido</option>
                </select>
        </div>
        <br>

      
        
        <table class="table table-hover">
           
            <tr>
              <th>#</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Usuario</th>
              <th>Contraseña</th>
              <th>Rol</th>
              <th>
                  <div style="margin-top: -5px" class="btn-group">
                      <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="modal('agregar')">Agregar</a>
                      <a href="javascript:void(0)" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
                      <ul class="dropdown-menu">
                          <li><a href="reporte/rpt_usuarios.php?sql=<?= $_pagi_sql?>" title="Descargar Excel"><div align="center"><span class="mdi-file-cloud-download"></span></div></a></li>
                      </ul>
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
              <td><?= $fila['id_usuario'];?></td>
              <td><?= $fila['nombre_usuario'];?></td>
              <td><?= $fila['apellido_usuario'];?></td>
              <td><?= $fila['login_usuario'];?></td>
              <td><?= $fila['pass_usuario'];?></td>
              <td><?php 
                        if($fila['rol_usuario'] == 1)
                        { 
                            echo "Administrador"; 
                        }
                        if($fila['rol_usuario'] == 2)
                        {
                            echo "Operador";
                        }
                  ?>
              </td>
              <td>
                  <div class="btn-group" style="margin-top: -5px" >
                    <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
                      Opciones <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#" onclick="modal_editar_usu('editar_usu',
                                                            '<?= $fila['id_usuario'];?>',
                                                            '<?= $fila['nombre_usuario'];?>',
                                                            '<?= $fila['apellido_usuario'];?>',
                                                            '<?= $fila['login_usuario'];?>',
                                                            '<?= $fila['pass_usuario'];?>',
                                                            '<?= $fila['rol_usuario'];?>',
                                                            '<?= $fila['correo_usuario'];?>',
                                                            '<?= $fila['tipo_nac_usuario'];?>',
                                                            '<?= $fila['cedula_usuario'];?>')">Editar</a></li>
                      
                      <li><a href="#" id="<?= $fila['id_usuario'];?>" onclick="inhabilitar_user(id)">Inhabilitar </a></li>
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
          <h3 align="center"> Registro de Usuario</h3>
            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_agregar_usuario" class="form-horizontal" role="form">
                          <div class="form-group">
                            <label class="col-md-3 control-label">Cédula</label>
                            <div class="col-md-1">
                              <select class="form-control" required id="tipo_nac" >
                                  <option value="">--</option>
                                  <option value="V" >V</option>
                                  <option value="E" >E</option>
                              </select>
                            </div>
                            <div class="col-md-7">
                               <input type="text" class="form-control" required onkeypress="ValidaSoloNumeros()" maxlength="8"  id="cedula" placeholder="Cedula">
                            </div>
                          </div>

                          <div class="form-group">
                            <label  class="col-md-3 control-label">Nombre</label>
                            <div class="col-md-3">
                              <input type="text" class="form-control" required onkeydown="return validarLetras(event)"  id="nombre" placeholder="Nombre">
                            </div>

                            <label class="col-md-2 control-label">Apellido</label>
                            <div class="col-md-3">
                              <input type="text" class="form-control" required onkeydown="return validarLetras(event)"   id="apellido" placeholder="Apellido">
                            </div>
                          </div>

                         
                          <div class="form-group">
                            <label  class="col-md-3 control-label">Correo</label>
                            <div class="col-md-3">
                              <input type="email" class="form-control" required  onchange="validaCorreo('correo')"  id="correo" placeholder="Correo">
                            </div>

                            <label for="inputrol" class="col-md-2 control-label">Rol</label>
                            <div class="col-md-3">
                                <select class="form-control" required id="rol">
                                  <option value="">Seleccione</option>
                                  <option value="1" >Administrador</option>
                                  <option value="2" >Operador</option>
                                </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="inputPassword" class="col-md-3 control-label">Usuario</label>
                            <div class="col-md-3">
                              <input type="text" class="form-control" required  id="username" placeholder="Username">
                            </div>

                            <label for="inputPassword" class="col-md-2 control-label">Contraseña</label>
                            <div class="col-md-3">
                              <input type="password" class="form-control" required  id="pass" placeholder="Password">
                            </div>
                            
                          </div>

                          <div class="form-group">
                            <div class="col-md-12" align="center">
                              <div id="enviar_usuario"><a  onclick="agregar_usuario()" class="btn  btn-default">Enviar</a></div>
                            </div>
                          </div>
                        </form>
                        <div id="respuesta"></div>
                </div>
            </div>
        </div>    

        <!-- DIV QUE MUESTRA FORMULARIO PARA EDITAR USUARIO -->
        <div id="editar_usu" class="ventana">
          <h3 align="center"> Editar Usuario</h3>
            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_agregar_usuario" class="form-horizontal" role="form">
                          <div class="form-group">
                            <label class="col-md-3 control-label">Cédula</label>
                            <div class="col-md-1">
                              <select class="form-control" required id="tipo_nac_usuario" >
                                  <option value="">--</option>
                                  <option value="V" >V</option>
                                  <option value="E" >E</option>
                              </select>
                            </div>
                            <div class="col-md-7">
                               <input type="text" class="form-control" required onkeypress="ValidaSoloNumeros()" maxlength="9"  id="cedula_usuario" placeholder="Cedula">
                               <input type="hidden" class="form-control" required onkeypress="ValidaSoloNumeros()" maxlength="9"  id="id_usuario" >
                            </div>
                          </div>

                          <div class="form-group">
                            <label  class="col-md-3 control-label">Nombre</label>
                            <div class="col-md-3">
                              <input type="text" class="form-control" required onkeydown="return validarLetras(event)"  id="nombre_usuario" placeholder="Nombre">
                            </div>

                            <label class="col-md-2 control-label">Apellido</label>
                            <div class="col-md-3">
                              <input type="text" class="form-control" required onkeydown="return validarLetras(event)"   id="apellido_usuario" placeholder="Apellido">
                            </div>
                          </div>

                         
                          <div class="form-group">
                            <label  class="col-md-3 control-label">Correo</label>
                            <div class="col-md-3">
                              <input type="email" class="form-control" required  onchange="validaCorreo('correo')"  id="correo_usuario" placeholder="Correo">
                            </div>

                            <label for="inputrol" class="col-md-2 control-label">Rol</label>
                            <div class="col-md-3">
                                <select class="form-control" required id="rol_usuario">
                                  <option value="">Seleccione</option>
                                  <option value="1" >Administrador</option>
                                  <option value="2" >Operador</option>
                                </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="inputPassword" class="col-md-3 control-label">Usuario</label>
                            <div class="col-md-3">
                              <input type="text" class="form-control" required  id="login_usuario" placeholder="Username">
                            </div>

                            <label for="inputPassword" class="col-md-2 control-label">Contraseña</label>
                            <div class="col-md-3">
                              <input type="password" class="form-control" required  id="pass_usuario" placeholder="Password">
                            </div>
                            
                          </div>

                          <div class="form-group">
                            <div class="col-md-12" align="center">
                              <div id="editar_usuario"><a href="#" onclick="editar_usuario()" class="btn btn-default">Enviar</a></div>
                            </div>
                          </div>
                        </form>
                        <div id="respuesta_"></div>
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

</html>
