<?php
		session_start ();
		require("../conectar.php"); //conexion

    function CalculaEdad( $fecha ) 
    {
        list($Y,$m,$d) = explode("-",$fecha);
        return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
    }
   
    @$periodo = $_GET['periodo'];
    @$mes = $_GET['mes'];



    $sql_empresa = "select * from tbl_empresa order by id_empresa desc";

    $re_empresa = mysqli_query($link, $sql_empresa);

    $row_empresa = mysqli_fetch_array($re_empresa);

		header("Content-Type: application/vnd.ms-excel");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("content-disposition: attachment;filename=Nomina_mensual_".$mes.".xls");

?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <div class="row">
            <div class="col-lg-12" >
                <h3 > <?= $row_empresa['nombre_empresa'];?><BR> RIF. <?= $row_empresa['rif_empresa'];?></h3>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12" >
                <h3 align="center"> NOMINA DEL MES <?= $mes?></h3>
            </div>
        </div>

        <div class="table-responsive">
          <table class="table" border = "1">
        <?php

            $sql_ = "SELECT * FROM tbl_quincena, 
                                  tbl_personal, 
                                  tbl_deduccion 
                            where id_quincena=fk_quincena 
                              and id_personal=fk_personal_quincena  
                              and month(fecha_quincena) = '$mes'
                              and fk_periodo_quincena = '$periodo'";

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
                      <th colspan="9" align="center">DATOS PERSONALES</th>
                      <th colspan="19" align="center">ASIGNACIONES</th>
                      
                      <th colspan="5" align="center">DEDUCCIONES</th>
                      <th align="center">MONTO</th>
                  </tr>
                  <tr bgcolor="#F0F0F0">
                      <th>#</th>
                      <th>CÉDULA</th>
                      <th>APELLIDO Y NOMBRE</th>
                      <th>CARGO</th>
                      <th>TIPO</th>
                      <th>FECHA INGRESO</th>
                      <th>SALARIO FAOV</th>
                      <th>SUELDO BÁSICO</th>
                      <th>SUELDO DIARIO</th>
                      <th>DÍAS TRABAJO</th>
                      <th>ASIG. QUINC.</th>
                      <th>BONIFIC.</th>
                      <th>DÍAS CESTA TICKET</th>
                      <th>CESTA TICKET</th>
                      <th>DÍAS FERIADOS</th>
                      <th>FERIADOS</th>
                      <th>CANT. HORAS DIUR</th>
                      <th>H-EXTRAS DIUR</th>
                      <th>CANT. HORAS NOCT</th>
                      <th>H-EXTRAS NOCT</th>
                      <th>OTROS</th>
                      <th>DIAS VACAS</th>
                      <th>VACACIONES</th>
                      <th>DIAS BONO V.</th>
                      <th>BONO VACACIONAL</th>
                      <th>UTILIDADES</th>
                      <th>INTERES ANTIGUEDAD</th>
                      <th>ADELANTO ANTIGUEDAD</th>
                      <th>SEGURO SOC</th>
                      <th>FAOV</th>
                      <th>ADEL. QUINC.</th>
                      <th>RET. IVA</th>
                      <th>TOTAL RET.</th>
                      <th>TOTAL A COBRAR</th>
                  </tr>
        <?php
                while($fila = mysqli_fetch_array($re))
                {
                  @$cont = $cont + 1;
                  $sueldo_diario = number_format($fila['monto_quincena']/$fila['dias_trabajados'], 2, '.', '');

                  @$conSueldo = $conSueldo + ($fila['monto_quincena'] / $fila['dias_trabajados'] * 30);
                  @$conQuin = $conQuin + $fila['monto_quincena'];
                  @$conBonif = $conBonif + $fila['bonificacion'];
                  @$conCesta = $conCesta + $fila['cesta_ticket'];
                  @$conFeria = $conFeria + $fila['feriados_trabajados'];
                  @$conHorDi = $conHorDi + $fila['h_extras_diur'];
                  @$conHorNoc = $conHorNoc + $fila['h_extras_noct'];
                  @$conOtros = $conOtros + $fila['otros_pagos'];
                  
                  @$conVacas = $conVacas + $fila['pago_vacaciones'];
                  @$conBonVaca = $conBonVaca + $fila['pago_bono_vacacional'];
                  @$conUtili = $conUtili + $fila['total_utilidades'];
                  @$conInteres = $conInteres + $fila['interes_anti'];
                  @$conAdelanto = $conAdelanto + $fila['adelanto_anti'];
                  @$conSeguro = $conSeguro + $fila['monto_seguro'];
                  @$conFaov = $conFaov + $fila['monto_faov'];
                  @$conAdelanto = $conAdelanto + $fila['prestamos'];
                  @$conIva = $conIva + $fila['ret_iva'];
                  @$total_ret = $fila['monto_seguro'] + $fila['monto_faov'] + $fila['prestamos'] + $fila['ret_iva'];
                  @$conRet = $conRet + $total_ret;

                  @$total_cobrar = ($fila['monto_quincena'] + $fila['interes_anti'] + $fila['adelanto_anti'] + $fila['pago_vacaciones'] + $fila['total_utilidades'] + $fila['pago_bono_vacacional'] + $fila['bonificacion'] + $fila['cesta_ticket'] + $fila['feriados_trabajados'] + $fila['h_extras_diur'] + $fila['h_extras_noct'] + $fila['otros_pagos'] ) - $total_ret;
                  @$conCobrar = $conCobrar + $total_cobrar;

                  $anos_servicio = CalculaEdad($fila['fecha_ingreso_personal']);

                  $dias_base = 15;
                  $dias_adicionales = ($anos_servicio - 1) * 2;
                  
                  $dias_adicionales_ = $dias_base + $dias_adicionales;

                  $alic_vac = ($sueldo_diario * $dias_adicionales_) / 360;
                  $alic_util = ($sueldo_diario * 30) / 360;
                  

        ?>
                  <tr <?php if($cont%2){ echo "bgcolor= ''";}?> >
                      <td><?= $cont;?></td>
                      <td><?= $fila['cedula_personal'];?></td>
                      <td><?= $fila['apellido_personal']." ".$fila['nombre_personal'];?></td>
                      <td><?= $fila['cargo_personal'];?></td>
                      <td><?= $fila['tipo_personal'];?></td>
                      <td><?= $fila['fecha_ingreso_personal'];?></td>
                      <td align="center"><?= number_format(($sueldo_diario + $alic_vac + $alic_util) * 30, 2, '.', '');?></td>
                      <td bdcolor="#F0F0F0" align="center"><?= $sueldo_diario * 30;?></td>
                      <td align="center"><?= $sueldo_diario;?></td>
                      <td align="center"><?= $fila['dias_trabajados'];?></td>
                      <td align="center"><?= number_format($fila['monto_quincena'], 2, '.', '');?></td>
                      <td align="center"><?= number_format($fila['bonificacion'], 2, '.', '');?></td>
                      <td align="center"><?= $fila['cant_dias_cesta_ticket'];?></td>
                      <td align="center"><?= number_format($fila['cesta_ticket'], 2, '.', '');?></td>
                      <td align="center"><?= $fila['cant_dias_feriados'];?></td>
                      <td align="center"><?= number_format($fila['feriados_trabajados'], 2, '.', '');?></td>
                      <td align="center"><?= $fila['cant_horas_extras_d'];?></td>
                      <td align="center"><?= number_format($fila['h_extras_diur'], 2, '.', '');?></td>
                      <td align="center"><?= $fila['cant_horas_extras_n'];?></td>
                      <td align="center"><?= number_format($fila['h_extras_noct'], 2, '.', '');?></td>
                      <td align="center"><?= number_format($fila['otros_pagos'], 2, '.', '');?></td>
                      <td align="center"><?= $fila['dias_vacas'];?></td>
                      <td align="center"><?= number_format($fila['pago_vacaciones'], 2, '.', '');?></td>
                      <td align="center"><?= $fila['dias_bono_vacas'];?></td>
                      <td align="center"><?= number_format($fila['pago_bono_vacacional'], 2, '.', '');?></td>
                      <td align="center"><?= number_format($fila['total_utilidades'], 2, '.', '');?></td>
                      <td align="center"><?= number_format($fila['interes_anti'], 2, '.', '');?></td>
                      <td align="center"><?= number_format($fila['adelanto_anti'], 2, '.', '');?></td>
                      <td align="center"><?= number_format($fila['monto_seguro'], 2, '.', '');?></td>
                      <td align="center"><?= number_format($fila['monto_faov'], 2, '.', '');?></td>
                      <td align="center"><?= number_format($fila['prestamos'], 2, '.', '');?></td>
                      <td align="center"><?= number_format($fila['ret_iva'], 2, '.', '');?></td>
                      <td align="center"><?php $total_ret = $fila['monto_seguro'] + $fila['monto_faov'] + $fila['prestamos'] + $fila['ret_iva']; echo number_format($total_ret, 2, '.', '')?></td>
                      <td align="center"><?php $total_cobrar = ($fila['monto_quincena'] + $fila['bonificacion'] + $fila['cesta_ticket'] + $fila['feriados_trabajados'] + $fila['h_extras_diur'] + $fila['h_extras_noct'] + $fila['otros_pagos'] + $fila['pago_vacaciones'] + $fila['pago_bono_vacacional'] + $fila['interes_anti'] + $fila['adelanto_anti'] + $fila['total_utilidades']  ) - $total_ret; echo number_format($total_cobrar, 2, '.', '')?></td>
                  </tr>

        <?php
                  if($cont == 27)
                  {
                    // break;
                  }
                }
        ?>
                <tr bgcolor="#F0F0F0">
                      <th colspan="7" align="right"> TOTALES </th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th><?= number_format($conQuin, 2, '.', '');  ?></th>
                      <th><?= number_format($conBonif, 2, '.', ''); ?></th>
                      <th></th>
                      <th><?= number_format($conCesta, 2, '.', ''); ?></th>
                      <th></th>
                      <th><?= number_format($conFeria, 2, '.', ''); ?></th>
                      <th></th>
                      <th><?= number_format($conHorDi, 2, '.', ''); ?></th>
                      <th></th>
                      <th><?= number_format($conHorNoc, 2, '.', ''); ?></th>
                      <th><?= number_format($conOtros, 2, '.', ''); ?></th>
                      <th></th>
                      <th><?= number_format($conVacas, 2, '.', ''); ?></th>
                      <th></th>
                      <th><?= number_format($conBonVaca, 2, '.', ''); ?></th>
                      <th><?= number_format($conUtili, 2, '.', ''); ?></th>
                      <th><?= number_format($conInteres, 2, '.', ''); ?></th>
                      <th><?= number_format($conAdelanto, 2, '.', ''); ?></th>
                      <th><?= number_format($conSeguro, 2, '.', ''); ?></th>
                      <th><?= number_format($conFaov, 2, '.', ''); ?></th>
                      <th><?= number_format($conAdelanto, 2, '.', ''); ?></th>
                      <th><?= number_format($conIva, 2, '.', ''); ?></th>
                      <th><?= number_format($conRet, 2, '.', ''); ?></th>
                      <th><?= number_format($conCobrar, 2, '.', ''); ?></th>
                  </tr>
        <?php
            }
        ?>
          </table>
        </div>