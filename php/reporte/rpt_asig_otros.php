<?php

session_start ();
require('fpdf/fpdf.php');
require("../conectar.php"); //conexion


@$id_personal = $_GET['id'];
@$periodo = $_GET['periodo'];
@$mes_temp = explode(" ",$_GET['quincena']);

$mes_ = $mes_temp['1'];

if($mes_ == 'ENERO')
{
	$mes = 1;
}
if($mes_ == 'FEBRERO')
{
	$mes = 2;
}
if($mes_ == 'MARZO')
{
	$mes = 3;
}
if($mes_ == 'ABRIL')
{
	$mes = 4;
}
if($mes_ == 'MAYO')
{
	$mes = 5;
}
if($mes_ == 'JUNIO')
{
	$mes = 6;
}
if($mes_ == 'JULIO')
{
	$mes = 7;
}
if($mes_ == 'AGOSTO')
{
	$mes = 8;
}
if($mes_ == 'SEPTIEMBRE')
{
	$mes = 9;
}
if($mes_ == 'OCTUBRE')
{
	$mes = 10;
}
if($mes_ == 'NOVIEMBRE')
{
	$mes = 11;
}
if($mes_ == 'DICIEMBRE')
{
	$mes = 12;
}




$sql_datos = "select * from 
							tbl_personal p inner join tbl_asignacion_otros ao on
							p.id_personal = ao.fk_personal_otros
					where 
							p.id_personal = $id_personal and
			                month(ao.fecha_asignacion_otros) = $mes and
			                ao.fk_periodo_otros = $periodo";
//echo $sql_datos;
$re_datos = mysqli_query($link,$sql_datos);
$num_re = mysqli_num_rows($re_datos);


$fila = mysqli_fetch_array($re_datos);

$id_asignacion = $fila['id_asignacion_otros'];
$apellidoNombre = $fila['apellido_personal']." ".$fila['nombre_personal'];
$cedula = $fila['cedula_personal'];
$fecha = $fila['fecha_asignacion_otros'];
$cargo = $fila['cargo_personal'];
$tipo_ = $fila['tipo_pago_otros'];

if($tipo_ == 'EFECTIVO')
{
	$tipo_1 = 'x';
}
if($tipo_ == 'DEPOSITO')
{
	$tipo_2 = 'x';
}
if($tipo_ == 'CHEQUE')
{
	$tipo_3 = 'x';
}
if($tipo_ == 'CTA. NOMINA')
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
		    @$pdf->Cell(64,10,utf8_decode('INVERSIONES FRIMECAR, C.A.'),0,0,'C');

		    @$pdf->SetFont('Arial','',6);

		    @$pdf->Cell(110,10,utf8_decode('RIF J-29807443-4'),0,0,'C');

		    @$pdf->SetFont('Arial','B',12);

		    @$pdf->Cell(-10,10,utf8_decode('INVERSIONES FRIMECAR, C.A.'),0,0,'C');

		    @$pdf->SetFont('Arial','',6);

		    @$pdf->Cell(195,10,utf8_decode('RIF J-29807443-4'),0,0,'C');

		    @$pdf->Ln(7);

		    @$pdf->SetFont('Arial','B',6);
		    
		    @$pdf->Cell(64,3,utf8_decode('Urb. Simón Bolívar, Redoma Principal - Zona Postal 7101'),0,0,'C');

		    @$pdf->Cell(40,3,utf8_decode(''),0,0,'C');

		    @$pdf->Cell(30,3,utf8_decode('RECIBO DE PAGO'),1,0,'C');

		    @$pdf->SetFont('Arial','B',6);
		    
		    @$pdf->Cell(67,3,utf8_decode('Urb. Simón Bolívar, Redoma Principal - Zona Postal 7101'),0,0,'C');

		    @$pdf->Cell(45,3,utf8_decode(''),0,0,'C');

		    @$pdf->Cell(30,3,utf8_decode('RECIBO DE PAGO'),1,0,'C');

		    @$pdf->Ln(3);

		    @$pdf->SetFont('Arial','B',6);
		    
		    @$pdf->Cell(64,3,utf8_decode('Puerto Ayacucho - Edo Amazonas '),0,0,'C');

		    @$pdf->Cell(40,3,utf8_decode(''),0,0,'C');

		    @$pdf->Cell(30,3,utf8_decode('Nº: '.$id_asignacion),1,0,'C');

		    @$pdf->SetFont('Arial','B',6);
		    
		    @$pdf->Cell(73,3,utf8_decode('Puerto Ayacucho - Edo Amazonas '),0,0,'C');

		    @$pdf->Cell(39,3,utf8_decode(''),0,0,'C');

		    @$pdf->Cell(30,3,utf8_decode('Nº: '.$id_asignacion),1,0,'C');

		    @$pdf->Ln(3);

		    @$pdf->SetFont('Arial','B',6);
		    
		    @$pdf->Cell(64,3,utf8_decode('TELÉFONOS: (0248)234-4323 / (0416)234-9320 '),0,0,'C');

		    @$pdf->Cell(40,7,utf8_decode(''),0,0,'C');

		    @$pdf->SetFont('Arial','B',6);
		    
		    @$pdf->Cell(130,3,utf8_decode('TELÉFONOS: (0248)234-4323 / (0416)234-9320 '),0,0,'C');

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
			$pdf->Cell(45,6,date('d')." / ".date('m')." / ".date('Y'),0,0,'L',0);

			$pdf->Cell(2,6,'',0,0,'C',0);
			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(10,6,utf8_decode('Lugar: '),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(70,6,utf8_decode('PUERTO PÁEZ. EDO. APURE'),0,0,'L',0);

			$pdf->SetFont('Arial','',8);
			//$pdf->Cell(40,10,$row['region'],0,0,'C');
			$pdf->Cell(10,6,utf8_decode('Fecha: '),0,0,'L',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(45,6,date('d')." / ".date('m')." / ".date('Y'),0,0,'L',0);

			$pdf->ln(5);

			$pdf->SetFont('Arial','',8);
			
			$pdf->Cell(5,6,utf8_decode('Yo: '),0,0,'L',0);
			
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(75,6,utf8_decode($apellidoNombre),0,0,'L',0);
			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(15,6,utf8_decode('C.I o RIF: '),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(40,6,utf8_decode($cedula),0,0,'L',0);

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

			
			$sql_ = "SELECT * FROM sisdoc.tbl_asignacion_otros where fk_personal_otros = $id_personal and month(fecha_asignacion_otros) = $mes and fk_periodo_otros = $periodo";
			
			$re_=mysqli_query($link, $sql_);	

			while($fila_ = mysqli_fetch_array($re_))
            {	
            	@$total_cobrar = $fila_['monto_bono_vacacional'] + $fila_['monto_bono_fin_año'] + $fila_['monto_bono_'] + $fila_['monto_bono_otros'];
            }

            $pdf->SetFont('Arial','',8);
			$pdf->Cell(90,6,utf8_decode('He recibido de: INVERSIONES FRIMECAR, C.A., la cantidad de: Bs. '),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(45,6,utf8_decode(@$total_cobrar),0,0,'L',0);

			$pdf->Cell(2,6,'',0,0,'C',0);

			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(90,6,utf8_decode('He recibido de: INVERSIONES FRIMECAR, C.A., la cantidad de: Bs. '),0,0,'L',0);
        	
        	$pdf->SetFont('Arial','B',8);
			$pdf->Cell(45,6,utf8_decode(@$total_cobrar),0,0,'L',0);

        	$pdf->ln(5);


			$pdf->SetFont('Arial','',8);
			
			$pdf->Cell(21,6,utf8_decode('Fecha Abono: '),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			
			$pdf->Cell(59,6,utf8_decode($fecha),0,0,'L',0);

			$pdf->SetFont('Arial','',8);

			$pdf->Cell(15,6,utf8_decode('Cargo: '),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			
			$pdf->Cell(40,6,utf8_decode($cargo),0,0,'L',0);

			$pdf->Cell(2,6,'',0,0,'C',0);

			$pdf->SetFont('Arial','',8);
			
			$pdf->Cell(21,6,utf8_decode('Fecha Abono: '),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			
			$pdf->Cell(59,6,utf8_decode($fecha),0,0,'L',0);

			$pdf->SetFont('Arial','',8);

			$pdf->Cell(15,6,utf8_decode('Cargo: '),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			
			$pdf->Cell(40,6,utf8_decode($cargo),0,0,'L',0);


			$pdf->ln(10);

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

							
		
		$id_periodo = $periodo;				

		$sql_prueba = "select 
			                      id_personal, 
						 		  'MONTO VACACIONES' apellido_personal, 
								  (select 
								  	      monto_bono_vacacional 
								  	 from 
								  	      tbl_asignacion_otros 
								  	where  
								  	      fk_personal_otros = $id_personal and 
								  	      month(fecha_asignacion_otros) = $mes and 
								  	      fk_periodo_otros = $periodo) as monto,
								  (select 
								  	      dias_vacaciones 
								  	 from 
								  	      tbl_asignacion_otros 
								  	where  
								  	      fk_personal_otros = $id_personal and 
								  	      month(fecha_asignacion_otros) = $mes and 
								  	      fk_periodo_otros = $periodo) as dias

						   from tbl_personal where id_personal = $id_personal and estatus_personal = 1 union
				
	                   select 
			                      id_personal, 
						 		  'BONO FIN DE AÑO' apellido_personal, 
								  (select 
								  	      monto_bono_fin_año 
								  	 from 
								  	      tbl_asignacion_otros 
								  	where  
								  	      fk_personal_otros = $id_personal and 
								  	      month(fecha_asignacion_otros) = $mes and 
								  	      fk_periodo_otros = $periodo) as monto,
								  '' as dias

						    from tbl_personal where id_personal = $id_personal and estatus_personal = 1 union
					
	                   select 
			                      id_personal, 
						 		  'OTROS BONOS' apellido_personal, 
								  (select 
								  	      monto_bono_ 
								  	 from 
								  	      tbl_asignacion_otros 
								  	where  
								  	      fk_personal_otros = $id_personal and 
								  	      month(fecha_asignacion_otros) = $mes and 
								  	      fk_periodo_otros = $periodo) as monto,
								  '' as dias

						    from tbl_personal where id_personal = $id_personal and estatus_personal = 1 union
					 
	                   select 
			                      id_personal, 
						 		  'OTROS BONOS 1' apellido_personal, 
								  (select 
								  	      monto_bono_otros
								  	 from 
								  	      tbl_asignacion_otros 
								  	where  
								  	      fk_personal_otros = $id_personal and 
								  	      month(fecha_asignacion_otros) = $mes and 
								  	      fk_periodo_otros = $periodo) as monto,
								  '' as dias

						    from tbl_personal where id_personal = $id_personal and estatus_personal = 1";

        $sql_quincena=mysqli_query($link, $sql_prueba);


   		if ($sql_quincena)
		{
			while ($fila = mysqli_fetch_array($sql_quincena))
			{
				$descripcion = $fila['apellido_personal'];
				$asignacion = $fila['monto'];
				$deduccion = 0;
				$dias = $fila['dias'];;
				if($dias == '')
				{
					$dias = 0;
				}
				@$total_asig = $total_asig + $asignacion;
				@$total_deduc = $total_deduc + $deduccion;
				@$monto_pagar = $total_asig - $total_deduc;

				$pdf->SetFont('Arial','',8);
				$pdf->Cell(50,5,utf8_decode($descripcion),0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(15,5, $dias,0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(24,5, $asignacion,0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(23,5, $deduccion,0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(24,5,'',0,0,'L',1);

				$pdf->Cell(3,6,'',0,0,'C',0);

				$pdf->SetFont('Arial','',8);
				$pdf->Cell(50,5, $descripcion,0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(15,5, $dias,0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(24,5, $asignacion,0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(24,5, $deduccion,0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(24,5,'',0,0,'L',1);
				$pdf->Ln(5);
			}


				$pdf->SetFont('Arial','',8);
				$pdf->Cell(50,5, '',0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(15,5, '',0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(24,5, '',0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(23,5, '',0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(24,5,'',0,0,'L',1);

				$pdf->Cell(3,6,'',0,0,'C',0);

				$pdf->SetFont('Arial','',8);
				$pdf->Cell(50,5, '',0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(15,5, '',0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(24,5, '',0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(24,5, '',0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(24,5,'',0,0,'L',1);
				$pdf->Ln(5);

				$pdf->SetFont('Arial','',8);
				$pdf->Cell(50,5, '',0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(15,5, '',0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(24,5, '',0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(23,5, '',0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(24,5,'',0,0,'L',1);

				$pdf->Cell(3,6,'',0,0,'C',0);

				$pdf->SetFont('Arial','',8);
				$pdf->Cell(50,5, '',0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(15,5, '',0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(24,5, '',0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(24,5, '',0,0,'L',0);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(24,5,'',0,0,'L',1);
				$pdf->Ln(5);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(65,5,'Totales',1,0,'R',1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(24,5,$total_asig,1,0,'L',1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(23,5,$total_deduc,1,0,'L',1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(24,5,$monto_pagar,1,0,'L',1);

				$pdf->Cell(3,6,'',0,0,'C',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(65,5,'Totales',1,0,'R',1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(24,5,$total_asig,1,0,'L',1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(24,5,$total_deduc,1,0,'L',1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(24,5,$monto_pagar,1,0,'L',1);
				$pdf->Ln(10);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(80,5,'CONDICIONES DE PAGO',0,0,'C',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(60,5,'POR LA EMPRESA',0,0,'C',0);

				$pdf->Cell(3,6,'',0,0,'C',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(70,5,'CONDICIONES DE PAGO',0,0,'C',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(70,5,'POR LA EMPRESA',0,0,'C',0);

				$pdf->Ln(9);

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

				$pdf->Ln(9);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(80,5,'Recibi Conforme:',0,0,'L',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(56,5,'',0,0,'C',0);

				$pdf->Cell(3,6,'',0,0,'C',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(70,5,'Recibi Conforme:',0,0,'L',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(70,5,'',0,0,'C',0);

				$pdf->Ln(9);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(88,5,'_____________________________________________________',0,0,'C',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(50,5,'____________________________',0,0,'C',0);

				$pdf->Cell(3,6,'',0,0,'C',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(77,5,'___________________________________________________',0,0,'C',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(70,5,'_______________________________',0,0,'C',0);

				$pdf->Ln(9);

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

