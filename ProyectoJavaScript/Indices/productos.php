<?php
require 'headerProd.html';
echo "<title>OSWI - Productos</title>";

$conexion = mysqli_connect("localhost", "root", "", "tenis", 3306) or die("Problemas con la conexión");

if (isset($_GET['producto'])) {
    $producto = $_GET['producto'];
    $consulta = "SELECT  t.id, t.precio, t.color, t.talla, ma.nombre as 'marca', mo.nombre as 'modelo', t.imagen, t.cantidad FROM tenis t, marca ma, modelo mo WHERE t.modelo = mo.id and t.marca = ma.id and imagen = '" . $producto . "';";
    $resultado = mysqli_query($conexion, $consulta);
    echo "<main class=\"contenedorP\"><h1 class=\"producto\">";
    echo "<p class=\"tituloP\">".$tenis["modelo"] . "<br></p>";
        echo "Color(es): " . $tenis["color"] . "<br>";
        echo "Talla: " . $tenis["talla"] . "(MX)<br>";
        echo "Marca: " . $tenis["marca"] . "<br>";
        if($tenis["cantidad"] > 0) {
            echo "Unidades disponibles: " . $tenis["cantidad"] . "<br>";
        }
        echo "<p class=\"precioP\">$" . $tenis["precio"] . " MXN<br></p>";
        echo "<img class=\"imgP\"src=\"../img/" . $tenis["imagen"] . "\" width=\"70%\">";
        if($tenis["cantidad"] > 0) {
            echo "<br><a class=\"botonCarritoP\" id=".$tenis["id"].">Agregar al Carrito</a>";
            echo "<br><a class=\"botonP\" href=\"compra.php?total=" . $tenis["precio"] . "&&id=" . $tenis["id"] . "\">Comprar</a><br><br>";
        }
        echo "</h1></main>";
} else {
    $consulta = "SELECT  t.id, t.precio, t.color, t.talla, ma.nombre as 'marca', mo.nombre as 'modelo', t.imagen, t.cantidad FROM tenis t, marca ma, modelo mo WHERE t.modelo = mo.id and t.marca = ma.id;";
    $resultado = mysqli_query($conexion, $consulta);
    echo "<h1 class=\"subtitulo\">Nuestros productos</h1>";
    while ($tenis = mysqli_fetch_assoc($resultado)) {
        echo "<main class=\"contenedorP\"><h1 class=\"producto\">";
        echo "<p class=\"tituloP\">".$tenis["modelo"] . "<br></p>";
        echo "Color(es): " . $tenis["color"] . "<br>";
        echo "Talla: " . $tenis["talla"] . "(MX)<br>";
        echo "Marca: " . $tenis["marca"] . "<br>";
        if($tenis["cantidad"] > 0) {
            echo "Unidades disponibles: " . $tenis["cantidad"] . "<br>";
        } else {
            echo "Sin unidades de momento... <br>";
        }
        echo "<p class=\"precioP\">$" . $tenis["precio"] . " MXN<br></p>";
        echo "<img class=\"imgP\"src=\"../img/" . $tenis["imagen"] . "\" width=\"70%\">";
            echo "<br><a class=\"botonCarritoP\" id=".$tenis["id"].">Agregar al Carrito</a>";
            echo "<br><a class=\"botonP\" href=\"compra.php?total=" . $tenis["precio"] . "&&id=" . $tenis["id"] . "\">Comprar</a><br><br>";  
        echo "</h1></main>";
    }    
    }
echo "<script src=\"DOM.js\"></script>";
mysqli_close($conexion);
require 'footerProd.html';
?>