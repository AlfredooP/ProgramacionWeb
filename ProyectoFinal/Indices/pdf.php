<?php

require('fpdf.php');

session_start();

// Validar que el usuario haya iniciado sesión
if (!isset($_SESSION['id'])) {
    $usuario = "No especificado";
} else {

    // Conectar a la base de datos para obtener el username del usuario
    $conexion = mysqli_connect("localhost", "root", "", "login-php", 3306) or die("Error en la conexión");

    $id = $_SESSION['id'];
    $consulta_usuario = "SELECT username FROM accounts WHERE id = $id";
    $resultado_usuario = mysqli_query($conexion, $consulta_usuario);

    if ($resultado_usuario) {
        $fila_usuario = mysqli_fetch_assoc($resultado_usuario);
        if ($fila_usuario) {
            $usuario = $fila_usuario['username'];
        } else {
            echo "<b>Error: Usuario no encontrado en la base de datos.</b>";
            exit();
        }
    } else {
        echo "<b>Error en la consulta: " . mysqli_error($conexion) . "</b>";
        exit();
    }
}

// $sesion = $_SESSION['control'];

if (isset($_SESSION['control'])) {
    $control = $_SESSION['control'];
} else {
    echo "La variable 'control' no está definida en la sesión.";
}

if ($control == '2') {

    $tenisid = $_SESSION['TenisID'];
    $modelo = $_SESSION['modelo'];
    $color = $_SESSION['color'];
    $talla = $_SESSION['talla'];
    $marca = $_SESSION['marca'];
    $cantidad = $_SESSION['cantidad'];
    $precio = $_SESSION['precio'];
    $cantidadAPagar = $_SESSION['cantidadAComprar'];
} else {
    $conexion = mysqli_connect("localhost", "root", "", "tenis", 3306) or die("Problemas con la conexión");

    $i = 1;
    $total = 0;
    $consulta = "SELECT  c.id, c.precio, c.color, c.talla, c.stock, ma.nombre as 'marca', mo.nombre as 'modelo', c.imagen, c.cantidad FROM carrito c, marca ma, modelo mo WHERE c.modelo = mo.id and c.marca = ma.id;";
    $resultado = mysqli_query($conexion, $consulta);

    // Crear el pdf
    $pdf = new FPDF();
    $pdf->AddPage();

    //Logo
    $pdf->Image('../img/OSWI-logo-negro.png', 75, null, 50, 50);

    // Titulo del recibo
    $pdf->SetFont('times', 'B', 36);
    //$pdf->Ln(10);
    $pdf->Cell(0, 10, 'Recibo de Compra', 0, 1, 'C');
    $pdf->SetFont('courier', 'B', 28);
    $pdf->Ln(4);

    //Pagina
    $pdf->Cell(0, 10, '"Tenis OSWI"', 0, 1, 'C', false, 'https://tenisoswi.netlify.app');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', '', 18);
    $pdf->Cell(0, 10, "Usuario: $usuario", 0, $i);

    while ($tenis = mysqli_fetch_assoc($resultado)) {
        $modelo = $tenis['modelo'];
        $color = $tenis['color'];
        $talla = $tenis['talla'];
        $marca = $tenis['marca'];
        $cantidad = $tenis['cantidad'];
        $precio = $tenis['precio'];

        // Descripcion de lo que se compro
        if ($tenis["stock"] == 0) {
            $pdf->Cell(0, 10, "Modelo: $modelo", 0, 1);
            $pdf->Cell(0, 10, "Marca: $marca", 0, 1);
            $pdf->Cell(0, 10, "Producto No Disponible de Momento", 0, 1);
            $pdf->Ln(10);
        } else {
            if ($tenis["stock"] <= $tenis['cantidad']) {
                $cantidad = $tenis["stock"];
                $pdf->SetFont('Arial', '', 18);
                $pdf->Cell(0, 10, "Modelo: $modelo", 0, $i);
                $pdf->Cell(0, 10, "Marca: $marca", 0, $i);
                $pdf->Cell(0, 10, "Color: $color", 0, $i);
                $pdf->Cell(0, 10, "Talla: $talla", 0, $i);
                $pdf->Cell(0, 10, "Precio: $precio $", 0, $i);
                $pdf->Cell(0, 10, "Cantidad: $cantidad (Ajustado a Existencias)", 0, $i);
                $pdf->Ln(10);
                $total += $precio * $cantidad;

                // Reflejar en el inventario
                $conexion = mysqli_connect("localhost", "root", "", "tenis", 3306) or die("Error en la conexión");
                $id = $tenis["id"];
                $consultaInv = "UPDATE tenis SET cantidad = cantidad - $cantidad WHERE id = $id;";
                $stmt = $conexion->prepare($consultaInv);
                $stmt->execute();
                $stmt->close();
            } else {
                $pdf->SetFont('Arial', '', 18);
                $pdf->Cell(0, 10, "Modelo: $modelo", 0, $i);
                $pdf->Cell(0, 10, "Marca: $marca", 0, $i);
                $pdf->Cell(0, 10, "Color: $color", 0, $i);
                $pdf->Cell(0, 10, "Talla: $talla", 0, $i);
                $pdf->Cell(0, 10, "Precio: $precio $", 0, $i);
                $pdf->Cell(0, 10, "Cantidad: $cantidad", 0, $i);
                $total += $precio * $cantidad;
                $pdf->Ln(10);

                // Reflejar en el inventario
                $conexion = mysqli_connect("localhost", "root", "", "tenis", 3306) or die("Error en la conexión");
                $id = $tenis["id"];
                $consultaInv = "UPDATE tenis SET cantidad = cantidad - $cantidad WHERE id = $id;";
                $stmt = $conexion->prepare($consultaInv);
                $stmt->execute();
                $stmt->close();
            }
        }
        $i++;
    }
    $pdf->Cell(0, 10, "Total a Pagar: $total $", 0, $i);
    $pdf->Cell(0, 10, "Gracias por su preferencia!", 0, $i, 'C');

    // PDF
    $pdf->Output('I', 'ReciboOSWI.pdf');
}

// Crear el pdf
$pdf = new FPDF();
$pdf->AddPage();

//Logo
$pdf->Image('../img/OSWI-logo-negro.png', 75, null, 50, 50);

// Titulo del recibo
$pdf->SetFont('times', 'B', 36);
//$pdf->Ln(10);
$pdf->Cell(0, 10, 'Recibo de Compra', 0, 1, 'C');
$pdf->SetFont('courier', 'B', 28);
$pdf->Ln(4);

//Pagina
$pdf->Cell(0, 10, '"Tenis OSWI"', 0, 1, 'C', false, 'https://tenisoswi.netlify.app');
$pdf->Ln(10);

// Descripcion de lo que se compro
$pdf->SetFont('Arial', '', 18);
if ($cantidad > 0) {
    $pdf->Cell(0, 10, "Usuario: $usuario", 0, 1);
    $pdf->Cell(0, 10, "Modelo: $modelo", 0, 1);
    $pdf->Cell(0, 10, "Marca: $marca", 0, 1);
    $pdf->Cell(0, 10, "Color: $color", 0, 1);
    $pdf->Cell(0, 10, "Talla: $talla", 0, 1);
    $pdf->Cell(0, 10, "Precio: $precio", 0, 1);
    $pdf->Cell(0, 10, "Cantidad: $cantidadAPagar", 0, 1);
    $pdf->Ln(10);

    // Reflejar en el inventario
    $conexion = mysqli_connect("localhost", "root", "", "tenis", 3306) or die("Error en la conexión");
    $consultaInv = "UPDATE tenis SET cantidad = cantidad - 1 WHERE id = $tenisid;";
    $stmt = $conexion->prepare($consultaInv);
    $stmt->execute();
    $stmt->close();
} else {
    $pdf->Cell(0, 10, "Usuario: $usuario", 0, 1);
    $pdf->Cell(0, 10, "Modelo: $modelo", 0, 1);
    $pdf->Cell(0, 10, "Marca: $marca", 0, 1);
    $pdf->Cell(0, 10, "Producto No Disponible de Momento", 0, 1);
    $pdf->Ln(10);
}

$pdf->Cell(0, 10, "Gracias por su preferencia!", 0, 1, 'C');

// PDF
$pdf->Output('I', 'ReciboOSWI.pdf');
