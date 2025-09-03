<?php
require __DIR__ . '/includes/funciones.php';
require __DIR__ . '/includes/config/database.php';
require __DIR__ . '/clases/cls.php';

$identificador = '2';

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

NOVELA::setDB($db);

$errores = []; 
$nuevaNov = new NOVELA();

$novela = '';
$director = '';
$df = '';
$script = '';
$sonido = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $novela = mysqli_real_escape_string($db, $_POST['novela']) ?? null;
    $director = mysqli_real_escape_string($db, $_POST['director']);
    $df = mysqli_real_escape_string($db, $_POST['df']) ?? null;
    $script = mysqli_real_escape_string($db, $_POST['script']);
    $sonido = mysqli_real_escape_string($db, $_POST['sonido']);

    if (!$novela) {
        $errores[] = 'Debe ingresar el nombre de la producción';
    }
    if (!$director) {
        $errores[] = 'Debe ingresar el nombre del director';
    }

    if (!$df) {
        $errores[] = 'Debe ingresar el nombre del Df';
    }

    if (!$script) {
        $errores[] = 'Debe ingresar el nombre del Script';
    }
    if (!$sonido) {
        $errores[] = 'Debe ingresar el nombre del sonidista';
    }

    if (empty($errores)) {
        //Guardar los datos en BD
        $nuevaNov->crear(
            $novela,
            $director,
            $df,
            $script,
            $sonido
        );
        //Redirigir a lista
        header("Location: panelprincipal");
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
        <?php include 'templates/saludoinic.php'; ?>
    </div>
    <main class="principal">
        <div class="contenido">
            <div class="contenedor panel">
                <h3>Agregar nueva Novela o Producción</h3>
                <div class="diseño_form formulario">
                    <?php foreach ($errores as $error) : ?>
                        <div class="alerta error">
                            <?php echo $error; ?>
                        </div>
                    <?php endforeach; ?>
                    <form method="POST">
                        <table>
                            <tr>
                                <td>Nombre Novela y/o Producción:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="novela" name="novela" value="<?php echo $novela;?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Director:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="director" name="director" value="<?php echo $director;?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Df:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="df" name="df" value="<?php echo $df;?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Script:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="script" name="script" value="<?php echo $script;?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Sonido:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="sonido" name="sonido" value="<?php echo $sonido;?>">
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="cont-boton">
                            <input class="boton-grabar" type="submit" value="Grabar"> </form>
                            <a class="boton-salir" href="panelprincipal">Salir</a>
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