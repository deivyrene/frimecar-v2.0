<?php
    session_start();
    require('helpers.php');
    require('conectar.php');

    @$descripcion = $_GET['get'];
    @$inventario = 0;
    @$mes = date('m');

    $buscador = '';

    if(!empty($_GET['id']))
    {
       $var = $_GET['id'];
       $campo = $_GET['campo'];

       $buscador = "where $campo like '%$var%'";
    }

              if($descripcion == "CUEROS")
              {
                $_pagi_sql  = "SELECT 
                                        id_entrada, 
                                        item_entrada,
                                        descripcion_entrada,
                                        cantidad_vaca_entrada,
                                        cantidad_toro_entrada,
                                        total_entrada, 
                                        fecha_entrada,
                                        cant_vaca_salida_aya+cant_toro_salida_aya as total_pyh,
                                        cant_vaca_salida_paez+cant_toro_salida_paez as total_paez,
                                        total_salida,
                                        inventario_actual,
                                        total_entrada-total_salida-auto_consumo_entrada-retiros_entrada as total_inventario,
                                        id_salida
                                FROM 
                                        tbl_entrada_diario ed 
                           left join 
                                        tbl_salida_diario sd 
                                  on 
                                        ed.id_entrada=sd.fk_entrada 
                               where    inventario_actual <> 0 

                                 and
                                        
                                        descripcion_entrada = '".$descripcion."' order by id_entrada asc ";
              }
              else
              {
                    $_pagi_sql  = "SELECT 
                                        id_entrada, 
                                        item_entrada,
                                        descripcion_entrada,
                                        cantidad_vaca_entrada,
                                        cantidad_toro_entrada,
                                        total_entrada, 
                                        fecha_entrada,
                                        cant_vaca_salida_aya+cant_toro_salida_aya as total_pyh,
                                        cant_vaca_salida_paez+cant_toro_salida_paez as total_paez,
                                        total_salida,
                                        inventario_actual,
                                        total_entrada-total_salida-auto_consumo_entrada-retiros_entrada as total_inventario,
                                        id_salida
                                FROM 
                                        tbl_entrada_diario ed 
                           left join 
                                        tbl_salida_diario sd 
                                  on 
                                        ed.id_entrada=sd.fk_entrada 
                               where 
                                        month(fecha_entrada) = '".$mes."' 
                                 and
                                        descripcion_entrada = '".$descripcion."' order by id_entrada asc ";
              }
    
    $_pagi_cuantos = 100; 
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
                <h3> Listado Detallado de Entrada y Salida de Inventario (Matanza Mes <?= $mes; ?>) </h3>
            </div>
        </div>
           <div class="input-group" align="center">
                <input class="form-control" type="text"  id="buscador" placeholder="Ingrese Datos para Consultar">
                <span class="input-group-addon" ><span class="mdi-notification-sync" ></span></span>
                <select  class="form-control" id="var_busqueda" onchange="consulta('tpl_documento')" >
                        <option value="">--Seleccione--</option>
                        <option value="descripcion">Descripción</option>
                </select>
            </div>
        <br>
        

        <?php
            if(@mysqli_num_rows($_pagi_result) == 0)
            {
        ?>
                <tr>
                  <th><div class="alert alert-warning" align="center" role="alert">No existen registros.! <br> Para Registrar Clic <a href="javascript:void(0)" onclick="modal('agregar')">Agregar</a></div></th>
                </tr>
        <?php
            }
            else
            {
        ?>
          <table class="table table-hover">
         
                <tr>
                  <th>#</th>
                  <th>Fecha</th>
                  <th>Descripción</th>
                  <th>Entrada</th>
                  <th>Salida PYH</th>
                  <th>Salida Páez</th>
                  <th>Salida</th>
                  <th>Restan</th>
                  <th>
                      <div style="margin-top: -5px;" class="btn-group">
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="modal('agregar')">Agregar</a>
                      </div>
                  </th>
                </tr>
        <?php

                while($fila = mysqli_fetch_array($_pagi_result))
                {
                  @$cont = $cont + 1;
                  $inventario = $inventario + $fila['inventario_actual'];

        ?>
                <tr>
                  <td><?= $cont;?></td>
                  <td><?= $fila['fecha_entrada'];?></td>
                  <td><?= $fila['descripcion_entrada'];?></td>
                  <td><?= $fila['total_entrada'];?></td>
                  <td><?= $fila['total_pyh'];?></td>
                  <td><?= $fila['total_paez'];?></td>
                  <td><?= $fila['total_salida'];?></td>
                  <td><?= $inventario;?></td>
                  <td>
                      <div class="btn-group" style="margin-top: -5px" >
                        <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
                          Opciones <span class="caret"></span>
                        </button>
                  <?php 
                        if($fila['descripcion_entrada'] == 'CUEROS')
                        {
                            $fecha = $helpers->comparaFecha($fila['fecha_entrada'],date('Y-m-d'));

                            //if($fecha == "menor")
                            //{
                  ?>
                             <!-- <ul class="dropdown-menu" role="menu">
                                <li><a href="javascript:void(0)" >  Sin Operación </a></li>
                              </ul>-->      
                  <?php
                           // }
                           // else
                            //{
                  ?>
                              <ul class="dropdown-menu" role="menu">
                              <li><a href="javascript:void(0)" onclick="modal_salida('<?= $descripcion; ?>', 
                                                                                     '<?= $fila['id_entrada']?>', 
                                                                                     '<?= $fila['cantidad_vaca_entrada']?>', 
                                                                                     '<?= $fila['cantidad_toro_entrada']?>', 
                                                                                     '<?= $inventario ?>')" >  Salida </a></li>
                              
                              </ul>  
                  <?php 
                           // }
                           
                        }
                        else
                        {
                  ?>
                            <ul class="dropdown-menu" role="menu">
                            <li><a href="javascript:void(0)" onclick="modal_salida('<?= $descripcion; ?>', 
                                                                                     '<?= $fila['id_entrada']?>', 
                                                                                     '<?= $fila['cantidad_vaca_entrada']?>', 
                                                                                     '<?= $fila['cantidad_toro_entrada']?>', 
                                                                                     '<?= $inventario ?>')" >  Salida </a></li>
                              
                            </ul> 
                  <?php        
                        }
                  ?>
                        
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
        
        
        <!-- DIV QUE MUESTRA FORMULARIO PARA AGREGAR NUEVO INVENTARIO DE MATERIA PRIMA-->
        <div id="agregar" class= "ventana" title="Carga Entrada">
            <div class= "row" >
                <div class="col-md-12"  >
                        <form id="form_documento" class="form-horizontal" role="form">

                          <h4 align="center"><label >MATERIA PRIMA</label></h4> 

                          <div class="form-group" >
                            <label class="col-md-3 control-label">Cant. Vaca:</label>
                            <div class="col-md-1">
                               <input type="text" class="form-control" autocomplete="off" required  maxlength="3" id="cant_vaca" >
                            </div>
                          
                            <label  class="col-md-3 control-label">Cant. Toro:</label>
                            <div class="col-md-1">
                              <input type="text" class="form-control" autocomplete="off"  required maxlength="3"  id="cant_toro" >
                            </div>

                            <label class="col-md-2 control-label">Ingreso</label>
                            <div class="col-md-2">
                               <input type="text" class="form-control" autocomplete="off" onchange="act_cantidad()" required id="fecha_entrada" >
                            </div>
                          </div>

                          <hr>

                          <h4 align="center"><label >SUB-PRODUCTOS</label></h4> 

                          <div class="form-group" >
                            <label class="col-md-2 control-label">Mondongo:</label>
                            <div class="col-md-1">
                               <input type="text" class="form-control" autocomplete="off" required  maxlength="3" id="cant_mondongo" >
                            </div>
                          
                          
                            <label  class="col-md-1 control-label">Cuero:&nbsp&nbsp</label>
                            <div class="col-md-1">
                              <input type="text" class="form-control" autocomplete="off"  required maxlength="3"  id="cant_cuero" >
                            </div>

                            <label  class="col-md-2 control-label">Chinchurria:</label>
                            <div class="col-md-1">
                              <input type="text" class="form-control" autocomplete="off"  required maxlength="3"  id="cant_chinchurria" >
                            </div>

                            <label  class="col-md-2 control-label">Carne Cuero:</label>
                            <div class="col-md-1">
                              <input type="text" class="form-control" autocomplete="off"  required maxlength="3"  id="cant_ccuero" >
                            </div>
                          </div>

                          <div class="form-group" >
                            <div class="col-md-12"  align="center">
                              <div id="enviar_materia"><a href="#" onclick="guardar_entrada('<?= $descripcion; ?>')" class="btn btn-md btn-primary">Enviar</a></div>
                            </div>
                          </div>

                        </form>
                      <div id="respuesta_entrada"></div>
                </div>
            </div>
        </div>    


        <!-- DIV QUE MUESTRA FORMULARIO PARA AGREGAR SALIDA-->
        <div id="<?php if($descripcion == 'MONDONGO' || $descripcion == 'MATANZA'){ echo $descripcion; }?>" class="ventana" title="Carga Salida">
            <div class= "row" >
                <div class="col-md-12"  >
                        <form id="form_documento" class="form-horizontal" role="form">

                          <h4 align="center"><label >DISPONIBLE</label></h4> 

                          <div class="form-group" >
                            <label class="col-md-3 control-label">Total:</label>
                            <div class="col-md-1">
                               <input type="text" class="form-control" autocomplete="off" disabled="disabled"  maxlength="3" id="resto_temp" >
                            </div>
                            <label  class="col-md-2 control-label">Vacas:</label>
                            <div class="col-md-1">
                              <input type="text"  class="form-control" autocomplete="off"  disabled="disabled" maxlength="3"  id="temp_vaca" >
                            </div>
                            <label  class="col-md-2 control-label">Toros:</label>
                            <div class="col-md-1">
                              <input type="text"  class="form-control" autocomplete="off"  disabled="disabled" maxlength="3"  id="temp_toro" >
                            </div>
                          </div> 

                          <h4 align="center"><label >INTERNO</label></h4> 

                          <div class="form-group" >
                            <label class="col-md-3 control-label">Autoconsumo:</label>
                            <div class="col-md-2">
                               <input type="text" onchange="valida_inventario(id)" class="form-control" autocomplete="off" required  maxlength="3" id="auto_consumo_mat" >
                               <input type="hidden" class="form-control" autocomplete="off" required  maxlength="5" id="mat_id" >
                               <input type="hidden" class="form-control" autocomplete="off" required  maxlength="5" id="cant_vaca_matanza" >
                               <input type="hidden" class="form-control" autocomplete="off" required  maxlength="5" id="cant_toro_matanza" >
                               <input type="hidden" class="form-control" autocomplete="off" required  maxlength="5" id="total_entrada" >
                            </div>
                          
                          
                            <label  class="col-md-4 control-label">Retiros:</label>
                            <div class="col-md-2">
                              <input type="text" onchange="valida_inventario(id)" class="form-control" autocomplete="off"  required maxlength="3"  id="retiro_mat" >
                            </div>

                          </div>

                        
                          <h4 align="center"><label >PUERTO PÁEZ</label></h4> 

                          <?php
                            if($descripcion == 'MATANZA')
                            {
                          ?>

                            <div class="form-group" >
                              <label class="col-md-3 control-label">Cant. Vaca:</label>
                              <div class="col-md-2">
                                 <input type="text" onchange="valida_inventario(id)"  class="form-control" autocomplete="off" required  maxlength="3" id="cant_vaca_p" >
                                
                              </div>
                            
                            
                              <label  class="col-md-4 control-label">Cant. Toro:</label>
                              <div class="col-md-2">
                                <input type="text"  onchange="valida_inventario(id)" class="form-control" autocomplete="off"  required maxlength="3"  id="cant_toro_p" >
                               
                              </div>

                            </div>

                          <?php
                            }
                            else
                            {
                          ?>
                            <div class="form-group" >
                              <label class="col-md-6 control-label">Cantidad:</label>
                              <div class="col-md-2">
                                 <input type="text" onchange="valida_inventario(id)" class="form-control" autocomplete="off" required  maxlength="3" id="cant_mondongo_p" >
                              </div>

                            </div>
                          <?php
                            }
                          ?>
                          

                          <h4 align="center"><label >PUERTO AYACUCHO</label></h4> 

                          <?php
                            if($descripcion == 'MATANZA')
                            {
                          ?>

                            <div class="form-group" >
                              <label class="col-md-3 control-label">Cant. Vaca:</label>
                              <div class="col-md-2">
                                 <input type="text"  onchange="valida_inventario(id)"  class="form-control" autocomplete="off" required  maxlength="3" id="cant_vaca_py" >
                              </div>
                            
                            
                              <label  class="col-md-4 control-label">Cant. Toro:</label>
                              <div class="col-md-2">
                                <input type="text" onchange="valida_inventario(id)"  class="form-control" autocomplete="off"  required maxlength="3"  id="cant_toro_py" >
                              </div>

                            </div>

                          <?php
                            }
                            else
                            {
                          ?>
                            <div class="form-group" >
                              <label class="col-md-6 control-label">Cantidad:</label>
                              <div class="col-md-2">
                                 <input type="text" onchange="valida_inventario(id)" class="form-control" autocomplete="off" required  maxlength="3" id="cant_mondongo_py" >
                              </div>

                            </div>
                          <?php
                            }
                          ?>

                          <div class="form-group" >
                            <label class="col-md-6 control-label">Precio Bs:</label>
                            <div class="col-md-2">
                               <input type="text" class="form-control" autocomplete="off" required  maxlength="6" id="precio_uno" >
                            </div>
                          </div>

                          <div class="form-group" >
                            <div class="col-md-12"  align="center">
                              <div id="salida_materia"><a href="#" onclick="salida_matanza('<?= $descripcion; ?>')" class="btn btn-md btn-primary">Enviar</a></div>
                            </div>
                          </div>

                        </form>
                      <div id="respuesta_salida"></div>
                </div>
            </div>
        </div>    

        <!-- DIV QUE MUESTRA FORMULARIO PARA AGREGAR SALIDA-->
        <div id="<?php if($descripcion == 'CUEROS' || $descripcion == 'CHINCHURRIA' || $descripcion == 'CARNE-CUERO'){ echo $descripcion; }?>" class="ventana" title="Carga Salida">
            <div class= "row" >
                <div class="col-md-12"  >
                        <form id="form_documento" class="form-horizontal" role="form">

                          <h4 align="center"><label >DISPONIBLE</label></h4> 

                          <div class="form-group" >
                            <label class="col-md-5 control-label">Total:</label>
                            <div class="col-md-3">
                               <input type="text" class="form-control" autocomplete="off" disabled="disabled"  maxlength="3" id="resto_temp_" >
                            </div>

                          </div>

                          <h4 align="center"><label >DESPACHO</label></h4> 

                          <div class="form-group" >
                            <label class="col-md-5 control-label">Cantidad:</label>
                            <div class="col-md-3">
                               <input type="text" onchange="valida_inventario(id)" class="form-control" autocomplete="off" required  maxlength="3" id="cantidad_sal" >
                               <input type="hidden" class="form-control" autocomplete="off" required  maxlength="3" id="mat_" >
                            </div>

                          </div>

                          <div class="form-group" >
                            <label class="col-md-5 control-label">Precio Bs:</label>
                            <div class="col-md-3">
                               <input type="text" class="form-control" autocomplete="off" required  maxlength="6" id="precio_dos" >
                            </div>
                          </div>

                          <div class="form-group" >
                            <div class="col-md-12"  align="center">
                              <div id="salida_materia"><a href="#" onclick="salida_matanza('<?= $descripcion; ?>')" class="btn btn-md btn-primary">Enviar</a></div>
                            </div>
                          </div>

                        </form>
                      <div id="respuesta_salida_2"></div>
                </div>
            </div>
        </div> 


        <?php $helpers->footer();?>

    </div>



    
</body>

<script type="text/javascript">
  
   
    $( "#fecha_entrada" ).datepicker({dateFormat: 'yy/mm/dd', changeMonth: true, changeYear: true, });

    $( "#fecha_nac_es" ).datepicker({dateFormat: 'yy/mm/dd', changeMonth: true, changeYear: true, });

</script>

</html>
