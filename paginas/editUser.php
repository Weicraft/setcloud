<?php
require __DIR__ . '/includes/funciones.php';
require __DIR__ . '/includes/config/database.php';
require __DIR__ . '/clases/cls.php';

$identificador = '1';

$auth = estaAutenticado();
$db = conectarDB();

include 'templates/user.php';

if (!$auth) {
    header('location: login');
}

//Gestión de Sesiones
if ($sesion->estado_sesion != '1') {
    header('location: login');
}

USERS::setDB($db);

$errores = [];

$id_user = $_GET['id_user'];

$usuarioEdit = USERS::listarUserId($id_user);

$editUser = new USERS();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = mysqli_real_escape_string($db, $_POST['nombre']) ?? null;
    $usuarioN = mysqli_real_escape_string($db, $_POST['usuario']);
    $cargo = mysqli_real_escape_string($db, $_POST['cargo']);

    if (!$nombre) {
        $errores[] = 'Debe ingresar el nombre del usuario';
    }
    if (!$usuarioN) {
        $errores[] = 'Debe ingresar un nombre de usuario';
    }

    $verifUser = USERS::listarUserUsuario($usuarioN);
    if ($verifUser && $usuarioN != $usuarioEdit->usuario) {
        $errores[] = 'El nombre de usuario ya existe. Elija otro';
    } else {

        if (empty($errores)) {
            //Guardar los datos en BD
            $editUser->editUser(
                $id_user,
                $nombre,
                $usuarioN,
                $cargo
            );
            //Redirigir a lista
            header("Location: usuarios");
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
                                        <input type="text" class="field" id="nombre" name="nombre" value="<?php echo $usuarioEdit->nombre; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Usuario:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="usuario" name="usuario" value="<?php echo $usuarioEdit->usuario; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Cargo:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="cargo" name="cargo" value="<?php echo $usuarioEdit->cargo; ?>">
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