<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" href="../CSS/normalize.css" as="style">
    <link rel="stylesheet" href="../CSS/normalize.css">
    <link rel="preload" href="../CSS/styleLogin.css" as="style">
    <link href="../CSS/styleLogin.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>OSWI - Registro</title>
</head>

<body class="fondo">
    <img src="../img/OSWI-logo-blanco.png" width="30%">
    <form class="formulario" action="registro.php" method="post" name="form" onsubmit="return validar(this)">

        <fieldset>
            <legend>Registro</legend>
            <div class="formulario-registro">
                <div class="childs">
                    <label for="email"> E-mail:</label>
                    <br>
                    <input class="input-text" type="text" placeholder="Email" name="email" id="email">
                    <br>
                </div>
                <div class="childs">
                    <label for="nombre"> Nombre(s):</label>
                    <br>
                    <input class="input-text" type="text" placeholder="Nombre(s)" name="nombre" id="nombre">
                    <br>
                </div>
                <div class="childs">
                    <label for="apellido"> Apellido(s):</label>
                    <br>
                    <input class="input-text" type="text" placeholder="Apellido(s)" name="apellido" id="apellido">
                    <br>
                </div>
                <div class="childs">
                    <label for="username"><i class="fas fa-user"></i> Usuario:</label>
                    <br>
                    <input class="input-text" type="text" placeholder="Usuario" name="username" id="username">
                    <br>
                </div>
                <div class="childs">
                    <label for="Edad"> Edad:</label>
                    <br>
                    <input class="input-text" type="text" placeholder="Edad" name="edad" id="edad">
                    <br>
                </div>
                <div class="childs">
                    <label for="telefono"> Teléfono:</label>
                    <br>
                    <input class="input-text" type="text" placeholder="Teléfono" name="telefono" id="telefono">
                    <br>
                </div>
                <div class="childs">
                    <label for="password"><i class="fas fa-lock"></i> Contraseña:</label>
                    <br>
                    <input class="input-text" type="password" placeholder="Contraseña" name="password" id="password">
                    <br>
                </div>
                <div class="childs">
                    <div class="derecha flex"><input class="boton w-sm-100" type="submit" value="Registrarse"></div>    
                </div>
            </div>
        </fieldset>
    </form>

    <script src="validacion.js"></script>

    <footer>
        <p>David Avalos | Alfredo Puentes <br> Todos los derechos reservados</p>
    </footer>