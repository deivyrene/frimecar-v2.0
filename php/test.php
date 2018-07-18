<?php

	include("conectar.php");

	@$id_sujeto = $_GET['id_sujeto'];

	$sql = "select nombre_personal, id_personal, sueldo_basico_personal from tbl_personal where tipo_personal <> 'ADMINISTRATIVO' and estatus_personal = 1 order by id_personal desc ";

	$re_sql = mysqli_query($link, $sql);

	$cont = mysqli_num_rows($re_sql);

	if($cont > 0)
	{
		$porcentaje = 0.20;

		while($row = mysqli_fetch_array($re_sql))
		{
			@$id_personal = $row['id_personal'];
			$sueldo_actual = $row['sueldo_basico_personal'];
			$sueldo_diario = ($sueldo_actual / 30) * 2;
			$sueldo_nuevo = ($sueldo_actual * $porcentaje) + $sueldo_actual;
			$cesta_ticket = (2.5 * 177) * 30;
			$monto = ($sueldo_nuevo / 2) + $cesta_ticket + $sueldo_diario;

			$cont = $cont + $monto;
			
			echo $row['nombre_personal'].' -- '.$sueldo_actual.' -- '.$cont."<br>";
			//echo "<br>".$cont." ".$sueldo_actual." nuevo: ".$sueldo_nuevo;

			//$sql_up = "update tbl_personal set sueldo_basico_personal = $sueldo_nuevo where id_personal = $id_personal";
			//$re_up = mysqli_query($link, $sql_up);

			/*if($re_up)
			{
				$sql = "select sueldo_basico_personal from tbl_personal where estatus_personal = 1 and cargo_personal <> 'GERENTE PRINCIPAL' ";

				$re_sql = mysqli_query($link, $sql);

				while($row = mysqli_fetch_array($re_sql))
				{
					$sueldo_actual = $row['sueldo_basico_personal'];
					echo "<br>".$sueldo_actual;
				}
			}*/
		}

		
		
	}