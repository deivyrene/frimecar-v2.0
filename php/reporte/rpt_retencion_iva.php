<?php

session_start ();
require('fpdf/fpdf.php');
require("../conectar.php"); //conexion


		@$id = $_GET['id'];
		@$n_comprobante = $_GET['comprobante'];
		

    	$sql_="select * from tbl_sujeto_retenido sr, 
    	                     tbl_retencion_iva ri 

    	                     where 
    	                     		sr.id_sujeto_retenido = ri.fk_sujeto_retenido
    	                     and   
    	                     		ri.fk_sujeto_retenido = $id
    	                     and 
    	                     		ri.n_comprobante_iva = '$n_comprobante' ";

    	$re_ = mysqli_query($link, $sql_);

    	$fila = mysqli_fetch_array($re_);

    	@$parte = explode('-', $fila['fecha_emision_iva']);
		@$ano = $parte['0'];
		@$mes = $parte['1'];
		@$dia = $parte['2'];
		@$fecha_com = $dia."/".$mes."/".$ano;

		@$parte_ = explode('-', $fila['fecha_factura_iva']);
		@$ano_ = $parte_['0'];
		@$mes_ = $parte_['1'];
		@$dia_ = $parte_['2'];
		@$fecha_com_ = $dia_."/".$mes_."/".$ano_;

class PDF extends FPDF
{

// Cabecera de página
function Header()
{
    @$this->Image('../imagenes/frimecar_.png',20,8,40,35);
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

			

			//Restore font and colors
			$pdf->SetFont('Arial','',10);
			$pdf->SetFillColor(225,225,225);
			$pdf->SetTextColor(0);

			@$pdf->Ln(-5);

		    @$pdf->SetFont('Arial','B',12);
			
			$pdf->Cell(400,6,utf8_decode('COMPROBANTE DE RETENCION DE I.V.A'),0,0,'C',0);

			@$pdf->Ln(5);

			@$pdf->SetFont('Arial','B',12);
			
			$pdf->Cell(400,6,utf8_decode(' '),0,0,'C',0);

			@$pdf->Ln(5);

			$pdf->SetFont('Arial','B',9);
			
			$pdf->Cell(400,6,utf8_decode('Emisión del Comprobante de Retención según Artículo 16 de Providencia '),0,0,'C',0);

			@$pdf->Ln(5);

			$pdf->Cell(400,6,utf8_decode('Administrativa Nº SNAT/2015/0049, Gaceta Oficial 40720 de fecha 10/08/2015'),0,0,'C',0);

			@$pdf->Ln(6);

			@$pdf->SetFont('Arial','B',9);
			
			$pdf->Cell(140,6,utf8_decode(' '),0,0,'C',0);

			@$pdf->SetFont('Arial','B',9);
			
			$pdf->Cell(70,4,utf8_decode('0- Nº de Comprobante de Retención:'),1,0,'C',0);

			$pdf->Cell(3,4,utf8_decode(' '),0,0,'C',0);

			$pdf->Cell(50,4,utf8_decode('1- Fecha de Emisión:'),1,0,'C',0);

			@$pdf->Ln(4);

			@$pdf->SetFont('Arial','B',9);
			
			$pdf->Cell(140,6,utf8_decode(' '),0,0,'C',0);

			@$pdf->SetFont('Arial','B',9);
			
			$pdf->Cell(70,6,utf8_decode('   '.$fila['n_comprobante_iva']),1,0,'C',0);

			$pdf->Cell(3,6,utf8_decode(' '),0,0,'C',0);

			$pdf->Cell(50,6,utf8_decode(' '.$fecha_com),1,0,'C',0);

		    // Salto de línea
		    @$pdf->Ln(-10);
		
		    $pdf->SetFont('Arial','B',10);
			
			$pdf->Cell(170,6,utf8_decode('Calle Principal, Local S/N, Urb. Simón Bolivar'),0,0,'C',0);

			

			@$pdf->Ln(4);

			$pdf->SetFont('Arial','B',8);
			
			$pdf->Cell(170,6,utf8_decode('Puerto Ayacucho-Edo. Amazonas - Z.P 7101'),0,0,'C',0);



			@$pdf->Ln(4);

			$pdf->SetFont('Arial','B',8);
			
			$pdf->Cell(170,6,utf8_decode('TELÉFONO: 0416-4418173'),0,0,'C',0);



			$pdf->ln(18);
			
			$pdf->SetFont('Arial','B',9);

			$pdf->Cell(15,4,utf8_decode(''),0,0,'L',0);
			
			$pdf->CellFitSpace(140,4,utf8_decode('2- Nombre o Razón Social del Agente de Retención: '),1,0,'L',0);

			$pdf->Cell(5,4,utf8_decode(''),0,0,'L',0);

			$pdf->CellFitSpace(48,4,utf8_decode('3- RIF del Agente de Retención: '),1,0,'L',0);

			$pdf->Cell(5,4,utf8_decode(''),0,0,'L',0);

			$pdf->CellFitSpace(50,4,utf8_decode('4- Período Fiscal: '),1,0,'L',0);

			$pdf->ln(4);
			
			$pdf->SetFont('Arial','B',12);

			$pdf->Cell(15,4,utf8_decode(''),0,0,'L',0);
			
			$pdf->CellFitSpace(140,6,utf8_decode('    Inversiones FRIMECAR, C.A'),1,0,'L',0);

			$pdf->Cell(5,6,utf8_decode(''),0,0,'L',0);

			$pdf->CellFitSpace(48,6,utf8_decode('     J-29807443-4 '),1,0,'L',0);

			$pdf->Cell(5,6,utf8_decode(''),0,0,'L',0);

			$pdf->CellFitSpace(50,6,utf8_decode('AÑO: '.$fila['ano_iva'].'   MES: '.$fila['mes_iva']),1,0,'L',0);



			$pdf->ln(10);

			$pdf->SetFont('Arial','B',9);

			$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);
			
			$pdf->Cell(248,4,utf8_decode('5- Dirección Fiscal del Agente de Retención:  '),1,0,'L',0);

			$pdf->ln(4);


			$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);
			
			$pdf->Cell(248,6,utf8_decode('    Calle Pincipal, local S/N, Urb. Simón Bolívar - Puerto Ayacucho - Edo. Amazonas '),1,0,'L',0);
			

			$pdf->ln(10);

			$pdf->SetFont('Arial','B',9);

			$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);
			
			$pdf->Cell(200,4,utf8_decode('6- Nombre o Razón Social del Sujeto Retenido:  '),1,0,'L',0);

			$pdf->Cell(4,4,utf8_decode(''),0,0,'L',0);

			$pdf->Cell(44,4,utf8_decode('7- RIF del Sujeto Retenido'),1,0,'L',0);

			$pdf->ln(4);

			$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);
			
			$pdf->Cell(200,7,utf8_decode('    '.$fila['nombre_sujeto']),1,0,'L',0);
			
			$pdf->Cell(4,7,utf8_decode(' '),0,0,'L',0);

			$pdf->Cell(44,7,utf8_decode(' '.$fila['rif_sujeto']),1,0,'C',0);

			$pdf->ln(10);

			$pdf->SetFont('Arial','B',9);

			$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);
			
			$pdf->Cell(248,4,utf8_decode('8- Dirección Fiscal del Sujeto Retenido:  '),1,0,'L',0);

			$pdf->ln(4);


			$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);
			
			$pdf->Cell(248,7,utf8_decode('     '.$fila['direccion_sujeto']),1,0,'L',0);
			
			
			$pdf->ln(10);

			$pdf->Cell(9,6,utf8_decode(''),0,0,'L',0);

			$pdf->SetFillColor(179,180,183);
			$pdf->SetTextColor(0);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(9,5,utf8_decode('Nº'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(25,5,utf8_decode('Fecha de'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(25,5,utf8_decode('Nº'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(25,5,utf8_decode('Nº '),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(12,5,utf8_decode('Nº'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(12,5,utf8_decode('Nº'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(14,5,utf8_decode('Tipo'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(17,5,utf8_decode('Nº Fact.'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(22,5,utf8_decode('Tot. Compra'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(22,5,utf8_decode('Tot. Compra'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(20,5,utf8_decode('Base'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(14,5,utf8_decode('%'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(21,5,utf8_decode('Impuesto'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(21,5,utf8_decode('I.V.A'),1,0,'C',1);

			$pdf->Ln(5);

			$pdf->Cell(9,6,utf8_decode(''),0,0,'L',0);

			
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(9,5,utf8_decode('Oper.'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(25,5,utf8_decode('Factura'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(25,5,utf8_decode('Factura'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(25,5,utf8_decode('Control'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(12,5,utf8_decode('Débito'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(12,5,utf8_decode('Crédito'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(14,5,utf8_decode('Trans.'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(17,5,utf8_decode('Afectada.'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(22,5,utf8_decode('con Iva'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(22,5,utf8_decode('Exentas'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(20,5,utf8_decode('Imponible'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(14,5,utf8_decode('Alicuota'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(21,5,utf8_decode('I.V.A'),1,0,'C',1);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(21,5,utf8_decode('Retenido'),1,0,'C',1);
			
			$pdf->Ln(5);


			$sql__="select * from tbl_sujeto_retenido sr, 
    	                     tbl_retencion_iva ri 

    	                     where 
    	                     		sr.id_sujeto_retenido = ri.fk_sujeto_retenido
    	                     and   
    	                     		ri.fk_sujeto_retenido = $id
    	                     and 
    	                     		ri.n_comprobante_iva = '$n_comprobante'
    	                     ";

    		$re__ = mysqli_query($link, $sql__);

			while($fila_=mysqli_fetch_array($re__))
			{

				@$sum_total_iva = number_format($sum_total_iva  + $fila_['total_compra_iva'], 2, '.', '');
				@$sum_total_exc = number_format($sum_total_exc + $fila_['total_compra_excenta_iva'], 2, '.', '');
				@$sum_base_imp =  number_format($sum_base_imp + $fila_['base_imponible_iva'], 2, '.', '');
				@$sum_imp_iva =   number_format($sum_imp_iva + $fila_['impuesto_iva'], 2, '.', '');
				@$sum_ret_iva =   number_format($sum_ret_iva + $fila_['iva_retenido'], 2, '.', '');

				$pdf->Cell(9,6,utf8_decode(''),0,0,'L',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->CellFitSpace(9,5,utf8_decode(' '.$fila_['n_operacion']),1,0,'C',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->CellFitSpace(25,5,utf8_decode(' '.$fecha_com_),1,0,'C',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->CellFitSpace(25,5,utf8_decode('  '.$fila_['n_factura_iva']),1,0,'C',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->CellFitSpace(25,5,utf8_decode('  '.$fila_['n_control_iva']),1,0,'C',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->CellFitSpace(12,5,utf8_decode('  '.$fila_['n_debito_iva']),1,0,'C',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->CellFitSpace(12,5,utf8_decode('  '.$fila_['n_credito_iva']),1,0,'C',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->CellFitSpace(14,5,utf8_decode('  '.$fila_['tipo_transacc_iva']),1,0,'C',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->CellFitSpace(17,5,utf8_decode('  '.$fila_['n_factura_afectada_iva']),1,0,'C',0);
				$pdf->SetFont('Arial','B',8);			
				$pdf->CellFitSpace(22,5,utf8_decode('  '.number_format($fila_['total_compra_iva'], 2, '.', '')),1,0,'C',0);
				$pdf->SetFont('Arial','B',8);			
				$pdf->CellFitSpace(22,5,utf8_decode('  '.number_format($fila_['total_compra_excenta_iva'], 2, '.', '')),1,0,'C',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->CellFitSpace(20,5,utf8_decode('  '.number_format($fila_['base_imponible_iva'], 2, '.', '')),1,0,'C',0);
				$pdf->SetFont('Arial','B',8);				
				$pdf->CellFitSpace(14,5,utf8_decode('  '.number_format($fila_['alicuota_iva'], 2, '.', '')),1,0,'C',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->CellFitSpace(21,5,utf8_decode('  '.number_format($fila_['impuesto_iva'], 2, '.', '')),1,0,'C',0);
				$pdf->SetFont('Arial','B',8);
				$pdf->CellFitSpace(21,5,utf8_decode('  '.number_format($fila_['iva_retenido'], 2, '.', '')),1,0,'C',0);

				$pdf->Ln(5);

			}
			

			$pdf->Cell(9,6,utf8_decode(''),0,0,'L',0);

			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(139,5,utf8_decode(' TOTALES'),1,0,'R',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(22,5,utf8_decode('  '.$sum_total_iva),1,0,'C',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(22,5,utf8_decode(' '.$sum_total_exc),1,0,'C',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(20,5,utf8_decode('  '.$sum_base_imp),1,0,'C',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(14,5,utf8_decode('  '.$fila['alicuota_iva']),1,0,'C',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(21,5,utf8_decode('  '.$sum_imp_iva),1,0,'C',0);
			$pdf->SetFont('Arial','B',8);
			$pdf->CellFitSpace(21,5,utf8_decode('  '.$sum_ret_iva),1,0,'C',0);
   		
			
				$pdf->Ln(15);

				$pdf->Cell(15,6,utf8_decode(''),0,0,'L',0);


				$pdf->Ln(10);

				$pdf->Cell(35,6,utf8_decode(''),0,0,'L',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(88,5,'_______________________________________________',0,0,'C',0);

				$pdf->Cell(60,6,utf8_decode(''),0,0,'L',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(50,5,'_______________________________________________',0,0,'C',0);


				$pdf->Ln(5);

				$pdf->Cell(35,6,utf8_decode(''),0,0,'L',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(88,5,'FIRMA Y SELLO DEL AGENTE DE RETENCION',0,0,'C',0);

				$pdf->Cell(60,6,utf8_decode(''),0,0,'L',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(50,5,'FIRMA Y SELLO DEL CONTRIBUYENTE RETENIDO',0,0,'C',0);

				$pdf->Ln(5);

				$pdf->Cell(35,6,utf8_decode(''),0,0,'L',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(88,5,'RIF:J-29807443-4',0,0,'C',0);

				$pdf->Cell(60,6,utf8_decode(''),0,0,'L',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(50,5,' ',0,0,'C',0);

				$pdf->Ln(5);

				$pdf->Cell(35,6,utf8_decode(''),0,0,'L',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(88,5,' ',0,0,'C',0);

				$pdf->Cell(60,6,utf8_decode(''),0,0,'L',0);

				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(50,5,utf8_decode(' '),0,0,'C',0);




//**************************************************************
$pdf->PageNo(); 
$pdf->Output('retencion.pdf','I');

?>

