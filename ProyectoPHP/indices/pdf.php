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

//Logo
$pdf->Image('../img/OSWI-logo-negro.png', 75, null, 50, 50);

// Titulo del recibo
$pdf->SetFont('times', 'B', 36);
//$pdf->Ln(10);
$pdf->Cell(0, 10, 'Recibo de Compra', 0, 1, 'C');
$pdf->SetFont('courier', 'I', 28);
$pdf->Ln(4);

//Pagina
$pdf->Cell(0, 10, '"Tenis OSWI"', 0, 1, 'C', false, 'https://tenisoswi.netlify.app');
$pdf->Ln(10);

// Descripcion de lo que se compro
$pdf->SetFont('Arial', '', 18);
$pdf->Cell(0,10,"Usuario: $usuario", 0,1);
$pdf->Cell(0,10,"Marca: $marca", 0,1);
$pdf->Cell(0,10,"Modelo: $modelo", 0,1);
$pdf->Cell(0,10,"Color: $color", 0,1);
$pdf->Cell(0,10,"Talla: $talla", 0,1);
$pdf->Cell(0,10,"Precio: $precio", 0,1);
$pdf->Ln(10);

$pdf->Cell(0,10,"Gracias por su preferencia!", 0,1, 'C');

// PDF
$pdf->Output('I', 'Recibo.pdf'); 

?>