<?php
    session_start();
    require('helpers.php');
    require('conectar.php');

    $buscador = 'where retencion_personal = 11 or retencion_personal = 12 ';

    if(!empty($_GET['id']))
    {
       $var = $_GET['id'];
       $campo = $_GET['campo'];

       $buscador = "where $campo like '%$var%' ";
    }

    $_pagi_sql  = "select * from tbl_personal ".$buscador." order by id_personal asc";
    
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
      <header class="jumbotron hero-spacer">
        <div class="row">
            <div class="col-lg-12" >
                <h3> Personal para Retención ISLR Sueldos y Salarios </h3>
            </div>
        </div>
           <div class="input-group" align="center">
                <input class="form-control" type="text"  id="buscador" placeholder="Ingrese Datos para Consultar">
                <span class="input-group-addon" ><span class="mdi-notification-sync" ></span></span>
                <select  class="form-control" id="var_busqueda" onchange="consulta('tpl_retencion_islr')" >
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
         
                <tr>
                  <th>#</th>
                  <th>R.I.F</th>
                  <th>Apellido y Nombre</th>
                  <th>Dirección</th>
                  <th>Teléfono</th>
                  <th>
                      <div style="margin-top: -5px" class="btn-group">
                          <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="modal('agregar')">Agregar</a>
                          
                      </div>
                  </th>
                </tr>
        <?php
                while($fila = mysqli_fetch_array($_pagi_result))
                {

                  $unidad = $helpers->declara_retencion($fila['sueldo_basico_personal'],$fila['fecha_ingreso_personal']);


                  if($unidad > 1000)
                  {
                    
        ?>
                <tr>
                  <td><?= $fila['id_personal'];?></td>
                  <td><?= $fila['rif_personal'];?></td>
                  <td><?= $fila['apellido_personal']." ".$fila['nombre_personal'];?></td>
                  <td><?= $fila['direccion_personal'];?></td>
                  <td><?= $fila['telefono_personal'];?></td>
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
                                                                      '<?= $fila['fecha_ingreso_personal'];?>')" >Editar</a>
                                </li>

                                
                                <li><a href="#" id="<?= $fila['id_personal'];?>" onclick="modal_retencion('retencion',
                                                                                                          '<?= $fila['id_personal'];?>',
                                                                                                          '<?= $fila['cedula_personal'];?>')">Cargar Retención</a></li>
                                
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
                    
            }
                
                
        ?>
          </table>
            
            <div class="row">
              <div class="col-md-3"></div>
              <div class="col-md-4" align="center">   <ul class='pagination pagination-sm'><?= $_pagi_navegacion; ?></ul></div> 
              <div class="col-md-4"></div>
            </div>
          </header>
       
        
        <!-- DIV QUE MUESTRA FORMULARIO PARA AGREGAR NUEVA PERSONA-->
        <div id="agregar" class="ventana" title="Registro de Sujeto Retenido">
            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_personal" class="form-horizontal" role="form">
                          <div class="form-group">
                            
                            <input type="hidden" class="form-control" autocomplete="off" value="V00000000"  placeholder="V22111333"  maxlength="10" id="cedula" >
                            
                            <label  class="col-md-2 control-label">R.I.F</label>
                            <div class="col-md-3">
                              <input type="text" class="form-control" autocomplete="off"  required maxlength="10"  id="rif" placeholder="V221113334" >
                              <input type="hidden" class="form-control" autocomplete="off"  required  maxlength="10" value="retencion_" id="retencion_1" >
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
                              <input type="hidden" class="form-control" autocomplete="off" value=""  placeholder="V22111333"  maxlength="10" id="cargo" >
                        
                              <input type="hidden" class="form-control" autocomplete="off" value=""  placeholder="V22111333"  maxlength="10" id="tipo" >
                          </div>

                          <div class="form-group">
                              <input type="hidden" class="form-control" autocomplete="off" value="0000"  placeholder="V22111333"  maxlength="10" id="sueldo" >
                            
                              <input type="hidden" class="form-control" autocomplete="off" value="0000/00/00"  placeholder="V22111333"  maxlength="10" id="fecha" >
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
                            
                              <input type="hidden" value="<?= @$_GET['_pagi_pg'];?>" id="pagina">
                              <input type="hidden" class="form-control" required disabled="disabled"  maxlength="10" id="ed_cedula" >
                              <input type="hidden" class="form-control" required disabled="disabled"  maxlength="10" id="ed_id" >
                            

                            <label  class="col-md-2 control-label">R.I.F</label>
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
                          
                              <input type="hidden" class="form-control" autocomplete="off"  required maxlength="100"  id="ed_cargo" >
                            
                              <input type="hidden" class="form-control" autocomplete="off"  required maxlength="100"  id="ed_tipo" >
                            
                          </div>

                          <div class="form-group">
                          
                              <input type="hidden" class="form-control"  required maxlength="100"   id="ed_sueldo" >
                           
                              <input type="hidden" class="form-control"  required maxlength="100"   id="ed_fecha" >
                            
                          </div>

                          <div class="form-group">
                            <div class="col-sm-12" align="center">
                              <div id="editar_personal_" ><a href="#"  onclick="editar_per()" class="btn btn-default">Enviar</a></div>
                            </div>
                          </div>

                        </form>
                      <div id="respuesta_editar_persona"></div>
                </div>
            </div>
        </div> 

         <!-- DIV QUE MUESTRA FORMULARIO PARA AGREGAR RETENCION-->
        <div id="retencion" class="ventana" title="Registro de Retención">
            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_retencion" class="form-horizontal" role="form">
                          
                          <div class="form-group">

                            <label class="col-md-2 control-label">Fecha Abono</label>
                              <div class="col-md-2">
                                 <input type="text" class="form-control" autocomplete="off"  id="fecha_abono" >
                                 <input type="hidden" class="form-control"  required disabled="disabled"  maxlength="20" id="id_perReten" >
                              </div>

                            <label class="col-md-2 control-label">Código Concepto</label>
                              <div class="col-md-2">
                                 <select class="form-control" id="codigo_concept" >
                                    <option value="">--Elija--</option>
                                    <option value="001">001</option>
                                    <option value="002">002</option>
                                    <option value="003">003</option>
                                    <option value="004">004</option>
                                    <option value="004">004</option>
                                    <option value="006">006</option>
                                  </select>
                              </div>

                            <label  class="col-md-2 control-label">Tipo Transaccion</label>
                              <div class="col-md-2" align="center">
                                 <select class="form-control" id="t_transaccion" >
                                    <option value="">--Elija--</option>
                                    <option value="1-REG">1-REG</option>
                                  </select>
                              </div>

                          </div>

                          <div class="form-group">
                          
                            <label  class="col-md-2 control-label">Nº Nota Crédito</label>
                              <div class="col-md-2" align="center">
                                <input type="text" class="form-control" maxlength="20"  autocomplete="off"  id="n_nota_credito" >
                              </div>

                            <label  class="col-md-2 control-label">Nº Nota Débito</label>
                              <div class="col-md-2" align="center">
                                <input type="text" class="form-control"  maxlength="20" autocomplete="off"   id="n_nota_debito" >
                              </div>

                            <label  class="col-md-2 control-label">% Retención</label>
                              <div class="col-md-2" align="center">
                                <input type="text" class="form-control"  required maxlength="20" autocomplete="off"   id="por_reten" >
                              </div>
                          
                          </div>

                          <div class="form-group">

                            <label  class="col-md-2 control-label">Cantidad Objeto Retención</label>
                              <div class="col-md-2" align="center">
                                <input type="text" class="form-control" autocomplete="off" onchange="calcula_impuesto()" required maxlength="20"   id="c_retencion" >
                              </div>

                            <label  class="col-md-2 control-label">Cantidad Pagada</label>
                              <div class="col-md-2" align="center">
                                <input type="text" class="form-control"  required maxlength="20" autocomplete="off"   id="c_pagada" >
                              </div>

                            <label  class="col-md-2 control-label">Impuesto Retenido</label>
                              <div class="col-md-2" align="center">
                                <input type="text" class="form-control"  required maxlength="20" autocomplete="off"   id="imp_retenido" >
                              </div>

                          </div>

                          <div class="form-group">
                            <div class="col-sm-6" align="center">
                              <div id="retencion_personal"> <a  onclick="agregar_retencion()" class="btn btn-default">Enviar</a></div>
                            </div>
                            <div class="col-sm-6" align="center">
                              <a id="ultima_retencion" onclick="ultima_retencion()" class="btn btn-primary">Ult. Retencion</a>
                            </div>
                          </div>

                        </form>
                      <div id="respuesta_retencion"></div>
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


</script>

</html>
