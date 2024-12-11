<?php
require 'headerProd.html';

session_start();

//Asignar titulo de la pestaña
echo "<title>OSWI - Compra</title>";

//Informacion de la compra
echo "<h1 class=\"subtitulo\"> Tu compra total:";
echo "<br>$" . $_GET['total'] . " MXN<br>Estas por comprar:</h1>";
echo "<main class=\"contenedorP\"><h1 class=\"producto\">";

//Validar que haya un total y un id
if (isset($_GET['total']) && isset($_GET['id'])) {
    //Obtener el id
    $id = $_GET['id'];
    //Conectar a la base de datos de tenis
    $conexion = mysqli_connect("localhost", "root", "", "tenis", 3306) or die("Problemas con la conexión");
    //Si el id es 0 se compra todo el carrito
    if ($id == 0) {
        //Obtener los productos del carrito
        $consulta = "SELECT  c.id, c.precio, c.color, c.talla, ma.nombre as 'marca', mo.nombre as 'modelo', c.imagen, c.cantidad FROM carrito c, marca ma, modelo mo WHERE c.modelo = mo.id and c.marca = ma.id;";
        $resultado = mysqli_query($conexion, $consulta);
        //Recorrer los productos del carrito
        while ($tenis = mysqli_fetch_assoc($resultado)) {
            //Asignarlos a la sesion actual
            $_SESSION['TenisID'] = $tenis["id"];
            $_SESSION['modelo'] = $tenis["modelo"];
            $_SESSION['color'] = $tenis["color"];
            $_SESSION['talla'] = $tenis["talla"];
            $_SESSION['marca'] = $tenis["marca"];
            $_SESSION['cantidad'] = $tenis["cantidad"];
            $_SESSION['precio'] = $tenis["precio"];
            $_SESSION['imagen'] = $tenis["imagen"];
            //Mostrar la informacion del producto
            echo "<p class=\"tituloP\">" . $tenis["modelo"] . "<br></p>";
            echo "Color(es): " . $tenis["color"] . "<br>";
            echo "Talla: " . $tenis["talla"] . "(MX)<br>";
            echo "Marca: " . $tenis["marca"] . "<br>";
            echo "Cantidad a comprar: " . $tenis["cantidad"] . "<br>";
            echo "<p class=\"precioP\">$" . $tenis["precio"] . " MXN<br></p>";
            echo "<img class=\"imgP\"src=\"../img/" . $tenis["imagen"] . "\" width=\"70%\">";
        }
        //Asigna el control 1 para indicar al recibo que hay mas de un producto
        $_SESSION['control'] = '1';
    } else {
        //Si solo es un producto lo busca en la tabla de tenis
        $consulta = "SELECT  t.id, t.precio, t.color, t.talla, ma.nombre as 'marca', mo.nombre as 'modelo', t.imagen, t.cantidad FROM tenis t, marca ma, modelo mo WHERE t.modelo = mo.id and t.marca = ma.id and t.id = " . $id;
        $resultado = mysqli_query($conexion, $consulta);
        //Cuando lo encuentra lo guarda en la variable tenis
        $tenis = mysqli_fetch_assoc($resultado);
        //Asigna los datos del tenis a la sesion actual
        $_SESSION['TenisID'] = $tenis["id"];
        $_SESSION['modelo'] = $tenis["modelo"];
        $_SESSION['color'] = $tenis["color"];
        $_SESSION['talla'] = $tenis["talla"];
        $_SESSION['marca'] = $tenis["marca"];
        $_SESSION['cantidad'] = $tenis["cantidad"];
        $_SESSION['precio'] = $tenis["precio"];
        $_SESSION['imagen'] = $tenis["imagen"];
        $_SESSION['cantidadAComprar'] = 1;
        //Mostrar la informacion del producto
        echo "<p class=\"tituloP\">" . $tenis["modelo"] . "<br></p>";
        echo "Color(es): " . $tenis["color"] . "<br>";
        echo "Talla: " . $tenis["talla"] . "(MX)<br>";
        echo "Marca: " . $tenis["marca"] . "<br>";
        echo "Cantidad a comprar: 1<br>";
        echo "<p class=\"precioP\">$" . $tenis["precio"] . " MXN<br></p>";
        echo "<img class=\"imgP\"src=\"../img/" . $tenis["imagen"] . "\" width=\"70%\">";
        //Asigna el control 2 para indicar al recibo que solo hay un producto
        $_SESSION['control'] = '2';
    }
    //Boton para iniciar sesion
    echo "<br><a class=\"botonP\" href=\"login.html\">¿Quieres iniciar sesion?</a>";
    //Boton para generar el recibo
    echo "<br><a class=\"botonP\" href=\"pdf.php\">Generar recibo en PDF</a><br><br>";
    echo "</h1></main>";
}

//Cerrar la conexion
mysqli_close($conexion);
//Mostrar el boton de pagar con Paypal
require 'footerCompra.html';
require 'footerProd.html';
?>