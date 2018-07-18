<?php
    session_start ();
    require("../conectar.php"); //conexion

   
    @$periodo = $_GET['periodo'];
    @$mes = $_GET['mes'];

    $sql_empresa = "select * from tbl_empresa order by id_empresa desc";

    $re_empresa = mysqli_query($link, $sql_empresa);

    $row_empresa = mysqli_fetch_array($re_empresa);

    header("Content-Type: application/vnd.ms-excel");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("content-disposition: attachment;filename=aporte_parafiscal_".$mes.".xls");

?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <div class="row">
            <div class="col-lg-12" >
                <h3 > <?= $row_empresa['nombre_empresa'];?><BR> RIF. <?= $row_empresa['rif_empresa'];?></h3>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12" >
                <h3 align="center"> NOMINA DEL MES <?= $mes?> </h3>
            </div>
        </div>

        <div class="table-responsive">
          <table class="table" border = "1">
        <?php

            $sql_ = "SELECT  
                            id_quincena,
                            cedula_personal,
                            apellido_personal,
                            nombre_personal,
                            cargo_personal,
                            tipo_personal,
                            sum(monto_quincena) as monto_quincena,
                            sum(dias_trabajados) as dias_trabajados,
                            sum(cesta_ticket) as cesta_ticket,
                            cant_dias_cesta_ticket,
                            sum(monto_seguro) as monto_seguro,
                            sum(monto_faov) as monto_faov
                            
                            FROM tbl_quincena, 
                                                      tbl_personal,
                                                      tbl_deduccion 
                                                where id_quincena=fk_quincena 
                                                  and id_personal=fk_personal_quincena  
                                                  and month(fecha_quincena) = '$mes'
                                                  and fk_periodo_quincena = '$periodo' group by cedula_personal order by id_quincena asc";

            $re=mysqli_query($link, $sql_); 

            if(mysqli_num_rows($re) == 0)
            {
        ?>
                  <tr>
                    <td align="center" colspan="18" ><b>NO EXISTEN REGISTROS</b></td>
                  </tr>
        <?php
            }
            else
            {
        ?> 
                  <tr bgcolor="#F0F0F0">
                      <th colspan="8" align="center">DATOS PERSONALES</th>
                      
                      <th colspan="3" align="center">APORTES TRABAJADOR</th>
                      <th colspan="4" align="center">APORTES PATRONALES</th>
                      <th align="center">MONTO</th>
                  </tr>
                  <tr bgcolor="#F0F0F0">
                      <th>#</th>
                      <th>CÉDULA</th>
                      <th>APELLIDO Y NOMBRE</th>
                      <th>CARGO</th>
                      <th>TIPO</th>
                      <th>SUELDO DIARIO</th>
                      <th>SUELDO QUINCENAL</th>
                      <th>CESTA TICKET</th>
                      <th>SEGURO SOC</th>
                      <th>FAOV</th>
                      <th>TOTAL APORTE TRABAJADOR.</th>
                      <th>SEGURO SOC</th>
                      <th>FAOV</th>
                      <th>INCES</th>
                      <th>TOTAL APORTE PATRONAL</th>
                      <th>TOTAL APORTES</th>
                  </tr>
        <?php
                while($fila = mysqli_fetch_array($re))
                {
                  @$cont = $cont + 1;
                  $sueldo_diario = number_format($fila['monto_quincena']/$fila['dias_trabajados'], 2, '.', '');
                  @$cesta_diario = $fila['cesta_ticket'] / $fila['cant_dias_cesta_ticket'];

                  @$conSueldo = $conSueldo + ($fila['monto_quincena'] / $fila['dias_trabajados'] * 30);
                  @$conQuin = $conQuin + $fila['monto_quincena'];
                  @$conSeguro = $conSeguro + $fila['monto_seguro'];
                  @$conFaov = $conFaov + $fila['monto_faov'];
                  @$total_ret = $fila['monto_seguro'] + $fila['monto_faov'];
                  @$conRet = $conRet + $total_ret;

                  @$total_cobrar = ($fila['monto_quincena'] + $fila['bonificacion'] + $fila['cesta_ticket'] + $fila['feriados_trabajados'] + $fila['h_extras_diur'] + $fila['h_extras_noct'] + $fila['otros_pagos'] ) - $total_ret;
                  @$conCobrar = $conCobrar + $total_cobrar;

                  $semana_cot = ($sueldo_diario * 30) * 12 / 52;
        ?>
                  <tr <?php if($cont%2){ echo "bgcolor= ''";}?> >
                      <td><?= $cont;?></td>
                      <td><?= $fila['cedula_personal'];?></td>
                      <td><?= $fila['apellido_personal']." ".$fila['nombre_personal'];?></td>
                      <td><?= $fila['cargo_personal'];?></td>
                      <td><?= $fila['tipo_personal'];?></td>
                      <td align="center"><?= $sueldo_diario;?></td>
                      <td bdcolor="#F0F0F0" align="center"><?= $quincena = $sueldo_diario * $fila['dias_trabajados'];?></td>
                      <td align="center"><?= number_format($cesta = $fila['cesta_ticket'], 2, '.', ''); ?></td>
                      <td align="center"><?= number_format($fila['monto_seguro'], 2, '.', '');?></td>
                      <td align="center"><?= number_format($fila['monto_faov'], 2, '.', '');?></td>
                      <td align="center"><?php $total_ret = $fila['monto_seguro'] + $fila['monto_faov']; echo number_format($total_ret, 2, '.', '')?></td>
                      <td align="center"><?php $aporte_sso = ($semana_cot * 0.14) * 4  ; echo number_format($aporte_sso, 2, '.', '')?></td>
                      <td align="center"><?php $aporte_faov = (($sueldo_diario * 30) / 4) * 0.02  ; echo number_format($aporte_faov, 2, '.', '')?></td>
                      <td align="center"><?php $aporte_ince = (($sueldo_diario * 30) / 4) * 0.02  ; echo number_format($aporte_ince, 2, '.', '')?></td>
                      <td align="center"><?php $total_aportes = $aporte_sso + $aporte_faov + $aporte_ince ; echo number_format($total_aportes, 2, '.', '')?></td>
                      <td align="center"><?php $total_ambos = $total_aportes + $cesta + $quincena ; echo number_format($total_ambos, 2, '.', '')?></td>
                      
                      </tr>


        <?php
                      @$con_aporte_ss = $con_aporte_ss + $aporte_sso;
                      @$con_aporte_faov = $con_aporte_faov + $aporte_faov;
                      @$con_aporte_ince = $con_aporte_ince + $aporte_ince;
                      @$con_aporte_aportes = $con_aporte_aportes + $total_aportes;
                      @$con_aporte_ambos = $con_aporte_ambos + $total_ambos;
                      @$con_quincena = $con_quincena + $quincena;
                      @$con_cesta = $con_cesta + $cesta;
                }
        ?>
                <tr bgcolor="#F0F0F0">
                      <th colspan="5" align="right"> TOTALES </th>
                      <th></th>
                      <th><?= number_format($con_quincena, 2, '.', ''); ?></th>
                      <th><?= number_format($con_cesta, 2, '.', ''); ?></th>
                      <th><?= number_format($conSeguro, 2, '.', ''); ?></th>
                      <th><?= number_format($conFaov, 2, '.', ''); ?></th>
                      <th><?= number_format($conRet, 2, '.', ''); ?></th>
                      <th><?= number_format($con_aporte_ss, 2, '.', ''); ?></th>
                      <th><?= number_format($con_aporte_faov, 2, '.', ''); ?></th>
                      <th><?= number_format($con_aporte_ince, 2, '.', ''); ?></th>
                      <th><?= number_format($con_aporte_aportes, 2, '.', ''); ?></th>
                      <th><?= number_format($con_aporte_ambos, 2, '.', ''); ?></th>
                  </tr>
        <?php
            }
        ?>
          </table>
        </div>