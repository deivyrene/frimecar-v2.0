<?php

session_start ();
require('fpdf/fpdf.php');
require("../conectar.php"); //conexion

if(@$_GET['periodo'] == "")
{
	@$periodo = $_SESSION['periodo'];
}
if(@$_GET['periodo'] != "")
{
	@$periodo = $_GET['periodo'];
}

@$id_personal = $_GET['id'];

@$quincena = $_GET['quincena'];

$sql_empresa = "select * from tbl_empresa order by id_empresa desc";

$re_empresa = mysqli_query($link, $sql_empresa);

$row_empresa = mysqli_fetch_array($re_empresa);

$sql_datos = "select * from 
							 tbl_personal p inner join tbl_quincena q on 
							 p.id_personal = q.fk_personal_quincena inner join 
							 tbl_deduccion d on q.id_quincena = d.fk_quincena 
					where 
							 p.id_personal = $id_personal and
			                 q.periodo_mes_quincena = '$quincena' and
			                 q.fk_periodo_quincena = $periodo";
//echo $sql_datos;
$re_datos = mysqli_query($link,$sql_datos);
$num_re = mysqli_num_rows($re_datos);


$fila = mysqli_fetch_array($re_datos);

$id_quincena = $fila['id_quincena'];
$apellidoNombre = $fila['apellido_personal']." ".$fila['nombre_personal'];
$cedula = $fila['cedula_personal'];
$montoMensual = $fila['monto_quincena'];
$fechaInic = $fila['fecha_inicio_quin'];
$fechaFin = $fila['fecha_fin_quin'];
$cargo = $fila['cargo_personal'];
$tipo_ = $fila['tipo_pago_quin'];
list($Y, $m, $d)= explode('-', $fila['fecha_quincena']);



if($tipo_ == 1)
{
	$tipo_1 = 'x';
}
if($tipo_ == 2)
{
	$tipo_2 = 'x';
}
if($tipo_ == 3)
{
	$tipo_3 = 'x';
}
if($tipo_ == 4)
{
	$tipo_4 = 'x';
}



class PDF extends FPDF
{


// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}


}

// Creación del objeto de la clase heredada
$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

$pdf->SetAutoPageBreak(TRUE,30);


//Set font and colors
$pdf->SetFont('Arial','B',10);

$pdf->SetFillColor(225,0,0);
$pdf->SetTextColor(255);
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(.3);

	

		    //Table header
			if($num_re == 0)
			{
				$pdf->Ln(20);
				$pdf->Cell(90,7,'',0,0,'C',0);
				$pdf->Cell(120,7,'No se encontraron resultados de Busqueda',1,1,'C',1);
			}
			else
			{


			//Restore font and colors
			$pdf->SetFont('Arial','',10);
			$pdf->SetFillColor(225,225,225);
			$pdf->SetTextColor(0);

			@$pdf->Ln(-5);

		    @$pdf->SetFont('Arial','B',12);
		    // Movernos a la derecha
		   // @$pdf->Cell(30);
		    // Título
		    @$pdf->Cell(64,10,utf8_decode($row_empresa['nombre_empresa']),0,0,'C');

		    @$pdf->SetFont('Arial','',6);

		    @$pdf->Cell(111,10,utf8_decode('RIF '.$row_empresa['rif_empresa']),0,0,'C');

		    @$pdf->SetFont('Arial','B',12);

		    @$pdf->Cell(-10,10,utf8_decode($row_empresa['nombre_empresa']),0,0,'C');

		    @$pdf->SetFont('Arial','',6);

		    @$pdf->Cell(195,10,utf8_decode('RIF '.$row_empresa['rif_empresa']),0,0,'C');

		    @$pdf->Ln(7);

		    @$pdf->SetFont('Arial','B',6);
		    
		    @$pdf->Cell(64,3,utf8_decode($row_empresa['direccion_empresa'].', ZP '.$row_empresa['codigo_postal_empresa']),0,0,'C');

		    @$pdf->Cell(41,3,utf8_decode(''),0,0,'C');

		    @$pdf->Cell(30,3,utf8_decode('RECIBO DE PAGO'),1,0,'C');

		    @$pdf->SetFont('Arial','B',6);
		    
		    @$pdf->Cell(67,3,utf8_decode($row_empresa['direccion_empresa'].', ZP '.$row_empresa['codigo_postal_empresa']),0,0,'C');

		    @$pdf->Cell(45,3,utf8_decode(''),0,0,'C');

		    @$pdf->Cell(30,3,utf8_decode('RECIBO DE PAGO'),1,0,'C');

		    @$pdf->Ln(3);

		    @$pdf->SetFont('Arial','B',6);
		    
		    @$pdf->Cell(64,3,utf8_decode($row_empresa['ciudad_empresa'].' - EDO.'.$row_empresa['estado_empresa']),0,0,'C');

		    @$pdf->Cell(41,3,utf8_decode(''),0,0,'C');

		    @$pdf->Cell(30,3,utf8_decode('Nº: '.$id_quincena),1,0,'C');

		    @$pdf->SetFont('Arial','B',6);
		    
		    @$pdf->Cell(67,3,utf8_decode($row_empresa['ciudad_empresa'].' - EDO.'.$row_empresa['estado_empresa']),0,0,'C');

		    @$pdf->Cell(45,3,utf8_decode(''),0,0,'C');

		    @$pdf->Cell(30,3,utf8_decode('Nº: '.$id_quincena),1,0,'C');

		    @$pdf->Ln(3);

		    @$pdf->SetFont('Arial','B',6);
		    
		    @$pdf->Cell(64,3,utf8_decode('TELÉFONOS: '.$row_empresa['telefono_empresa']),0,0,'C');

		    @$pdf->Cell(40,7,utf8_decode(''),0,0,'C');

		    @$pdf->SetFont('Arial','B',6);
		    
		    @$pdf->Cell(130,3,utf8_decode('TELÉFONOS: '.$row_empresa['telefono_empresa']),0,0,'C');

		    @$pdf->Cell(40,7,utf8_decode(''),0,0,'C');

		   
		    // Salto de línea
		    @$pdf->Ln(9);
		

			
			$pdf->SetFont('Arial','',8);
			
			$pdf->Cell(10,6,utf8_decode('Lugar: '),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(70,6,utf8_decode('PUERTO PÁEZ. EDO. APURE'),0,0,'L',0);

			$pdf->SetFont('Arial','',8);
			//$pdf->Cell(40,10,$row['region'],0,0,'C');
			$pdf->Cell(10,6,utf8_decode('Fecha: '),0,0,'L',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(46,6,$d." / ".$m." / ".$Y,0,0,'L',0);

			$pdf->Cell(2,6,'',0,0,'C',0);
			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(10,6,utf8_decode('Lugar: '),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(70,6,utf8_decode('PUERTO PÁEZ. EDO. APURE'),0,0,'L',0);

			$pdf->SetFont('Arial','',8);
			//$pdf->Cell(40,10,$row['region'],0,0,'C');
			$pdf->Cell(10,6,utf8_decode('Fecha: '),0,0,'L',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(45,6,$d." / ".$m." / ".$Y,0,0,'L',0);

			$pdf->ln(5);

			$pdf->SetFont('Arial','',8);
			
			$pdf->Cell(5,6,utf8_decode('Yo: '),0,0,'L',0);
			
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(75,6,utf8_decode($apellidoNombre),0,0,'L',0);
			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(15,6,utf8_decode('C.I o RIF: '),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(41,6,utf8_decode($cedula),0,0,'L',0);

			$pdf->Cell(2,6,'',0,0,'C',0);
			
			$pdf->SetFont('Arial','',8);
			
			$pdf->Cell(5,6,utf8_decode('Yo: '),0,0,'L',0);
			
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(75,6,utf8_decode($apellidoNombre),0,0,'L',0);
			//$pdf->Cell(40,10,$row['region'],0,0,'C');
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(15,6,utf8_decode('C.I o RIF: '),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(40,6,utf8_decode($cedula),0,0,'L',0);

			$pdf->ln(5);

			$pdf->SetFont('Arial','',8);


			$sql_ = "SELECT * FROM tbl_quincena, 
                                   tbl_personal, 
                                   tbl_deduccion 
                            where  id_quincena=fk_quincena 
                              and  estatus_personal = 1
                              and  id_personal=fk_personal_quincena  
                              and  periodo_mes_quincena = '$quincena'
                              and  fk_periodo_quincena = $periodo
                              and  fk_personal_quincena = $id_personal";
			
			$re_=mysqli_query($link, $sql_);	

			while($fila_ = mysqli_fetch_array($re_))
            {	
            	@$mensual = ($fila_['monto_quincena']/$fila_['dias_trabajados'])*30;
            	@$total_ret = $fila_['monto_seguro'] + $fila_['monto_faov'] + $fila_['prestamos'] + $fila_['ret_iva'];
            	@$total_cobrar = ($fila_['monto_quincena'] + $fila_['pago_vacaciones'] + $fila_['pago_bono_vacacional']  + $fila_['bonificacion'] + $fila_['cesta_ticket'] + $fila_['feriados_trabajados'] + $fila_['h_extras_diur'] + $fila_['h_extras_noct'] + $fila_['otros_pagos'] ) - $total_ret;
            }
			
			$pdf->Cell(90,6,utf8_decode('He recibido de: '.$row_empresa['nombre_empresa'].', la cantidad de: Bs. '),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(46,6,utf8_decode(@number_format($total_cobrar, 2, '.', '')),0,0,'L',0);

			$pdf->Cell(2,6,'',0,0,'C',0);

			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(90,6,utf8_decode('He recibido de: '.$row_empresa['nombre_empresa'].', la cantidad de: Bs. '),0,0,'L',0);
        	
        	$pdf->SetFont('Arial','B',8);
			$pdf->Cell(45,6,utf8_decode(@number_format($total_cobrar, 2, '.', '')),0,0,'L',0);

        	$pdf->ln(5);

			$pdf->SetFont('Arial','',8);
			
			$pdf->Cell(16,6,utf8_decode('Período: '),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			
			$pdf->Cell(64,6,utf8_decode($fechaInic.' al '.$fechaFin),0,0,'L',0);

			$pdf->SetFont('Arial','',8);

			$pdf->Cell(15,6,utf8_decode('Cargo: '),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			
			$pdf->Cell(41,6,utf8_decode($cargo),0,0,'L',0);

			$pdf->Cell(2,6,'',0,0,'C',0);

			$pdf->SetFont('Arial','',8);
			
			$pdf->Cell(16,6,utf8_decode('Período: '),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			
			$pdf->Cell(64,6,utf8_decode($fechaInic.' al '.$fechaFin),0,0,'L',0);

			$pdf->SetFont('Arial','',8);

			$pdf->Cell(15,6,utf8_decode('Cargo: '),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			
			$pdf->Cell(40,6,utf8_decode($cargo),0,0,'L',0);

			$pdf->ln(5);

			$pdf->SetFont('Arial','',8);
			
			$pdf->Cell(30,6,utf8_decode('Tipo Empleado: '),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			
			$pdf->Cell(50,6,utf8_decode($fila['tipo_personal']),0,0,'L',0);

			$pdf->SetFont('Arial','',8);

			$pdf->Cell(25,6,utf8_decode('Sueldo Base: '),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			
			$pdf->Cell(31,6,utf8_decode(@number_format($mensual, 2, '.', '')),0,0,'L',0);

			$pdf->Cell(2,6,'',0,0,'C',0);

			$pdf->SetFont('Arial','',8);
			
			$pdf->Cell(30,6,utf8_decode('Tipo Empleado: '),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			
			$pdf->Cell(50,6,utf8_decode($fila['tipo_personal']),0,0,'L',0);

			$pdf->SetFont('Arial','',8);

			$pdf->Cell(25,6,utf8_decode('Sueldo Base: '),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			
			$pdf->Cell(30,6,utf8_decode(@number_format($mensual, 2, '.', '')),0,0,'L',0);

			$pdf->ln(6);

			$pdf->SetFillColor(179,180,183);
			$pdf->SetTextColor(0);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(50,5,utf8_decode('Descripción:'),1,0,'L',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(15,5,utf8_decode('Días:'),1,0,'L',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(24,5,utf8_decode('Asignación:'),1,0,'L',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(23,5,utf8_decode('Deducción:'),1,0,'L',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(24,5,'Monto a Pagar:',1,0,'L',1);

			$pdf->Cell(3,6,'',0,0,'C',0);

			$pdf->SetFillColor(179,180,183);
			$pdf->SetTextColor(0);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(50,5,utf8_decode('Descripción:'),1,0,'L',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(15,5,utf8_decode('Días:'),1,0,'L',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(24,5,utf8_decode('Asignación:'),1,0,'L',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(24,5,utf8_decode('Deducción:'),1,0,'L',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(24,5,'Monto a Pagar:',1,0,'L',1);
			$pdf->Ln(5);

							
		$descrip_periodo = $quincena;
		$id_periodo = $periodo;				

		$sql_prueba = "select id_personal, 
												   'MONTO QUINCENA' apellido_personal, 
											       (select monto_quincena from  tbl_quincena where fk_personal_quincena = $id_personal and 
																								   periodo_mes_quincena = '$descrip_periodo' and
																								   fk_periodo_quincena = $id_periodo) as quincena,
											       (select dias_trabajados from  tbl_quincena where fk_personal_quincena = $id_personal and 
																								   periodo_mes_quincena = '$descrip_periodo' and
																								   fk_periodo_quincena = $id_periodo) as cant_,
											       '0.00' nombre_personal  
																							  from tbl_personal where id_personal = $id_personal 
																							                      and estatus_personal = 1 union 
											select id_personal, 
												   'CESTA TICKET' apellido_personal, 
											       (select cesta_ticket from tbl_quincena where fk_personal_quincena = $id_personal and 
																			                    periodo_mes_quincena = '$descrip_periodo' and
											                                                    fk_periodo_quincena = $id_periodo) as quincena,
											       (select cant_dias_cesta_ticket from  tbl_quincena where fk_personal_quincena = $id_personal and 
																								   periodo_mes_quincena = '$descrip_periodo' and
																								   fk_periodo_quincena = $id_periodo) as cant_,
											       '0.00' nombre_personal 
																						   from tbl_personal where id_personal = $id_personal 
																							                   and estatus_personal = 1 union  
											select id_personal, 
												   'BONIFICACION' apellido_personal, 
											       (select bonificacion from tbl_quincena where fk_personal_quincena = $id_personal and 
																			                    periodo_mes_quincena = '$descrip_periodo' and
											                                                    fk_periodo_quincena = $id_periodo) as quincena,
											       
											       '0' cant_, 
											       '0.00' nombre_personal 
																						   from tbl_personal where id_personal = $id_personal 
																							                   and estatus_personal = 1 union 
											select id_personal, 
												   'FERIADOS TRABAJADOS' apellido_personal, 
											       (select feriados_trabajados from tbl_quincena where fk_personal_quincena = $id_personal and 
																			                    periodo_mes_quincena = '$descrip_periodo' and
											                                                    fk_periodo_quincena = $id_periodo) as quincena,
											       (select cant_dias_feriados from  tbl_quincena where fk_personal_quincena = $id_personal and 
																								   periodo_mes_quincena = '$descrip_periodo' and
																								   fk_periodo_quincena = $id_periodo) as cant_,
											       '0.00' nombre_personal 
																						   from tbl_personal where id_personal = $id_personal 
																							                   and estatus_personal = 1 union 
											select id_personal, 
												   'HORAS EXTRAS DIURNAS' apellido_personal, 
											       (select h_extras_diur from tbl_quincena where fk_personal_quincena = $id_personal and 
																			                    periodo_mes_quincena = '$descrip_periodo' and
											                                                    fk_periodo_quincena = $id_periodo) as quincena,
											       (select cant_horas_extras_d from  tbl_quincena where fk_personal_quincena = $id_personal and 
																								   periodo_mes_quincena = '$descrip_periodo' and
																								   fk_periodo_quincena = $id_periodo) as cant_,
											       '0.00' nombre_personal 
																						   from tbl_personal where id_personal = $id_personal 
																							                   and estatus_personal = 1 union 
											select id_personal, 
												   'HORAS EXTRAS NOCTURNAS' apellido_personal, 
											       (select h_extras_noct from tbl_quincena where fk_personal_quincena = $id_personal and 
																			                    periodo_mes_quincena = '$descrip_periodo' and
											                                                    fk_periodo_quincena = $id_periodo) as quincena,
											       (select cant_horas_extras_n from  tbl_quincena where fk_personal_quincena = $id_personal and 
																								   periodo_mes_quincena = '$descrip_periodo' and
																								   fk_periodo_quincena = $id_periodo) as cant_,
											       '0.00' nombre_personal 
																						   from tbl_personal where id_personal = $id_personal
																							                   and estatus_personal = 1 union 
											select id_personal, 
												   'BONO ESCOLAR' apellido_personal, 
											       (select otros_pagos from tbl_quincena where fk_personal_quincena = $id_personal and 
																			                    periodo_mes_quincena = '$descrip_periodo' and
											                                                    fk_periodo_quincena = $id_periodo) as quincena,
											       '0' cant_, 
											       '0.00' nombre_personal 
																						   from tbl_personal where id_personal = $id_personal 
																							                   and estatus_personal = 1 union
											select id_personal, 
												   'VACACIONES' apellido_personal, 
											       (select pago_vacaciones from tbl_quincena where fk_personal_quincena = $id_personal and 
																			                    periodo_mes_quincena = '$descrip_periodo' and
											                                                    fk_periodo_quincena = $id_periodo) as quincena,
											       (select dias_vacas from  tbl_quincena where fk_personal_quincena = $id_personal and 
																								   periodo_mes_quincena = '$descrip_periodo' and
																								   fk_periodo_quincena = $id_periodo) as cant_, 
											       '0.00' nombre_personal 
																						   from tbl_personal where id_personal = $id_personal 
																							                   and estatus_personal = 1 union 
											select id_personal, 
												   'BONO VACACIONAL' apellido_personal, 
											       (select pago_bono_vacacional from tbl_quincena where fk_personal_quincena = $id_personal and 
																			                    periodo_mes_quincena = '$descrip_periodo' and
											                                                    fk_periodo_quincena = $id_periodo) as quincena,
											       (select dias_bono_vacas from  tbl_quincena where fk_personal_quincena = $id_personal and 
																								   periodo_mes_quincena = '$descrip_periodo' and
																								   fk_periodo_quincena = $id_periodo) as cant_, 
											       '0.00' nombre_personal 
																						   from tbl_personal where id_personal = $id_personal 
																							                   and estatus_personal = 1 union
											select id_personal, 
												   'UTILIDADES' apellido_personal, 
											       (select total_utilidades from tbl_quincena where fk_personal_quincena = $id_personal and 
																			                    periodo_mes_quincena = '$descrip_periodo' and
											                                                    fk_periodo_quincena = $id_periodo) as quincena,
											       (select dias_utilidades from  tbl_quincena where fk_personal_quincena = $id_personal and 
																								   periodo_mes_quincena = '$descrip_periodo' and
																								   fk_periodo_quincena = $id_periodo) as cant_, 
											       '0.00' nombre_personal 
																						   from tbl_personal where id_personal = $id_personal 
																							                   and estatus_personal = 1 union 
										    select id_personal, 
												   'INTERES ANTIGUEDAD' apellido_personal, 
											       (select interes_anti from tbl_quincena where fk_personal_quincena = $id_personal and 
																			                    periodo_mes_quincena = '$descrip_periodo' and
											                                                    fk_periodo_quincena = $id_periodo) as quincena,
											       '0' cant_, 
											       '0.00' nombre_personal 
																						   from tbl_personal where id_personal = $id_personal 
																							                   and estatus_personal = 1 union 
											select id_personal, 
												   'ADELANTO ANTIGUEDAD' apellido_personal, 
											       (select adelanto_anti from tbl_quincena where fk_personal_quincena = $id_personal and 
																			                    periodo_mes_quincena = '$descrip_periodo' and
											                                                    fk_periodo_quincena = $id_periodo) as quincena,
											       '0' cant_, 
											       '0.00' nombre_personal 
																						   from tbl_personal where id_personal = $id_personal 
																							                   and estatus_personal = 1 union 
											select id_personal, 
												   'SEGURO SOCIAL' apellido_personal, 
											       '0.00' apellido_personal,
											       '0' cant_, 
											       (select monto_seguro from tbl_deduccion inner join tbl_quincena on id_quincena = fk_quincena 
																						where
																			                    periodo_mes_quincena = '$descrip_periodo' and
											                                                    fk_periodo_quincena = $id_periodo and
											                                                    fk_personal_quincena = $id_personal) as deduccion
																						   from tbl_personal where id_personal = $id_personal 
																							                   and estatus_personal = 1 union 
											select id_personal, 
												   'FAOV' apellido_personal, 
											       '0.00' apellido_personal,
											       '0' cant_, 
											       (select monto_faov from tbl_deduccion inner join tbl_quincena on id_quincena = fk_quincena 
																						where
																			                    periodo_mes_quincena = '$descrip_periodo' and
											                                                    fk_periodo_quincena = $id_periodo and
											                                                    fk_personal_quincena = $id_personal) as deduccion
																						   from tbl_personal where id_personal = $id_personal
																							                   and estatus_personal = 1 union 
											select id_personal, 
												   'ADELANTO QUINCENA' apellido_personal, 
											       '0.00' apellido_personal,
											       '0' cant_, 
											       (select prestamos from tbl_deduccion inner join tbl_quincena on id_quincena = fk_quincena 
																						where
																			                    periodo_mes_quincena = '$descrip_periodo' and
											                                                    fk_periodo_quincena = $id_periodo and
											                                                    fk_personal_quincena = $id_personal) as deduccion
																						   from tbl_personal where id_personal = $id_personal 
																							                   and estatus_personal = 1 union 
											select id_personal, 
												   'RET. ISLR' apellido_personal, 
											       '0.00' apellido_personal,
											       '0' cant_, 
											       (select ret_iva from tbl_deduccion inner join tbl_quincena on id_quincena = fk_quincena 
																						where
																			                    periodo_mes_quincena = '$descrip_periodo' and
											                                                    fk_periodo_quincena = $id_periodo and
											                                                    fk_personal_quincena = $id_personal) as deduccion
																						   from tbl_personal where id_personal = $id_personal 
																							                   and estatus_personal = 1;";

        $sql_quincena=mysqli_query($link, $sql_prueba);


   		if ($sql_quincena)
		{
			while ($fila = mysqli_fetch_array($sql_quincena))
			{
				$descripcion = $fila['apellido_personal'];
				$asignacion = $fila['quincena'];
				$deduccion = $fila['nombre_personal'];
				$dias = $fila['cant_'];
				if($dias == '')
				{
					$dias = 0;
				}
				@$total_asig = $total_asig + $asignacion;
				@$total_deduc = $total_deduc + $deduccion;
				@$monto_pagar = $total_asig - $total_deduc;

				
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(50,5, $descripcion,0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(15,5, $dias,0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(24,5, number_format($asignacion, 2, '.', ''),0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(23,5, number_format($deduccion, 2, '.', ''),0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(24,5,'',0,0,'L',1);

				$pdf->Cell(3,6,'',0,0,'C',0);

				$pdf->SetFont('Arial','',8);
				$pdf->Cell(50,5, $descripcion,0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(15,5, $dias,0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(24,5, number_format($asignacion, 2, '.', ''),0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(24,5, number_format($deduccion, 2, '.', ''),0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(24,5,'',0,0,'L',1);
				$pdf->Ln(5);
			}

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(65,5,'Totales',1,0,'R',1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(24,5,number_format($total_asig, 2, '.', ''),1,0,'L',1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(23,5,number_format($total_deduc, 2, '.', ''),1,0,'L',1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(24,5,number_format($monto_pagar, 2, '.', ''),1,0,'L',1);

				$pdf->Cell(3,6,'',0,0,'C',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(65,5,'Totales',1,0,'R',1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(24,5,number_format($total_asig, 2, '.', ''),1,0,'L',1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(24,5,number_format($total_deduc, 2, '.', ''),1,0,'L',1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(24,5,number_format($monto_pagar, 2, '.', ''),1,0,'L',1);
				$pdf->Ln(6);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(80,5,'CONDICIONES DE PAGO',0,0,'C',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(60,5,'POR LA EMPRESA',0,0,'C',0);

				$pdf->Cell(3,6,'',0,0,'C',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(70,5,'CONDICIONES DE PAGO',0,0,'C',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(70,5,'POR LA EMPRESA',0,0,'C',0);

				$pdf->Ln(7);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(12,5,'Efectivo: ',0,0,'C',0);
				$pdf->Cell(5,5,@$tipo_1,0,0,'C',1);
				$pdf->Cell(3,6,'',0,0,'C',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(12,5,'Deposito: ',0,0,'C',0);
				$pdf->Cell(5,5,@$tipo_2,0,0,'C',1);
				$pdf->Cell(3,6,'',0,0,'C',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(12,5,'Cheque: ',0,0,'C',0);
				$pdf->Cell(5,5,@$tipo_3,0,0,'C',1);
				$pdf->Cell(4,6,'',0,0,'C',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(16,5,utf8_decode('Cta. Nómina: '),0,0,'C',0);
				$pdf->Cell(5,5,@$tipo_4,0,0,'C',1);

				$pdf->Cell(59,6,'',0,0,'C',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(12,5,'Efectivo: ',0,0,'C',0);
				$pdf->Cell(5,5,@$tipo_1,0,0,'C',1);
				$pdf->Cell(3,6,'',0,0,'C',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(12,5,'Deposito: ',0,0,'C',0);
				$pdf->Cell(5,5,@$tipo_2,0,0,'C',1);
				$pdf->Cell(3,6,'',0,0,'C',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(12,5,'Cheque: ',0,0,'C',0);
				$pdf->Cell(5,5,@$tipo_3,0,0,'C',1);
				$pdf->Cell(4,6,'',0,0,'C',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(15,5,utf8_decode('Cta. Nómina: '),0,0,'C',0);
				$pdf->Cell(5,5,@$tipo_4,0,0,'C',1);

				$pdf->Ln(8);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(80,5,'Recibi Conforme:',0,0,'L',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(56,5,'',0,0,'C',0);

				$pdf->Cell(3,6,'',0,0,'C',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(70,5,'Recibi Conforme:',0,0,'L',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(70,5,'',0,0,'C',0);

				$pdf->Ln(6);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(88,5,'_____________________________________________________',0,0,'C',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(50,5,'____________________________',0,0,'C',0);

				$pdf->Cell(3,6,'',0,0,'C',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(77,5,'___________________________________________________',0,0,'C',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(70,5,'_______________________________',0,0,'C',0);

				$pdf->Ln(8);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(88,5,'Firma',0,0,'C',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(50,5,'Firma y Sello',0,0,'C',0);

				$pdf->Cell(3,6,'',0,0,'C',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(77,5,'Firma',0,0,'C',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(70,5,'Firma y Sello',0,0,'C',0);

				
		}
		else
		{
			$pdf->Cell(50,7,'',0,0,'C',0);
			$pdf->Cell(120,7,'No se encontraron resultados de Busqueda'.mysqli_error($link),1,1,'C',1);
		}

	}




//**************************************************************
$pdf->PageNo(); 
//$pdf->Output('recibo_pago.pdf','D');
$pdf->Output();
?>

