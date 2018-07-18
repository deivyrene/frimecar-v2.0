<?php
session_start();
require('conectar.php');

//Recibo el parametro del controller.js, compruebo con empty para validar que no este vacío y ejecuto

//FUNCIONES DE UTILIDAD DENTRO DEL ARCHIVO

function declara_retencion($sueldo, $fecha_ingreso)
{
        $dias_vacaciones = CalculaEdad($fecha_ingreso) + 15;
        $sueldo_diario = number_format($sueldo/30, 2, '.', '');
        $vacaciones = number_format($sueldo_diario*$dias_vacaciones, 2, '.', '');
        $fin_ano = number_format($sueldo_diario*30, 2, '.', '');
        $sueldo_anual = $sueldo * 12;

        $total = $sueldo_anual + $fin_ano + $vacaciones;

        $unidad = $total / 150;

        return $unidad;

}

function CalculaEdad($fecha) 
{
   @list($Y,$m,$d) = explode("-",$fecha);
    return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
}

// Subir Imagen
if (isset($_FILES["inputFile"]))
{

    $file = $_FILES["inputFile"];
    $nombre = $file["name"];
    $tipo = $file["type"];
    $ruta_provisional = $file["tmp_name"];
    $size = $file["size"];
    $dimensiones = getimagesize($ruta_provisional);
    $width = $dimensiones[0];
    $height = $dimensiones[1];
    $carpeta = "imagenes/";
     
    if ($tipo != 'image/jpg' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif')
    {
      echo "Error, el archivo no es una imagen"; 
    }
    else if ($size > 1024*1024)
    {
      echo "Error, el tamaño máximo permitido es un 1MB";
    }
    else if ($width > 1200 || $height > 1200)
    {
        echo "Error la anchura y la altura maxima permitida es 500px";
    }
    else if($width < 60 || $height < 60)
    {
        echo "Error la anchura y la altura mínima permitida es 60px";
    }
    else
    {
        $src = $carpeta.$nombre;

        if(move_uploaded_file($ruta_provisional, $src))
        {
        	$re = mysqli_query($link, "insert into tbl_documento VALUES ('0','titulo','descripcion','$src','2015-03-20');");
        	echo "<img src='$src'>";
        }
    }
}

if(!empty($_GET['login']))
{

	$usuario = $_GET['user'];
	$pass = $_GET['pass'];

	$sql="select * from tbl_usuario where login_usuario = '".$usuario."' and pass_usuario = '".$pass."' and rol_usuario = 1";

	$re = mysqli_query($link, $sql);

	$sql_ = "select * from tbl_periodo order by id_periodo desc limit 1";

	$re_ = mysqli_query($link, $sql_);


	$sql__ = "select * from tbl_monto_dia_cestaticket order by id_monto_cesta desc limit 1";

	$re__ = mysqli_query($link, $sql__);


    $num = mysqli_num_rows($re);
	
	$num_ = mysqli_num_rows($re_);


	if($num > 0 && $num_ > 0)
	{
		while($fila = mysqli_fetch_array($re))
		{
		    $_SESSION["id_usuario"] = $fila['id_usuario'];
		    $_SESSION["rol_usuario"] = $fila['rol_usuario'];
		    $_SESSION["username"] = $fila['nombre_usuario']." ".$fila['apellido_usuario'];
		}
		while($fila_ = mysqli_fetch_array($re_))
		{
		    $_SESSION["periodo"] = $fila_['id_periodo'];
		    $_SESSION["descrip_periodo"] = $fila_['ano_periodo'];
		    $_SESSION["fecha_ven"] = $fila_['fecha_vencimiento'];
		}
		 
		while($fila__ = mysqli_fetch_array($re__))
		{
		    $_SESSION["monto_bs"] = $fila__['monto_bs'];
		}
		 
		echo "true";
	}
	else
	{
		echo "false";
	}

}

if(!empty($_GET['cerrar']))
{
	  
		session_unset();

		echo "true";
}

if(!empty($_GET['agregar_usuario']))
{

	@$tipo_nac = $_GET['tipo_nac'];
	@$cedula = $_GET['cedula'];
	@$nombre = $_GET['nombre'];
	@$apellido = $_GET['apellido'];
	@$correo = $_GET['correo'];
	@$rol = $_GET['rol'];
	@$username = $_GET['username'];
	@$pass = $_GET['pass'];

	
	$sql = "insert into tbl_usuario values(
		                                        '0',
		                                        '$tipo_nac',
		                                        '$cedula',
		                                        '$nombre',
		                                        '$apellido',
		                                        '$username',
		                                        '$pass',
		                                         $rol,
		                                        '$correo'
		                                        )";
	$re_sql = mysqli_query($link, $sql);

	//ECHO $sql;

	if(!$re_sql)
	{
		echo "false";
	}
	else
	{
		echo "true";
	}
	
}

if(!empty($_GET['editar_usuario']))
{
	@$id_usuario = $_GET['id_usuario'];
	@$tipo_nac = $_GET['tipo_nac'];
	@$cedula = $_GET['cedula'];
	@$nombre = $_GET['nombre'];
	@$apellido = $_GET['apellido'];
	@$correo = $_GET['correo'];
	@$rol = $_GET['rol'];
	@$username = $_GET['username'];
	@$pass = $_GET['pass'];


	       $sql = "UPDATE 
					       tbl_usuario
					 set 
					       tipo_nac_usuario = '$tipo_nac',
					       cedula_usuario = '$cedula',
					       nombre_usuario = '$nombre',
					       apellido_usuario = '$apellido',
					       login_usuario = '$username',
					       pass_usuario = '$pass',
					       rol_usuario = '$rol',
					       correo_usuario = '$correo'
					 where
					   id_usuario = $id_usuario ";

	$re_sql = mysqli_query($link, $sql);

	if(!$re_sql)
	{
		echo "false";
	}
	else
	{
		echo "true";
	}
}


if(!empty($_GET['agregar_personal']))
{

	@$cedula = $_GET['cedula'];
	@$rif = $_GET['rif'];
	@$nombre = $_GET['nombre'];
	@$apellido = $_GET['apellido'];
	@$cargo = $_GET['cargo'];
	@$tipo = $_GET['tipo'];
	@$direccion = $_GET['direccion'];
	@$telefono = $_GET['telefono'];
	@$fecha = $_GET['fecha'];
	@$sueldo = $_GET['sueldo'];
	@$retencion = $_GET['retencion'];
	@$ret_temp = "0";

	if($retencion == "retencion")
	{
		$unidad = declara_retencion($sueldo,$fecha);

		if($unidad > 1000)
		{
			$ret_temp = "1";
		}
	}

	if($retencion == "retencion_")
	{
		$ret_temp = "1";
	}
	

	$sql = "insert into tbl_personal values(
		                                        '0',
		                                        '$cedula',
		                                        '$rif',
		                                        '$apellido',
		                                        '$nombre',
		                                        '$direccion',
		                                        '$telefono',
		                                        '$cargo',
		                                        '$tipo',
		                                        '$sueldo',
		                                        '$fecha',
		                                        '1',
		                                        '$ret_temp'
		                                        )";
	$re_sql = mysqli_query($link, $sql);

	//ECHO $sql;

	if(!$re_sql)
	{
		echo "false";
	}
	else
	{
		echo "true";
	}
	
}

if(!empty($_GET['editar_personal']))
{
	@$id = $_GET['id'];
	@$nombre = $_GET['nombre'];
	@$apellido = $_GET['apellido'];
	@$cargo = $_GET['cargo'];
	@$tipo = $_GET['tipo'];
	@$direccion = $_GET['direccion'];
	@$telefono = $_GET['telefono'];
	@$fecha = $_GET['fecha'];
	@$sueldo = $_GET['sueldo'];
	@$retencion = $_GET['retencion'];
	@$ret_temp = "0";

	if($retencion == "retencion")
	{
		$unidad = declara_retencion($sueldo,$fecha);

		if($unidad > 1000)
		{
			$ret_temp = "11";
		}
	}

	if($retencion == "retencion_")
	{
		$ret_temp = "12";
	}


			   $sql = "UPDATE 
					            tbl_personal
					      set 
					            nombre_personal = '$nombre',
					            apellido_personal = '$apellido',
					            direccion_personal = '$direccion',
					            telefono_personal = '$telefono',
					            cargo_personal = '$cargo',
					            tipo_personal = '$tipo',
					            fecha_ingreso_personal = '$fecha',
					            sueldo_basico_personal = '$sueldo',
					            retencion_personal = '$ret_temp'
					      where
					      		id_personal = $id ";

	$re_sql = mysqli_query($link, $sql);

	if(!$re_sql)
	{
		echo "false";
	}
	else
	{
		echo "true";
	}
}



if(!empty($_GET['inhabilitar_personal']))
{
	@$id_personal = $_GET['id_personal'];
	@$fecha_egreso = $_GET['fecha_egreso'];
	@$motivo_egreso = $_GET['motivo_egreso'];

	$re_update = mysqli_query($link, "update tbl_personal set estatus_personal = 0, retencion_personal = 22 where id_personal = $id_personal");

	if(!$re_update)
	{
		echo "false";
	}
	else
	{
		$sql_egreso = "insert into tbl_egreso values('0', '$fecha_egreso', '$motivo_egreso', $id_personal)";
		$re_egreso = mysqli_query($link, $sql_egreso);

		if($re_egreso)
		{
			echo "true";
		}
	}
}

if(!empty($_GET['habilitar_personal']))
{
	@$id_personal = $_GET['id_personal'];

	$re_update = mysqli_query($link, "update tbl_personal set estatus_personal = 1 where id_personal = $id_personal");

	if(!$re_update)
	{
		echo "false";
	}
	else
	{
		echo "true";
	}
}

if(!empty($_GET['agregar_reten']))
{
	@$id_perReten = $_GET['id_perReten'];
	@$fecha_abono = $_GET['fecha_abono'];
	@$n_nota_debito = $_GET['n_nota_debito'];
	@$n_nota_credito = $_GET['n_nota_credito'];
	@$t_transaccion = $_GET['t_transaccion'];
	@$c_retencion = $_GET['c_retencion'];
	@$por_reten = $_GET['por_reten'];
	@$c_pagada = $_GET['c_pagada'];
	@$cod_concep = $_GET['cod_concep'];
    @$imp_retenido = $_GET['imp_retenido'];

    @$hoy = date('Y-m-d');
    @$parte = explode('/', $fecha_abono);
    @$ano = $parte[0];
    @$mes = $parte[1];
    @$dat_ym = $ano."".$mes;

    $sql_id = "SHOW TABLE STATUS LIKE 'tbl_retencion_personal'";

    $re_id = mysqli_query($link, $sql_id);
    $fila_id = mysqli_fetch_array($re_id);

    $id_prox = $fila_id['Auto_increment'];
    $cont_id = strlen($fila_id['Auto_increment']);

    if($cont_id == 1)
    {
    	$n_comprobante = $dat = $dat_ym.'0000000'.$id_prox;
    	$n_factura = $fac = $dat_ym.'000'.$id_prox;
    }
    if ($cont_id == 2) 
    {
    	$n_comprobante = $dat = $dat_ym.'000000'.$id_prox;
    	$n_factura = $fac = $dat_ym.'00'.$id_prox;
    }
    if ($cont_id == 3) 
    {
    	$n_comprobante = $dat = $dat_ym.'00000'.$id_prox;
    	$n_factura = $fac = $dat_ym.'0'.$id_prox;
    }
    if ($cont_id == 4) 
    {
    	$n_comprobante = $dat = $dat_ym.'0000'.$id_prox;
    	$n_factura = $fac = $dat_ym.''.$id_prox;
    }
    if ($cont_id == 5) 
    {
    	$n_comprobante = $dat = $dat_ym.'000'.$id_prox;
    }
    if ($cont_id == 6) 
    {
    	$n_comprobante = $dat = $dat_ym.'00'.$id_prox;
    }
    if ($cont_id == 7) 
    {
    	$n_comprobante = $dat = $dat_ym.'0'.$id_prox;
    }
    if ($cont_id == 8) 
    {
    	$n_comprobante = $dat = $dat_ym.''.$id_prox;
    }

   /* $sql_ = "select * from tbl_retencion_personal where fk_personal = $id_perReten and mes_retencion = $mes and ano_retencion = $ano";

    $re_ = mysqli_query($link, $sql_);

    $fila = mysqli_fetch_array($re_);

    if($fila != "")
    {
    	echo "error_1";
    }
    else
    { */

	   $sql = "insert 
				                    into 

				                    tbl_retencion_personal
				                    values(
				                                        '0',
				                                        '$hoy',
				                                        '$ano',
				                                        '$mes',
				                                        '$n_comprobante',
				                                        '$id_prox',
				                                        '$fecha_abono',
				                                        '$n_factura',
				                                        '$n_factura',
				                                        '$n_nota_debito',
				                                        '$n_nota_credito',
				                                        '$t_transaccion',
				                                        '$cod_concep',
				                                        '$c_retencion',
				                                        '$por_reten',
				                                        '$c_pagada',
				                                        '$imp_retenido',
				                                        '$id_perReten')";
	
		//echo $sql;

		$re = mysqli_query($link, $sql);

		if(!$re)
		{
			echo "false";
		}
		else
		{
			echo "true";
		}
	//}
	

}

if(!empty($_GET['verifica_quincena']))
{
	@$id_personal = $_GET['id_personal'];
	@$quincena = $_GET['quincena'];
	@$periodo = $_SESSION['periodo'];

	$sql_quin = "select * from tbl_quincena where fk_periodo_quincena = '$periodo' and fk_personal_quincena = '$id_personal' and periodo_mes_quincena = '$quincena' ";

	$re_quin = mysqli_query($link, $sql_quin);

	$num_quin = mysqli_num_rows($re_quin);

	if($num_quin > 0)
	{
		echo "true";
	}
	else
	{
		echo "false";
	}

}

if(!empty($_GET['agregar_quincena']))
{
	@$id_personal = $_GET['id_personal'];
	@$tipo = $_GET['tipo'];
	@$quincena = $_GET['quincena'];
	@$tipo_pago = $_GET['tipo_pago'];
	@$dias_feriados = $_GET['dias_feriados'];
	@$dias_cesta = $_GET['dias_cesta'];
	@$h_extra_n = $_GET['h_extras_noct'];
	@$h_extra_d = $_GET['h_extras_diur'];
	@$cant_lunes = $_GET['cant_lunes'];
	@$asig_quinc = number_format($_GET['asig_quinc'], 4, '.', '');
	@$asig_cesta = number_format($_GET['asig_cesta'], 4, '.', '');
	@$dias_trabajados = $_GET['dias_trabajados'];
	@$asig_bonif = number_format($_GET['asig_bonif'], 4, '.', '');
	@$asig_feriado = number_format($_GET['asig_feriado'], 4, '.', '');
	@$asig_h_diur = number_format($_GET['asig_h_diur'], 4, '.', '');
	@$asig_h_noct = number_format($_GET['asig_h_noct'], 4, '.', '');
	@$asig_otros = number_format($_GET['asig_otros'], 4, '.', '');
	@$ret_seguro = number_format($_GET['ret_seguro'], 4, '.', '');
	@$ret_faov = number_format($_GET['ret_faov'], 4, '.', '');
	@$ret_prestamo = number_format($_GET['ret_prestamo'], 4, '.', '');
	@$ret_iva_ = number_format($_GET['ret_iva_'], 4, '.', '');
	@$hoy = date('Y-m-d');
	@$fk_periodo = $_SESSION['periodo'];
	@$fecha_inicio = $_GET['fecha_inicio'];
	@$fecha_fin = $_GET['fecha_fin'];

	@$dias_vacas = $_GET['dias_vacas'];
	@$dias_bono_vacas = $_GET['dias_bono_vacas'];
	@$total_vacas = $_GET['total_vacas'];
	@$total_bono_vacas = $_GET['total_bono_vacas'];
	@$dias_utilidades = $_GET['dias_utilidades'];
	@$total_utilidades = $_GET['total_utilidades'];
	@$interes_anti = $_GET['interes_anti'];
	@$adelanto_anti = $_GET['adelanto_anti'];

	$sql_ver = "SELECT   id_quincena,
						   id_deduccion,
						   fecha_inicio_quin, 
						   fecha_fin_quin, 
					       tipo_pago_quin, 
					       dias_trabajados, 
					       cant_dias_feriados, 
					       cant_dias_cesta_ticket, 
					       bonificacion, 
					       cant_horas_extras_d, 
					       cant_horas_extras_n, 
					       cesta_ticket, 
					       otros_pagos, 
					       cant_lunes, 
					       monto_seguro, 
					       monto_faov, 
					       prestamos, 
					       ret_iva, 
					       cesta_ticket+monto_quincena+bonificacion+feriados_trabajados+h_extras_diur+h_extras_noct+otros_pagos as asignacion, 
					       monto_seguro+monto_faov+prestamos+ret_iva as retencion,
					       (cesta_ticket+monto_quincena+bonificacion+feriados_trabajados+h_extras_diur+h_extras_noct+otros_pagos)-(monto_seguro+monto_faov+prestamos+ret_iva) as total

					       FROM tbl_quincena q inner join tbl_deduccion d on q.id_quincena=d.fk_quincena where fk_personal_quincena = ".$id_personal." and fk_periodo_quincena = ".$fk_periodo." and periodo_mes_quincena = '".$quincena."' order by id_quincena desc limit 1";

	$re_ver = mysqli_query($link, $sql_ver);

	$con_ver = mysqli_num_rows($re_ver);

	if($con_ver > 0)
	{
		echo "tiene";
	}
	else
	{

		$sql_asig = " insert into tbl_quincena value ('0', $asig_quinc, '$hoy', $fk_periodo, $id_personal, '$tipo','$quincena', $dias_cesta, $asig_cesta, 
														 $dias_trabajados, $asig_bonif, $dias_feriados, $asig_feriado, $h_extra_d, $asig_h_diur, $h_extra_n, $asig_h_noct, $asig_otros, $dias_vacas, $total_vacas, $dias_bono_vacas, $total_bono_vacas, $dias_utilidades, $total_utilidades, $interes_anti, $adelanto_anti, '$fecha_inicio', '$fecha_fin', $tipo_pago)";

		
		$re_asig = mysqli_query($link, $sql_asig);

		if($re_asig)
		{
			$consulta_id = "select id_quincena from tbl_quincena order by id_quincena desc limit 1";
			$re_consulta = mysqli_query($link, $consulta_id);

			@$ult_id = "";

			while($fila = mysqli_fetch_array($re_consulta))
			{
				$ult_id = $fila['id_quincena'];
			}

	    	$sql_ret = "insert into tbl_deduccion value ('0', $cant_lunes, $ret_seguro, $ret_faov, $ret_prestamo, $ret_iva_, $ult_id)";

			$re_ret = mysqli_query($link, $sql_ret);
		}

		//echo $sql_asig." ".$sql_ret;

		if(!$re_asig || !$re_ret)
		{
			echo "false";
		}
		else
		{
			echo "true";
		}

	}
}

if(!empty($_GET['modificar_quincena']))
{
	@$id_personal = $_GET['id_personal'];
	@$id_quincena = $_GET['id_quincena'];
	@$id_deduccion = $_GET['id_deduccion'];
	@$quincena = $_GET['quincena'];
	@$tipo_pago = $_GET['tipo_pago'];
	@$dias_feriados = $_GET['dias_feriados'];
	@$dias_cesta = $_GET['dias_cesta'];
	@$h_extra_n = $_GET['h_extras_noct'];
	@$h_extra_d = $_GET['h_extras_diur'];
	@$cant_lunes = $_GET['cant_lunes'];
	@$asig_quinc = number_format($_GET['asig_quinc'], 4, '.', '');
	@$asig_cesta = number_format($_GET['asig_cesta'], 4, '.', '');
	@$dias_trabajados = $_GET['dias_trabajados'];
	@$asig_bonif = number_format($_GET['asig_bonif'], 4, '.', '');
	@$asig_feriado = number_format($_GET['asig_feriado'], 4, '.', '');
	@$asig_h_diur = number_format($_GET['asig_h_diur'], 4, '.', '');
	@$asig_h_noct = number_format($_GET['asig_h_noct'], 4, '.', '');
	@$asig_otros = number_format($_GET['asig_otros'], 4, '.', '');
	@$ret_seguro = number_format($_GET['ret_seguro'], 4, '.', '');
	@$ret_faov = number_format($_GET['ret_faov'], 4, '.', '');
	@$ret_prestamo = number_format($_GET['ret_prestamo'], 4, '.', '');
	@$ret_iva_ = number_format($_GET['ret_iva_'], 4, '.', '');
	@$hoy = date('Y-m-d');
	@$fk_periodo = $_SESSION['periodo'];
	@$fecha_inicio = $_GET['fecha_inicio'];
	@$fecha_fin = $_GET['fecha_fin'];

	@$dias_vacas = $_GET['dias_vacas'];
	@$dias_bono_vacas = $_GET['dias_bono_vacas'];
	@$total_vacas = $_GET['total_vacas'];
	@$total_bono_vacas = $_GET['total_bono_vacas'];
	@$dias_utilidades = $_GET['dias_utilidades'];
	@$total_utilidades = $_GET['total_utilidades'];
	@$interes_anti = $_GET['interes_anti'];
	@$adelanto_anti = $_GET['adelanto_anti'];


	$sql_quin = "UPDATE 
					           tbl_quincena
					    set 
							   fecha_inicio_quin = '$fecha_inicio', 
							   fecha_fin_quin = '$fecha_fin', 
						       tipo_pago_quin = $tipo_pago, 
						       dias_trabajados = $dias_trabajados, 
						       cant_dias_feriados = $dias_feriados, 
						       cant_dias_cesta_ticket = $dias_cesta, 
						       bonificacion = $asig_bonif, 
						       cant_horas_extras_d = $h_extra_d, 
						       cant_horas_extras_n = $h_extra_n, 
						       cesta_ticket = $asig_cesta, 
						       otros_pagos = $asig_otros, 
						       monto_quincena = $asig_quinc,
						       feriados_trabajados = $asig_feriado,
						       h_extras_diur = $asig_h_diur,
						       h_extras_noct = $asig_h_noct,
						       dias_vacas = $dias_vacas,
						       dias_bono_vacas = $dias_bono_vacas,
						       pago_vacaciones = $total_vacas,
						       pago_bono_vacacional = $total_bono_vacas,
						       dias_utilidades = $dias_utilidades,
						       total_utilidades = $total_utilidades,
						       interes_anti = $interes_anti,
						       adelanto_anti = $adelanto_anti
					    where
					      	   id_quincena = $id_quincena ";

	$re_quin = mysqli_query($link, $sql_quin);

	$sql_deduc = "UPDATE 
					            tbl_deduccion
					    set 
							   cant_lunes = $cant_lunes, 
						       monto_seguro = $ret_seguro, 
						       monto_faov = $ret_faov, 
						       prestamos = $ret_prestamo, 
						       ret_iva = $ret_iva_
					    where
					      	   fk_quincena = $id_quincena ";

	$re_deduc = mysqli_query($link, $sql_deduc);

	if(!$re_quin || !$re_deduc)
	{
		echo "false";
	}
	else
	{
		echo "true";
	}


}


if(!empty($_GET['ult_quincena']))
{
	@$id_personal = $_GET['id_personal'];
	@$quincena = $_GET['quincena'];

	$sql_ult_q = "SELECT   id_quincena,
						   id_deduccion,
						   fecha_inicio_quin, 
						   fecha_fin_quin, 
					       tipo_pago_quin, 
					       dias_trabajados, 
					       cant_dias_feriados, 
					       cant_dias_cesta_ticket, 
					       bonificacion, 
					       cant_horas_extras_d, 
					       cant_horas_extras_n, 
					       cesta_ticket, 
					       otros_pagos, 
					       cant_lunes, 
					       monto_seguro, 
					       monto_faov, 
					       prestamos, 
					       ret_iva, 
					       dias_vacas,
					       dias_bono_vacas,
					       pago_vacaciones,
					       pago_bono_vacacional,
					       dias_utilidades,
					       total_utilidades,
					       interes_anti,
					       adelanto_anti,
					       cesta_ticket+monto_quincena+bonificacion+feriados_trabajados+h_extras_diur+h_extras_noct+otros_pagos+pago_vacaciones+pago_bono_vacacional+total_utilidades+interes_anti+adelanto_anti as asignacion, 
					       monto_seguro+monto_faov+prestamos+ret_iva as retencion,
					       (cesta_ticket+monto_quincena+bonificacion+feriados_trabajados+h_extras_diur+h_extras_noct+otros_pagos+pago_vacaciones+pago_bono_vacacional+total_utilidades+interes_anti+adelanto_anti)-(monto_seguro+monto_faov+prestamos+ret_iva) as total

					       FROM tbl_quincena q inner join tbl_deduccion d on q.id_quincena=d.fk_quincena where fk_personal_quincena = ".$id_personal." and periodo_mes_quincena = '".$quincena."' order by id_quincena desc limit 1";

	$re_quin = mysqli_query($link, $sql_ult_q);

	$num_quin = mysqli_num_rows($re_quin);

	if($num_quin == 1)
	{
		if($row = mysqli_fetch_array($re_quin))
		{
			echo json_encode($row);
		}
	}
	else
	{
		echo "false";
	}

}



if(!empty($_GET['agregar_entrada']))
{
	@$cant_vaca = $_GET['cant_vaca'];
	@$cant_toro = $_GET['cant_toro'];
	@$cant_chinchurria = $_GET['cant_chinchurria'];
	@$cant_ccuero = $_GET['cant_ccuero'];
	@$total = $_GET['total'];
	@$fecha_entrada = $_GET['fecha_entrada'];
	@$fk_periodo = $_SESSION['periodo'];


	//INGRESO DE REGISTRO DE MATANZA
	$sql_matanza = "insert into tbl_entrada_diario value ('0', 'MATANZA/UNIDAD', 'MATANZA' , $cant_vaca, $cant_toro, $total, $total, '$fecha_entrada', 0.00 , $fk_periodo)";

	$re_matanza = mysqli_query($link, $sql_matanza);


	//INGRESO DE REGISTRO DE MONDONGO
	$sql_mondongo = "insert into tbl_entrada_diario value ('0', 'MONDONGO/UNIDAD', 'MONDONGO' , 0, 0, $total, $total, '$fecha_entrada', 0.00 , $fk_periodo)";

	$re_mondongo = mysqli_query($link, $sql_mondongo);


	//INGRESO DE REGISTRO DE CUEROS
	$sql_cuero = "insert into tbl_entrada_diario value ('0', 'CUEROS/UNIDAD', 'CUEROS' , 0, 0, $total, $total, '$fecha_entrada', 0.00 , $fk_periodo)";

	$re_cuero = mysqli_query($link, $sql_cuero);


	//INGRESO DE REGISTRO DE CHINCHURRIA
	$sql_chinchurria = "insert into tbl_entrada_diario value ('0', 'CHINCHURRIA/UNIDAD', 'CHINCHURRIA' , 0, 0, $cant_chinchurria, $cant_chinchurria, '$fecha_entrada', 0.00 , $fk_periodo)";

	$re_chinchurria = mysqli_query($link, $sql_chinchurria);

	//INGRESO DE REGISTRO DE CARNE CUERO
	$sql_ccuero = "insert into tbl_entrada_diario value ('0', 'CARNE-CUERO/UNIDAD', 'CARNE-CUERO' , 0, 0, $cant_ccuero, $cant_ccuero, '$fecha_entrada', 0.00 , $fk_periodo)";

	$re_ccuero = mysqli_query($link, $sql_ccuero);

	if(!$re_matanza)
	{
		echo "error_mat";
	}
	if(!$re_mondongo)
	{
		echo "error_mon";
	}
	if(!$re_cuero)
	{
		echo "error_cuero";
	}
	if(!$re_chinchurria)
	{
		echo "error_chin";
	}
	if(!$re_ccuero)
	{
		echo "error_ccuero";
	}
	if($re_chinchurria && $re_cuero && $re_mondongo && $re_matanza && $re_ccuero)
	{
		$ultimos_cuatros = "select id_entrada from tbl_entrada_diario order by id_entrada desc limit 5";
		$re_ultimos = mysqli_query($link, $ultimos_cuatros);

		while($row = mysqli_fetch_array($re_ultimos))
		{
			$fk_entrada = $row['id_entrada'];
			$insert_salida = "insert into tbl_salida_diario value ('0', 0, 0 , 0, 0, 0, 0, 0, 0.00, $fk_entrada)";
			$re_insert = mysqli_query($link, $insert_salida);
		}
		if($re_insert)
		{
			echo "true";
		}
	}

}

//PENDIENTE TERMINAR MODULO DE SALIDA INVENTARIO
if(!empty($_GET['salida_matanza']))
{
	@$cant_vaca_p = $_GET['cant_vaca_p'];
	@$cant_toro_p = $_GET['cant_toro_p'];
	@$cant_vaca_py = $_GET['cant_vaca_py'];
	@$cant_toro_py = $_GET['cant_toro_py'];
	@$cant_mondongo_p = $_GET['cant_mondongo_p'];
	@$cant_mondongo_py = $_GET['cant_mondongo_py'];
	@$auto_consumo_mat = $_GET['auto_consumo_mat'];
	@$retiro_mat = $_GET['retiro_mat'];
	@$resto_temp = $_GET['resto_temp'];
	@$resto_temp_ = $_GET['resto_temp_'];
	@$fk_salida = $_GET['salida_id'];
	@$descrip_tipo = $_GET['descrip_tipo'];
	@$cantidad_sal = $_GET['cantidad_sal'];
	@$total_salida = $cant_toro_py + $cant_vaca_py + $cant_vaca_p + $cant_toro_p;
	@$total_mondongo = $cant_mondongo_p + $cant_mondongo_py;
	@$precio_uno = $_GET['precio_uno'];
	@$precio_dos = $_GET['precio_dos'];


		//INGRESO DE REGISTRO DE MATANZA
		if($descrip_tipo == 'MATANZA')
		{
			$sql_ = "update tbl_salida_diario 
						set 
							auto_consumo_entrada = $auto_consumo_mat, 
							retiros_entrada = $retiro_mat , 
							cant_vaca_salida_aya = $cant_vaca_py, 
							cant_toro_salida_aya = $cant_toro_py, 
							cant_vaca_salida_paez = $cant_vaca_p, 
							cant_toro_salida_paez = $cant_toro_p,
							valor_ant_salida = $precio_uno, 
							total_salida = $total_salida 
					  where 
							fk_entrada = $fk_salida";

			$sql_up ="update tbl_entrada_diario 
		                 set 
		                     inventario_actual = $resto_temp 
		               where 
		               	     id_entrada = $fk_salida";
		}
		//INGRESO DE REGISTRO DE MONDONGO
		if($descrip_tipo == 'MONDONGO')
		{
			$sql_ = "update tbl_salida_diario 
						set 
							auto_consumo_entrada = $auto_consumo_mat, 
							retiros_entrada = $retiro_mat , 
							cant_vaca_salida_aya = $cant_mondongo_py, 
							cant_vaca_salida_paez = $cant_mondongo_p,
							valor_ant_salida = $precio_uno,  
							total_salida = $total_mondongo 
					  where 
							fk_entrada = $fk_salida";

			$sql_up ="update tbl_entrada_diario set inventario_actual = $resto_temp where id_entrada = $fk_salida";
		}
		//INGRESO DE REGISTRO DE CUEROS
		if($descrip_tipo == 'CUEROS')
		{
			$sql_ = "update tbl_salida_diario 
						set 
							total_salida = $cantidad_sal,
							valor_ant_salida = $precio_dos
					  where 
							fk_entrada = $fk_salida";
			$sql_up ="update tbl_entrada_diario set inventario_actual = $resto_temp_ where id_entrada = $fk_salida";
			
			//echo $sql_." SEgundo query: ".$sql_up;
		}
		//INGRESO DE REGISTRO DE CHINCHUNRRIA
		if($descrip_tipo == 'CHINCHURRIA')
		{
			$sql_ = "update tbl_salida_diario 
						set 
							total_salida = $cantidad_sal,
							valor_ant_salida = $precio_dos 
					  where 
							fk_entrada = $fk_salida";
			$sql_up ="update tbl_entrada_diario set inventario_actual = $resto_temp_ where id_entrada = $fk_salida";

		}
		//INGRESO DE REGISTRO DE CARNE CUERO
		if($descrip_tipo == 'CARNE-CUERO')
		{
			$sql_ = "update tbl_salida_diario 
						set 
							total_salida = $cantidad_sal,
							valor_ant_salida = $precio_dos 
					  where 
							fk_entrada = $fk_salida";
			$sql_up ="update tbl_entrada_diario set inventario_actual = $resto_temp_ where id_entrada = $fk_salida";

		}
		
		//echo $descrip_tipo."<br>";
		//echo $sql_."<br>";
		//echo $sql_up."<br>";
		
		$re_ = mysqli_query($link, $sql_);
		$re_up = mysqli_query($link, $sql_up);

		if(!$re_ && !$re_up)
		{
			echo "error_mat";
		}
		else
		{
			if($descrip_tipo == 'CUEROS')
			{
				$sql_ = "select * from tbl_entrada_diario where inventario_actual <> 0 and id_entrada <> $fk_salida and descripcion_entrada = 'CUEROS';";

				$re_sql = mysqli_query($link, $sql_);

				while($row = mysqli_fetch_array($re_sql))
				{
					@$id_entrada = $row['id_entrada'];

					$sql_1 = "update tbl_entrada_diario set inventario_actual = 0 where id_entrada = $id_entrada;";
					$re_sql_ = mysqli_query($link, $sql_1);
				}
				if($re_sql_)
				{
					echo "true";
				}
				else
				{
					echo "error_act";
				}
			}
			else
			{
				echo "true";
			}

		}

}

if(!empty($_GET['guardar_otra_asig']))
{
	@$tipo_otra_asig = $_GET['tipo_otra_asig'];
	@$fecha_otras_asig = $_GET['fecha_otras_asig'];
	@$id_personal = $_GET['id_otra'];
	@$sueldo_otra = $_GET['sueldo_otra'];
	@$dias_otra = $_GET['dias_otra'];
	@$vaca_otra = $_GET['vaca_otra'];
	@$fin_otra = $_GET['fin_otra'];
	@$otros_ = $_GET['otros_'];
	@$otros_pagos = $_GET['otros_pagos'];
	@$fk_periodo = $_SESSION['periodo'];

	$sql_asig_ = "insert into 
							  tbl_asignacion_otros 
					   value 
					   		  ('0', 
					   		    $dias_otra, 
					   		    $vaca_otra, 
					   		    $fin_otra, 
					   		    $otros_,
					   		    $otros_pagos,
					   		    '$tipo_otra_asig', 
					   		    '$fecha_otras_asig', 
					   		    $fk_periodo, 
					   		    $id_personal
					   		   )";

	$re_asig = mysqli_query($link, $sql_asig_);

	if($re_asig)
	{
		echo "true";
	}
	else
	{
		echo "false";
	}

}

if(!empty($_GET['agregar_sujeto']))
{

	@$rif_sujeto = $_GET['rif_sujeto'];
	@$nombre_sujeto = $_GET['nombre_sujeto'];
	@$direccion_sujeto = $_GET['direccion_sujeto'];

	
	$sql = "insert into tbl_sujeto_retenido values(
			                                        '0',
			                                        '$nombre_sujeto',
			                                        '$direccion_sujeto',
			                                        '$rif_sujeto'
			                                        )";
	$re_sql = mysqli_query($link, $sql);

	//ECHO $sql;

	if(!$re_sql)
	{
		echo "false";
	}
	else
	{
		echo "true";
	}
	
}

if(!empty($_GET['editar_sujeto']))
{
	@$ed_id_sujeto = $_GET['ed_id_sujeto'];
	@$ed_rif_sujeto = $_GET['ed_rif_sujeto'];
	@$ed_nombre_sujeto = $_GET['ed_nombre_sujeto'];
	@$ed_direccion_sujeto = $_GET['ed_direccion_sujeto'];


			   $sql = "UPDATE 
					            tbl_sujeto_retenido
					      set 
					            nombre_sujeto = '$ed_nombre_sujeto',
					            direccion_sujeto = '$ed_direccion_sujeto',
					            rif_sujeto = '$ed_rif_sujeto'
					      where
					      		id_sujeto_retenido = $ed_id_sujeto ";

	$re_sql = mysqli_query($link, $sql);

	if(!$re_sql)
	{
		echo "false";
	}
	else
	{
		echo "true";
	}
}

if(!empty($_GET['agregar_operacion']))
{

	
	@$n_comprobante = $_GET['n_comprobante'];
	@$fecha_emision = $_GET['fecha_emision'];
	@$id_sujeto_ret = $_GET['id_sujeto_ret'];
	@$ano_retencion_iva = $_GET['ano_retencion_iva'];
	@$mes_retencion_iva = $_GET['mes_retencion_iva'];
	@$n_operacion = $_GET['n_operacion'];
	@$fecha_factura = $_GET['fecha_factura'];
	@$n_factura = $_GET['n_factura'];
	@$n_control = $_GET['n_control'];
	@$n_debito = $_GET['n_debito'];
	@$n_credito = $_GET['n_credito'];
	@$tipo_trans = $_GET['tipo_trans'];
	@$n_fact_afect = $_GET['n_fact_afect'];
	@$tota_iva = $_GET['tota_iva'];
	@$total_exc = $_GET['total_exc'];
	@$base_imponible = $_GET['base_imponible'];
	@$alicuota = $_GET['alicuota'];
	@$iva = $_GET['iva'];
	@$iva_ret = $_GET['iva_ret'];
	@$fk_periodo = $_SESSION['periodo'];

	$sql_id = "SHOW TABLE STATUS LIKE 'tbl_retencion_iva'";

    	$re_id = mysqli_query($link, $sql_id);
    	$fila_id = mysqli_fetch_array($re_id);

    	$id_prox = $fila_id['Auto_increment'];

	
	$sql = "insert into tbl_retencion_iva values(
			                                        '0',
			                                        '$n_comprobante',
			                                        '$fecha_emision',
			                                        '$ano_retencion_iva',
			                                        '$mes_retencion_iva',
			                                        '$n_operacion',
			                                        '$fecha_factura',
			                                        '$n_factura',
			                                        '$n_control',
			                                        '$n_debito',
			                                        '$n_credito',
			                                        '$tipo_trans',
			                                        '$n_fact_afect',
			                                        '$tota_iva',
			                                        '$total_exc',
			                                        '$base_imponible',
			                                        '$alicuota',
			                                        '$iva',
			                                        '$iva_ret',
			                                        '$id_sujeto_ret',
			                                        '$fk_periodo'

			                                        )";
	$re_sql = mysqli_query($link, $sql);

	if(!$re_sql)
	{
		echo "false";
	}
	else
	{
		
		header('Content-Type: application/json');
		echo json_encode(array('exito'=>true, 'id_'=>$id_prox,
											  'n_operacion'=>$n_operacion,
											  'fecha_factura'=>$fecha_factura,
											  'n_factura'=>$n_factura,
											  'n_control'=>$n_control,
											  'n_debito'=>$n_debito,
											  'n_credito'=>$n_credito,
											  'tipo_trans'=>$tipo_trans,
											  'n_fact_afect'=>$n_fact_afect,
											  'tota_iva'=>$tota_iva,
											  'total_exc'=>$total_exc,
											  'base_imponible'=>$base_imponible,
											  'alicuota'=>$alicuota,
											  'iva'=>$iva,
											  'iva_ret'=>$iva_ret ));
	}
	
}

if(!empty($_GET['consulta_sujeto_']))
{

	@$id_sujeto = $_GET['id_sujeto'];

	$sql = "select n_comprobante_iva, fecha_emision_iva, iva_retenido from tbl_sujeto_retenido sr, 
    	                  tbl_retencion_iva ri 

    	             where 
    	                   sr.id_sujeto_retenido = ri.fk_sujeto_retenido
    	             and   
    	                   ri.fk_sujeto_retenido = $id_sujeto group by n_comprobante_iva";

	$re_sql = mysqli_query($link, $sql);

	$cont = mysqli_num_rows($re_sql);

	$arreglo = array();

	if($cont > 0)
	{


		while($row = mysqli_fetch_array($re_sql))
		{
			@$con++;
			$arreglo[$con] = $row;
		}

		echo json_encode($arreglo);
		
	}
	if($cont <= 0)
	{	
		header('Content-Type: application/json');
		echo json_encode(array('n_comprobante' => false));
	}
	
}

if(!empty($_GET['periodo_']))
{
	@$ano = $_GET['ano'];
	@$fecha_inicio = $_GET['fecha_inicio'];
	@$fecha_fin = $_GET['fecha_fin'];
	@$descrip_periodo = $_SESSION['descrip_periodo'];

	if($ano == $descrip_periodo)
	{
		echo "igual";
	}
	else
	{
		$sql = "insert into tbl_periodo values(
				                                '0',
				                                '$ano',
				                                '$fecha_inicio',
				                                '$fecha_fin'
				                                )";
		//echo $sql;
		$re_sql = mysqli_query($link, $sql);

		if(!$re_sql)
		{
			echo "false";
		}
		else
		{
			echo "true";
		}
	}

	
}

if(!empty($_GET['eliminar_periodo']))
{
	@$id_periodo= $_GET['id_periodo'];

	$sql_com = "DELETE FROM `tbl_periodo` WHERE `tbl_periodo`.`id_periodo` = $id_periodo";

	$re_com = mysqli_query($link, $sql_com);

	if(!$re_com)
	{
		echo "false";
	}
	else
	{
		echo "true";
	}

}


if(!empty($_GET['cesta_']))
{
	    @$monto_bs = $_GET['monto_bs'];

	
	
		$sql = "insert into tbl_monto_dia_cestaticket values(
				                                			 '0',
				                                			 '$monto_bs'
				                                			 )";
		//echo $sql;
		$re_sql = mysqli_query($link, $sql);

		if(!$re_sql)
		{
			echo "false";
		}
		else
		{
			echo "true";
		}

	
}

if(!empty($_GET['consul_reten']))
{
	@$n_comprobante = $_GET['n_comprobante'];

	$sql_com = "SELECT * FROM `tbl_retencion_iva` where n_comprobante_iva  = '$n_comprobante'";

	$re_com = mysqli_query($link, $sql_com);

	$num_com = mysqli_num_rows($re_com);

	if($num_com > 0)
	{
		echo "true";
	}
	else
	{
		echo "false";
	}

}
