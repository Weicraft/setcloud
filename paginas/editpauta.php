<?php
require __DIR__ . '/includes/funciones.php';
require __DIR__ . '/includes/config/database.php';
require __DIR__ . '/clases/cls.php';

$identificador = '4';

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

$novelaEnv = $_GET['novela'];
$id_registro_pauta = $_GET['pauta'];
$indice = $_GET['indice'];
$fecha = $_GET['fecha'] ?? null;
$capitulo = $_GET['capitulo'] ?? null;

REGISTROPAUTAS::setDB($db);
HOJASPAUTA::setDB($db);
NOVELA::setDB($db);
$registro_pauta = REGISTROPAUTAS::listarRegistroPautaID($id_registro_pauta);
$novela = NOVELA::listarNovelaId($novelaEnv);
$hojaPauta = HOJASPAUTA::listarHojaPautaId($registro_pauta->id_hpauta);
$regCam4 = REGISTROPAUTAS::listarHpautaCam4($registro_pauta->id_hpauta);
$regCam5 = REGISTROPAUTAS::listarHpautaCam5($registro_pauta->id_hpauta);
$editpauta = new REGISTROPAUTAS();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $capitulo = mysqli_real_escape_string($db, $_POST['capitulo']) ?? null;
    $escena = mysqli_real_escape_string($db, $_POST['escena']) ?? null;
    $plano = mysqli_real_escape_string($db, $_POST['plano']) ?? null;
    $toma = mysqli_real_escape_string($db, $_POST['toma']) ?? null;
    $retoma = mysqli_real_escape_string($db, $_POST['retoma']) ?? null;
    $clip_cam1 = mysqli_real_escape_string($db, $_POST['clip_cam1']) ?? null;
    $time_cam1 = mysqli_real_escape_string($db, $_POST['time_cam1']) ?? null;
    $clip_cam2 = mysqli_real_escape_string($db, $_POST['clip_cam2']) ?? null;
    $time_cam2 = mysqli_real_escape_string($db, $_POST['time_cam2']) ?? null;
    $clip_cam3 = mysqli_real_escape_string($db, $_POST['clip_cam3']) ?? null;
    $time_cam3 = mysqli_real_escape_string($db, $_POST['time_cam3']) ?? null;
    $clip_cam4 = mysqli_real_escape_string($db, $_POST['clip_cam4']) ?? null;
    $time_cam4 = mysqli_real_escape_string($db, $_POST['time_cam4']) ?? null;
    $clip_cam5 = mysqli_real_escape_string($db, $_POST['clip_cam5']) ?? null;
    $time_cam5 = mysqli_real_escape_string($db, $_POST['time_cam5']) ?? null;
    $obs = mysqli_real_escape_string($db, $_POST['obs']) ?? null;

    //Guardar los datos en BD
    $editpauta->editRegistroPautas(
        $id_registro_pauta,
        $capitulo,
        $escena,
        $plano,
        $toma,
        $retoma,
        $clip_cam1,
        $time_cam1,
        $clip_cam2,
        $time_cam2,
        $clip_cam3,
        $time_cam3,
        $clip_cam4,
        $time_cam4,
        $clip_cam5,
        $time_cam5,
        $obs
    );
    //Redirigir a lista
    header("Location: pauta?hpauta=$registro_pauta->id_hpauta&novela=$novelaEnv&indice=$indice&fecha=$fecha&capitulo=$capitulo");
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
    <script src="https://cdn.tiny.cloud/1/o7abjcddazz4e196cozip4uhvnx0ikppz5p6tqm7n3dkaxyg/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
                <h2>PRODUCCIÓN: <?php echo $novela->novela; ?></h2>
                <h3>Editar Pauta de Hoja de Pauta N° <?php echo $hojaPauta->num_hpauta; ?></h3>
                <div class="diseño_form formulario">
                    <form method="POST">
                        <table>
                            <tr>
                                <td>Capítulo:</td>
                                <td>
                                    <div class="input">
                                        <input type="input" class="field" id="capitulo" name="capitulo" value="<?php echo $registro_pauta->capitulo; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Escena:</td>
                                <td>
                                    <div class="input">
                                        <input type="input" class="field" id="escena" name="escena" value="<?php echo $registro_pauta->escena; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Plano:</td>
                                <td>
                                    <div class="input">
                                        <input type="input" class="field" id="plano" name="plano" value="<?php echo $registro_pauta->plano; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Toma:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="toma" name="toma" value="<?php echo $registro_pauta->toma; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Retoma:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="retoma" name="retoma" value="<?php echo $registro_pauta->retoma; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Clip Cam 1:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="clip_cam1" name="clip_cam1" value="<?php echo $registro_pauta->clip_cam1; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Time Cam 1:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="time_cam1" name="time_cam1" value="<?php echo $registro_pauta->time_cam1; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Clip Cam 2:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="clip_cam2" name="clip_cam2" value="<?php echo $registro_pauta->clip_cam2; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Time Cam 2:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="time_cam2" name="time_cam2" value="<?php echo $registro_pauta->time_cam2; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Clip Cam 3:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="clip_cam3" name="clip_cam3" value="<?php echo $registro_pauta->clip_cam3; ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Time Cam 3:</td>
                                <td>
                                    <div class="input">
                                        <input type="text" class="field" id="time_cam3" name="time_cam3" value="<?php echo $registro_pauta->time_cam3; ?>">
                                    </div>
                                </td>
                            </tr>
                            <?php if ($regCam4) { ?>
                                <tr>
                                    <td>Clip Cam 4:</td>
                                    <td>
                                        <div class="input">
                                            <input type="text" class="field" id="clip_cam4" name="clip_cam4" value="<?php echo $registro_pauta->clip_cam4; ?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Time Cam 4:</td>
                                    <td>
                                        <div class="input">
                                            <input type="text" class="field" id="time_cam4" name="time_cam4" value="<?php echo $registro_pauta->time_cam4; ?>">
                                        </div>
                                    </td>
                                </tr>
                            <?php }
                            if ($regCam5) { ?>
                                <tr>
                                    <td>Clip Cam 5:</td>
                                    <td>
                                        <div class="input">
                                            <input type="text" class="field" id="clip_cam5" name="clip_cam5" value="<?php echo $registro_pauta->clip_cam5; ?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Time Cam 5:</td>
                                    <td>
                                        <div class="input">
                                            <input type="text" class="field" id="time_cam5" name="time_cam5" value="<?php echo $registro_pauta->time_cam5; ?>">
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                        <table class="margin-top">
                            <td>
                                <div>Observaciones:</div>
                                <div class="input">
                                    <textarea id="editor" name="obs" rows="4"><?php echo $registro_pauta->obs; ?></textarea>
                                </div>
                            </td>
                        </table>
                        <div class="cont-boton">
                            <input class="boton-grabar" type="submit" value="Grabar">
                    </form>
                    <a class="boton-salir" href="pauta?hpauta=<?php echo $registro_pauta->id_hpauta; ?>&novela=<?php echo $novelaEnv; ?>&indice=<?php echo $indice; ?>&fecha=<?php echo $fecha; ?>&capitulo=<?php echo $capitulo; ?>">Salir</a>
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