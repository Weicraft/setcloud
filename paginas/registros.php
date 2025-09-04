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

$novela = $_GET['novela'];
$hpauta = $_GET['hpauta'];
$indice = $_GET['indice'];
$fecha = $_GET['fecha'] ?? null;
$capitulo = $_GET['capitulo'] ?? null;

NOVELA::setDB($db);
HOJASPAUTA::setDB($db);
REGISTROPAUTAS::setDB($db);

$novelaConsulta = NOVELA::listarNovelaId($novela);
$hojaPauta = HOJASPAUTA::listarHojaPautaId($hpauta);

$errores = [];
$nuevaPauta = new REGISTROPAUTAS();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = $_POST['data'];

    foreach ($data as $fila) {
        // Columnas normales (0-10)
        $capitulo = $fila[0];
        $escena   = $fila[1];
        $plano    = $fila[2];
        $toma     = $fila[3];
        $retoma   = $fila[4];
        $clip_cam1 = $fila[5];
        $time_cam1 = $fila[6];
        $clip_cam2 = $fila[7];
        $time_cam2 = $fila[8];
        $clip_cam3 = $fila[9];
        $time_cam3 = $fila[10];

        // Columna VB (✅ = "1", ❌ = "0")
        $vb = isset($fila['VB']) ? $fila['VB'] : null;

        // Columna Observaciones
        $obs = $fila[12];

        // Guardar solo si hay algo
        if ($capitulo || $escena || $plano || $toma || $retoma || $clip_cam1 || $time_cam1 || $clip_cam2 || $time_cam2 || $clip_cam3 || $time_cam3 || $vb || $obs) {
            $registroNuevo = new REGISTROPAUTAS();
            $registroNuevo->crear(
                $hpauta,
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
                null,
                null,
                null,
                null,
                $vb,
                $obs
            );
        }
    }
    header("Location: pauta?hpauta=$hpauta&novela=$novela&indice=$indice&fecha=$fecha&capitulo=$capitulo");
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
    <script src="paginas/build/js/ajaxregistros.js"></script>
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
        <div class="contenedor tablas">
            <h2>PRODUCCIÓN: <?php echo $novelaConsulta->novela; ?></h2>
            <h3>Agregar registros a Hoja de Pauta N° <?php echo $hojaPauta->num_hpauta; ?></h3>
            <form method="post">
                <table class="tabla-pauta">
                    <tr>
                        <th>Capítulo</th>
                        <th>Escena</th>
                        <th>Plano</th>
                        <th>Toma</th>
                        <th>Retoma</th>
                        <th>Clip Cam 1</th>
                        <th>Time Cam 1</th>
                        <th>Clip Cam 2</th>
                        <th>Time Cam 2</th>
                        <th>Clip Cam 3</th>
                        <th>Time Cam 3</th>
                        <th>VB</th> <!-- Columna 12 -->
                        <th>Observaciones</th> <!-- Columna 13 -->
                    </tr>

                    <colgroup>
                        <?php for ($j = 0; $j < 13; $j++): ?>
                            <col>
                        <?php endfor; ?>
                    </colgroup>

                    <?php for ($i = 0; $i < 19; $i++): ?>
                        <tr>
                            <?php for ($j = 0; $j < 13; $j++): ?>
                                <?php if ($j == 11): ?>
                                    <!-- Columna VB -->
                                    <td class="vb-cell" data-name="data[<?= $i ?>][VB]">
                                        <input type="hidden" name="data[<?= $i ?>][VB]" value="">
                                    </td>
                                <?php elseif ($j == 12): ?>
                                    <!-- Columna Observaciones -->
                                    <td>
                                        <textarea name="data[<?= $i ?>][<?= $j ?>]"></textarea>
                                    </td>
                                <?php else: ?>
                                    <!-- Columnas 1-11 -->
                                    <td>
                                        <input type="text" class="text-center" name="data[<?= $i ?>][<?= $j ?>]">
                                    </td>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </tr>
                    <?php endfor; ?>
                </table>
                <!-- Menú contextual -->
                <div id="vb-menu" class="vb-menu">
                    <button type="button" data-value="1">✅</button>
                    <button type="button" data-value="0">❌</button>
                </div>

                <div class="flex-simple-center margin-top">
                    <a class="boton-salir" href="pauta?hpauta=<?php echo $hpauta; ?>&novela=<?php echo $novela; ?>&indice=<?php echo $indice; ?>&fecha=<?php echo $fecha; ?>&capitulo=<?php echo $capitulo; ?>">Salir sin grabar</a>
                    <button type="submit" class="boton-grabar big-margin-left">Guardar</button>
                </div>
            </form>

        </div>
    </main>
    <?php
    include 'templates/footer.php';
    ?>
    <script src="paginas/build/js/bundle.min.js"></script>
</body>

</html>