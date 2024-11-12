<?php

require('fpdf.php');

$usuario = 'David Avalos';
$marca = 'Nike';
$modelo = 'Jordan 4';
$color = 'Amarillo con Negro';
$talla = '28 (MX)';
$precio = '$2800';

// Crear el pdf
$pdf = new FPDF();
$pdf->AddPage();

// Titulo del recibo
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Recibo de Compra', 0, 1, 'C');
$pdf->Ln(10);

// Descripcion de lo que se compro
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0,10,"Usuario: $usuario", 0,1);
$pdf->Cell(0,10,"Marca: $marca", 0,1);
$pdf->Cell(0,10,"Modelo: $modelo", 0,1);
$pdf->Cell(0,10,"Color: $color", 0,1);
$pdf->Cell(0,10,"Talla: $talla", 0,1);
$pdf->Cell(0,10,"Precio: $precio", 0,1);
$pdf->Ln(10);

// PDF
$pdf->Output('I', 'Recibo.pdf'); 

?>