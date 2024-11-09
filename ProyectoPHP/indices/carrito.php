<?php

include 'headerProd.html';

// Confirmar sesión
session_start();

if(!isset($_SESSION['loggedin'])) {
    header('Location: productos.php');
    exit();
}

echo "<h1 class=\"subtitulo\"> Carrito de compra </h1>";

include 'footerProd.html';

?> 