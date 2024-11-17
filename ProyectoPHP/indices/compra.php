<?php

require 'headerProd.html';

include 'headerCompra.html';

echo "<h1 class=\"subtitulo\"> Tu compra total:";
echo "<br>$".$_GET['total']." MXN<br>Estas por comprar:</h1>";
echo "<h1 class=\"fondo\">";
if (isset($_GET['total']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $conexion = mysqli_connect("localhost", "root", "", "tenis", 3306) or die("Problemas con la conexión");

    if($id == 0){
        $consulta = "SELECT  c.id, c.precio, c.color, c.talla, ma.nombre as 'marca', mo.nombre as 'modelo', c.imagen, c.cantidad FROM carrito c, marca ma, modelo mo WHERE c.modelo = mo.id and c.marca = ma.id;";
        $resultado = mysqli_query($conexion, $consulta);
        while ($tenis = mysqli_fetch_assoc($resultado)) {            
            echo $tenis["modelo"]."<br>";
            echo "Color(es): ".$tenis["color"]."<br>";   
            echo "Talla: ".$tenis["talla"]."(MX)<br>";
            echo "Marca: ".$tenis["marca"]."<br>";
            echo "Cantidad: " . $tenis["cantidad"] . " pieza(s)<br>";
            echo "$".$tenis["precio"]." MXN<br>"; 
            echo "<img src=\"../img/" . $tenis["imagen"] . "\" width=\"10%\"><br><br>";           
        }
    }
    else{
        $consulta = "SELECT  t.id, t.precio, t.color, t.talla, ma.nombre as 'marca', mo.nombre as 'modelo', t.imagen, t.cantidad FROM tenis t, marca ma, modelo mo WHERE t.modelo = mo.id and t.marca = ma.id and t.id = ".$id;
        $resultado = mysqli_query($conexion, $consulta);
        $tenis = mysqli_fetch_assoc($resultado);
        echo $tenis["modelo"]."<br>";
        echo "Color(es): ".$tenis["color"]."<br>";   
        echo "Talla: ".$tenis["talla"]."(MX)<br>";
        echo "Marca: ".$tenis["marca"]."<br>";
        echo "$".$tenis["precio"]." MXN<br>"; 
        echo "<img src=\"../img/" . $tenis["imagen"] . "\" width=\"10%\"><br><br>";            
        
    }
    echo "<br><a class=\"boton\" href=\"login.html\">¿Quieres iniciar sesion?</a><br>";
    //echo "<br><a class=\"boton\" href=\"\">Pagar con PayPal</a><br>";
    echo "<br><a class=\"boton\" href=\"pdf.php\">Generar recibo en PDF</a><br>";
    echo "</h1>";
}
else{
    //echo "No fue posible calcular el total";
}

include 'footerCompra.html';

?>