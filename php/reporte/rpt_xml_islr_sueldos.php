<?php
require('../conectar.php');

$periodo = $_GET['periodo'];
$mes = $_GET['mes'];
$Name = "xml_islr_".$periodo."_".$mes.".xml";
$FileName = "./$Name";
$Header = '';
$Header .= "\r\n";

header ('Expires: 0');
header ('Cache-Control: private');
header ('Content-type: text/xml');
header ('Cache-Control:  must-revalidate, post-check=0, pre-check=0');
header ('Content-Description: File Transfer');
header ('Last-Modified: '.date('D, d M Y H:i:s'));
header ('Content-Disposition: attachment; filename="'.$Name.'"');
header ('Content-Transfer-Encoding: binary');


$resultado = mysqli_query($link, 'SELECT p.rif_personal, rt.n_factura, rt.n_control, rt.fecha_comprobante, rt.cantidad_retencion, rt.por_retencion FROM tbl_retencion_personal rt, tbl_personal p where rt.fk_personal = p.id_personal and mes_retencion = '.$mes.' and ano_retencion = '.$periodo);

header ("Content-type: text/xml");
echo ('<?xml version="1.0" encoding="ISO-8859-1"?>'."\n");
echo ("<RelacionRetencionesISLR RifAgente='J298074434' Periodo='".$periodo."".$mes."'>"."\n");
while ($dato = mysqli_fetch_array($resultado))
{
	list($Y, $m, $d)= explode('-', $dato['fecha_comprobante']);
	$monto = number_format($dato['cantidad_retencion'], 2, '.', '');
	echo ("<DetalleRetencion>"."\n");
	echo ("<RifRetenido>$dato[rif_personal]</RifRetenido>"."\n");
	echo ("<NumeroFactura>$dato[n_factura]</NumeroFactura>"."\n");
	echo ("<NumeroControl>$dato[n_control]</NumeroControl>"."\n");
	echo ("<FechaOperacion>$d/$m/$Y</FechaOperacion>"."\n");
	echo ("<CodigoConcepto>001</CodigoConcepto>"."\n");
	echo ("<MontoOperacion>$monto</MontoOperacion>"."\n");
	echo ("<PorcentajeRetencion>$dato[por_retencion]</PorcentajeRetencion>"."\n");
	echo ("</DetalleRetencion>"."\n");
	
}

echo ("</RelacionRetencionesISLR>");
