<?php
		session_start ();
		require("../conectar.php"); //conexion

    function CalculaEdad( $fecha ) 
    {
        list($Y,$m,$d) = explode("-",$fecha);
        return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
    }


    $periodo = $_GET['periodo'];


		header("Content-Type: application/vnd.ms-excel");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("content-disposition: attachment;filename=Lista_Personal.xls");

?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <div class="row">
            <div class="col-lg-12" >
                <h3 > INVERSIONES FRIMECAR, C.A <BR> RIF. J-29807443-4
                </h3>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12" >
                <h4 align="center"> NOMINA GENERAL </h3>
            </div>
        </div>

        <div class="table-responsive">
          <table class="table">
        <?php

           $re=mysqli_query($link, "select * from tbl_personal where estatus_personal = 1  ");	
            if(mysqli_num_rows($re) == 0)
            {
        ?>
                  <tr>
                    <div class="alert alert-danger" align="center" role="alert">No existen registros</div>
                  </tr>
        <?php
            }
            else
            {
        ?> 
                  <tr bgcolor="#00BCD4">
                      <th>#</th>
                      <th>Cédula</th>
                      <th>R.I.F</th>
                      <th>Apellido y Nombre</th>
                      <th>Cargo</th>
                      <th>Tipo</th>
                      <th>Fecha Ingreso</th>
                      <th>Años de Servicio</th>
                      <th>Sueldo Básico</th>
                      <th>Sueldo Diario</th>
                      <th>Semana Cotización IVSS</th>
                      <th>Salario Integral FAOV</th>
                      <th>Días Vacaciones</th>
                      <th>Vacaciones Colectivas</th>
                      <th>Diferecia de Vacaciones</th>
                  </tr>
        <?php
                while($fila = mysqli_fetch_array($re))
                {
                  @$cont = $cont + 1;
                  $dias_vacaciones = CalculaEdad($fila['fecha_ingreso_personal']) + 15;
                  $sueldo_diario = number_format($fila['sueldo_basico_personal']/30, 2, '.', '');
                  $vacaciones = number_format($sueldo_diario*$dias_vacaciones, 2, '.', '');
                  $fin_ano = number_format($sueldo_diario*30, 2, '.', '');
                  $semana_cot = ($sueldo_diario * 30) * 12 / 52;
                  $vacaciones_colectivas = 5;
                  $anos_servicio = CalculaEdad($fila['fecha_ingreso_personal']);

                  if($cont == 11)
                  {
                    $vacaciones_colectivas = 15;
                  }

                  $dias_base = 15;
                  $dias_adicionales = ($anos_servicio - 1) * 2;
                  
                  $dias_adicionales_ = $dias_base + $dias_adicionales;

                  $alic_vac = ($sueldo_diario * $dias_adicionales_) / 360;
                  $alic_util = ($sueldo_diario * 30) / 360;



        ?>
                  <tr <?php if($cont%2){ echo "bgcolor= ''";}?> >
                      <td><?= $cont;?></td>
                      <td><?= $fila['cedula_personal'];?></td>
                      <td><?= $fila['rif_personal'];?></td>
                      <td><?= $fila['apellido_personal']." ".$fila['nombre_personal'];?></td>
                      <td><?= $fila['cargo_personal'];?></td>
                      <td><?= $fila['tipo_personal'];?></td>
                      <td align="center"><?= $fila['fecha_ingreso_personal'];?></td>
                      <td align="center"><?= $anos_servicio?></td>
                      <td align="center"><?= $fila['sueldo_basico_personal'];?></td>
                      <td align="center"><?= $sueldo_diario;?></td>
                      <td align="center"><?= number_format($semana_cot, 2, '.', '');?></td>
                      <td align="center"><?= number_format(($sueldo_diario + $alic_vac + $alic_util) * 30, 2, '.', '');?></td>
                      <td align="center"><?= $dias_vacaciones;?></td>
                      <td align="center"><?= $vacaciones_colectivas;?></td>
                      <td align="center"><?= $total_ = $dias_vacaciones - $vacaciones_colectivas; ?></td>
                  </tr>
        <?php
                }
            }
        ?>
          </table>
        </div>