<?php
    session_start();
    require('helpers.php');
    require('conectar.php');

    @$buscador = '';

    if(!empty($_GET['id']))
    {
       $var = $_GET['id'];
       $campo = $_GET['campo'];

       $buscador = "where $campo like '%$var%' ";
    }

    $_pagi_sql  = "select * from tbl_sujeto_retenido ".$buscador." order by id_sujeto_retenido desc";
    
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
                <h3> Retención de IVA </h3>
            </div>
        </div>
           <div class="input-group" align="center">
                <input class="form-control" type="text"  id="buscador" placeholder="Ingrese Datos para Consultar">
                <span class="input-group-addon" ><span class="mdi-notification-sync" ></span></span>
                <select  class="form-control" id="var_busqueda" onchange="consulta('tpl_retencion_iva')" >
                        <option value="">--Seleccione--</option>
                        <option value="rif_sujeto">Rif</option>
                        <option value="nombre_sujeto">Nombre</option>
                        <option value="direccion_sujeto">Dirección</option>
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
                  <th>Nombre</th>
                  <th >Dirección</th>
                  <th>
                      <div style="margin-top: -5px" class="btn-group">
                          <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="modal('agregar')">Agregar</a>
                      </div>
                  </th>
                </tr>
        <?php
                while($fila = mysqli_fetch_array($_pagi_result))
                {
  
        ?>
                <tr>
                  <td><?= $fila['id_sujeto_retenido'];?></td>
                  <td><?= $fila['rif_sujeto'];?></td>
                  <td><?= $fila['nombre_sujeto'];?></td>
                  <td><?= $fila['direccion_sujeto'];?></td>
                  <td>
                      <div class="btn-group" style="margin-top: -5px" >
                        <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
                          Opciones <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">

                                <li><a target="_blank" href="reporte/retencion_blanco.pdf" >Comprobante en Blanco</a>
                                </li>
                            
                                <li><a href="#" onclick="modal_sujeto_iva('editar',
                                                                          '<?= $fila['id_sujeto_retenido'];?>',
                                                                          '<?= $fila['rif_sujeto'];?>',
                                                                          '<?= $fila['nombre_sujeto'];?>',
                                                                          '<?= $fila['direccion_sujeto'];?>')" >Editar</a>
                                </li>

                                
                                <li><a href="#" id="<?= $fila['id_sujeto_retenido'];?>" onclick="modal_retencion_iva('retencion',
                                                                                                                     '<?= $fila['id_sujeto_retenido'];?>',
                                                                                                                     '<?= $fila['nombre_sujeto'];?>',
                                                                                                                     '<?= $fila['rif_sujeto'];?>')">Cargar Retención</a></li>
                                <li><a href="#" id="<?= $fila['id_sujeto_retenido'];?>" onclick="modal_view_retencion_iva('view_retencion',
                                                                                                                     '<?= $fila['id_sujeto_retenido'];?>',
                                                                                                                     '<?= $fila['nombre_sujeto'];?>')">Retenciones</a></li>
                                
                           
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
        <div id="agregar" class="ventana" title="Registro de Sujeto Retenido">
            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_personal" class="form-horizontal" role="form">
                          <div class="form-group">

                            <label  class="col-md-5 control-label">R.I.F</label>
                            <div class="col-md-5">
                              <input type="text" class="form-control" autocomplete="off"  required maxlength="10"  id="rif_sujeto" placeholder="J221113334" >
                            </div>
                          </div>

                          <div class="form-group">
                          <label  class="col-md-5 control-label">Nombre o Razón Social</label>
                            <div class="col-md-5" align="center">
                              <input type="text" class="form-control" autocomplete="off"   required maxlength="100"  id="nombre_sujeto" >
                            </div>
                          </div>

                          <div class="form-group">
                          <label  class="col-md-5 control-label">Dirección</label>
                            <div class="col-md-5" align="center">
                              <input type="text" class="form-control" autocomplete="off"  required  id="direccion_sujeto" >
                            </div>
                          </div>


                          <div class="form-group">
                            <div class="col-sm-12" align="center">
                              <div id="enviar_personal"><a href="#" onclick="agregar_sujeto_ret()" class="btn btn-default">Enviar</a></div>
                            </div>
                          </div>

                        </form>
                      <div id="respuesta_sujeto"></div>
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
                              <input type="hidden" id="ed_id_sujeto">  

                            <label  class="col-md-5 control-label">R.I.F: </label>
                            <div class="col-md-5">
                              <input type="text" class="form-control"  required disabled="disabled" maxlength="10"  id="ed_rif_sujeto" >
                            </div>
                          </div>

                          <div class="form-group">
                          <label  class="col-md-5 control-label">Nombre: </label>
                            <div class="col-md-5" align="center">
                              <input type="text" class="form-control"  required maxlength="100"  id="ed_nombre_sujeto" >
                            </div>
                          </div>

                          <div class="form-group">
                          <label  class="col-md-5 control-label">Dirección: </label>
                            <div class="col-md-5" align="center">
                              <input type="text" class="form-control" autocomplete="off"  required maxlength="100"  id="ed_direccion_sujeto" >
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="col-sm-12" align="center">
                              <div id="editar_personal_" ><a href="#"  onclick="editar_sujeto()" class="btn btn-default">Enviar</a></div>
                            </div>
                          </div>

                        </form>
                      <div id="respuesta_editar_sujeto"></div>
                </div>
            </div>
        </div> 

        <?php
               $re_n = mysqli_query($link, "select n_comprobante_iva from tbl_retencion_iva order by n_comprobante_iva desc limit 1");
               $fila_n= mysqli_fetch_array($re_n);
        ?>

         <!-- DIV QUE MUESTRA FORMULARIO PARA AGREGAR NUEVO COMPROBANTE-->
        <div id="retencion" class="ventana" title="Registro de Retención IVA">
            <header class="jumbotron hero-spacer">
            <div class="row" style="margin-bottom: 20px">
              <div class="col-lg-12" >
                  <center><h3><b> Ficha de Retención de IVA &nbsp&nbsp&nbsp Ultimo Comprobante: <?= $fila_n['n_comprobante_iva'];?></b></h3></center>
              </div>
            </div>

            
            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_retencion" class="form-horizontal" role="form">
                          
                          <div class="form-group">

                            <label  class="col-md-2 control-label" > Comprobante: </label>
                              <div class="col-md-2 " align="center">
                                <input type="text" class="form-control"  autocomplete="off" maxlength="14" value="<?= date('Y')."".date('m')."00000000"?>" id="n_comprobante" >
                              </div>

                            <label class="col-md-2 control-label">Fecha Emisión: </label>
                              <div class="col-md-2">
                                 <input type="text" class="form-control" autocomplete="off" maxlength="10"  id="fecha_emision" >
                                 <input type="hidden" class="form-control"  required disabled="disabled"   id="id_sujeto_ret" >
                                 <input type="hidden" class="form-control"  required disabled="disabled"   id="control_iva" >
                              </div>

                            <label class="col-md-1 control-label">Año: </label>
                              <div class="col-md-1">
                                 <input type="text" class="form-control" autocomplete="off" maxlength="4" value="<?= date('Y')?>" id="ano_retencion_iva" >
                              </div>

                            <label  class="col-md-1 control-label">Mes: </label>
                              <div class="col-md-1" align="center">
                                <input type="text" class="form-control"  autocomplete="off" maxlength="2" value="<?= date('m')?>" id="mes_retencion_iva" >
                              </div>

                          </div>

                          <div class="form-group">
                          
                            <label  class="col-md-2 control-label" >Nombre: </label>
                              <div class="col-md-6" align="center">
                                <input type="text" class="form-control" maxlength="100"  autocomplete="off"  id="nombre_sujeto_ret" >
                              </div>

                            <label  class="col-md-2 control-label">RIF Sujeto: </label>
                              <div class="col-md-2" align="center">
                                <input type="text" class="form-control"  maxlength="10" autocomplete="off"   id="rif_sujeto_ret" >
                              </div>
                          
                          </div>

                          <table class="table table-hover" id="tabla_iva">
         
                            <tr>
                              <th align="center">Nº Op.</th>
                              <th align="center">Fecha Fact.</th>
                              <th align="center">Nº Fact</th>
                              <th align="center">Nº Ctrl.</th>
                              <th align="center">Nº Déb.</th>
                              <th align="center">Nº Cré.</th>
                              <th align="center">T. Trans.</th>
                              <th align="center">Fact. Afect</th>
                              <th align="center">Total C. Iva</th>
                              <th align="center">Total C. Exent.</th>
                              <th align="center">Base Impon.</th>
                              <th align="center">Alic.</th>
                              <th align="center">IVA</th>
                              <th align="center">IVA Ret.</th>
                            </tr>
                          </table>

                          <table class="table table-hover" id="tabla_2">
                            <tr>
                              <th align="center">Nº Op.</th>
                              <th align="center">Fecha Fact.</th>
                              <th align="center">Nº Fact</th>
                              <th align="center">Nº Ctrl.</th>
                              <th align="center">Nº Déb.</th>
                              <th align="center">Nº Cré.</th>
                              <th align="center">T. Trans.</th>
                              <th align="center">Fact. Afect</th>
                              <th align="center">Total C. Iva</th>
                              <th align="center">Porcent.</th>
                              <th align="center">Total C. Exent.</th>
                              <th align="center">Base Impon.</th>
                              <th align="center">Alic.</th>
                              <th align="center">IVA</th>
                              <th align="center">IVA Ret.</th>
                            </tr>
                          <tr>
                            <td>
                                <input type="text" id="n_operacion" class="form-control"  autocomplete="off" maxlength="2" >
                            </td>
                            <td>
                                <input type="text" id="fecha_factura" class="form-control"  autocomplete="off" maxlength="10" >
                            </td>
                            <td>
                                <input type="text" id="n_factura" class="form-control"  autocomplete="off" maxlength="8" >
                            </td>
                            <td>
                                <input type="text" id="n_control" class="form-control"  autocomplete="off" maxlength="12" >
                            </td>
                            <td>
                                <input type="text" id="n_debito" class="form-control"  autocomplete="off" maxlength="12" >
                            </td>
                            <td>
                                <input type="text" id="n_credito" class="form-control"  autocomplete="off" maxlength="12" >
                            </td>
                            <td>
                                <input type="text" id="tipo_trans" class="form-control"  autocomplete="off" maxlength="12" >
                            </td>
                            <td>
                                <input type="text" id="n_fact_afect" class="form-control"  autocomplete="off" maxlength="12" >
                            </td>
                            <td>
                                <input type="text" id="tota_iva"  class="form-control"  autocomplete="off" maxlength="14" >
                            </td>
                            <td>
                                <input type="text" id="porcentaje" onkeyup="calcular_ret()" class="form-control"  autocomplete="off" maxlength="14" >
                            </td>
                            <td>
                                <input type="text" id="total_exc" class="form-control"  autocomplete="off" maxlength="14" >
                            </td>
                            <td>
                                <input type="text" id="base_imponible" class="form-control"  autocomplete="off" maxlength="14" >
                            </td>
                            <td>
                                <input type="text" id="alicuota" class="form-control"  autocomplete="off" maxlength="14" >
                            </td>
                            <td>
                                <input type="text" id="iva" class="form-control"  autocomplete="off" maxlength="14" >
                            </td>
                            <td>
                                <input type="text" id="iva_ret" class="form-control"  autocomplete="off" maxlength="14" >
                            </td>
                          </tr>
                  
                    </table>

                          <div class="form-group">
                            <div class="col-sm-6" align="center">
                              <div id="retencion_personal">  <a  onclick="agregar_operacion()" class="btn btn-primary">Agregar</a></div>
                            </div>
                            <div class="col-sm-6" align="center">
                              <div id="retencion_personal_" style="display: none;"> <a  onclick="enviar_retencion_iva()" class="btn btn-primary">Generar Recibo</a></div>
                            </div>
                          </div>

                        </form>
                      <div id="respuesta_operacion"></div>
                </div>
            </div>
          </header>
        </div>  

        <!-- DIV QUE MUESTRA FORMULARIO PARA MOSTRAR RETENCIONES DE UN SUJETO-->
        <div id="view_retencion" class="ventana" title="Mostrar Retenciones">
            <div id="contenido_mostrar">
                
            </div>
        </div>    
       
        <?php $helpers->footer();?>

    </div>



    
</body>

<script type="text/javascript">
  
   
    $( "#fecha" ).datepicker({dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true});

    $( "#fecha_factura" ).datepicker({dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true});

    $( "#fecha_emision" ).datepicker({dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true});


</script>

</html>
