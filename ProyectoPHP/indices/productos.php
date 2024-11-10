<?php

include 'headerProd.html';

// Confirmar sesión
// session_start();

// if(!isset($_SESSION['loggedin'])) {
//     header('Location: productos.php');
//     exit();
// }

// Conectar a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "tenis", 3306) or die("Problemas con la conexión");

if (isset($_GET['producto'])) {
    $producto = $_GET['producto'];
    echo "<h1 class=\"subtitulo\"> Esta usted viendo el producto: ". $producto."</h1>";
    $consulta = "SELECT * FROM tenis WHERE imagen = '".$producto."';";
    $resultado = mysqli_query($conexion, $consulta);
    $tenis = mysqli_fetch_assoc($resultado);
    echo "<h1 class=\"fondo\">";
    echo "Precio = ".$tenis["precio"]."<br>";
    echo "Color = ".$tenis["color"]."<br>";
    echo "Talla = ".$tenis["talla"]."<br>";
    echo "Marca = ".$tenis["marca"]."<br>";
    echo "Modelo = ".$tenis["modelo"]."<br>";
    echo "<img src=\"../img/".$tenis["imagen"]."\" width=\"10%\">";
    echo "<br></h1>";
    mysqli_close($conexion);
} else {
    echo "<h1 class=\"subtitulo\"> Esta usted viendo todos los productos </h1>";
    $consulta = "SELECT * FROM tenis;";
    $resultado = mysqli_query($conexion, $consulta);
    while ($tenis = mysqli_fetch_assoc($resultado)) {
        echo "<h1 class=\"fondo\">";
        echo "Precio = ".$tenis["precio"]."<br>";
        echo "Color = ".$tenis["color"]."<br>";
        echo "Talla = ".$tenis["talla"]."<br>";
        echo "Marca = ".$tenis["marca"]."<br>";
        echo "Modelo = ".$tenis["modelo"]."<br>";
        echo "<img src=\"../img/".$tenis["imagen"]."\" width=\"10%\">";
        echo "<br></h1>";
    }
    mysqli_close($conexion);
}

include 'footerProd.html';

?>