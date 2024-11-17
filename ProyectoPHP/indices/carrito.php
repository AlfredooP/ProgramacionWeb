<?php

require 'headerProd.html';
echo "<title>OSWI - Carrito</title>";
echo "<h1 class=\"subtitulo\"> Carrito de compra </h1>";
echo "<h1 class=\"fondo\">";

$conexion = mysqli_connect("localhost", "root", "", "tenis", 3306) or die("Problemas con la conexión"); 

if (isset($_GET['producto']) && isset($_GET['eliminar']) && $_GET['eliminar'] == 'false') {
    $producto = $_GET['producto'];
    $consulta = "SELECT  c.id, c.precio, c.color, c.talla, ma.nombre as 'marca', mo.nombre as 'modelo', c.imagen, c.cantidad FROM carrito c, marca ma, modelo mo WHERE c.modelo = mo.id and c.marca = ma.id;";
    $resultado = mysqli_query($conexion, $consulta);
    while ($tenis = mysqli_fetch_assoc($resultado)) {
        if ($tenis["id"] == $producto) {
            $consulta = "UPDATE carrito SET cantidad = '" . ($tenis["cantidad"] + 1) . "' WHERE id = '" . $tenis["id"] . "';";
            mysqli_query($conexion, $consulta);
            $producto = 0;
        }
    }
    if ($producto != 0) {
        $consulta = "INSERT INTO carrito (id, precio, color, talla, marca, modelo, imagen, cantidad) SELECT id, precio, color, talla, marca, modelo, imagen, 1 FROM tenis WHERE id = '" . $producto . "';";
        mysqli_query($conexion, $consulta);
    }
} else if (isset($_GET['producto']) && isset($_GET['eliminar']) && $_GET['eliminar'] == 'true') {
    $producto = $_GET['producto'];
    $consulta = "DELETE FROM carrito WHERE id = " . $producto;
    mysqli_query($conexion, $consulta);
}

$consulta = "SELECT  c.id, c.precio, c.color, c.talla, ma.nombre as 'marca', mo.nombre as 'modelo', c.imagen, c.cantidad FROM carrito c, marca ma, modelo mo WHERE c.modelo = mo.id and c.marca = ma.id;";
$resultado = mysqli_query($conexion, $consulta);
$total = 0;
$numProd = 0;

while ($tenis = mysqli_fetch_assoc($resultado)) {
    echo $tenis["modelo"] . "<br>";
    echo "Color(es): " . $tenis["color"] . "<br>";
    echo "Talla: " . $tenis["talla"] . "(MX)<br>";
    echo "Marca: " . $tenis["marca"] . "<br>";
    echo "Cantidad: " . $tenis["cantidad"] . " pieza(s)<br>";
    echo "$" . $tenis["precio"] . " MXN<br>";
    echo "<img src=\"../img/" . $tenis["imagen"] . "\" width=\"10%\">";
    echo "<br><a class=\"boton\" href=\"carrito.php?producto=" . $tenis["id"] . "&eliminar=true\">Borrar del Carrito</a>";
    echo "<br><a class=\"boton\" href=\"compra.php?total=" . $tenis["precio"]*$tenis["cantidad"] . "&&id=" . $tenis["id"] . "\">Comprar</a><br><br>";
    $total += $tenis["precio"] * $tenis["cantidad"];
    $numProd += 1 * $tenis["cantidad"];
}
if ($numProd == 0) {
    echo "El carrito esta vacio";
    echo "<br><a class=\"boton\" href=\"productos.php\">Agrega un producto aqui</a>";
} else {
    echo "Total de productos: " . $numProd;
    echo "<br>Total a pagar: $" . $total . "MXN";
    echo "<br><a class=\"boton\" href=\"compra.php?total=" . $total . "&&id=0\">Comprar todo</a><br>";
}

echo "</h1>";
mysqli_close($conexion);

include 'footerProd.html';
