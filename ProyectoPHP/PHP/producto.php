<?php include 'includes/header.php';

// Confirmar sesión
session_start();

if(!isset($_SESSION['loggedin'])) {
    header('Location: productos.php');
    exit();
}



// include 'footerProd.html';

?>