<?php
require __DIR__ . '/includes/funciones.php';
require __DIR__ . '/includes/config/database.php';
require __DIR__ . '/clases/cls.php';

$identificador = '1';

$auth = estaAutenticado();
$db = conectarDB();

include 'templates/user.php';

if (!$auth) {
    header('location: login.php');
}

//Gestión de Sesiones
if ($sesion->estado_sesion != '1') {
    header('location: login');
}

$plan = $_SESSION['plan'];

USERS::setDB($db);
$contadorUser = USERS::contarUsers();
$contarUser = $contadorUser->contar;
$errores = [];
$nuevoUser = new USERS();

$nombre = '';
$usuarioN = '';
$pass = '';
$repeatPass = '';
$cargo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = mysqli_real_escape_string($db, $_POST['nombre']) ?? null;
    $usuarioN = mysqli_real_escape_string($db, $_POST['usuario']);
    $pass = mysqli_real_escape_string($db, $_POST['pass']) ?? null;
    $repeatPass = mysqli_real_escape_string($db, $_POST['repeatPass']) ?? null;
    $cargo = mysqli_real_escape_string($db, $_POST['cargo']);

    if (!$nombre) {
        $errores[] = 'Debe ingresar el nombre del usuario';
    }
    if (!$usuarioN) {
        $errores[] = 'Debe ingresar un nombre de usuario';
    }

    if (!$pass) {
        $errores[] = 'Debe ingresar una contraseña';
    }

    if (!$repeatPass) {
        $errores[] = 'Debe repetir la contraseña';
    }

    if ($pass != $repeatPass) {
        $errores[] = 'Las contraseñas no son iguales';
    }

    $verifUser = USERS::listarUserUsuario($usuarioN);
    if ($verifUser) {
        $errores[] = 'El nombre de usuario ya existe. Elija otro';
    } else {

        if (empty($errores)) {
            if ($contarUser < $plan) {
                //Guardar los datos en BD
                $nuevoUser->crear($nombre, $usuarioN, $pass, $cargo);
                //Redirigir a lista
                header("Location: permisos?usuario=$usuarioN");
            } else {
                header("Location: nomoreuser?plan=$plan");
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producción Audiovisual</title>
    <link rel="icon" href="paginas/build/img/favicon_NiBel.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <?php include 'templates/cssindex.php' ?>
</head>

<body>
    <?php
    include 'templates/headerprincipal.php';
    ?>
    <div class="saludo">
        <?php include 'templates/saludogestuser.php'; ?>
    </div>
    <main class="principal">
        <div class="contenido">
            <div class="contenedor panel">
                <h3>Agregar nuevo Usuario</h3>
                <div class="diseño_form formulario">
                    <?php foreach ($errores as $error) : ?>
                        <div class="alerta error">
                            <?php echo $error; ?>
                        </div>
                    <?php endforeach; ?>
                    <form method="POST">
                        <table>
                            <tr>
                                <td>Nombre:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Usuario:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="usuario" name="usuario" value="<?php echo $usuarioN; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Contraseña:</td>
                                <td>
                                    <div class="input">
                                        <input type="password" class="field" id="password" name="pass" value="<?php echo $pass; ?>">
                                        <span class="toggle-password" onclick="togglePasswordVisibility()">
                                            🔓
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Repetir Contraseña:</td>
                                <td>
                                    <div class="input">
                                        <input type="password" class="field" id="password2" name="repeatPass" value="<?php echo $repeatPass; ?>">
                                        <span class="toggle-password" onclick="togglePassword2Visibility()">
                                            🔓
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Cargo:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="cargo" name="cargo" value="<?php echo $cargo; ?>">
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="cont-boton">
                            <input class="boton-grabar" type="submit" value="Grabar">
                    </form>
                    <a class="boton-salir" href="usuarios">Salir</a>
                </div>
            </div>
        </div>
        </div>
    </main>
    <?php
    include 'templates/footer.php';
    ?>
    <script src="paginas/build/js/bundle.min.js"></script>
</body>

</html>