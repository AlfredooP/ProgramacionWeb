<?php
require 'headerProd.html';

//Asignar titulo de la pestaña
echo "<title>OSWI - Carrito</title>";

//Conectar a la base de datos de tenis
$conexion = mysqli_connect("localhost", "root", "", "tenis", 3306) or die("Problemas con la conexión");

//Validar si se va a eliminar un producto del carrito
if (isset($_GET['producto']) && isset($_GET['eliminar']) && isset($_GET['cantidad']) && $_GET['eliminar'] == 'false') {
    //Si no, lee el producto y cantidad enviados
    $producto = $_GET['producto'];
    $cantidad = $_GET['cantidad'];

    //Realiza la consulta para obtener todos los tenis del carrito
    $consulta = "SELECT  c.id, c.precio, c.color, c.talla, ma.nombre as 'marca', mo.nombre as 'modelo', c.imagen, c.cantidad FROM carrito c, marca ma, modelo mo WHERE c.modelo = mo.id and c.marca = ma.id;";
    $resultado = mysqli_query($conexion, $consulta);

    //Recorrer todos los tenis
    while ($tenis = mysqli_fetch_assoc($resultado)) {
        //Validar si el producto ha sido ingresado antes
        if ($tenis["id"] == $producto) {
            //Si es cierto, solo suma la cantidad ingresada
            $consulta = "UPDATE carrito SET cantidad = '" . ($tenis["cantidad"] + $cantidad) . "' WHERE id = '" . $tenis["id"] . "';";
            mysqli_query($conexion, $consulta);

            //Cambia el producto a 0 para informar que ya se ingreso
            $producto = 0;
        }
    }

    //Validar si el producto no ha sido ingresado antes
    if ($producto != 0) {
        //Si no, lo ingresa copiandolo de la tabla tenis a la tabla carrito
        $consulta = "INSERT INTO carrito (id, precio, color, talla, marca, modelo, imagen, cantidad, stock) 
                                   SELECT id, precio, color, talla, marca, modelo, imagen, " . $cantidad . ", cantidad FROM tenis WHERE id = '" . $producto . "';";
        mysqli_query($conexion, $consulta);
    }
}

//Si se va a eliminar
else if (isset($_GET['producto']) && isset($_GET['eliminar']) && $_GET['eliminar'] == 'true') {
    //Obtiene el producto a eliminar
    $producto = $_GET['producto'];

    //Lo elimina por medio de una consulta
    $consulta = "DELETE FROM carrito WHERE id = " . $producto;
    mysqli_query($conexion, $consulta);
}

//Consulta para mostrar todo el carrito
$consulta = "SELECT  c.id, c.precio, c.color, c.talla, ma.nombre as 'marca', mo.nombre as 'modelo', c.imagen, c.cantidad FROM carrito c, marca ma, modelo mo WHERE c.modelo = mo.id and c.marca = ma.id;";
$resultado = mysqli_query($conexion, $consulta);

$total = 0; //Variable para sumar el precio total
$numProd = 0; //Variable para contar los productos en el carrito

//Agregar subtitulo
echo "<h1 class=\"subtitulo\">Carrito de compra</h1>";

//Recorrer todos los tenis
while ($tenis = mysqli_fetch_assoc($resultado)) {
    //Mostrar la informacion del tenis
    echo "<main class=\"contenedorP\"><h1 class=\"producto\">";
    echo "<p class=\"tituloP\">" . $tenis["modelo"] . "<br></p>";
    echo "Color(es): " . $tenis["color"] . "<br>";
    echo "Talla: " . $tenis["talla"] . "(MX)<br>";
    echo "Marca: " . $tenis["marca"] . "<br>";
    echo "Cantidad a comprar: " . $tenis["cantidad"] . "<br>";
    echo "<p class=\"precioP\">$" . $tenis["precio"] . " MXN<br></p>";
    echo "<img class=\"imgP\"src=\"../img/" . $tenis["imagen"] . "\" width=\"70%\">";

    //Botones del producto
    echo "<br><a class=\"botonP\" href=\"carrito.php?producto=" . $tenis["id"] . "&eliminar=true\">Borrar del Carrito</a>";
    echo "<br><a class=\"botonP\" href=\"compra.php?total=" . $tenis["precio"] * $tenis["cantidad"] . "&&id=" . $tenis["id"] . "\">Comprar</a><br><br>";
    
    //Sumar al total
    $total += $tenis["precio"] * $tenis["cantidad"];
    
    //Contar los productos
    $numProd += $tenis["cantidad"];
    echo "</h1></main>";
}

//Validar si el carrito esta vacio
if ($numProd == 0) { //Si es cierto, pone un mensaje
    echo "<h2>El carrito esta vacio!</h2>";
    echo "<h1 class=\"producto\"><br><a class=\"botonP\" href=\"productos.php\">Agrega un producto aqui</a></h1>";
} else { //Si es falso agrega la informacion del carrito
    echo "<main class=\"contenedorP\"><h2>";
    echo "<br>Total de productos: " . $numProd;
    echo "<br>Total a pagar: $" . $total . " MXN";

    //Boton para comprar todo en el carrito
    echo "<br><a class=\"botonP\" href=\"compra.php?total=" . $total . "&&id=0\">Comprar todo</a><br><br>";
    echo "</h2></main>";
}

mysqli_close($conexion);
require 'footerProd.html';
?>