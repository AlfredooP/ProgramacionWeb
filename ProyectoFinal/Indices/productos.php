<?php
require 'headerProd.html';

//Asignar titulo de la pestaña
echo "<title>OSWI - Productos</title>";

//Conectar a la base de datos de tenis
$conexion = mysqli_connect("localhost", "root", "", "tenis", 3306) or die("Problemas con la conexión");

//Validar si se desea un producto en especifico
if (isset($_GET['producto'])) {
    //Si es cierto lo lee
    $producto = $_GET['producto'];

    //Busca el producto en la tabla tenis
    $consulta = "SELECT  t.id, t.precio, t.color, t.talla, ma.nombre as 'marca', mo.nombre as 'modelo', t.imagen, t.cantidad FROM tenis t, marca ma, modelo mo WHERE t.modelo = mo.id and t.marca = ma.id and imagen = '" . $producto . "';";
    $resultado = mysqli_query($conexion, $consulta);

    //Lo guarda en la variable tenis
    $tenis = mysqli_fetch_assoc($resultado);

    //Muestra la informacion del tenis
    echo "<main class=\"contenedorP\"><h1 class=\"producto\">";
    echo "<p class=\"tituloP\">" . $tenis["modelo"] . "<br></p>";
    echo "Color(es): " . $tenis["color"] . "<br>";
    echo "Talla: " . $tenis["talla"] . "(MX)<br>";
    echo "Marca: " . $tenis["marca"] . "<br>";
    echo "Unidades disponibles: " . $tenis["cantidad"] . "<br>";
    echo "<p class=\"precioP\">$" . $tenis["precio"] . " MXN<br></p>";
    echo "<img class=\"imgP\"src=\"../img/" . $tenis["imagen"] . "\" width=\"70%\">";

    //Botones del producto
    echo "<br><a class=\"botonCarritoP\" id=" . $tenis["id"] . ">Agregar al Carrito</a>";
    echo "<br><a class=\"botonP\" href=\"compra.php?total=" . $tenis["precio"] . "&&id=" . $tenis["id"] . "\">Comprar</a><br><br>";
    echo "</h1></main>";
} else {
    //Si no se desea un producto en especifico se consultan todos
    $consulta = "SELECT  t.id, t.precio, t.color, t.talla, ma.nombre as 'marca', mo.nombre as 'modelo', t.imagen, t.cantidad FROM tenis t, marca ma, modelo mo WHERE t.modelo = mo.id and t.marca = ma.id;";
    $resultado = mysqli_query($conexion, $consulta);

    //Agregar un subtitulo
    echo "<h1 class=\"subtitulo\">Nuestros productos</h1>";

    //Mostrar todos los tenis
    while ($tenis = mysqli_fetch_assoc($resultado)) {
        echo "<main class=\"contenedorP\"><h1 class=\"producto\">";
        echo "<p class=\"tituloP\">" . $tenis["modelo"] . "<br></p>";
        echo "Color(es): " . $tenis["color"] . "<br>";
        echo "Talla: " . $tenis["talla"] . "(MX)<br>";
        echo "Marca: " . $tenis["marca"] . "<br>";        
        if ($tenis["cantidad"] > 0) {
            echo "Unidades disponibles: " . $tenis["cantidad"] . "<br>";
        } else {
            //Si no hay unidades en el inventario agrega un mensaje
            echo "Sin unidades de momento... <br>";
        }
        echo "<p class=\"precioP\">$" . $tenis["precio"] . " MXN<br></p>";
        echo "<img class=\"imgP\"src=\"../img/" . $tenis["imagen"] . "\" width=\"70%\">";

        //Botones del producto
        echo "<br><a class=\"botonCarritoP\" id=" . $tenis["id"] . ">Agregar al Carrito</a>";
        echo "<br><a class=\"botonP\" href=\"compra.php?total=" . $tenis["precio"] . "&&id=" . $tenis["id"] . "\">Comprar</a><br><br>";
        echo "</h1></main>";
    }
}
//Llama el script para el DOM
echo "<script src=\"DOM.js\"></script>";
mysqli_close($conexion);
require 'footerProd.html';
?>