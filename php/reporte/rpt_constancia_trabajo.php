<?php 
session_start();
ob_start();
html_entity_decode("&aacute;");  
header("Content-Type: text/html; charset=iso-8859-1");
require("../lib/conexion.php");
require("../lib/consulta.php");
//require('FPDF/fpdf.php');
require('FPDF/fpdf.php');

$ced=$_REQUEST['ced'];

$consulta= new sisges();
//$ced=10516082528;

$sql_p="select * from periodo_escolar"; 
			   $re_p=$consulta->consulta($sql_p,$conectar); 
			   while($fila=mysql_fetch_array($re_p))
			   {
			   		$periodo=$fila['descripcion'];
			   }

$sql_a="SELECT  alumno.nombre_alumno, alumno.apellido_alumno, alumno.estado,
alumno.ci_alumno, grado.grado, grado.seccion, periodo_escolar.descripcion, alumno.sexo_alumno, 
alumno.fecha_nacimiento_alumno, alumno.estado_nac_alumno, representante.ci_representante,
 representante.nombre_representante, representante.apellido_representante
FROM alumno
INNER JOIN representante ON alumno.ci_representante = representante.ci_representante
INNER JOIN inscripcion ON alumno.ci_alumno = inscripcion.ci_alumno
INNER JOIN grado ON grado.id_grado = inscripcion.id_grado
INNER JOIN periodo_escolar ON periodo_escolar.id_periodo = inscripcion.id_periodo
WHERE alumno.ci_alumno='$ced' and periodo_escolar.descripcion='$periodo'";

$re_a=$consulta->consulta($sql_a,$conectar);
$fila_a=mysql_fetch_array($re_a);

if($fila_a==Null||$fila_a['estado']=='Inactivo')
{?>
<script language="javascript">
alert('El alumno no esta inscrito');
window.close();
//window.location="../generar_constancia.php";
</script>
<?php
}
else
{

$pdf=new FPDF();
$pdf->AddPage();
$alto=7;

$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,$alto,"República Bolivariana de Venezuela ",0,0);
$pdf->Ln(5);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,$alto,"Gobierno Bolivariano del Estado Miranda ",0,0);
$pdf->Ln(5);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,$alto,"Dirección General de Educación ",0,0);
$pdf->Ln(5);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,$alto,"Subregión Educativa N°1 'Altos Mirandinos' ",0,0);
$pdf->Ln(5);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,$alto,"Unidad Educativa Estatal 'Alberto Ravell' ",0,0);
$pdf->Ln(5);


$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,$alto,"Código D.E.A OD. 12391510 ",0,0);
$pdf->Ln(5);


$pdf->SetFont('Arial','B',16);
//$pdf->Image('../imagenes/logo2.png',10,10,190);
$pdf->Ln(25);
$pdf->Cell(180,$alto,"CONSTANCIA DE ESTUDIOS",0,0,'C');
$pdf->Ln(20);

$pdf->SetFont('Arial','',12.5);
// Parámetros: Cadena original, Numero de columnas a imprimir la cadena, Variable del FPDF para imprimir devuelta 
function textIntoCols($strOriginal,$noCols,$pdf) 
{ 
    $iAlturaRow = 7; //Altura entre renglones 
    $iMaxCharRow = 175; //Número máximo de caracteres por renglón 
    $iSizeMultiCell = $iMaxCharRow / $noCols; //Tamaño ancho para la columna 
    $iTotalCharMax = 9957; //Número máximo de caracteres por página 
    $iCharPerCol = $iTotalCharMax / $noCols; //Caracteres por Columna 
    $iCharPerCol = $iCharPerCol - 290; //Ajustamos el tamaño aproximado real del número de caracteres por columna 
    $iLenghtStrOriginal = strlen($strOriginal); //Tamaño de la cadena original 
    $iPosStr = 0; // Variable de la posición para la extracción de la cadena. 
    // get current X and Y 
    $start_x = $pdf->GetX(); //Posición Actual eje X 
    $start_y = $pdf->GetY(); //Posición Actual eje Y 
    $cont = 0; 
    while($iLenghtStrOriginal > $iPosStr) // Mientras la posición sea menor al tamaño total de la cadena entonces imprime 
    { 
        $strCur = substr($strOriginal,$iPosStr,$iCharPerCol);//Obtener la cadena actual a pintar 
        if($cont != 0) //Evaluamos que no sea la primera columna 
        { 
            // seteamos a X y Y, siendo el nuevo valor para X 
            // el largo de la multicelda por el número de la columna actual, 
            // más 10 que sumamos de separación entre multiceldas 
            $pdf->SetXY(($iSizeMultiCell*$cont)+10,$start_y); //Calculamos donde iniciará la siguiente columna 
        } 
        $pdf->MultiCell($iSizeMultiCell,$iAlturaRow,$strCur); //Pintamos la multicelda actual 
        $iPosStr = $iPosStr + $iCharPerCol; //Posicion actual de inicio para extracción de la cadena 
        $cont++; //Para el control de las columnas 
    }     
    return $pdf; 
}
//........ 
$pdf->SetFont('Arial','',12.5);
/*$alumno_ape=trim($fila_alumno[2]);
$alumno_nom=trim($fila_alumno[1]);
*/

$sql_d="select * from parametro where id_para='1'";
$re_d=$consulta->consulta($sql_d,$conectar);
$filad=mysql_fetch_array($re_d);

$conte="La suscrita, Directora de la Unidad Educativa Estadal Alberto Ravell, ubicada en la Calle Principal de Santa Eulalia, Sector El Tanque, Barrio San Pablito, Los Teques, Edo. Miranda; Por medio de la presente hace constar que el Alumno(a):$fila_a[1] $fila_a[0], Cédula N°:$ced, nació el $fila_a[8], en la ciudad de $fila_a[9], cursa estudios regulares en esta institución en el Nivel:$fila_a[4], Sección:$fila_a[5], durante el Período Escolar:$fila_a[6]";
//$pdf->Ln(5);
//$conte=$pdf->WriteHTML($conte);

//$conte=utf8_decode($conte);      
            // se pasa como parametros la variable con el texto, el número de columnas deseado y la variable con la que imprimes el pdf 

textIntoCols($conte,1,$pdf); 
//....... 

$pdf->Ln(7) ;


$dia=date("d");
$mes=date("m");
$año=date("Y");

$con="Representante:$fila_a[12] $fila_a[11] Cédula:$fila_a[10]";
//$cont2=utf8_decode($cont2); 

//$con=$pdf->WriteHTML($con);
//$pdf->Ln(7) ;
textIntoCols($con,1,$pdf);  
$pdf->Ln(7) ;

$cont2="Constancia que se expide a petición de la parte interesada, en Los Teques, el $dia del mes $mes de año $año";
//$cont2=utf8_decode($cont2);  

textIntoCols($cont2,1,$pdf); 
$pdf->Ln(15) ;


$cont3="Atentamente";
$pdf->Cell(180,$alto,"$cont3",0,0,'C');
$pdf->Ln(20) ;


$cont4="__________________";
$pdf->Cell(180,$alto,"$cont4",0,0,'C');
$pdf->Ln(8);

$cont5="$filad[4] $filad[1] $filad[2]";
$cont5=utf8_decode($cont5);  
$cont6="C.I. $filad[3]";
$pdf->Cell(180,$alto,"$cont5",0,0,'C');
$pdf->Ln(5);
$pdf->Cell(180,$alto,"$cont6",0,0,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','',11);
$cont7="Directora de la Institución";
//$cont7=utf8_decode($cont7);  
$pdf->Cell(180,$alto,"$cont7",0,0,'C');
$pdf->Ln(5);


$pdf->Output(); 

}

?>