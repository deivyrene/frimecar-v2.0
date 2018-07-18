<?php
		session_start ();
		require("../conectar.php"); //conexion

    $descripcion = $_GET['descripcion'];
    $periodo = explode('-', $_GET['periodo']);
   
    $id_periodo = $periodo['0'];
    $ano_periodo = $periodo['1'];

    $mes = explode('-', $_GET['mes']);

    $mes_1 = $mes['0'];
    $mes_2 = $mes['1'];
    $mes_ant = $mes_1;

    $sql_empresa = "select * from tbl_empresa order by id_empresa desc";

    $re_empresa = mysqli_query($link, $sql_empresa);

    $row_empresa = mysqli_fetch_array($re_empresa);


    $sql_ = " SELECT 
                      id_entrada, 
                      item_entrada,
                      descripcion_entrada,
                      cantidad_vaca_entrada,
                      cantidad_toro_entrada,
                      total_entrada, 
                      fecha_entrada,
                      retiros_entrada, 
                      auto_consumo_entrada,
                      valor_bs,
                      cant_vaca_salida_aya+cant_toro_salida_aya as total_pyh,
                      cant_vaca_salida_paez+cant_toro_salida_paez as total_paez,
                      total_salida,
                      inventario_actual,
                      valor_ant_salida,
                      total_entrada-total_salida-auto_consumo_entrada-retiros_entrada as total_inventario,
                      id_salida,
                      fk_periodo
              FROM 
                      tbl_entrada_diario ed 
          left join 
                      tbl_salida_diario sd 
                on 
                      ed.id_entrada=sd.fk_entrada 
              where 
                      descripcion_entrada = '$descripcion'
                and   fk_periodo = $id_periodo
                and   month(fecha_entrada) = '$mes_1'
            
                
                order by id_entrada asc";

    @$cant_mes_ant = "";

    if($descripcion == "CUEROS")
    {
       $sql__ = "SELECT SUM(inventario_anterior + total_entrada - total_salida) as cantidad, sum(inventario_actual) as cant_ant, total_entrada from tbl_entrada_diario ed left join tbl_salida_diario sd on ed.id_entrada=sd.fk_entrada where ed.descripcion_entrada = '$descripcion'
                                                        and fk_periodo = $id_periodo 
                                                        and month(fecha_entrada) < '$mes_ant'";
       //echo $sql__;
       $re_sql__ = mysqli_query($link, $sql__);
       $fila__ = mysqli_fetch_array($re_sql__);

       if($mes_ant == 1 && $id_periodo == 5)
       {
          $cant_mes_ant = 279;
       }
       else
       {
          $cant_mes_ant = $fila__['cantidad'];
       }
       

    }
    else
    {
       $cant_mes_ant = 0;
    }

		header("Content-Type: application/vnd.ms-excel");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("content-disposition: attachment;filename=Rpt_Inventario_".$descripcion.".xls");

?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <div class="row">
            <div class="col-lg-12" >
                <h3 > &nbsp <BR> &nbsp  </h3>
            </div>
        </div>

        <table>
            <tr bgcolor="#F0F0F0">
                <th colspan="7" align="right">REGISTRO DETALLADO </th>
                <th colspan="6" align="left"> DE ENTRADA Y SALIDA DE <?= $descripcion; ?> </th>
            </tr>
            <tr bgcolor="#F0F0F0">
                <th colspan="7" align="right">MES:</th>
                <th colspan="6" align="left"><?= $mes_2; ?></th>
            </tr>
            <tr bgcolor="#F0F0F0">
                <th colspan="7" align="right">EJERCICIO GRAVABLE:</th>
                <th colspan="6" align="left"><?= $ano_periodo; ?></th>
            </tr>
            <tr bgcolor="#F0F0F0">
                <th colspan="7" align="right">RAZON SOCIAL:</th>
                <th colspan="6" align="left"><?= $row_empresa['nombre_empresa'];?></th>
            </tr>
            <tr bgcolor="#F0F0F0">
                <th colspan="7" align="right">RIF DEL CONTRIBUYENTE:</th>
                <th colspan="6" align="left"><?= $row_empresa['rif_empresa'];?></th>
            </tr>
        </table>


        <div class="table-responsive">
          <table class="table" border = "1">
        <?php

            $re=mysqli_query($link, $sql_);	

            if(mysqli_num_rows($re) == 0)
            {
        ?>
                  <tr>
                    <td align="center" colspan="12" ><b>NO EXISTEN REGISTROS </b></td>
                  </tr>
        <?php
            }
            else
            {
        ?> 
                  <tr bgcolor="#F0F0F0">
                      <th colspan="4" align="center"></th>
                      <th colspan="7" align="center">UNIDADES</th>
                      <th colspan="2" align="center">BOLIVARES</th>
                  </tr>
                  <tr bgcolor="#F0F0F0">
                      <th>#</th>
                      <th>FECHA</th>
                      <th>ITEM DEL INVENTARIO</th>
                      <th>DESCRIPCIÓN</th>
                      <th>TOTAL ENTRADA</th>
                      <th>SALIDAS PTO AYA</th>
                      <th>SALIDAS P/PTO PAEZ</th>
                      <th>RETIROS</th>
                      <th>AUTO-CONSUMOS</th>
                      <th>TOTAL SALIDA</th>
                      <th>EXISTENCIA ACTUAL</th>
                      <th>VALOR SALIDA BS.</th>
                      <th>SALIDAS</th>
                  </tr>
        <?php
                while($fila = mysqli_fetch_array($re))
                {
                  @$cont = $cont + 1;


                  @$total_entrada = $total_entrada + $fila['total_entrada'];
                  @$total_pyh = $total_pyh + $fila['total_pyh'];
                  @$total_paez = $total_paez + $fila['total_paez'];
                  @$total_retiros = $total_retiros + $fila['retiros_entrada'];
                  @$total_auto_consumo = $total_auto_consumo + $fila['auto_consumo_entrada'];
                  @$total_salida = $total_salida + $fila['total_salida'];
                  @$total_bs = $total_bs + ($fila['valor_ant_salida'] * $fila['total_salida']);
                  
                  if($cont == 6 || $cont == 11 || $cont == 16 || $cont == 21)
                  {
        ?>
                      <tr>
                        <td colspan="12"></td>
                      </tr>
                      <tr bgcolor="#F0F0F0">
                          <th colspan="4" align="center"></th>
                          <th colspan="7" align="center">UNIDADES</th>
                          <th colspan="2" align="center">BOLIVARES</th>
                      </tr>
                      <tr bgcolor="#F0F0F0">
                          <th>#</th>
                          <th>FECHA</th>
                          <th>ITEM DEL INVENTARIO</th>
                          <th>DESCRIPCIÓN</th>
                          <th>TOTAL ENTRADA</th>
                          <th>SALIDAS PTO AYA</th>
                          <th>SALIDAS P/PTO PAEZ</th>
                          <th>RETIROS</th>
                          <th>AUTO-CONSUMOS</th>
                          <th>TOTAL SALIDA</th>
                          <th>EXISTENCIA ACTUAL</th>
                          <th>VALOR SALIDA BS.</th>
                          <th>SALIDAS</th>
                      </tr>
        <?php
                  }
        ?>
                      <tr <?php if($cont%2){ echo "bgcolor= ''";}?> >
                          <td><?= $cont;?></td>
                          <td><?= $fila['fecha_entrada'];?></td>
                          <td><?= $fila['item_entrada'];?></td>
                          <td><?= $fila['descripcion_entrada'];?></td>
                          <td><?= $fila['total_entrada'];?></td>
                          <td><?= $fila['total_pyh']; ?></td>
                          <td><?= $fila['total_paez']; ?></td>
                          <td><?= $fila['retiros_entrada']; ?></td>
                          <td><?= $fila['auto_consumo_entrada']; ?></td>
                          <td><?= $fila['total_salida']; ?></td>
                          <td><?php if($cont == 1){ @$inv = ($inv + $fila['total_entrada'] + $cant_mes_ant) - $fila['total_salida'];}else{ @$inv = ($inv + $fila['total_entrada']) - $fila['total_salida'];  } if($inv < 0){ echo $inv = $fila['total_entrada'];}else{ echo $inv;}?></td>
                          <td align="right"><?= $fila['valor_ant_salida']; ?></td>
                          <td align="right"><?= number_format($fila['valor_ant_salida'] * $fila['total_salida'], 2, '.', ''); ?></td>
                      </tr>
        <?php
                  if($cont > 0 && $cont < 6)
                  {
                      @$total_entrada_0 = $total_entrada_0 + $fila['total_entrada'];
                      @$total_pyh_0 = $total_pyh_0 + $fila['total_pyh'];
                      @$total_paez_0 = $total_paez_0 + $fila['total_paez'];
                      @$total_retiros_0 = $total_retiros_0 + $fila['retiros_entrada'];
                      @$total_auto_consumo_0 = $total_auto_consumo_0 + $fila['auto_consumo_entrada'];
                      @$total_salida_0 = $total_salida_0 + $fila['total_salida'];
                      @$total_bs_0 = $total_bs_0 + ($fila['valor_ant_salida'] * $fila['total_salida']);
                  }
                  if($cont > 5 && $cont < 11)
                  {
                      @$total_entrada_1 = $total_entrada_1 + $fila['total_entrada'];
                      @$total_pyh_1 = $total_pyh_1 + $fila['total_pyh'];
                      @$total_paez_1 = $total_paez_1 + $fila['total_paez'];
                      @$total_retiros_1 = $total_retiros_1 + $fila['retiros_entrada'];
                      @$total_auto_consumo_1 = $total_auto_consumo_1 + $fila['auto_consumo_entrada'];
                      @$total_salida_1 = $total_salida_1 + $fila['total_salida'];
                      @$total_bs_1 = $total_bs_1 + ($fila['valor_ant_salida'] * $fila['total_salida']);
                  }
                  if($cont > 10 && $cont < 16)
                  {
                      @$total_entrada_2 = $total_entrada_2 + $fila['total_entrada'];
                      @$total_pyh_2 = $total_pyh_2 + $fila['total_pyh'];
                      @$total_paez_2 = $total_paez_2 + $fila['total_paez'];
                      @$total_retiros_2 = $total_retiros_2 + $fila['retiros_entrada'];
                      @$total_auto_consumo_2 = $total_auto_consumo_2 + $fila['auto_consumo_entrada'];
                      @$total_salida_2 = $total_salida_2 + $fila['total_salida'];
                      @$total_bs_2 = $total_bs_2 + ($fila['valor_ant_salida'] * $fila['total_salida']);
                  }
                  if($cont > 15 && $cont < 21)
                  {
                      @$total_entrada_3 = $total_entrada_3 + $fila['total_entrada'];
                      @$total_pyh_3 = $total_pyh_3 + $fila['total_pyh'];
                      @$total_paez_3 = $total_paez_3 + $fila['total_paez'];
                      @$total_retiros_3 = $total_retiros_3 + $fila['retiros_entrada'];
                      @$total_auto_consumo_3 = $total_auto_consumo_3 + $fila['auto_consumo_entrada'];
                      @$total_salida_3 = $total_salida_3 + $fila['total_salida'];
                      @$total_bs_3 = $total_bs_3 + ($fila['valor_ant_salida'] * $fila['total_salida']);
                  }

                  if($cont == 5)
                  {

        ?>
                       <tr bgcolor="#F0F0F0">
                            <th colspan="4" align="right"> TOTALES </th>
                            <td><b><?= $total_entrada_0; ?></b></td>
                            <td><b><?= $total_pyh_0; ?></b></td>
                            <td><b><?= $total_paez_0; ?></b></td>
                            <td><b><?= $total_retiros_0; ?></b></td>
                            <td><b><?= $total_auto_consumo_0; ?></b></td>
                            <td><b><?= $total_salida_0; ?></b></td>
                            <td>0</td>
                            <td>0</td>
                            <td align="right"><b><?= $total_bs_0; ?></b></td>
                      </tr>
        <?php
                  }
                  if($cont == 10)
                  {

        ?>
                       <tr bgcolor="#F0F0F0">
                            <th colspan="4" align="right"> TOTALES </th>
                            <td><b><?= $total_entrada_1; ?></b></td>
                            <td><b><?= $total_pyh_1; ?></b></td>
                            <td><b><?= $total_paez_1; ?></b></td>
                            <td><b><?= $total_retiros_1; ?></b></td>
                            <td><b><?= $total_auto_consumo_1; ?></b></td>
                            <td><b><?= $total_salida_1; ?></b></td>
                            <td>0</td>
                            <td>0</td>
                            <td align="right"><b><?= $total_bs_1; ?></b></td>
                      </tr>
        <?php
                  }
                  if($cont == 15)
                  {

        ?>
                       <tr bgcolor="#F0F0F0">
                            <th colspan="4" align="right"> TOTALES </th>
                            <td><b><?= $total_entrada_2; ?></b></td>
                            <td><b><?= $total_pyh_2; ?></b></td>
                            <td><b><?= $total_paez_2; ?></b></td>
                            <td><b><?= $total_retiros_2; ?></b></td>
                            <td><b><?= $total_auto_consumo_2; ?></b></td>
                            <td><b><?= $total_salida_2; ?></b></td>
                            <td>0</td>
                            <td>0</td>
                            <td align="right"><b><?= $total_bs_2; ?></b></td>
                      </tr>
        <?php
                  }
                  if($cont == 20)
                  {

        ?>
                       <tr bgcolor="#F0F0F0">
                            <th colspan="4" align="right"> TOTALES </th>
                            <td><b><?= $total_entrada_3; ?></b></td>
                            <td><b><?= $total_pyh_3; ?></b></td>
                            <td><b><?= $total_paez_3; ?></b></td>
                            <td><b><?= $total_retiros_3; ?></b></td>
                            <td><b><?= $total_auto_consumo_3; ?></b></td>
                            <td><b><?= $total_salida_3; ?></b></td>
                            <td>0</td>
                            <td>0</td>
                            <td align="right"><b><?= $total_bs_3; ?></b></td>
                      </tr>
        <?php
                  }

                  
                }
        ?>
                      <tr bgcolor="#F0F0F0">
                            <th colspan="4" align="right"> TOTAL GENERAL MES </th>
                            <td><b><?= @$total_general = $total_entrada_0 + $total_entrada_3 + $total_entrada_2 + $total_entrada_1; ?></b></td>
                            <td><b><?= @$total_general = $total_pyh_0 + $total_pyh_3 + $total_pyh_2 + $total_pyh_1; ?></b></td>
                            <td><b><?= @$total_general = $total_paez_0 + $total_paez_3 + $total_paez_2 + $total_paez_1; ?></b></td>
                            <td><b><?= @$total_general = $total_retiros_0 + $total_retiros_3 + $total_retiros_2 + $total_retiros_1; ?></b></td>
                            <td><b><?= @$total_general = $total_auto_consumo_0 + $total_auto_consumo_3 + $total_auto_consumo_2 + $total_auto_consumo_1; ?></b></td>
                            <td><b><?= @$total_general = $total_salida_0 + $total_salida_3 + $total_salida_2 + $total_salida_1; ?></b></td>
                            <td>0</td>
                            <td>0</td>
                            <td align="right"><b><?= @$total_general = $total_bs_0 + $total_bs_1 + $total_bs_2 + $total_bs_3; ?></b></td>
                      </tr>
        <?php
            }
        ?>
          </table>
          
          <table>
            <tr>
                <td colspan="13"> </td>
            </tr>
          </table>

          <?php
                @$total_reses = $total_pyh+$total_paez;
                @$por_paez = ($total_paez * 100) / $total_reses;
                @$por_pyh = ($total_pyh * 100) / $total_reses;
          ?>

          <table border="1">
            <?php

                if($descripcion == "CUEROS" || $descripcion == "CHINCHURRIA" || $descripcion == "CARNE-CUERO")
                {
            ?>
                <tr>
                    <td colspan="8" align="left"><b>TOTAL OPERACIONES MES DE <?= $mes_2." ".$ano_periodo;?> </b></td>
                    <td colspan="3" align="center"><b><?=  $total_entrada; ?></b></td>
                </tr>
            <?php
                }
                else
                {
            ?>
                <tr>
                    <td colspan="8" align="center"><b>RESUMEN DE OPERACIONES MES DE <?= $mes_2." ".$ano_periodo;?>  </b></td>
                    <td colspan="3" align="center"><b>DESTINO FINAL DE CANALES(reses)</b></td>
                    <td colspan="2" align="center"><b>%</b></td>
                </tr>
                <tr>
                    <td colspan="8" align="left">TOTAL RESES SACRIFICADAS DESTINADAS AL CONSUMO DE LA POBLACION DE PTO PAEZ-EDO.APURE </td>
                    <td colspan="3" align="center"><?= $total_paez; ?></td>
                    <td colspan="2" align="center"><?= number_format($por_paez, 2, '.', ''); ?></td>
                </tr>
                <tr>
                    <td colspan="8" align="left">TOTAL RESES SACRIFICADAS DESTINADAS AL CONSUMO DE LA POBLACION DE PTO AYACUCHO-EDO. AMAZONAS </td>
                    <td colspan="3" align="center"><?= $total_pyh; ?></td>
                    <td colspan="2" align="center"><?= number_format($por_pyh, 2, '.', '');?></td>
                </tr>
                <tr>
                    <td colspan="8" align="left"><b>TOTAL  </b></td>
                    <td colspan="3" align="center"><b><?=  $total_reses; ?></b></td>
                    <td colspan="2" align="center"><b><?=  $por_paez + $por_pyh; ?></b></td>
                </tr>
            <?php
                }
            ?>
            
          </table>
        </div>