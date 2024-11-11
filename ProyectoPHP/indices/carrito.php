<?php

require 'headerProd.html';

// function eliminarCarrito($id): bool
// {
//     $conexion = mysqli_connect("localhost", "root", "", "tenis", 3306) or die("Problemas con la conexión");
//     $consulta = "DELETE FROM carrito WHERE id = " . $id;
//     $resultado = mysqli_query($conexion, $consulta);
//     mysqli_close($conexion);
//     return $resultado;
// }

$conexion = mysqli_connect("localhost", "root", "", "tenis", 3306) or die("Problemas con la conexión");
echo "<h1 class=\"subtitulo\"> Carrito de compra </h1>";
echo "<h1 class=\"fondo\">";

if (isset($_GET['producto']) && isset($_GET['eliminar']) && $_GET['eliminar'] == 'false') {
    $producto = $_GET['producto'];
    $consulta = "INSERT INTO carrito (SELECT * FROM tenis WHERE id = '" . $producto . "');";
    $resultado = mysqli_query($conexion, $consulta);
}
else if (isset($_GET['producto']) && !isset($_GET['eliminar'])) {
    $producto = $_GET['producto'];
    $consulta = "INSERT INTO carrito (SELECT * FROM tenis WHERE id = '" . $producto . "');";
    $resultado = mysqli_query($conexion, $consulta);
}
else if (isset($_GET['producto']) && isset($_GET['eliminar']) && $_GET['eliminar'] == 'true'){
    $producto = $_GET['producto'];
    $consulta = "DELETE FROM carrito WHERE id = " . $producto;
    $resultado = mysqli_query($conexion, $consulta);
}

$consulta = "SELECT  c.id, c.precio, c.color, c.talla, ma.nombre as 'marca', mo.nombre as 'modelo', c.imagen FROM carrito c, marca ma, modelo mo WHERE c.modelo = mo.id and c.marca = ma.id;";
$resultado = mysqli_query($conexion, $consulta);
$total = 0; $numProd = 0;

while ($tenis = mysqli_fetch_assoc($resultado)) {    
    echo $tenis["modelo"]."<br>";
    echo "Color(es): ".$tenis["color"]."<br>";   
    echo "Talla: ".$tenis["talla"]."(MX)<br>";
    echo "Marca: ".$tenis["marca"]."<br>";
    echo "$".$tenis["precio"]." MXN<br>"; 
    echo "<img src=\"../img/" . $tenis["imagen"] . "\" width=\"10%\">";
    echo "<br><a class=\"boton\" href=\"carrito.php?producto=".$tenis["id"]."&eliminar=true\">Borrar del Carrito</a>";
    echo "<br><a class=\"boton\" href=\"compra.php?total=".$tenis["precio"]."&&json=".$tenis["id"]."\">Comprar</a><br><br>";
    $total += $tenis["precio"];
    $numProd += 1;
}
if($numProd == 0){
    echo "El carrito esta vacio";
    echo "<br><a class=\"boton\" href=\"productos.php\">Agrega un producto aqui</a>";
}
else{
    echo "Total de productos: ".$numProd;
    echo "<br>Total a pagar: $".$total."MXN";
    echo "<br><a class=\"boton\" href=\"compra.php?total=".$total."&&json=0\">Comprar todo</a><br>";
}


echo "</h1>";
mysqli_close($conexion);

include 'footerProd.html';
