<?php

session_start();

// credenciales de acceso a la base de datos
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'login-php';

// Conexión a la base de datos
$conexion = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if(mysqli_connect_error()) {
    // Si encuentra error en la conexión
    exit('Fallo en la conexión de mysqli: ' . mysqli_connect_error());
}

// Se valida si se ha enviado información
// Función isset
if(!isset($_POST['username'], $_POST['password'])) {
    // Si no hay datos muestra error y redirecciona a login
    header('Location: login.html');
}

// Evitar inyección sql
if($smtmt = $conexion->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    // Parametros de enlace de la cadena s
    $smtmt->bind_param('s', $_POST['username']);
    $smtmt->execute();
} 

// Validar si lo ingresado coincide con la base de datos
$smtmt->store_result();
if($smtmt->num_rows > 0) {
    $smtmt->bind_result($id, $password);
    $smtmt->fetch();

    // Se confirma que la cuenta existe ahora validamos la contraseña
    if($_POST['password'] === $password) {
        // La conexión sería exitosa y se crea sesión
        session_regenerate_id();
        $_SESSION['loggedin'] = true;
        $_SESSION['name'] = $_POST['username'];
        $_SESSION['id'] = $id;
        // Lo manda a la pagina inicial con la sesión iniciada ya reconocida
        header('Location: productos.php');
    }
} else {
    // Usuario incorrecto 
    header('Location: login.html');
}

$smtmt->close();

?>