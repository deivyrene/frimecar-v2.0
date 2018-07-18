<?php
//***********************************************************************************************************************************************
//***********************************************************************************************************************************************
//***********************************************************************************************************************************************
// César Ríos Granados - México 10/01/2012
// crios@bam.com.mx
// infected_artillery@hotmail.com
//
// Parámetros: Cadena original, Numero de columnas a imprimir la cadena, Variable del FPDF para imprimir devuelta
function textIntoCols($strOriginal,$noCols,$pdf)
{
    $iAlturaRow = 7; //Altura entre renglones
    $iMaxCharRow = 250; //Número máximo de caracteres por renglón
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
//***********************************************************************************************************************************************
//***********************************************************************************************************************************************
//***********************************************************************************************************************************************  
?>