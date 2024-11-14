<?php

include 'headerProd.html';
echo "<head><title>OSWI - Productos</title></head>";

// Confirmar sesión
// session_start();

// if(!isset($_SESSION['loggedin'])) {
//     header('Location: productos.php');
//     exit();
// }

// Conectar a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "tenis", 3306) or die ("Problemas con la conexión");

if (isset($_GET['producto'])) {
    $producto = $_GET['producto'];
    //echo "<h1 class=\"subtitulo\"> Esta usted viendo el producto: ". $producto."</h1>";
    $consulta = "SELECT  t.id, t.precio, t.color, t.talla, ma.nombre as 'marca', mo.nombre as 'modelo', t.imagen FROM tenis t, marca ma, modelo mo WHERE t.modelo = mo.id and t.marca = ma.id and imagen = '".$producto."';";
    $resultado = mysqli_query($conexion, $consulta);
    $tenis = mysqli_fetch_assoc($resultado);
    echo "<h1 class=\"fondo\">";
    echo $tenis["modelo"]."<br>";
    echo "Color(es): ".$tenis["color"]."<br>";   
    echo "Talla: ".$tenis["talla"]."(MX)<br>";
    echo "Marca: ".$tenis["marca"]."<br>";
    echo "$".$tenis["precio"]." MXN<br>"; 
    echo "<img src=\"../img/".$tenis["imagen"]."\" width=\"10%\">";
    echo "<br><a class=\"boton\" href=\"carrito.php?producto=".$tenis["id"]."\">Agregar al Carrito</a>";
    echo "<br><a class=\"boton\" href=\"compra.php?total=".$tenis["precio"]."&&id=".$tenis["id"]."\">Comprar</a><br></h1>";
    mysqli_close($conexion);
} else {
    //echo "<h1 class=\"subtitulo\"> Esta usted viendo todos los productos </h1>";
    $consulta = "SELECT  t.id, t.precio, t.color, t.talla, ma.nombre as 'marca', mo.nombre as 'modelo', t.imagen FROM tenis t, marca ma, modelo mo WHERE t.modelo = mo.id and t.marca = ma.id;";
    $resultado = mysqli_query($conexion, $consulta);
    while ($tenis = mysqli_fetch_assoc($resultado)) {
        echo "<h1 class=\"fondo\">";
        echo $tenis["modelo"]."<br>";
        echo "Color(es): ".$tenis["color"]."<br>";   
        echo "Talla: ".$tenis["talla"]."(MX)<br>";
        echo "Marca: ".$tenis["marca"]."<br>";
        echo "$".$tenis["precio"]." MXN<br>";
        echo "<img src=\"../img/".$tenis["imagen"]."\" width=\"10%\">";
        echo "<br><a class=\"boton\" href=\"carrito.php?producto=".$tenis["id"]."&eliminar=false\">Agregar al Carrito</a>";
        echo "<br><a class=\"boton\" href=\"compra.php?total=".$tenis["precio"]."&&id=".$tenis["id"]."\">Comprar</a><br><br></h1>";
    }
    mysqli_close($conexion);
}

include 'footerProd.html';

?>