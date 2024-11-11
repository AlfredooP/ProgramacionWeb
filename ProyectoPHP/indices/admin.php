<?php
declare(strict_types = 1);
include 'headerAdmin.html';

function altaMarca($nombreMarca) : string {
    return "INSERT INTO `marca` (`id`, `nombre`) VALUES ('NULL', '$nombreMarca');";
}

function altaModelo($marcaM, $nombreModelo) : string {
    return "INSERT INTO `modelo` (`id`, `nombre`, `marca`) VALUES ('NULL', '$nombreModelo', '$marcaM');";
}

function altaTenis($precioT, $colorT, $tallaT, $marcaT, $modeloT, $imagenT) : string {
    return "INSERT INTO `tenis` (`id`, `precio`, `color`, `talla`, `marca`, `modelo`, `imagen`) VALUES ('NULL', '$precioT', '$colorT', '$tallaT', '$marcaT', '$modeloT', '$imagenT');";
}

function consultas($host, $user, $pass, $name, $port, $consulta) {
    // Conectar a la base de datos
    $conexion = mysqli_connect($host, $user, $pass, $name, $port) or die("Problemas con la conexión");
    
    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $consulta);
    
    // Verificar si la consulta es un SELECT para retornar el resultado
    if (strpos($consulta, 'SELECT') === 0) {
        // Si hay resultados, convertirlos a un arreglo asociativo
        $data = mysqli_fetch_assoc($resultado); // Obtiene la primera fila como arreglo asociativo
        mysqli_close($conexion);
        return $data; // Retornar el resultado
    }
    
    // Si no es un SELECT, cerramos la conexión y retornamos true
    mysqli_close($conexion);
    return true; // Para consultas de tipo INSERT, UPDATE, DELETE
}


$dbhost = "localhost"; // Host donde esta la bd
$dbname = "tenis"; // Nombre de la bd
$dbuser = "root"; // Username
$dbpass = ""; // Password

$marca = $_POST["marca"];
$modelo = $_POST["modelo"];
$precio = $_POST["precio"];
$color = $_POST["color"];
$talla = $_POST["talla"];
$imagen = $_POST["imagen"];

$marcaModelo = $_POST["marcaClave"];
$marcaProducto = $_POST["marcaProd"];
$modeloProducto = $_POST["modeloProd"];


if($_SERVER["REQUEST_METHOD"] == "POST") {
    $formulario = $_POST['formulario'];

    switch($formulario) {
        case 'formMarca':
            // Se va a dar de alta una marca
            if($marca == "") {
                echo "Establezca los datos correctamente";
            } else {
                $sql = altaMarca($marca);
                consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $sql);
            }
        break;
            
        case 'formModelo':
            // Se dará de alta un modelo
            if($marcaModelo == "" || $modelo == "") {
                echo "Establezca los datos correctamente";
            } else {
                $clave = "SELECT id from `marca` where nombre = '$marcaModelo'";
                $clave = consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $clave);
                //var_dump($clave["id"]);
                //exit;
                $sql = altaModelo($clave["id"], $modelo);
                consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $sql);
            }
        break;

        case 'formProducto':
            // Se dará de alta un tenis
            if($precio == "" || $color == "" || $talla == "" || $imagen == "") {
                echo "Establezca los datos correctamente";
            } else {
                $claveMarca = "SELECT id from `marca` where nombre = '$marcaProducto'";
                $claveModelo = "SELECT id from `modelo` where nombre = '$modeloProducto'";
                $claveMarca = consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $claveMarca);
                $claveModelo = consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $claveModelo);
                $sql = altaTenis($precio, $color, $talla, $claveMarca["id"], $claveModelo["id"], $imagen);
                consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $sql);
            }
        break;
    }
}

echo "<b>Bienvenido de nuevo mi admin</b>";

include 'footerAdmin.html';

?>