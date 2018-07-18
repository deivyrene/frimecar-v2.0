<?php
    session_start();
    require('helpers.php');
    require('conectar.php');
/*create table tbl_prestaciones
(
    id_prestaciones int primary key auto_increment,
    fecha_inicio_mes date, 
    fecha_fin_mes date,
    sueldo_mensual_pres decimal(11.4),*/
    
    $buscador = 'where estatus_personal = 1 and retencion_personal = 11 or retencion_personal = 0';

    if(!empty($_GET['id']))
    {
       $var = $_GET['id'];
       $campo = $_GET['campo'];

       $buscador = "where $campo like '%$var%' and estatus_personal = 1";
    }

    $_pagi_sql  = "select * from tbl_personal ".$buscador." order by id_personal desc";
    
    $_pagi_cuantos = 6; 

    $_pagi_conteo_alternativo = true;

    include("paginator.inc.php"); 


?>
<!DOCTYPE html>
<html lang="en">

<body>

    <?php $helpers->menu();?>
    
    <!-- Page Content -->
    <div class="container">
      <div id="principal">
      <header class="jumbotron hero-spacer">

        <div class="row">
            <div class="col-lg-12" >
                <h3> Listado de Personal </h3>
            </div>
        </div>
           <div class="input-group" align="center">
                <input class="form-control" type="text"  id="buscador" placeholder="Ingrese Datos para Consultar">
                <span class="input-group-addon" ><span class="mdi-notification-sync" ></span></span>
                <select  class="form-control" id="var_busqueda" onchange="consulta('tpl_personal')" >
                        <option value="">--Seleccione--</option>
                        <option value="cedula_personal">Cédula</option>
                        <option value="apellido_personal">Apellido</option>
                        <option value="nombre_personal">Nombre</option>
                        <option value="cargo_personal">Cargo</option>
                </select>
            </div>
        <br>
        

        <?php
            if(@mysqli_num_rows($_pagi_result) == 0)
            {
        ?>
                <tr>
                  <th><div class="alert alert-warning" align="center" role="alert">No existen registros.! <br> Para Registrar Clic <a href="javascript:void(0)" onclick="modal('agregar')" title="Registrar Personal">Aquí</a></div></th>
                </tr>
        <?php
            }
            else
            {
        ?>
          <table class="table table-hover">
         
                <tr >
                  <th>#</th>
                  <th>C.I</th>
                  <th>R.I.F</th>
                  <th>Apellido y Nombre</th>
                  <th>Cargo</th>
                  <th>Tipo</th>
                  <th>Sueldo Bs</th>
                  <th>Fecha Ingreso</th>
                  <th>
                      <div style="margin-top: -5px" class="btn-group">
                          <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="modal('agregar')">Agregar</a>
                      </div>
                  </th>
                </tr>
        <?php
                while($fila = mysqli_fetch_array($_pagi_result))
                {
                
                  @$id_quin = $fila['id_personal'];

                  $sql_ultima_quin = "SELECT 
                                              nombre_personal, 
                                              dias_trabajados, 
                                              periodo_mes_quincena 
                                        FROM 
                                              tbl_personal, 
                                              tbl_quincena 
                                        where 
                                              id_personal = fk_personal_quincena 
                                          and 
                                              id_personal = $id_quin 
                                     order by 
                                              id_quincena desc limit 1";

                  $re_ultima_quin = mysqli_query($link, $sql_ultima_quin);

                  $num_ultima = mysqli_num_rows($re_ultima_quin);

                  if($num_ultima > 0)
                  {

                    while($row_ultima = mysqli_fetch_array($re_ultima_quin))
                    {
                       @$dias_trabajados_ultima = $row_ultima['dias_trabajados'];
                    }

                  }
                  else
                  {
                      @$dias_trabajados_ultima = 0;
                  }

                  $sueldo_diario = number_format($fila['sueldo_basico_personal']/30, 2, '.', '');
                  $dias_vacaciones = $helpers->CalculaEdad($fila['fecha_ingreso_personal']) + 15;
                  $vacaciones = number_format($sueldo_diario*$dias_vacaciones, 2, '.', '');
                  if(date('m') != 12)
                  {
                    $fin_ano = "0.0";
                  }
                  else
                  {
                    $fin_ano = number_format($sueldo_diario*30, 2, '.', '');
                  }
        ?>
                <tr>
                  <td><?= $fila['id_personal'];?></td>
                  <td><a onclick="modal_mostrar('mostrar',
                                                '<?= $fila['cedula_personal'];?>',
                                                '<?= $fila['rif_personal'];?>',
                                                '<?= $fila['apellido_personal'];?>',
                                                '<?= $fila['nombre_personal'];?>',
                                                '<?= $fila['direccion_personal'];?>',
                                                '<?= $fila['telefono_personal'];?>',
                                                '<?= $fila['cargo_personal'];?>',
                                                '<?= $fila['tipo_personal'];?>',
                                                '<?= $fila['sueldo_basico_personal'];?>',
                                                '<?= $fila['fecha_ingreso_personal'];?>')"><?= $fila['cedula_personal'];?></a></td>
                  <td><?= $fila['rif_personal'];?></td>
                  <td><?= $fila['apellido_personal']." ".$fila['nombre_personal'];?></td>
                  <td><?= $fila['cargo_personal'];?></td>
                  <td><?= $fila['tipo_personal'];?></td>
                  <td><?= $fila['sueldo_basico_personal'];?></td>
                  <td><?= $fila['fecha_ingreso_personal'];?></td>
                  <td>
                      <div class="btn-group" style="margin-top: -5px" >
                        <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
                          Opciones <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <?php 
                              if($fila['estatus_personal'] == 0) 
                              { 
                              ?>
                                  <!--<li><a href="#" id="<?= $fila['id_personal'];?>" onclick="habilitar_personal(id)">Habilitar </a></li>-->
                              <?php 
                              }
                              else
                              {
                            ?>
                                <li><a href="#" onclick="modal_editar('editar',
                                                                        '<?= $fila['id_personal'];?>',
                                                                        '<?= $fila['cedula_personal'];?>',
                                                                        '<?= $fila['rif_personal'];?>',
                                                                        '<?= $fila['apellido_personal'];?>',
                                                                        '<?= $fila['nombre_personal'];?>',
                                                                        '<?= $fila['cargo_personal'];?>',
                                                                        '<?= $fila['tipo_personal'];?>',
                                                                        '<?= $fila['direccion_personal'];?>',
                                                                        '<?= $fila['telefono_personal'];?>',
                                                                        '<?= $fila['sueldo_basico_personal'];?>',
                                                                        '<?= $fila['fecha_ingreso_personal'];?>')" >Editar</a></li>
                                
                                <li><a href="#" onclick="modal_inhabilitar('inhabilitar_',
                                                                           '<?= $fila['id_personal'];?>')">Egresar </a></li>

                                <?php 

                                  $unidad = $helpers->declara_retencion($fila['sueldo_basico_personal'],$fila['fecha_ingreso_personal']);
                                    
                                    @$im_ret = "";

                                    if($unidad > 1000)
                                    {
                                      $sql_ret = "select * from tbl_retencion_personal where fk_personal = ".$fila['id_personal']." order by id_retencion_personal desc limit 1";
                                  
                                      $re_ret = mysqli_query($link, $sql_ret);

                                      $row = mysqli_fetch_array($re_ret);

                                      $im_ret = $row['impuesto_retenido'];
                                    }
                                ?>
                                  <li><a href="#" id="<?= $fila['id_personal'];?>" onclick="modal_quincena('quincena_',
                                                                                                           '<?= $fila['id_personal'];?>',
                                                                                                           '<?= $sueldo_diario;?>',
                                                                                                           '<?= $fila['apellido_personal'];?>',
                                                                                                           '<?= $fila['nombre_personal'];?>',
                                                                                                           '<?= $im_ret;?>',
                                                                                                           '<?= $fila['tipo_personal'];?>',
                                                                                                           '<?= $dias_trabajados_ultima;?>')">Cargar Quincenas</a></li>

                                  <li><a href="#" id="<?= $fila['id_personal'];?>" onclick="modal_quincena('ed_quincena_',
                                                                                                           '<?= $fila['id_personal'];?>',
                                                                                                           '<?= $sueldo_diario;?>',
                                                                                                           '<?= $fila['apellido_personal'];?>',
                                                                                                           '<?= $fila['nombre_personal'];?>',
                                                                                                           '<?= $im_ret;?>',
                                                                                                           '<?= $fila['tipo_personal'];?>',
                                                                                                           '<?= $dias_trabajados_ultima;?>')">Editar Quincenas</a></li>
                                <!--  <li><a href="#" id="<?= $fila['id_personal'];?>" onclick="modal_otras_asig('otras_asig',
                                                                                                             '<?= $fila['id_personal']; ?>',
                                                                                                             '<?= $sueldo_diario; ?>',
                                                                                                             '<?= $fila['apellido_personal']; ?>',
                                                                                                             '<?= $fila['nombre_personal']; ?>',
                                                                                                             '<?= $vacaciones; ?>',
                                                                                                             '<?= $dias_vacaciones; ?>',
                                                                                                             '<?= $fin_ano; ?>')">Otras Asignaciones</a></li>-->
                               
                                <li><a href="#" id="<?= $fila['id_personal'];?>" onclick="modal_pago('recibo_',id)">Recibo de Pago </a></li>

                                <li><a href="tpl_prestaciones.php?id=<?= $fila['id_personal'];?>"  target='_blank'>Prestaciones </a></li>
                            <?php
                              }
                            ?>
                        </ul>
                      </div>
                  </td>
                </tr>
        <?php
                }
                    
            }
                
    
                
        ?>
          </table>
            
            <div class="row">
              <div class="col-md-3"></div>
              <div class="col-md-4" align="center">   <ul class='pagination pagination-sm'><?= $_pagi_navegacion; ?></ul></div> 
              <div class="col-md-4"></div>
            </div>
          </header>
          </div>
       
        
        <!-- DIV QUE MUESTRA FORMULARIO PARA AGREGAR NUEVA PERSONA-->
        <div id="agregar" class="ventana" title="Registro de Personal">
            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_personal" class="form-horizontal" role="form">
                          <div class="form-group">
                            <label class="col-md-2 control-label">Cédula</label>
                            <div class="col-md-3">
                               <input type="text" class="form-control" autocomplete="off"  required placeholder="V22111333"  maxlength="10" id="cedula" >
                               <input type="hidden" class="form-control" autocomplete="off"  required  maxlength="10" value="retencion" id="retencion_1" >
                            </div>

                            <label  class="col-md-3 control-label">R.I.F</label>
                            <div class="col-md-3">
                              <input type="text" class="form-control" autocomplete="off"  required maxlength="10"  id="rif" placeholder="V221113334" >
                            </div>
                          </div>

                          <div class="form-group">
                          <label  class="col-md-2 control-label">Apellido</label>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off"  required maxlength="100"  id="apellido" >
                            </div>
                          <label  class="col-md-3 control-label">Nombre</label>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off"   required maxlength="100"  id="nombre" >
                            </div>
                          </div>

                          <div class="form-group">
                          <label  class="col-md-2 control-label">Dirección</label>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off"  required maxlength="100"  id="direccion" >
                            </div>
                          <label  class="col-md-3 control-label">Teléfono</label>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off"  required maxlength="100"  id="telefono" >
                            </div>
                          </div>

                          <div class="form-group">
                          <label  class="col-md-2 control-label">Cargo</label>
                            <div class="col-md-3" align="center">
                              <select class="form-control" id="cargo" >
                                <option value="">--Seleccione--</option>
                                <option value="GERENTE PRINCIPAL">Gerente Principal</option>
                                <option value="ASISTENTE ADMON">Asistente Admon</option>
                                <option value="ANALISTA INFORMATICA">Analista Informática</option>
                                <option value="SUP. SALA MATANZA">Supervisor Sala</option>
                                <option value="MANTENIMIENTO">Mantenimiento</option>
                                <option value="DEPOSTA CABEZA">Deposta Cabeza</option>
                                <option value="DESOLLADOR">Desollador</option>
                                <option value="CORRALERO">Corralero</option>
                                <option value="QUITA CABEZA">Quita Cabeza</option>
                                <option value="PICADOR DE RES">Picador de Res</option>
                                <option value="MONDONGUERO">Mondonguero</option>
                                <option value="CUERERO">Cuerero</option>
                                <option value="VIGILANTE">Vigilante</option>
                                <option value="CALETERO">Caletero</option>
                              </select>
                            </div>

                          <label  class="col-md-3 control-label">Tipo</label>
                            <div class="col-md-3" align="center">
                              <select class="form-control" id="tipo"  >
                                <option value="">--Seleccione--</option>
                                <option value="ADMINISTRATIVO">Administrativo</option>
                                <option value="OBRERO">Obrero</option>
                                <option value="CONTRATADO">Contratado</option>
                              </select>
                            </div>
                          </div>

                          <div class="form-group">
                          <label  class="col-md-2 control-label">Sueldo Básico</label>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control"  required maxlength="100"   id="sueldo" >
                            </div>
                          <label  class="col-md-3 control-label">Fecha Ingreso</label>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control"  required maxlength="100"   id="fecha" >
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="col-sm-12" align="center">
                              <div id="enviar_personal"><a href="#" onclick="agregar_personal()" class="btn btn-default">Enviar</a></div>
                            </div>
                          </div>

                        </form>
                      <div id="respuesta_persona"></div>
                </div>
            </div>
        </div>    

        <!-- DIV QUE MUESTRA FORMULARIO PARA EDITAR PERSONAL-->
        <div id="editar" class="ventana" title="Editar Personal">
            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_editar_personal" class="form-horizontal" role="form">
                          <div class="form-group">
                            <label class="col-md-2 control-label">Cédula</label>
                            <div class="col-md-3">
                               <input type="hidden" value="<?= @$_GET['_pagi_pg'];?>" id="pagina">
                               <input type="text" class="form-control" required disabled="disabled"  maxlength="10" id="ed_cedula" >
                               <input type="hidden" class="form-control" required disabled="disabled"  maxlength="10" id="ed_id" >
                            </div>

                            <label  class="col-md-3 control-label">R.I.F</label>
                            <div class="col-md-3">
                              <input type="text" class="form-control"  required disabled="disabled" maxlength="10"  id="ed_rif" >
                            </div>
                          </div>

                          <div class="form-group">
                          <label  class="col-md-2 control-label">Apellido</label>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control"  required maxlength="100"  id="ed_apellido" >
                            </div>
                          <label  class="col-md-3 control-label">Nombre</label>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control"  required maxlength="100"  id="ed_nombre" >
                            </div>
                          </div>

                          <div class="form-group">
                          <label  class="col-md-2 control-label">Dirección</label>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off"  required maxlength="100"  id="ed_direccion" >
                            </div>
                          <label  class="col-md-3 control-label">Teléfono</label>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off"  required maxlength="100"  id="ed_telefono" >
                            </div>
                          </div>

                          <div class="form-group">
                          <label  class="col-md-2 control-label">Cargo</label>
                            <div class="col-md-3" align="center">
                              <select class="form-control" id="ed_cargo"  >
                                <option value="">--Seleccione--</option>
                                <option value="GERENTE PRINCIPAL">Gerente Principal</option>
                                <option value="ASISTENTE ADMON">Asistente Admon</option>
                                <option value="ANALISTA INFORMATICA">Analista Informática</option>
                                <option value="SUP. SALA MATANZA">Supervisor Sala</option>
                                <option value="MANTENIMIENTO">Mantenimiento</option>
                                <option value="DEPOSTA CABEZA">Deposta Cabeza</option>
                                <option value="DESOLLADOR">Desollador</option>
                                <option value="CORRALERO">Corralero</option>
                                <option value="QUITA CABEZA">Quita Cabeza</option>
                                <option value="PICADOR DE RES">Picador de Res</option>
                                <option value="MONDONGUERO">Mondonguero</option>
                                <option value="CUERERO">Cuerero</option>
                                <option value="VIGILANTE">Vigilante</option>
                                <option value="CALETERO">Caletero</option>
                              </select>
                            </div>

                          <label  class="col-md-3 control-label">Tipo</label>
                            <div class="col-md-3" align="center">
                              <select class="form-control" id="ed_tipo"  >
                                <option value="">--Seleccione--</option>
                                <option value="ADMINISTRATIVO">Administrativo</option>
                                <option value="OBRERO">Obrero</option>
                                <option value="CONTRATADO">Contratado</option>
                              </select>
                            </div>
                          </div>

                          <div class="form-group">
                          <label  class="col-md-2 control-label">Sueldo Básico</label>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control"  required maxlength="100"   id="ed_sueldo" >
                            </div>
                          <label  class="col-md-3 control-label">Fecha Ingreso</label>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control"  required maxlength="100"   id="ed_fecha" >
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="col-sm-12" align="center">
                              <div id="editar_personal_"><a href="#" onclick="editar_per()" class="btn btn-default">Enviar</a></div>
                            </div>
                          </div>

                        </form>
                      <div id="respuesta_editar_persona"></div>
                </div>
            </div>
        </div> 

        <!-- DIV QUE MUESTRA FORMULARIO PARA AGREGAR NUEVA QUINCENA-->
        <div id="quincena_" class="ventana" title="Registro de Quincena">
            <header class="jumbotron hero-spacer">
              <div class="row" style="margin-bottom: 20px">
                <div class="col-md-12" >
                        <form id="form_quincena" class="form-horizontal" role="form">
                          <h4 align="center" id="titulo">Asignaciones</h4>
                          <div class="form-group">

                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" id="fecha_inicio" placeholder="Fecha Inicio" title="Ingrese Fecha Inicio Quincena" required maxlength="100" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" id="fecha_fin" placeholder="Fecha Fin" title="Ingrese Fecha Fin Quincena" maxlength="100" >
                            </div>

                            <div class="col-md-3" align="center">
                              <input type="hidden" class="form-control" required disabled="disabled"  maxlength="10" id="q_id" >
                              <input type="hidden" class="form-control" required disabled="disabled"  maxlength="10" id="q_sueldo" >
                              <input type="hidden" class="form-control" required disabled="disabled"  maxlength="10" id="q_tipo" >
                              <select class="form-control" id="quincena" onchange="verifica_quincena()" >
                                <option value="">--QUINCENA--</option>
                              <?php 

                                  $re = mysqli_query($link, "select * from tbl_mes");

                                  while($fil = mysqli_fetch_array($re))
                                  {
                                    //@$mes = $fil['mes'];
                                    //if($mes >= date('m'))
                                    //{
                              ?>
                                    <option value="<?= $fil['descripcion_mes'];?>"><?= $fil['descripcion_mes'];?></option>
                              <?php
                                   // }
                                  }
                              ?>
                              </select>
                            </div>

                            <div class="col-md-3" align="center">
                              <select class="form-control" id="tipo_pago_asig" >
                                <option value="">--PAGO--</option>
                                <option value="1">EFECTIVO</option>
                                <option value="2">DEPOSITO</option>
                                <option value="3">CHEQUE</option>
                                <option value="4">CTA. NOMINA</option>
                              </select>
                            </div>
                          </div>

                          <div class="form-group">
                            
                           
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off" placeholder="Dias Trabajados" title="Ingrese Días Trabajados" required maxlength="100" disabled="disabled"  id="dias_traba" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off"  placeholder="Dias Feriados" title="Ingrese Días Trabajados" maxlength="100" disabled="disabled"  id="dias_feriados" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off" placeholder="Dias Cesta Ticket" title="Ingrese Días Trabajados Cesta Ticket" disabled="disabled" maxlength="100"   id="dias_cesta" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off" placeholder="Bonificación (Bs.)" title="Ingrese Monto en Bs. 1000.45" maxlength="100" disabled="disabled"  id="bonificacion" >
                            </div>
                          </div>

                          <div class="form-group">
                            
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off" placeholder="H/Extras Diurnas" title="Cantidad Horas Extras Diurnas"  maxlength="100" disabled="disabled"   id="h_extras_diur" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off" placeholder="H/Extras Noct" title="Cantidad Horas Extras Nocturnas" maxlength="100" disabled="disabled"  id="h_extras_noct" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off" placeholder="Cesta Ticket Bs." title="Cantidad a Recibir Cesta Ticket" maxlength="100" disabled="disabled"   id="cesta_bs" >
                            </div>
                             <div class="col-md-3" align="center">
                                <input type="text" class="form-control" autocomplete="off" placeholder="Bono Escolar (Bs)" title="Bono Escolar (Bs)"  maxlength="100" disabled="disabled"  id="otros" >
                              </div>
                          </div>

                          <div style="display: none;" id="mas">
                            <div class="form-group" >
                              

                              <div class="col-md-1" align="center">
                                <input type="text" class="form-control" autocomplete="off" placeholder="Dias Utilidades" onkeyup="calcular_vacas('total_utilidades','utilidades','q_sueldo')" title="Dias de Utilidades"  maxlength="100"   id="utilidades" >
                              </div>

                              <div class="col-md-2" align="center">
                                <input type="text" class="form-control" autocomplete="off" placeholder="Total Utilidades" title="Total utilidades" maxlength="100" disabled="disabled"   id="total_utilidades"  >
                              </div>

                              <div class="col-md-1" align="center">
                                <input type="text" class="form-control" autocomplete="off" placeholder="Dias Vacaciones" onkeyup="calcular_vacas('total_vacaciones','vacaciones','q_sueldo')" title="Dias de Vacaciones"  maxlength="100"   id="vacaciones" >
                              </div>

                              <div class="col-md-2" align="center">
                                <input type="text" class="form-control" autocomplete="off" placeholder="Total Vacaciones" title="Total Vacaciones" maxlength="100" disabled="disabled"   id="total_vacaciones"  >
                              </div>

                              <div class="col-md-1" align="center">
                                <input type="text" class="form-control" autocomplete="off" placeholder="Dias Bono Vacacional" onkeyup="calcular_vacas('total_bono_vacacional','bono_vacacional','q_sueldo')" title="Dias Bono Vacacional" maxlength="100"   id="bono_vacacional"  >
                              </div>

                              <div class="col-md-2" align="center">
                                <input type="text" class="form-control" autocomplete="off" placeholder="Total Bono Vacacional" title="Total Bono Vacacional" maxlength="100" disabled="disabled"  id="total_bono_vacacional"  >
                              </div>

                              <div class="col-md-1" align="center">
                                <input type="text" class="form-control" autocomplete="off" placeholder="Interés Antigüedad"  title="Ingrese monto de Interés Antigüedad" maxlength="100"   id="interes_anti"  >
                              </div>

                              <div class="col-md-1" align="center">
                                <input type="text" class="form-control" autocomplete="off" placeholder="Adelanto Antigüedad" title="Ingrese monto de Adelanto Antigüedad" maxlength="100"  id="adelanto_anti"  >
                              </div>

                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-md-3 control-label"></label>

                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off" placeholder="Asig. Quinc." title="Asignación Quincenal" maxlength="100"   id="asig_quinc" disabled="disabled"  >
                            </div>
                            <div class="col-md-3" align="center" style="margin-top: 0px">
                                  <a href="#" onclick="cortina('mas')" id="boton_" title="Mostrar y Ocultar más Opciones"> <b>+</b> </a>
                            </div>
  
                          </div>

                          <hr>

                          <h4 align="center">Deducciones</h4>

                          <div class="form-group">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off" placeholder="Cant. Lunes" title="Cantidad de Lunes de la quincena" required maxlength="100" disabled="disabled"   id="cant_lunes" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off" disabled="disabled" placeholder="Seguro Social" title="Monto deducción Seguro Social"  maxlength="100"   id="seguro_social" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off" disabled="disabled" placeholder="FAOV" title="Monto deducción de FAOV"  maxlength="100"   id="faov" >
                            </div>
                            
                          </div>

                          <div class="form-group">
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off" disabled="disabled" placeholder="Adelanto Quincena" title="Adelanto de Quincena"  maxlength="100"   id="prestamos" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off" disabled="disabled" placeholder="Rent. ISLR" title="Retención de IVA Sueldos y Salarios"  maxlength="100"   id="ret_iva" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off" placeholder="Total Retención" title="Retenciones total"  maxlength="100" disabled="disabled"   id="ret_total" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off" placeholder="Neto a Cobrar" title="Neto a cobrar de la quincena"  maxlength="100" disabled="disabled"   id="neto_cobrar" >
                            </div>

                          </div>


                          <div class="form-group">
                            <div class="col-sm-6" align="center">
                              <div id="enviar_quincena"> <a onclick="agregar_quincena()" class="btn btn-xs btn-default">Guardar</a> </div>
                            </div>
                            <div class="col-sm-6"  align="center">
                               <a id="calcular_asignacion" onclick="calcular_quincena()" class="btn btn-xs btn-primary">Calcular</a>
                            </div>
                          </div>

                        </form>
                      <div id="respuesta_quincena"></div>
                </div>
            </div>
             </header>
        </div>  

        <!-- DIV QUE MUESTRA FORMULARIO PARA EDITAR ULTIMA QUINCENA-->
        <div id="ed_quincena_" class="ventana" title="Editar Quincena">
            <header class="jumbotron hero-spacer">
              <div class="row" style="margin-bottom: 20px">
                <div class="col-md-12" >
                        <form id="form_quincena" class="form-horizontal" role="form">
                          <h4 align="center" id="titulo_ed">Asignaciones</h4>
                          <div class="form-group">

                            <div class="col-md-3" align="center">
                              <input type="hidden" class="form-control" required disabled="disabled"  maxlength="10" id="q_id_ed" >
                              <input type="hidden" class="form-control" required disabled="disabled"  maxlength="10" id="id_quincena_ed" >
                              <input type="hidden" class="form-control" required disabled="disabled"  maxlength="10" id="id_deduccion_ed" >
                              <input type="hidden" class="form-control" required disabled="disabled"  maxlength="10" id="q_sueldo_ed" >
                              <input type="hidden" class="form-control" required disabled="disabled"  maxlength="10" id="q_tipo_ed" >
                              <select class="form-control" id="quincena_ed" onchange="verifica_quincena('modificar')" >
                                <option value="">--QUINCENA--</option>
                              <?php 

                                  $re = mysqli_query($link, "select * from tbl_mes");

                                  while($fil = mysqli_fetch_array($re))
                                  {
                                    //@$mes = $fil['mes'];
                                    //if($mes >= date('m'))
                                    //{
                              ?>
                                    <option value="<?= $fil['descripcion_mes'];?>"><?= $fil['descripcion_mes'];?></option>
                              <?php
                                    //}
                                  }
                              ?>
                              </select>
                            </div>

                            <div class="col-md-3" align="center">
                              <select class="form-control" id="tipo_pago_asig_ed" >
                                <option value="">--PAGO--</option>
                                <option value="1">EFECTIVO</option>
                                <option value="2">DEPOSITO</option>
                                <option value="3">CHEQUE</option>
                                <option value="4">CTA. NOMINA</option>
                              </select>
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" id="fecha_inicio_ed" placeholder="Fecha Inicio" title="Ingrese Fecha Inicio Quincena" maxlength="100" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" id="fecha_fin_ed" placeholder="Fecha Fin" title="Ingrese Fecha Fin Quincena" maxlength="100" >
                            </div>
                          </div>

                          <div class="form-group">
                            
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" placeholder="Dias Trabajados" title="Ingrese Días Trabajados" required maxlength="100"   id="dias_traba_ed" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" placeholder="Dias Feriados" title="Ingrese Días Trabajados Feriados" maxlength="100"   id="dias_feriados_ed" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" placeholder="Dias Cesta Ticket" title="Ingrese Días Trabajados Cesta Ticket"  maxlength="100"   id="dias_cesta_ed" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" placeholder="Bonificación (Bs.)" title="Ingrese Monto en Bs. 1000.45" maxlength="100"  id="bonificacion_ed" >
                            </div>
                          </div>

                          <div class="form-group">
                            
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" placeholder="H/Extras Diurnas" title="Cantidad Horas Extras Diurnas"  maxlength="100"   id="h_extras_diur_ed" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" placeholder="H/Extras Noct" title="Cantidad Horas Extras Nocturnas" maxlength="100"  id="h_extras_noct_ed" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" disabled="disabled" placeholder="Cesta Ticket Bs." title="Cantidad a Recibir Cesta Ticket" maxlength="100"  id="cesta_bs_ed" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" autocomplete="off" placeholder="Bono Escolar (Bs)" title="Bono Escolar (Bs)"  maxlength="100" disabled="disabled"  id="otros_ed" >
                            </div>
                          </div>

                          <div class="form-group" >

                              <div class="col-md-1" align="center">
                                <input type="text" class="form-control" autocomplete="off" placeholder="Dias Utilidades" onkeyup="calcular_vacas('total_utilidades_ed','utilidades_ed','q_sueldo_ed')" title="Dias de Utilidades"  maxlength="100"   id="utilidades_ed" >
                              </div>

                              <div class="col-md-2" align="center">
                                <input type="text" class="form-control" autocomplete="off" placeholder="Total Utilidades" title="Total utilidades" maxlength="100" disabled="disabled"   id="total_utilidades_ed"  >
                              </div>

                            <div class="col-md-1" align="center">
                              <input type="text" class="form-control" autocomplete="off" placeholder="Dias Vacaciones" onkeyup="calcular_vacas('total_vacaciones_ed','vacaciones_ed','q_sueldo_ed')" title="Dias de Vacaciones"  maxlength="100"   id="vacaciones_ed" >
                            </div>
                            <div class="col-md-2" align="center">
                              <input type="text" class="form-control" autocomplete="off" placeholder="Total Vacaciones" title="Total Vacaciones" maxlength="100" disabled="disabled"   id="total_vacaciones_ed"  >
                            </div>
                            <div class="col-md-1" align="center">
                              <input type="text" class="form-control" autocomplete="off" placeholder="Dias Bono Vacacional" onkeyup="calcular_vacas('total_bono_vacacional_ed','bono_vacacional_ed','q_sueldo_ed')" title="Dias Bono Vacacional" maxlength="100"   id="bono_vacacional_ed"  >
                            </div>
                            <div class="col-md-2" align="center">
                              <input type="text" class="form-control" autocomplete="off" placeholder="Total Bono Vacacional" title="Total Bono Vacacional" maxlength="100" disabled="disabled"  id="total_bono_vacacional_ed"  >
                            </div>

                            <div class="col-md-1" align="center">
                                <input type="text" class="form-control" autocomplete="off" placeholder="Interés Antigüedad"  title="Ingrese monto de Interés Antigüedad" maxlength="100"   id="interes_anti_ed"  >
                              </div>

                              <div class="col-md-1" align="center">
                                <input type="text" class="form-control" autocomplete="off" placeholder="Adelanto Antigüedad" title="Ingrese monto de Adelanto Antigüedad" maxlength="100"  id="adelanto_anti_ed"  >
                              </div>

                          </div>

                          <div class="form-group">
                            <div class="col-md-4" align="center">
                            </div>

                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" placeholder="Asig. Quinc."  disabled="disabled"   title="Asignación Quincenal" maxlength="100"   id="asig_quinc_ed"   >
                            </div>
  
                            <div class="col-md-3" align="center">
                            </div>
                          </div>

                          <hr>

                          <h4 align="center">Deducciones</h4>

                          <div class="form-group">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" placeholder="Cant. Lunes" title="Cantidad de Lunes de la quincena" required maxlength="100"    id="cant_lunes_ed" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control"  placeholder="Seguro Social" title="Monto deducción Seguro Social"  maxlength="100"   id="seguro_social_ed" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" placeholder="FAOV" title="Monto deducción de FAOV"  maxlength="100"   id="faov_ed" >
                            </div>
                            
                          </div>

                          <div class="form-group">
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control"  placeholder="Adelanto Quincena" title="Adelanto de Quincena"  maxlength="100"   id="prestamos_ed" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control"  placeholder="Rent. ISLR" title="Retención de IVA Sueldos y Salarios"  maxlength="100"   id="ret_iva_ed" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" disabled="disabled"   placeholder="Total Retención" title="Retenciones total"  maxlength="100"   id="ret_total_ed" >
                            </div>
                            <div class="col-md-3" align="center">
                              <input type="text" class="form-control" disabled="disabled"   placeholder="Neto a Cobrar" title="Neto a cobrar de la quincena"  maxlength="100" id="neto_cobrar_ed" >
                            </div>

                          </div>


                          <div class="form-group">
                            <div class="col-sm-6" align="center">
                               <div id="modificar_quincena_"><a  onclick="modificar_quincena()" class="btn btn-xs btn-default">Modificar</a></div>
                            </div>
                            <div class="col-sm-6"  align="center">
                               <a id="calcular_asignacion" onclick="calcular_quincena_editar()" class="btn btn-xs btn-primary">Calcular</a>
                            </div>
                          </div>

                        </form>
                      <div id="respuesta_modifica"></div>
                </div>
            </div>
            <header>
        </div>

        <!-- DIV QUE MUESTRA FORMULARIO PARA AGREGAR OTRAS ASIGNACIONES-->
        <div id="otras_asig" class="ventana" title="Registro de Otras Asignaciones">
            <div class= "row" >
                <div class="col-md-12">
                        <form id="form_quincena" class="form-horizontal" role="form">
                          <h4 align = "center" id="titulo_otras">Asignaciones</h4>
                          <hr>
                          <div class="form-group">

                            <div class="col-md-6" align="center">
                              <select class="form-control" id="tipo_otra_asig" >
                                <option value="">--PAGO--</option>
                                <option value="EFECTIVO">EFECTIVO</option>
                                <option value="DEPOSITO">DEPOSITO</option>
                                <option value="CHEQUE">CHEQUE</option>
                                <option value="CTA. NOMINA">CTA. NOMINA</option>
                              </select>
                            </div>

                            <div class="col-md-6" align="center">
                              <input type="text" class="form-control" id="fecha_otras_asig" placeholder="Fecha Registro" title="Ingrese Fecha Registro" required maxlength="11" >
                              <input type="hidden" class="form-control" required disabled="disabled"  maxlength="10" id="id_otra" >
                              <input type="hidden" class="form-control" required disabled="disabled"  maxlength="10" id="sueldo_otra" >
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="col-md-4" align="center">
                              Bono Fin Año <input type="text" class="form-control" autocomplete="off" placeholder="Bonificación (Bs.)" title="Monto Fin de Año" maxlength="100"   id="fin_otra" >
                            </div>
                            <div class="col-md-4" align="center">
                              Bono Vacaciones <input type="text" class="form-control" autocomplete="off"  placeholder="Monto Bs. Vacaciones" title="Monto Bs. Vacaciones" maxlength="100"  id="vaca_otra" >
                            </div>
                            <div class="col-md-4" align="center">
                              Dias Vacaciones <input type="text" class="form-control" autocomplete="off" placeholder="Días Vacaciones" title="Dias Vacaciones" maxlength="100"   id="dias_otra" >
                            </div>
                          </div>
                           <div class="form-group">
                            <div class="col-md-6" align="center">
                              Otros Pagos <input type="text" class="form-control" autocomplete="off" placeholder="Monto (Bs.)" title="Otros Pagos" maxlength="100"   id="otros_" >
                            </div>
                            <div class="col-md-6" align="center">
                              Otros Pagos <input type="text" class="form-control" autocomplete="off"  placeholder="Monto (Bs.)" title="Otros Pagos" maxlength="100"  id="otros_pagos" >
                            </div>
                          </div>

                          <hr>

                          <div class="form-group">
                            <div class="col-md-12" align="center">
                               <div id="guardar_otra_asig_"><a  onclick="guardar_otra_asig()" class="btn btn-xs btn-primary">Guardar</a></div>
                            </div>
                          </div>

                        </form>
                      <div id="respuesta_otra_asig"></div>
                </div>
            </div>
        </div>  


        <!-- DIV QUE MUESTRA FORMULARIO PARA RECIBO DE PAGO-->
        <div id="recibo_" class="ventana" title="Generar Recibo de Pago">
            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_recibo" class="form-horizontal" role="form">
                          <div class="form-group">
                            <label class="col-md-2 control-label">Quincena: </label>
                            <div class="col-md-2" align="center" style="margin-top: 8px">
                              <input type="hidden" class="form-control" required disabled="disabled"  maxlength="10" id="re_id" >
                              <select class="form-control" id="quincena_recibo" >
                                <option value="">--Seleccione--</option>
                                <option value="1RA ENERO">1RA ENERO</option>
                                <option value="2DA ENERO">2DA ENERO</option>
                                <option value="1RA FEBRERO">1RA FEBRERO</option>
                                <option value="2DA FEBRERO">2DA FEBRERO</option>
                                <option value="1RA MARZO">1RA MARZO</option>
                                <option value="2DA MARZO">2DA MARZO</option>
                                <option value="1RA ABRIL">1RA ABRIL</option>
                                <option value="2DA ABRIL">2DA ABRIL</option>
                                <option value="1RA MAYO">1RA MAYO</option>
                                <option value="2DA MAYO">2DA MAYO</option>
                                <option value="1RA JUNIO">1RA JUNIO</option>
                                <option value="2DA JUNIO">2DA JUNIO</option>
                                <option value="1RA JULIO">1RA JULIO</option>
                                <option value="2DA JULIO">2DA JULIO</option>
                                <option value="1RA AGOSTO">1RA AGOSTO</option>
                                <option value="2DA AGOSTO">2DA AGOSTO</option>
                                <option value="1RA SEPTIEMBRE">1RA SEPTIEMBRE</option>
                                <option value="2DA SEPTIEMBRE">2DA SEPTIEMBRE</option>
                                <option value="1RA OCTUBRE">1RA OCTUBRE</option>
                                <option value="2DA OCTUBRE">2DA OCTUBRE</option>
                                <option value="1RA NOVIEMBRE">1RA NOVIEMBRE</option>
                                <option value="2DA NOVIEMBRE">2DA NOVIEMBRE</option>
                                <option value="1RA DICIEMBRE">1RA DICIEMBRE</option>
                                <option value="2DA DICIEMBRE">2DA DICIEMBRE</option>
                              </select>
                            </div>

                            <label  class="col-md-2 control-label">Período: </label>
                            <div class="col-md-2" style="margin-top: 8px">
                              <select class="form-control" id="periodo_recibo" >
                                <option value="">--Seleccione--</option>
                              <?php 

                                  $re = mysqli_query($link, "select * from tbl_periodo");

                                  while($fil = mysqli_fetch_array($re))
                                  {
                              ?>
                                    <option value="<?= $fil['id_periodo'];?>"><?= $fil['ano_periodo'];?></option>
                              <?php
                                  }
                              ?>
                              </select>
                            </div>

                            <label  class="col-md-1 control-label">Tipo: </label>
                            <div class="col-md-2" style="margin-top: 8px">
                              <select class="form-control" id="tipo_recibo" >
                                <option value="">--Seleccione--</option>
                                  <option value="1">Doble Cara</option>
                                  <option value="2">Simple</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-12" align="center">
                              <a href="#" onclick="generar_recibo()" class="btn btn-md btn-primary">Enviar</a>
                            </div>
                          </div>

                        </form>
                </div>
            </div>
        </div>    


        <!-- DIV QUE MUESTRA FORMULARIO PARA INHABILITAR PERSONAL-->
        <div id="inhabilitar_" class="ventana" title="Inhabilitar Personal">
            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_recibo" class="form-horizontal" role="form">
                          <div class="form-group">
                            <label class="col-md-3 control-label">Fecha: </label>
                            <div class="col-md-3"  style="margin-top: 8px">
                              <input type="hidden" class="form-control" required disabled="disabled"  maxlength="10" id="inh_id" >
                              
                              <input type="text" class="form-control" autocomplete="off" id="fecha_egreso" >
                            </div>

                            <label class="col-md-2 control-label">Motivo: </label>
                            <div class="col-md-3"  style="margin-top: 8px">
                               <select class="form-control" id="motivo_egreso" >
                                  <option value="">--Seleccione--</option>
                                  <option value="RETIRO VOLUNTARIO">RETIRO VOLUNTARIO</option>
                                  <option value="DESPIDO">DESPIDO</option>
                               </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="col-sm-12" align="center">
                              <a href="#" onclick="inhabilitar_personal()" class="btn btn-md btn-primary">Enviar</a>
                            </div>
                          </div>

                        </form>
                        <div id="respuesta_egreso"></div>
                </div>
            </div>
        </div>    

        <!-- DIV QUE MUESTRA FORMULARIO PARA MOSTRAR DATOS PERSONAL-->
        <div id="mostrar" class="ventana" title="Datos Básicos Personal">
            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_personal" class="form-horizontal" role="form">
                          <div class="form-group">
                            <label class="col-md-2 control-label">Cédula</label><div  class="col-md-3 " style="margin-top: 6px" ><div id="cedula_mos"></div></div>

                            <label  class="col-md-3 control-label">R.I.F</label><div  class="col-md-3 " style="margin-top: 6px" ><div id="rif_mos"></div></div>
                          </div>

                          <div class="form-group">
                            <label  class="col-md-2 control-label">Apellido</label><div  class="col-md-3 " style="margin-top: 6px"><div id="apellido_mos"></div></div>
                            
                            <label  class="col-md-3 control-label">Nombre</label><div  class="col-md-3 " style="margin-top: 6px"><div id="nombre_mos"></div></div>
                          </div>

                          <div class="form-group">
                            <label  class="col-md-2 control-label">Dirección</label><div  class="col-md-3 " style="margin-top: 6px"><div id="direccion_mos"></div></div>
                            
                            <label  class="col-md-3 control-label">Teléfono</label><div  class="col-md-3 " style="margin-top: 6px"><div id="telefono_mos"></div></div>
                          </div>

                          <div class="form-group">
                            <label  class="col-md-2 control-label">Cargo</label><div  class="col-md-3 " style="margin-top: 6px"><div id="cargo_mos"></div></div>

                            <label  class="col-md-3 control-label">Tipo</label><div  class="col-md-3 " style="margin-top: 6px"><div id="tipo_mos"></div></div>  
                          </div>

                          <div class="form-group">
                            <label  class="col-md-2 control-label">Sueldo Básico</label><div  class="col-md-3 " style="margin-top: 6px"><div id="sueldo_mos"></div></div>
                            
                            <label  class="col-md-3 control-label">Fecha Ingreso</label><div  class="col-md-3 " style="margin-top: 6px"><div id="fecha_mos"></div></div>
                          </div>

                      </form>
                </div>
            </div>
        </div>    
       
        <?php $helpers->footer();?>

    </div>



    
</body>

<script type="text/javascript">
  
   
    $( "#fecha" ).datepicker({dateFormat: 'yy/mm/dd', changeMonth: true, changeYear: true});

    $( "#ed_fecha" ).datepicker({dateFormat: 'yy/mm/dd', changeMonth: true, changeYear: true});

    $( "#fecha_abono" ).datepicker({dateFormat: 'yy/mm/dd', changeMonth: true, changeYear: true});

    $( "#fecha_inicio" ).datepicker({dateFormat: 'yy/mm/dd', changeYear: true});

    $( "#fecha_fin" ).datepicker({dateFormat: 'yy/mm/dd', changeYear: true});

    $( "#fecha_inicio_ed" ).datepicker({dateFormat: 'yy/mm/dd', changeYear: true});

    $( "#fecha_fin_ed" ).datepicker({dateFormat: 'yy/mm/dd', changeYear: true});

    $( "#fecha_otras_asig" ).datepicker({dateFormat: 'yy/mm/dd', changeYear: true});

    $( "#fecha_egreso" ).datepicker({dateFormat: 'yy/mm/dd', changeMonth: true, changeYear: true});

    


</script>

</html>
