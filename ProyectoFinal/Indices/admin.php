<?php
declare(strict_types=1);
require 'headerAdmin.html';

// Dar de alta una marca
function altaMarca($nombreMarca): string
{
    return "INSERT INTO `marca` (`id`, `nombre`) VALUES ('NULL', '$nombreMarca');";
}

// Dar de baja una marca
function bajaMarca($nombreMarca): string
{
    return "DELETE FROM `marca` WHERE nombre = '$nombreMarca'";
}

// Modificar una marca
function modificarMarca($nuevoNombre, $nombreMarca): string
{
    return "UPDATE `marca` SET `nombre` = '$nuevoNombre' WHERE `nombre` = '$nombreMarca'";
}

// Dar de alta un modelo
function altaModelo($marcaM, $nombreModelo): string
{
    return "INSERT INTO `modelo` (`id`, `nombre`, `marca`) VALUES ('NULL', '$nombreModelo', '$marcaM');";
}

// Dar de baja un modelo
function bajaModelo($nombreModelo): string
{
    return "DELETE FROM `modelo` WHERE nombre = '$nombreModelo'";
}

// Modificar un modelo
function modificarModelo($nuevoNombre, $nombreModelo): string
{
    return "UPDATE `modelo` SET `nombre` = '$nuevoNombre' WHERE `nombre` = '$nombreModelo'";
}

// Dar de alta un tenis
function altaTenis($precioT, $colorT, $tallaT, $marcaT, $modeloT, $imagenT, $cantidadT): string
{
    return "INSERT INTO `tenis` (`id`, `precio`, `color`, `talla`, `marca`, `modelo`, `imagen`, `cantidad`) VALUES ('NULL', '$precioT', '$colorT', '$tallaT', '$marcaT', '$modeloT', '$imagenT', '$cantidadT');";
}

// Dar de baja un tenis
function bajatenis($marca, $modelo): string
{
    return "DELETE FROM `tenis` WHERE marca = '$marca' AND modelo = '$modelo'";
}

// Modificar un tenis
function modificarTenis($id, $precio, $color, $talla, $imagen, $cantidad): string
{
    return "UPDATE `tenis` SET `precio`='$precio', `color`='$color', `talla`='$talla', `imagen`='$imagen', `cantidad`='$cantidad' WHERE `id` = '$id'";
}

//Para consultas en general
function consultas($host, $user, $pass, $name, $port, $consulta)
{
    // Conectar a la base de datos
    $conexion = mysqli_connect($host, $user, $pass, $name, $port) or die("Problemas con la conexión");

    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $consulta);

    // Verificar si la consulta es un SELECT para retornar el resultado
    if (strpos($consulta, 'SELECT') === 0) {
        // Si hay resultados, convertirlos a un arreglo asociativo
        $data = mysqli_fetch_assoc($resultado); // Obtiene la primera fila como arreglo asociativo
        mysqli_close($conexion); //Cerrar la conexion
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Obtener el formulario que lo activo
    $formulario = $_POST['formulario'];

    //Filtrar por el nombre del formulario
    switch ($formulario) {
        case 'formMarca':
            $marca = $_POST["marca"];
            // Se va a dar de alta una marca
            if ($marca == "") {
                echo "Establezca los datos correctamente";
            } else {
                if ($_POST['accion'] == 'Dar de Alta') {
                    $sql = altaMarca($marca);
                    consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $sql);
                } else if ($_POST['accion'] == 'Dar de Baja') { // Se da de baja una Marca
                    $sql = bajaMarca($marca);
                    consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $sql);
                }
            }
            break;

        case 'formModelo':
            $marcaModelo = $_POST["marcaClave"];
            $modelo = $_POST["modelo"];
            // Se dará de alta un modelo
            if ($marcaModelo == "" || $modelo == "") {
                echo "Establezca los datos correctamente";
            } else {
                $clave = "SELECT id from `marca` where nombre = '$marcaModelo'";
                $clave = consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $clave);
                if ($_POST['accion'] == 'Dar de Alta') { // Alta de un modelo
                    $sql = altaModelo($clave["id"], $modelo);
                    consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $sql);
                } else if ($_POST['accion'] == 'Dar de Baja') { // Baja de un modelo
                    $sql = bajaModelo($modelo);
                    consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $sql);
                }
            }
            break;

        case 'formProducto':
            $precio = $_POST["precio"];
            $color = $_POST["color"];
            $talla = $_POST["talla"];
            $imagen = $_POST["imagen"];
            $cantidad = $_POST["cantidad"];
            $marcaProducto = $_POST["marcaProd"];
            $modeloProducto = $_POST["modeloProd"];
            // Se dará de alta un tenis
            if ($precio == "" || $color == "" || $talla == "" || $imagen == "" || $cantidad == "") {
                if ($_POST['marcaProd'] == "" || $_POST['modeloProd'] == "") {
                    echo "Establezca los datos correctamente";
                } else {
                    // Se dará de baja un tenis
                    if ($_POST['accion'] = 'Dar de Baja') {
                        $claveMarca = "SELECT id from `marca` where nombre = '$marcaProducto'";
                        $claveModelo = "SELECT id from `modelo` where nombre = '$modeloProducto'";
                        $claveMarca = consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $claveMarca);
                        $claveModelo = consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $claveModelo);
                        $sql = bajatenis($claveMarca["id"], $claveModelo["id"]);
                        consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $sql);
                    }
                }
            } else {
                $claveMarca = "SELECT id from `marca` where nombre = '$marcaProducto'";
                $claveModelo = "SELECT id from `modelo` where nombre = '$modeloProducto'";
                $claveMarca = consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $claveMarca);
                $claveModelo = consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $claveModelo);
                if ($_POST['accion'] = 'Dar de ALta') { // Se dará de alta un tenis
                    $sql = altaTenis($precio, $color, $talla, $claveMarca["id"], $claveModelo["id"], $imagen, $cantidad);
                    consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $sql);
                } else if ($_POST['accion'] = 'Dar de Baja') { // Se dará de baja un tenis
                    $sql = bajatenis($claveMarca["id"], $claveModelo["id"]);
                    consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $sql);
                }
            }
            break;

        case 'formModificaciones':
            $modMarca = $_POST['modMarca'];
            $modModelo = $_POST['modModelo'];

            //Filtrar por boton
            switch ($_POST['accion']) {
                case 'Marca':
                    $marcaNueva = $_POST['modMarcaNueva'];
                    if ($marcaNueva == "" || $modMarca == "") {
                        echo "Establezca los datos correctamente";
                    } else {
                        $sql = modificarMarca($marcaNueva, $modMarca);
                        consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $sql);
                    }
                    break;

                case 'Modelo':
                    $modeloNuevo = $_POST['modModeloNuevo'];
                    if ($modeloNuevo == "" || $modModelo == "") {
                        echo "Establezca los datos correctamente";
                    } else {
                        $sql = modificarModelo($modeloNuevo, $modModelo);
                        consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $sql);
                    }
                    break;

                case 'Tenis':
                    $precioNuevo = $_POST['modPrecioNuevo'];
                    $colorNuevo = $_POST['modColorNuevo'];
                    $tallaNuevo = $_POST['modTallaNueva'];
                    $imagenNuevo = $_POST['modImagenNueva'];
                    $cantidadNuevo = $_POST['cantidad'];
                    $id = $_POST['id'];
                    if ($precioNuevo == "" || $colorNuevo == "" || $tallaNuevo == "" || $imagenNuevo == "" || $id == "" || $cantidadNuevo == "") {
                        echo "Establezca los datos correctamente";
                    } else {
                        $sql = modificarTenis($id, $precioNuevo, $colorNuevo, $tallaNuevo, $imagenNuevo, $cantidadNuevo);
                        consultas($dbhost, $dbuser, $dbpass, $dbname, 3306, $sql);
                    }
                    break;
            }
            break;
    }
}
?>