<?php

include 'headerProd.html';

// Confirmar sesión
session_start();

if(!isset($_SESSION['loggedin'])) {
    header('Location: productos.php');
    exit();
}

echo "<b> Esta usted viendo los productos de OSWI <b>";

include 'footerProd.html';

?>