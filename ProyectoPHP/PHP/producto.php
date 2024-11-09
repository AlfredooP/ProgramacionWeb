<<<<<<< Updated upstream:ProyectoPHP/PHP/producto.php
<?php include 'includes/header.php';

// Confirmar sesión
// session_start();

// if(!isset($_SESSION['loggedin'])) {
//     header('Location: productos.php');
//     exit();
// }



// include 'footerProd.html';

=======
<?php

include 'headerProd.html';

// Confirmar sesión
session_start();

if(!isset($_SESSION['loggedin'])) {
    header('Location: productos.php');
    exit();
}

if (isset($_GET['producto'])) {
    $producto = $_GET['producto'];
    echo "<h1 class=\"subtitulo\"> Esta usted viendo el producto: ". $producto."</h1>";
} else {
    echo "<h1 class=\"subtitulo\"> Esta usted viendo todos los productos </h1>";
}

include 'footerProd.html';

>>>>>>> Stashed changes:ProyectoPHP/Indices/productos.php
?>