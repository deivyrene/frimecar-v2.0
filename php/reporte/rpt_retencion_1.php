<?php

session_start ();
require('fpdf/fpdf.php');
require("../conectar.php"); //conexion


		@$id = $_GET['id'];
		@$con = $_GET['con'];
		@$mes = date('m');
    	@$ano = date('Y');
    	@$temp = "";
    	@$concat = "id_personal = ".$id." ";

    	if(!empty($_GET['temp']))
    	{
			@$temp = $_GET['temp'];
			@$cedula = $_GET['cedula'];
			@$mes = $_GET['mes'];
    		@$ano = $_GET['periodo'];
    		@$concat = "cedula_personal = '".$cedula."' ";
    	}

    	$sql_empresa = "select * from tbl_empresa order by id_empresa desc";

		$re_empresa = mysqli_query($link, $sql_empresa);

		$row_empresa = mysqli_fetch_array($re_empresa);


class PDF extends FPDF
{

// Cabecera de página
function Header()
{
    //@$this->Image('../img/logo.png',20,8,35);
    // Arial bold 15
	
    
   
}

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

			
			if($con != "")
			{
				$sql = "select * from tbl_retencion_personal, tbl_personal where 
																		 fk_personal = id_personal and ".$concat." 
																	order by id_retencion_personal desc";
			}
			else
			{
				$sql="select * from tbl_retencion_personal, tbl_personal where 
																		 fk_personal = id_personal and ".$concat." 
																	and  mes_retencion = $mes 
																	and  ano_retencion = $ano
																	order by id_retencion_personal desc";
			}


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
				$pdf->Output();
			}
			else
			{

			    if($temp == "temp")
				{
					while($fila = mysqli_fetch_array($re))
					{

						$apellidoNombre = $fila['apellido_personal']." ".$fila['nombre_personal'];
						$cedula = $fila['cedula_personal'];


						//Restore font and colors
						$pdf->SetFont('Arial','',10);
						$pdf->SetFillColor(225,225,225);
						$pdf->SetTextColor(0);

						@$pdf->Ln(-5);

					    @$pdf->SetFont('Arial','B',12);
					   
					   
					    // Salto de línea
					    @$pdf->Ln(15);
					
					    $pdf->SetFont('Arial','B',10);
						
						$pdf->Cell(276,6,utf8_decode('COMPROBANTE DE RETENCIÓN ISLR, SALARIOS Y OTRAS'),0,0,'C',0);


						$pdf->ln(10);
						
						$pdf->SetFont('Arial','B',8);

						$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);
						
						$pdf->CellFitSpace(57,6,utf8_decode('Nº COMPROBANTE: '.$fila['n_comprobante']),1,0,'L',0);

						$pdf->SetFont('Arial','B',8);

						$pdf->Cell(135,6,utf8_decode(''),0,0,'L',0);
						
						@$parte = explode('-', $fila['fecha_comprobante']);
						@$ano = $parte['0'];
						@$mes = $parte['1'];
						@$dia = $parte['2'];
						@$fecha_com = $dia."/".$mes."/".$ano;

						$pdf->Cell(55,6,utf8_decode('FECHA: '.$fecha_com),1,0,'L',0);


						$pdf->ln(10);

						$pdf->SetFont('Arial','B',8);

						$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);
						
						$pdf->Cell(125,6,utf8_decode('NOMBRE DEL AGENTE DE RETENCIÓN: '.$row_empresa['nombre_empresa']),1,0,'L',0);

						$pdf->SetFont('Arial','B',8);

						$pdf->Cell(44,6,utf8_decode(''),0,0,'L',0);
						
						$pdf->Cell(78,6,utf8_decode('REGISTRO DE INFORMACIÓN FISCAL: '.$row_empresa['rif_empresa']),1,0,'L',0);
						
						
						$pdf->ln(10);

						$pdf->SetFont('Arial','B',8);

						$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);
						
						$pdf->Cell(125,6,utf8_decode('DIRECCIÓN FISCAL: '.$row_empresa['direccion_empresa']),1,0,'L',0);

						$pdf->SetFont('Arial','B',8);

						$pdf->Cell(44,6,utf8_decode(''),0,0,'L',0);
						
						$pdf->Cell(78,6,utf8_decode('PERÍODO FISCAL: AÑO: '.$fila['ano_retencion'].' MES: '.$fila['mes_retencion']),1,0,'L',0);


						$pdf->ln(10);

						$pdf->SetFont('Arial','B',8);

						$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);
						
						$pdf->Cell(125,6,utf8_decode('NOMBRE DEL SUJETO RETENIDO: '.$apellidoNombre),1,0,'L',0);

						$pdf->SetFont('Arial','B',8);

						$pdf->Cell(44,6,utf8_decode(''),0,0,'L',0);
						
						$pdf->Cell(78,6,utf8_decode('REGISTRO DE INFORMACIÓN FISCAL: '.$fila['rif_personal']),1,0,'L',0);

						$pdf->ln(10);

						$pdf->SetFont('Arial','B',8);

						$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);
						
						$pdf->Cell(125,6,utf8_decode('DIRECCION FISCAL: '.strtoupper($fila['direccion_personal'])),1,0,'L',0);


						$pdf->ln(10);

						$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);

						$pdf->SetFillColor(179,180,183);
						$pdf->SetTextColor(0);
						$pdf->SetFont('Arial','B',8);
						$pdf->CellFitSpace(10,5,utf8_decode('Nº Op.'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->CellFitSpace(20,5,utf8_decode('Fecha de Pago'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(22,5,utf8_decode('Nº Factura'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->CellFitSpace(22,5,utf8_decode('Nº Control'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->CellFitSpace(12,5,utf8_decode('Nº Débito'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->CellFitSpace(12,5,utf8_decode('Nº Crédito'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(27,5,utf8_decode('Tipo Trans.'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(28,5,utf8_decode('Cant. Obj. Reten.'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(13,5,utf8_decode('% Reten.'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(28,5,utf8_decode('Cant. Pag.'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(28,5,utf8_decode('Imp. Retenido'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(25,5,utf8_decode('Código Concep.'),1,0,'C',1);

						$pdf->Ln(5);


						$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);

						
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(10,5,utf8_decode($fila['n_operacion']),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						@$parte_ = explode('-',$fila['fecha_abono']);
						@$ano_ = $parte_['0'];
						@$mes_ = $parte_['1'];
						@$dia_ = $parte_['2'];
						@$fecha_com_ = $dia_."/".$mes_."/".$ano_;
						$pdf->Cell(20,5,utf8_decode($fecha_com_),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(22,5,utf8_decode($fila['n_factura']),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(22,5,utf8_decode($fila['n_control']),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(12,5,utf8_decode($fila['n_debito']),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(12,5,utf8_decode($fila['n_credito']),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(27,5,utf8_decode($fila['tipo_transacc']),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(28,5,utf8_decode(number_format($fila['cantidad_retencion'], 2, '.', '')),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(13,5,utf8_decode(number_format($fila['por_retencion'], 2, '.', '')),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(28,5,utf8_decode(number_format($fila['cantidad_pagada'], 2, '.', '')),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(28,5,utf8_decode(number_format($fila['impuesto_retenido'], 2, '.', '')),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(25,5,utf8_decode($fila['codigo_concepto']),1,0,'C',0);

						$pdf->Ln(5);


						$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);

						
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(166,5,utf8_decode('TOTALES'),1,0,'R',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(28,5,utf8_decode(number_format($fila['cantidad_pagada'], 2, '.', '')),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(28,5,utf8_decode(number_format($fila['impuesto_retenido'], 2, '.', '')),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(25,5,utf8_decode(''),1,0,'C',0);


		   		
					
						$pdf->Ln(20);

						$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);


						$pdf->Ln(9);

						$pdf->Cell(35,6,utf8_decode(''),0,0,'L',0);

						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(88,5,'______________________________________',0,0,'C',0);

						$pdf->Cell(60,6,utf8_decode(''),0,0,'L',0);

						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(50,5,'________________________________',0,0,'C',0);


						$pdf->Ln(5);

						$pdf->Cell(35,6,utf8_decode(''),0,0,'L',0);

						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(88,5,'FIRMA DEL AGENTE DE RETENCION',0,0,'C',0);

						$pdf->Cell(60,6,utf8_decode(''),0,0,'L',0);

						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(50,5,'RECIBIDO POR',0,0,'C',0);

						$pdf->Ln(5);

						$pdf->Cell(35,6,utf8_decode(''),0,0,'L',0);

						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(88,5,$row_empresa['nombre_empresa']." ".$row_empresa['rif_empresa'],0,0,'C',0);

						$pdf->Cell(60,6,utf8_decode(''),0,0,'L',0);

						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(50,5,utf8_decode($apellidoNombre),0,0,'C',0);

						$pdf->Ln(60);

						
					}
				}
				else
				{
					    $fila = mysqli_fetch_array($re);
					

						$apellidoNombre = $fila['apellido_personal']." ".$fila['nombre_personal'];
						$cedula = $fila['cedula_personal'];

				
						//Restore font and colors
						$pdf->SetFont('Arial','',10);
						$pdf->SetFillColor(225,225,225);
						$pdf->SetTextColor(0);

						@$pdf->Ln(-5);

					    @$pdf->SetFont('Arial','B',12);
					   
					   
					    // Salto de línea
					    @$pdf->Ln(15);
					
					    $pdf->SetFont('Arial','B',10);
						
						$pdf->Cell(276,6,utf8_decode('COMPROBANTE DE RETENCIÓN ISLR, SALARIOS Y OTRAS'),0,0,'C',0);


						$pdf->ln(10);
						
						$pdf->SetFont('Arial','B',8);

						$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);
						
						$pdf->CellFitSpace(57,6,utf8_decode('Nº COMPROBANTE: '.$fila['n_comprobante']),1,0,'L',0);

						$pdf->SetFont('Arial','B',8);

						$pdf->Cell(135,6,utf8_decode(''),0,0,'L',0);

						@$parte = explode('-', $fila['fecha_comprobante']);
						@$ano = $parte['0'];
						@$mes = $parte['1'];
						@$dia = $parte['2'];
						@$fecha_com = $dia."/".$mes."/".$ano;

						
						$pdf->Cell(55,6,utf8_decode('FECHA: '.$fecha_com),1,0,'L',0);


						$pdf->ln(10);

						$pdf->SetFont('Arial','B',8);

						$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);
						
						$pdf->Cell(125,6,utf8_decode('NOMBRE DEL AGENTE DE RETENCIÓN: '.$row_empresa['nombre_empresa']),1,0,'L',0);

						$pdf->SetFont('Arial','B',8);

						$pdf->Cell(44,6,utf8_decode(''),0,0,'L',0);
						
						$pdf->Cell(78,6,utf8_decode('REGISTRO DE INFORMACIÓN FISCAL: '.$row_empresa['rif_empresa']),1,0,'L',0);
						
						
						$pdf->ln(10);

						$pdf->SetFont('Arial','B',8);

						$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);
						
						$pdf->Cell(125,6,utf8_decode('DIRECCIÓN FISCAL: '.$row_empresa['direccion_empresa']),1,0,'L',0);

						$pdf->SetFont('Arial','B',8);

						$pdf->Cell(44,6,utf8_decode(''),0,0,'L',0);
						
						$pdf->Cell(78,6,utf8_decode('PERÍODO FISCAL: AÑO: '.$fila['ano_retencion'].' MES: '.$fila['mes_retencion']),1,0,'L',0);


						$pdf->ln(10);

						$pdf->SetFont('Arial','B',8);

						$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);
						
						$pdf->Cell(125,6,utf8_decode('NOMBRE DEL SUJETO RETENIDO: '.$apellidoNombre),1,0,'L',0);

						$pdf->SetFont('Arial','B',8);

						$pdf->Cell(44,6,utf8_decode(''),0,0,'L',0);
						
						$pdf->Cell(78,6,utf8_decode('REGISTRO DE INFORMACIÓN FISCAL: '.$fila['rif_personal']),1,0,'L',0);

						$pdf->ln(10);

						$pdf->SetFont('Arial','B',8);

						$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);
						
						$pdf->Cell(125,6,utf8_decode('DIRECCION FISCAL: '.$fila['direccion_personal']),1,0,'L',0);



						


						$pdf->ln(10);

						$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);

						$pdf->SetFillColor(179,180,183);
						$pdf->SetTextColor(0);
						$pdf->SetFont('Arial','B',8);
						$pdf->CellFitSpace(10,5,utf8_decode('Nº Op.'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->CellFitSpace(20,5,utf8_decode('Fecha de Pago'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(22,5,utf8_decode('Nº Factura'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->CellFitSpace(22,5,utf8_decode('Nº Control'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->CellFitSpace(12,5,utf8_decode('Nº Débito'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->CellFitSpace(12,5,utf8_decode('Nº Crédito'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(27,5,utf8_decode('Tipo Trans.'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(28,5,utf8_decode('Cant. Obj. Reten.'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(13,5,utf8_decode('% Reten.'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(28,5,utf8_decode('Cant. Pag.'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(28,5,utf8_decode('Imp. Retenido'),1,0,'C',1);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(25,5,utf8_decode('Código Concep.'),1,0,'C',1);

						$pdf->Ln(5);


						$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);

						
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(10,5,utf8_decode($fila['n_operacion']),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						@$parte_ = explode('-',$fila['fecha_abono']);
						@$ano_ = $parte_['0'];
						@$mes_ = $parte_['1'];
						@$dia_ = $parte_['2'];
						@$fecha_com_ = $dia_."/".$mes_."/".$ano_;
						$pdf->Cell(20,5,utf8_decode($fecha_com_),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(22,5,utf8_decode($fila['n_factura']),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(22,5,utf8_decode($fila['n_control']),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(12,5,utf8_decode($fila['n_debito']),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(12,5,utf8_decode($fila['n_credito']),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(27,5,utf8_decode($fila['tipo_transacc']),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(28,5,utf8_decode(number_format($fila['cantidad_retencion'], 2, '.', '')),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(13,5,utf8_decode(number_format($fila['por_retencion'], 2, '.', '')),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(28,5,utf8_decode(number_format($fila['cantidad_pagada'], 2, '.', '')),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(28,5,utf8_decode(number_format($fila['impuesto_retenido'], 2, '.', '')),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(25,5,utf8_decode($fila['codigo_concepto']),1,0,'C',0);

						$pdf->Ln(5);


						$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);

						
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(166,5,utf8_decode('TOTALES'),1,0,'R',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(28,5,utf8_decode(number_format($fila['cantidad_pagada'], 2, '.', '')),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(28,5,utf8_decode(number_format($fila['impuesto_retenido'], 2, '.', '')),1,0,'C',0);
						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(25,5,utf8_decode(''),1,0,'C',0);


		   		
					
						$pdf->Ln(20);

						$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);


						$pdf->Ln(9);

						$pdf->Cell(35,6,utf8_decode(''),0,0,'L',0);

						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(88,5,'______________________________________',0,0,'C',0);

						$pdf->Cell(60,6,utf8_decode(''),0,0,'L',0);

						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(50,5,'________________________________',0,0,'C',0);


						$pdf->Ln(5);

						$pdf->Cell(35,6,utf8_decode(''),0,0,'L',0);

						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(88,5,'FIRMA DEL AGENTE DE RETENCION',0,0,'C',0);

						$pdf->Cell(60,6,utf8_decode(''),0,0,'L',0);

						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(50,5,'RECIBIDO POR',0,0,'C',0);

						$pdf->Ln(5);

						$pdf->Cell(35,6,utf8_decode(''),0,0,'L',0);

						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(88,5,$row_empresa['nombre_empresa']." ".$row_empresa['rif_empresa'],0,0,'C',0);

						$pdf->Cell(60,6,utf8_decode(''),0,0,'L',0);

						$pdf->SetFont('Arial','B',8);
						$pdf->Cell(50,5,utf8_decode($apellidoNombre),0,0,'C',0);


				}



			}

$pdf->PageNo(); 
$pdf->Output();
?>

