<?php

session_start ();
require('fpdf/fpdf.php');
require("../conectar.php"); //conexion


		@$cedula_ = $_GET['cedula'];
		@$ano = $_GET['ano'];

		$sql_empresa = "select * from tbl_empresa order by id_empresa desc";

		$re_empresa = mysqli_query($link, $sql_empresa);

		$row_empresa = mysqli_fetch_array($re_empresa);


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
$pdf = new PDF('L','mm','legal');
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

			
			$sql = "select * from tbl_personal where cedula_personal = '".$cedula_."'";

			$re = mysqli_query($link, $sql);

			$num_row = mysqli_num_rows($re);

			if($num_row == 0)
			{
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

				$pdf->Cell(65,7,'',0,0,'C',0);
				$pdf->Cell(150,7,'No se encontraron resultados de Busqueda',1,1,'C',1);

				$pdf->PageNo(); 
				$pdf->Output('arc_'.$ano.'.pdf', 'I');
			}
			else
			{
				$fila = mysqli_fetch_array($re);

				$apellidoNombre = $fila['apellido_personal']." ".$fila['nombre_personal'];
				$cedula = $fila['cedula_personal'];
				$rif = $fila['rif_personal'];
				$id_personal = $fila['id_personal'];


			//Restore font and colors
			$pdf->SetFont('Arial','',10);
			$pdf->SetFillColor(225,225,225);
			$pdf->SetTextColor(0);

			@$pdf->Ln(-5);

		    @$pdf->SetFont('Arial','B',12);
		   
		   
		    // Salto de línea
		    @$pdf->Ln(2);
		
		    $pdf->SetFont('Arial','B',10);
			
			$pdf->Cell(330,6,utf8_decode('COMPROBANTE DE RETENCIONES VARIAS'),0,0,'C',0);

			@$pdf->Ln(4);

			$pdf->SetFont('Arial','B',8);
			
			$pdf->Cell(330,6,utf8_decode('DEL IMPUESTO SOBRE LA RENTA'),0,0,'C',0);

			$pdf->ln(4);
			
			$pdf->SetFont('Arial','B',10);

			$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);
			
			$pdf->Cell(140,6,utf8_decode('DATOS DEL AGENTE DE RETENCION AR-CV '),0,0,'C',0);

			$pdf->SetFont('Arial','B',10);

			
			$pdf->Cell(165,6,utf8_decode('DATOS DEL BENEFICIARIO'),0,0,'C',0);


			$pdf->ln(6);

			$pdf->SetFont('Arial','B',8);

			$pdf->Cell(5,6,utf8_decode(''),0,0,'L',0);
			
			$pdf->Cell(155,4,utf8_decode('MARQUE TIPO DE AGENTE DE RETENCIÓN'),1,0,'C',0);

			$pdf->Cell(135,4,utf8_decode('APELLIDO(S) Y NOMBRE(S) - RAZÓN SOCIAL'),1,0,'C',0);
			
			$pdf->CellFitSpace(35,4,utf8_decode('TIPO PERSONA'),1,0,'C',0);

			$pdf->ln(4);

			$pdf->SetFont('Arial','',8);

			$pdf->Cell(5,6,utf8_decode(''),0,0,'L',0);
			
			$pdf->CellFitSpace(51,4,utf8_decode('1) PERSONA NATURAL'),1,0,'L',0);

			$pdf->CellFitSpace(52,4,utf8_decode('2) PERSONA JURÍDICA'),1,0,'L',0);

			$pdf->CellFitSpace(52,4,utf8_decode('3) ENTIDAD PÚBLICA'),1,0,'L',0);


			$pdf->SetFont('Arial','',8);
			
			$pdf->CellFitSpace(135,8,utf8_decode(' '.$apellidoNombre),1,0,'L',0);

			$pdf->CellFitSpace(35,8,utf8_decode('NATURAL'),1,0,'C',0);
			

			$pdf->ln(4);

			$pdf->SetFont('Arial','B',8);

			$pdf->Cell(5,6,utf8_decode(''),0,0,'L',0);
			
			$pdf->CellFitSpace(155,4,utf8_decode('UBIQUESE EN EL TIPO DE AGENTE DE RETENCION Y SUMINISTRE LOS DATOS'),1,0,'C',0);

			

			$pdf->ln(4);

			$pdf->SetFont('Arial','B',8);

			$pdf->Cell(5,6,utf8_decode(''),0,0,'L',0);
			
			$pdf->CellFitSpace(10,7,utf8_decode('1'),1,0,'C',0);

			$pdf->CellFitSpace(72,3,utf8_decode('APELLIDO(S) Y NOMBRE(S)'),1,0,'C',0);

			$pdf->CellFitSpace(73,3,utf8_decode('Nº R.I.F.'),1,0,'C',0);


			$pdf->CellFitSpace(90,3,utf8_decode('NACIONALIDAD'),1,0,'C',0);

			$pdf->CellFitSpace(40,3,utf8_decode('DOMICILIO EN EL PAÍS'),1,0,'C',0);

			$pdf->CellFitSpace(40,3,utf8_decode('CONSTITUIDA EN EL PAÍS'),1,0,'C',0);

			$pdf->ln(3);

			$pdf->SetFont('Arial','B',8);

			$pdf->Cell(5,6,utf8_decode(''),0,0,'L',0);
			
			$pdf->CellFitSpace(10,4,utf8_decode(' '),0,0,'C',0);

			$pdf->CellFitSpace(72,4,utf8_decode(' '),1,0,'C',0);

			$pdf->CellFitSpace(73,4,utf8_decode(' '),1,0,'C',0);

			$pdf->SetFont('Arial','',8);

			$pdf->CellFitSpace(90,4,utf8_decode(' VENEZOLANO'),1,0,'L',0);

			$pdf->CellFitSpace(40,4,utf8_decode('X'),1,0,'C',0);

			$pdf->CellFitSpace(40,4,utf8_decode('X'),1,0,'C',0);


			$pdf->ln(4);

			$pdf->SetFont('Arial','B',8);

			$pdf->Cell(5,6,utf8_decode(''),0,0,'L',0);
			
			$pdf->CellFitSpace(10,7,utf8_decode('2'),1,0,'C',0);

			$pdf->CellFitSpace(72,3,utf8_decode('NOMBRE O RAZON SOCIAL'),1,0,'C',0);

			$pdf->CellFitSpace(73,3,utf8_decode('Nº R.I.F.'),1,0,'C',0);


			$pdf->CellFitSpace(90,3,utf8_decode('CÉDULA DE IDENTIDAD'),1,0,'C',0);

			$pdf->CellFitSpace(80,3,utf8_decode('Nº R.I.F'),1,0,'C',0);

			$pdf->ln(3);

			$pdf->SetFont('Arial','B',8);

			$pdf->Cell(5,6,utf8_decode(''),0,0,'L',0);
			
			$pdf->CellFitSpace(10,5,utf8_decode(' '),0,0,'C',0);

			$pdf->SetFont('Arial','',8);

			$pdf->CellFitSpace(72,4,utf8_decode($row_empresa['nombre_empresa']),1,0,'L',0);

			$pdf->SetFont('Arial','',8);

			$pdf->CellFitSpace(73,4,utf8_decode($row_empresa['rif_empresa']),1,0,'L',0);


			$pdf->CellFitSpace(90,4,utf8_decode(' '.$cedula),1,0,'L',0);

			$pdf->CellFitSpace(80,4,utf8_decode(' '.$rif),1,0,'L',0);

			$pdf->ln(4);

			$pdf->SetFont('Arial','B',8);

			$pdf->Cell(5,6,utf8_decode(''),0,0,'L',0);
			
			$pdf->CellFitSpace(10,14,utf8_decode('3'),1,0,'C',0);

			$pdf->CellFitSpace(145,3,utf8_decode('NOMBRE DEL ORGANISMO'),1,0,'C',0);


			$pdf->CellFitSpace(170,3,utf8_decode('DIRECCIÓN Y TELÉFONO'),1,0,'C',0);

			$pdf->ln(3);

			$pdf->SetFont('Arial','B',8);

			$pdf->Cell(5,3,utf8_decode(' '),0,0,'L',0);
			
			$pdf->CellFitSpace(10,4,utf8_decode(' '),0,0,'C',0);

			$pdf->CellFitSpace(145,4,utf8_decode(' '),1,0,'C',0);

		    $pdf->SetFont('Arial','',8);

			$pdf->CellFitSpace(170,7,utf8_decode(strtoupper($fila['direccion_personal'])),1,0,'C',0);

			$pdf->ln(4);

			$pdf->SetFont('Arial','B',8);

			$pdf->Cell(5,6,utf8_decode(''),0,0,'L',0);
			
			$pdf->CellFitSpace(10,5,utf8_decode(' '),0,0,'C',0);

			$pdf->CellFitSpace(72,3,utf8_decode('FUNCIONARIO AUTORIZADO '),1,0,'C',0);

			$pdf->CellFitSpace(73,3,utf8_decode(' Nº R.I.F.'),1,0,'C',0);

			$pdf->ln(3);

			$pdf->SetFont('Arial','B',8);

			$pdf->Cell(5,6,utf8_decode(''),0,0,'L',0);
			
			$pdf->CellFitSpace(10,4,utf8_decode(' '),0,0,'C',0);

			$pdf->CellFitSpace(72,4,utf8_decode(' '),1,0,'C',0);

			$pdf->CellFitSpace(73,4,utf8_decode(' '),1,0,'C',0);

			$pdf->CellFitSpace(100,4,utf8_decode('OBSERVACIONES: '),1,0,'L',0);

			$pdf->CellFitSpace(70,4,utf8_decode('PERÍODO DE REMUNERACIONES '),1,0,'L',0);

			$pdf->ln(4);

			$pdf->SetFont('Arial','B',8);

			$pdf->Cell(5,6,utf8_decode(''),0,0,'L',0);

			$pdf->CellFitSpace(102,4,utf8_decode('DIRECCIÓN Y TELÉFONO '),1,0,'C',0);

			$pdf->CellFitSpace(53,4,utf8_decode(' FECHA CIERRE EJERCICIO'),1,0,'C',0);

			$pdf->SetFont('Arial','',8);
			
			$pdf->CellFitSpace(100,12,utf8_decode(' '),1,0,'C',0);

			$pdf->CellFitSpace(70,12,utf8_decode(' DESDE: 01/01/'.$ano.' - HASTA: 31/12/'.$ano.'  '),1,0,'C',0);

			$pdf->ln(4);

			$pdf->SetFont('Arial','B',8);

			$pdf->Cell(5,6,utf8_decode(''),0,0,'L',0);

			$pdf->SetFont('Arial','',8);

			$pdf->CellFitSpace(102,8,utf8_decode($row_empresa['direccion_empresa'].', '.$row_empresa['ciudad_empresa'].' - EDO.'.$row_empresa['estado_empresa']),1,0,'C',0);
 
			$pdf->CellFitSpace(53,8,utf8_decode(' 31/12/'.$ano),1,0,'C',0);
			
			$pdf->ln(7);

			$pdf->SetFont('Arial','B',10);

			$pdf->Cell(5,6,utf8_decode(' '),0,0,'L',0);

			$pdf->Cell(15,6,utf8_decode(' INFORMACIÓN DEL IMPUESTO RETENIDO Y ENTERADO'),0,0,'L',0);

			$pdf->ln(5);

			$pdf->Cell(2,6,utf8_decode(''),0,0,'L',0);

			$pdf->SetFillColor(179,180,183);
			$pdf->SetTextColor(0);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(22,5,utf8_decode('MES'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(30,5,utf8_decode('Nº COMPROBANTE'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(13,5,utf8_decode('CÓD. RET.'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(26,5,utf8_decode('CANT. PAGADA'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(36,5,utf8_decode('CANT. OBJ. RETENCIÓN'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(20,5,utf8_decode('% RETENCIÓN'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(33,5,utf8_decode('IMPUESTO RETENIDO'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(33,5,utf8_decode('CANT. OBJETO ACUM.'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(30,5,utf8_decode('VACACIONES Y UTIL.'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(36,5,utf8_decode('IMP. RETENIDO ACUM.'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(53,3,utf8_decode('IMPUESTO ENTERADO'),1,0,'C',1);

			$pdf->Ln(3);

			$pdf->Cell(281,6,utf8_decode(''),0,0,'L',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(53,2,utf8_decode('BANCO'),1,0,'C',1);

			$pdf->Ln(2);
			/*$sql_ret = "SELECT mes_retencion, 
			                   n_comprobante, 
			                   codigo_concepto, 
			                   sum(cantidad_pagada) as cantidad_pagada, 
			                   sum(cantidad_retencion) as cantidad_retencion, 
			                   por_retencion,
			                   sum(impuesto_retenido) as impuesto_retenido,
			                   fk_personal
			                    
			              FROM 
			                   tbl_retencion_personal rp 
			        inner join 
			                   tbl_personal p 
			                on 
			                   rp.fk_personal=p.id_personal 
			             where 
			                   cedula_personal = '$cedula'
			               and ano_retencion = $ano

			          group by 1 ";*/
			$sql_ret = "SELECT * FROM tbl_retencion_personal rp inner join tbl_personal p on rp.fk_personal=p.id_personal where cedula_personal = '".$cedula."' and ano_retencion = ".$ano."";
			$re_ret = mysqli_query($link, $sql_ret);
			$num_ret = mysqli_num_rows($re_ret);

			if($num_ret == 0)
			{
				$sql_ret_ = "SELECT fecha_quincena, monto_quincena, fk_personal_quincena, month(fecha_quincena) as mes, pago_vacaciones+pago_bono_vacacional+total_utilidades as vacaciones FROM tbl_quincena  where fk_personal_quincena = '".$id_personal."' and year(fecha_quincena) = ".$ano."";
				$re_ret_ = mysqli_query($link, $sql_ret_);
				$num_ret_ = mysqli_num_rows($re_ret_);

				if($num_ret_ == 0)
				{

					$pdf->Cell(95,7,'',0,0,'C',0);
					$pdf->Cell(150,7,'No se encontraron resultados de Busqueda_',1,1,'C',1);
				}
				else
				{
					while($row = mysqli_fetch_array($re_ret_))
					{

							$pdf->Cell(2,6,utf8_decode(''),0,0,'L',0);


							@$cantidad_pagada = $cantidad_pagada +  $row['monto_quincena'];
							@$cantidad_retencion = 0;
							@$impuesto_retenido = 0;

							$pdf->SetFont('Arial','B',8);
							@$parte_ = explode('-',$row['fecha_quincena']);
							@$ano_ = $parte_['0'];
							@$mes_ = $parte_['1'];
							@$dia_ = $parte_['2'];
							@$fecha_com_ = $dia_."/".$mes_."/".$ano_;
							@$mes_pago = '';
							
							if($row['mes'] == 1)
							{
								$mes_pago = 'ENERO';
							}
							if($row['mes'] == 2)
							{
								$mes_pago = 'FEBRERO';
							}
							if($row['mes'] == 3)
							{
								$mes_pago = 'MARZO';
							}
							if($row['mes'] == 4)
							{
								$mes_pago = 'ABRIL';
							}
							if($row['mes'] == 5)
							{
								$mes_pago = 'MAYO';
							}
							if($row['mes'] == 6)
							{
								$mes_pago = 'JUNIO';
							}
							if($row['mes'] == 7)
							{
								$mes_pago = 'JULIO';
							}
							if($row['mes'] == 8)
							{
								$mes_pago = 'AGOSTO';
							}
							if($row['mes'] == 9)
							{
								$mes_pago = 'SEPTIEMBRE';
							}
							if($row['mes'] == 10)
							{
								$mes_pago = 'OCTUBRE';
							}
							if($row['mes'] == 11)
							{
								$mes_pago = 'NOVIEMBRE';
							}
							if($row['mes'] == 12)
							{
								$mes_pago = 'DICIEMBRE';
							}

							@$vacaciones = 0;
							@$vacaciones = $vacaciones + $row['vacaciones'];

							$pdf->Cell(22,4,utf8_decode(' '.$mes_pago),1,0,'L',0);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(30,4,utf8_decode('0'),1,0,'C',0);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(13,4,utf8_decode('0'),1,0,'C',0);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(26,4,utf8_decode(' '.number_format($row['monto_quincena'], 2, '.', '')),1,0,'C',0);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(36,4,utf8_decode('0'),1,0,'C',0);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(20,4,utf8_decode('0'),1,0,'C',0);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(33,4,utf8_decode('0'),1,0,'C',0);
							$pdf->SetFont('Arial','B',8);
							@$acum_obj = $acum_obj + $row['monto_quincena'];
							$pdf->Cell(33,4,' '.number_format($acum_obj, 2, '.', ''),1,0,'C',0);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(30,4,' '.number_format($vacaciones, 2, '.', ''),1,0,'C',0);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(36,4,'0',1,0,'C',0);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(53,4,utf8_decode(' '),1,0,'C',0);

							
							$pdf->Ln(4);

						}


					
							$pdf->Cell(2,6,utf8_decode(' '),0,0,'L',0);

							
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(65,5,utf8_decode('TOTALES'),1,0,'C',0);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(26,5,utf8_decode(number_format($cantidad_pagada, 2, '.', '')),1,0,'C',0);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(36,5,utf8_decode('0'),1,0,'C',0);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(20,5,utf8_decode('0'),1,0,'C',0);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(33,5,utf8_decode('0'),1,0,'C',0);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(33,5,utf8_decode(' '.number_format($cantidad_pagada, 2, '.', '')),1,0,'C',0);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(30,5,utf8_decode(' '.number_format($vacaciones, 2, '.', '')),1,0,'C',0);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(36,5,utf8_decode('0'),1,0,'C',0);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(53,5,utf8_decode(' '),1,0,'C',TRUE);
				}

			}
			else
			{
				while($row = mysqli_fetch_array($re_ret))
				{

					$pdf->Cell(2,6,utf8_decode(''),0,0,'L',0);


					@$cantidad_pagada = $cantidad_pagada +  $row['cantidad_pagada'];
					@$cantidad_retencion = $cantidad_retencion + $row['cantidad_retencion'];
					@$impuesto_retenido = $impuesto_retenido + $row['impuesto_retenido'];

					$pdf->SetFont('Arial','B',8);
					@$parte_ = explode('-',$row['fecha_abono']);
					@$ano_ = $parte_['0'];
					@$mes_ = $parte_['1'];
					@$dia_ = $parte_['2'];
					@$fecha_com_ = $dia_."/".$mes_."/".$ano_;
					@$mes_pago = '';
					
					if($row['mes_retencion'] == 1)
					{
						$mes_pago = 'ENERO';
					}
					if($row['mes_retencion'] == 2)
					{
						$mes_pago = 'FEBRERO';
					}
					if($row['mes_retencion'] == 3)
					{
						$mes_pago = 'MARZO';
					}
					if($row['mes_retencion'] == 4)
					{
						$mes_pago = 'ABRIL';
					}
					if($row['mes_retencion'] == 5)
					{
						$mes_pago = 'MAYO';
					}
					if($row['mes_retencion'] == 6)
					{
						$mes_pago = 'JUNIO';
					}
					if($row['mes_retencion'] == 7)
					{
						$mes_pago = 'JULIO';
					}
					if($row['mes_retencion'] == 8)
					{
						$mes_pago = 'AGOSTO';
					}
					if($row['mes_retencion'] == 9)
					{
						$mes_pago = 'SEPTIEMBRE';
					}
					if($row['mes_retencion'] == 10)
					{
						$mes_pago = 'OCTUBRE';
					}
					if($row['mes_retencion'] == 11)
					{
						$mes_pago = 'NOVIEMBRE';
					}
					if($row['mes_retencion'] == 12)
					{
						$mes_pago = 'DICIEMBRE';
					}

					$sql_ingreso = "SELECT pago_vacaciones+pago_bono_vacacional+total_utilidades as vacaciones  FROM `tbl_quincena` WHERE fk_personal_quincena = ".$row['fk_personal']." and fecha_quincena = '".$row['fecha_comprobante']."' order by vacaciones desc limit 1 ";
					$re_ingreso = mysqli_query($link, $sql_ingreso);
					$row_ = mysqli_fetch_array($re_ingreso);

					@$vacaciones = $vacaciones + $row_['vacaciones'];

					$pdf->Cell(22,4,utf8_decode(' '.$mes_pago),1,0,'L',0);
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(30,4,utf8_decode(' '.$row['n_comprobante']),1,0,'C',0);
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(13,4,utf8_decode(' '.$row['codigo_concepto']),1,0,'C',0);
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(26,4,utf8_decode(' '.number_format($row['cantidad_pagada'], 2, '.', '')),1,0,'C',0);
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(36,4,utf8_decode(' '.number_format($row['cantidad_retencion'], 2, '.', '')),1,0,'C',0);
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(20,4,utf8_decode(' '.number_format($row['por_retencion'], 2, '.', '')),1,0,'C',0);
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(33,4,utf8_decode(' '.number_format($row['impuesto_retenido'], 2, '.', '')),1,0,'C',0);
					$pdf->SetFont('Arial','B',8);
					@$acum_obj = $acum_obj + $row['cantidad_pagada'];
					$pdf->Cell(33,4,number_format($acum_obj, 2, '.', ''),1,0,'C',0);
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(30,4,number_format($row_['vacaciones'], 2, '.', ''),1,0,'C',0);
					$pdf->SetFont('Arial','B',8);
					@$acum_imp = $acum_imp + $row['impuesto_retenido'];
					$pdf->Cell(36,4,number_format($acum_imp, 2, '.', ''),1,0,'C',0);
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(53,4,utf8_decode(' BANCO DEL TESORO'),1,0,'C',0);

					
					$pdf->Ln(4);

				}


			
			$pdf->Cell(2,6,utf8_decode(' '),0,0,'L',0);

			
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(65,5,utf8_decode('TOTALES'),1,0,'C',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(26,5,utf8_decode(number_format($cantidad_pagada, 2, '.', '')),1,0,'C',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(36,5,utf8_decode(number_format($cantidad_retencion, 2, '.', '')),1,0,'C',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(20,5,utf8_decode(' '),1,0,'C',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(33,5,utf8_decode(number_format($impuesto_retenido, 2, '.', '')),1,0,'C',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(33,5,utf8_decode(number_format($cantidad_pagada, 2, '.', '')),1,0,'C',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(30,5,utf8_decode(number_format($vacaciones, 2, '.', '')),1,0,'C',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(36,5,utf8_decode(number_format($impuesto_retenido, 2, '.', '')),1,0,'C',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(53,5,utf8_decode(' '),1,0,'C',TRUE);
			

   			}
			
			/*$pdf->Ln(10);

				$pdf->Cell(120,6,utf8_decode(''),0,0,'L',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(88,5,'_______________________________________________',0,0,'C',0);


				$pdf->Ln(4);

				$pdf->Cell(120,6,utf8_decode(''),0,0,'L',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(88,5,'FIRMA Y SELLO DEL AGENTE DE RETENCION',0,0,'C',0);


			$pdf->Cell(108,6,utf8_decode(''),0,0,'L',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(120,4,'AGENTE DE RETENCION (SELLO, FECHA Y FIRMA)',1,0,'C',0);

			$pdf->Ln(4);

			$pdf->Cell(108,6,utf8_decode(''),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(120,16,'',1,0,'C',0);*/


//**************************************************************
$pdf->PageNo(); 
$pdf->Output('arc_'.$ano.'.pdf', 'I');

			}
?>