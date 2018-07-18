<?php
    session_start();
    require('helpers.php');
    require('conectar.php');

     @$id_personal = $_GET['id'];

     $sql_personal = "SELECT * FROM tbl_personal where id_personal = $id_personal";

     $re_personal=mysqli_query($link, $sql_personal);  

     $fila_ = mysqli_fetch_array($re_personal);

     list($Y,$m,$d) = explode("-",$fila_['fecha_ingreso_personal']);

     $primer = array('11','12','1');
     $segundo = array('2','3','4');
     $tercer = array('5','6','7');
     $cuarto = array('8','9','10');

     $arreglo = array();

     @$ant_acumulada = $_GET['monto_antiguedad'];
     @$sum_intereses = $_GET['monto_interes'];
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
                <h3> Prestaciones Social: <?= $fila_['apellido_personal']." ".$fila_['nombre_personal']?></h3>
            </div>
        </div>
           
        <br>
            <div class="form-group" align="center">
              <label style="margin-top:8px" class="col-md-2 control-label" > Ant. Acumulada </label>
                    <div class="col-md-2 " align="center">
                      <input title="Monto de la última antigüedad acumulada" class="form-control" type="text" value="<?= $ant_acumulada; ?>" id="buscador" placeholder="Ingrese Monto de Última Antigüedad Mensual Acumulada">
                    </div>

              <label style="margin-top:8px" class="col-md-2 control-label"> Interés Acumulado </label>
                    <div class="col-md-2">
                        <input title="Monto de la sumatoria de intereses acumulados" class="form-control" type="text" value="<?= $sum_intereses ?>" id="buscador_" placeholder="Ingrese Monto de Sumatoria de Interéses">
                    </div>  
                    <div style="margin-top:-15px" class="col-md-2">
                        <a onclick="antiguedad_acumulada(<?= $id_personal;?>)" class=" btn btn-xs btn-primary">Aplicar</a>
                    </div> 
                
            </div>
        
<?php

          $sql_personal = "SELECT month(fecha_quincena) as mes, 
                                  id_quincena,
                                  (monto_quincena/dias_trabajados)*30 as sueldo_mensual, 
                                  (monto_quincena/dias_trabajados) as sueldo_diario
                                  
                                  
                             FROM 
                                  `tbl_quincena`
                             
                             where 
                                    fk_personal_quincena = $id_personal group by 1 order by id_quincena asc";

          $re_personal=mysqli_query($link, $sql_personal);  

          
?>

          <table class="table table-bordered">
         
                <tr >
                  <th>Mes</th>
                  <th>Mensual Bs.</th>
                  <th>Diario Bs.</th>
                  <th>Alic. Vac.</th>
                  <th>Alic. Util.</th>
                  <th>Salario Integral</th>
                  <th>Dias Antigüedad</th>
                  <th>Antigüedad Mensual</th>
                  <th>Ant. Mensual Acum.</th>
                  <th>Tasa de Int.</th>
                  <th>Tasa Mensual</th>
                  <th>Interéses</th>
                </tr>
                
<?php
          while($fila = mysqli_fetch_array($re_personal))
          {
              @$conteo++;
              @$dias_base = 15;
              @$antiguedad = $helpers->CalculaEdad($fila_['fecha_ingreso_personal'] - 1) ;
              @$dias_vacaciones = $antiguedad + $dias_base;
              @$mes_operacion = $fila['mes'];
              @$mensual_bs = number_format($fila['sueldo_mensual'], 2, '.', '');
              @$sueldo_diario = number_format($fila['sueldo_diario'], 2, '.', '');
              @$alic_vac = number_format(($fila['sueldo_diario'] * $dias_vacaciones) /360, 2, '.', '');
              @$alic_util = number_format(($fila['sueldo_diario'] * 30) /360, 2, '.', '');
              @$salario_integral = number_format($fila['sueldo_diario'] + $alic_vac + $alic_util, 2, '.', '');

?>            
                <tr>
                   <!--<td><?= $dias_vacaciones;?></td>-->
                   <td><?= $mes_operacion; ?></td>
                   <td><?= $mensual_bs; ?></td>
                   <td><?= $sueldo_diario; ?></td>
                   <td><?= $alic_vac;?></td>
                   <td><?= $alic_util;?></td>
                   <td><?= $salario_integral;?></td>
                   <td><?php 
                              if($fila['mes'] == 1)
                              { 
                                  $primer_ = in_array($m, $primer);
                                  if($primer_ == true)
                                  {
                                      $dias_ant = $dias_base + ($antiguedad * 2);
                                      echo $dias_ant;
                                  }
                                  else
                                  {
                                      $dias_ant = $dias_base;
                                      echo $dias_ant;
                                  }
                              }
                              else if($fila['mes'] == 4)
                              { 
                                  $segundo_ = in_array($m, $segundo);
                                  if($segundo_ == true)
                                  {
                                      $dias_ant = $dias_base + ($antiguedad * 2);
                                      echo $dias_ant;
                                  }
                                  else
                                  {
                                      $dias_ant = $dias_base;
                                      echo $dias_ant;
                                  }
                              }
                              else if($fila['mes'] == 7)
                              { 
                                  $tercer_ = in_array($m, $tercer);
                                  if($tercer_ == true)
                                  {
                                      $dias_ant = $dias_base + ($antiguedad * 2);
                                      echo $dias_ant;
                                  }
                                  else
                                  {
                                      $dias_ant = $dias_base;
                                      echo $dias_ant;
                                  }
                              }
                              else if($fila['mes'] == 10)
                              { 
                                  $cuarto_ = in_array($m, $cuarto);
                                  if($cuarto_ == true)
                                  {
                                      $dias_ant = $dias_base + ($antiguedad * 2);
                                      echo $dias_ant;
                                  }
                                  else
                                  {
                                      $dias_ant = $dias_base;
                                      echo $dias_ant;
                                  }
                              }
                              else
                              {
                                     $dias_ant = 0;
                                     echo $dias_ant;
                              }
                        ?>
                   </td>
                   <td width="60px">
                       <?php 
                              if($fila['mes'] == 1)
                              { 
                                  $primer_ = in_array($m, $primer);
                                  if($primer_ == true)
                                  {
                                      $ant_mensual = ($dias_base + ($antiguedad * 2)) * $salario_integral;
                                      echo $ant_mensual;
                                  }
                                  else
                                  {
                                      $ant_mensual = $dias_base * $salario_integral;
                                      echo $ant_mensual;
                                  }
                              }
                              else if($fila['mes'] == 4)
                              { 
                                  $segundo_ = in_array($m, $segundo);
                                  if($segundo_ == true)
                                  {
                                      $ant_mensual = ($dias_base + ($antiguedad * 2)) * $salario_integral;
                                      echo $ant_mensual;
                                  }
                                  else
                                  {
                                      $ant_mensual = $dias_base * $salario_integral;
                                      echo $ant_mensual;
                                  }
                              }
                              else if($fila['mes'] == 7)
                              { 
                                  $tercer_ = in_array($m, $tercer);
                                  if($tercer_ == true)
                                  {
                                      $ant_mensual = ($dias_base + ($antiguedad * 2)) * $salario_integral;
                                      echo $ant_mensual;
                                  }
                                  else
                                  {
                                      $ant_mensual = $dias_base * $salario_integral;
                                      echo $ant_mensual;
                                  }
                              }
                              else if($fila['mes'] == 10)
                              { 
                                  $cuarto_ = in_array($m, $cuarto);
                                  if($cuarto_ == true)
                                  {
                                      $ant_mensual = ($dias_base + ($antiguedad * 2)) * $salario_integral;
                                      echo $ant_mensual;
                                  }
                                  else
                                  {
                                      $ant_mensual = $dias_base * $salario_integral;
                                      echo $ant_mensual;
                                  }
                              }
                              else
                              {
                                      $ant_mensual = 0;
                                      echo $ant_mensual;
                              }

                              $ant_acumulada = $ant_acumulada + $ant_mensual;
                        ?>
                    </td>
                    <td width="70px" >
                       <input class="form-control" type="text" id="ant_acumulada_<?= $conteo;?>" value="<?= $ant_acumulada;?>" disabled="disabled">
                    </td>
                    <td width="50px">
                       <input class="form-control" id="tasa_int_<?= $conteo;?>" onchange="calcular_interes('<?= $conteo;?>')"  type="text">
                    </td>
                    <td>
                        <div id="tasa_mensual_<?= $conteo; ?>"></div>
                    </td>
                    <td width="50px">
                        <div id="intereses<?= $conteo; ?>"></div>
                        <input type="hidden" id="sum_interes_<?= $conteo; ?>" value="<?= $sum_intereses?>">
                    </td>

                </tr>



<?php
              //Arreglo para guardar matriz de prestaciones
              $arreglo[$conteo] = array
              ( 
                  'mes' => $mes_operacion,
                  'mensual_bs' => $mensual_bs,
                  'sueldo_diario' => $sueldo_diario,
                  'alic_vac' => $alic_vac,
                  'alic_util' => $alic_util,
                  'salario_integral' => $salario_integral,
                  'dias_ant' => $dias_ant,
                  'ant_mensual' => $ant_mensual,
                  'ant_acumulada' => $ant_acumulada
              );
          
          } //Fin del While principal

          //echo json_encode($arreglo);
?>
          
          </table>
        

          <div class="row">
            <div class="form-group" align="center">
                <div  class="col-md-12">
                      <a onclick="calcular_total(<?= $conteo; ?>,'calculo_mostrar')" class="btn btn-xs btn-primary">Calcular</a>
                </div> 
            </div>
          </div>

          <!-- DIV QUE MUESTRA FORMULARIO PARA PRESTACIONES SOCIALES-->
        <div id="calculo_mostrar" class="ventana" title="Calculo de Prestaciones Sociales">
            <div class= "row" >
                <div class="col-md-12" >
                        <form id="form_personal" class="form-horizontal" role="form">
                          <div class="form-group">
                            <label class="col-md-2 control-label">Antigüedad: </label>
                            <div class="col-md-2">
                                <input type="text" title="Total Antigüedad del Empleado" disabled="disabled" class="form-control" autocomplete="off"  required  maxlength="10" id="total_antiguedad" >
                            </div>

                            <label  class="col-md-2 control-label">Interés: </label>
                            <div class="col-md-2">
                                <input type="text" title="Total Interés del Empleado" disabled="disabled" class="form-control" autocomplete="off"  required maxlength="10"  id="interes_antiguedad" >
                            </div>

                            <label  class="col-md-2 control-label">Total Bs: </label>
                            <div class="col-md-2">
                              <input type="text" title="Total Antigüedad más Interés del Empleado" disabled="disabled" class="form-control" autocomplete="off"  required maxlength="10"  id="total_" >
                            </div>
                          </div>

                          <hr>

                          <div class="form-group">
                          <label  class="col-md-2 control-label">Utilidades</label>
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
          </header>


        <?php $helpers->footer();?>

    </div>



    
</body>


</html>
