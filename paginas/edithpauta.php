<?php
require __DIR__ . '/includes/funciones.php';
require __DIR__ . '/includes/config/database.php';
require __DIR__ . '/clases/cls.php';

$identificador = '3';

$auth = estaAutenticado();
$db = conectarDB();

include 'templates/user.php';

//SESIONES::setDB($db);

if (!$auth) {
    header('location: login');
}

//Gestión de Sesiones
if ($sesion->estado_sesion != '1') {
    header('location: login');
}

$novela = $_GET['novela'];
$id_hpauta = $_GET['hpauta'];
$indice = $_GET['indice'];
$fecha = $_GET['fecha'] ?? null;
$capitulo = $_GET['capitulo'] ?? null;
$destino = asignarDestino($indice, $novela, $fecha, $capitulo, $id_hpauta);

NOVELA::setDB($db);
HOJASPAUTA::setDB($db);

$novelaConsulta = NOVELA::listarNovelaId($novela);
$hPauta = HOJASPAUTA::listarHojaPautaId($id_hpauta);
$errores = [];
$editHojaPauta = new HOJASPAUTA();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $ubic_rodaje = $_POST['ubic_rodaje'] ?? null;
    $momento_dia = $_POST['momento_dia'] ?? null;
    $fecha = $_POST['fecha'] ?? null;
    $director = mysqli_real_escape_string($db, $_POST['director']) ?? null;
    $df = mysqli_real_escape_string($db, $_POST['df']) ?? null;
    $script = mysqli_real_escape_string($db, $_POST['script']) ?? null;
    $sonido = mysqli_real_escape_string($db, $_POST['sonido']) ?? null;
    $dia_ficcion = mysqli_real_escape_string($db, $_POST['dia_ficcion']) ?? null;
    $locacion = mysqli_real_escape_string($db, $_POST['locacion']) ?? null;
    $personajes = mysqli_real_escape_string($db, $_POST['personajes']) ?? null;

    if (!$fecha) {
        $errores[] = 'Debe ingresar la fecha de la Hoja de Pauta';
    }

    if (empty($errores)) {
        //Guardar los datos en BD
        $editHojaPauta->editHpauta(
            $id_hpauta,
            $ubic_rodaje,
            $momento_dia,
            $fecha,
            $director,
            $df,
            $script,
            $sonido,
            $dia_ficcion,
            $locacion,
            $personajes,
        );
        //Redirigir a lista
        header("Location: $destino");
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
            <div class="contenedor tablas">
                <h2>PRODUCCIÓN: <?php echo $novelaConsulta->novela; ?></h2>
                <h3>Editar la Hoja de Pauta N° <?php echo $hPauta->num_hpauta; ?></h3>
                <div class="diseño_form formulario">
                    <?php foreach ($errores as $error) : ?>
                        <div class="alerta error">
                            <?php echo $error; ?>
                        </div>
                    <?php endforeach; ?>
                    <form method="POST">
                        <table>
                            <tr>
                                <td>Ubicación de Rodaje:</td>
                                <td>
                                    <div class="radio-group">
                                        <label class="radio-item">
                                            <input type="radio" name="ubic_rodaje" value="1" <?php if ($hPauta->id_ubic_rodaje == 1) echo 'checked'; ?>>
                                            <span>Ext.</span>
                                        </label>
                                        <label class="radio-item">
                                            <input type="radio" name="ubic_rodaje" value="2" <?php if ($hPauta->id_ubic_rodaje == 2) echo 'checked'; ?>>
                                            <span>Int.</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Momento día:</td>
                                <td>
                                    <div class="radio-group">
                                        <label class="radio-item">
                                            <input type="radio" name="momento_dia" value="1" <?php if ($hPauta->id_momento_dia == 1) echo 'checked'; ?>>
                                            <span>Día</span>
                                        </label>
                                        <label class="radio-item">
                                            <input type="radio" name="momento_dia" value="2" <?php if ($hPauta->id_momento_dia == 2) echo 'checked'; ?>>
                                            <span>Noche</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Fecha:</td>
                                <td>
                                    <div class="input">
                                        <input type="date" class="field" id="fecha" name="fecha" value='<?php echo $hPauta->fecha; ?>'>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Director:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="director" name="director" value="<?php echo $hPauta->director; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Df:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="df" name="df" value="<?php echo $hPauta->df; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Script:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="script" name="script" value="<?php echo $hPauta->script; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Sonido:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="sonido" name="sonido" value="<?php echo $hPauta->sonido; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Día Ficción:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="dia_ficcion" name="dia_ficcion" value=" <?php echo $hPauta->dia_ficcion; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Locación:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="locacion" name="locacion" value="<?php echo $hPauta->locacion; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Personajes:</td>
                                <td>
                                    <div class="input">
                                        <textarea id="comentarios" name="personajes" rows="4"><?php echo $hPauta->personajes; ?></textarea>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="cont-boton">
                            <input class="boton-grabar" type="submit" value="Grabar">
                    </form>
                    <a class="boton-salir" href="<?php echo $destino; ?>">Salir</a>
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