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
$elimpauta = new REGISTROPAUTAS();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $elimpauta->elimRegistroPauta($id_registro_pauta);
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
                <h2>PRODUCCIÓN: <?php echo $novela->novela; ?></h2>
                <h3>HOJA DE PAUTA N° <?php echo $hojaPauta->num_hpauta; ?></h3>
                <div class="contenedor">
                    <form method="POST">
                        <div class="alerta error">¿Está seguro que desea eliminar la este registro de la hora de Pauta N° <?php echo $hojaPauta->num_hpauta; ?>?</div>
                        <div class="cont-boton">
                            <input class="boton-salir" type="submit" value="Eliminar">
                    </form>
                    <a class="boton-grabar" href="pauta?hpauta=<?php echo $registro_pauta->id_hpauta; ?>&novela=<?php echo $novelaEnv; ?>&indice=<?php echo $indice; ?>&fecha=<?php echo $fecha; ?>&capitulo=<?php echo $capitulo; ?>">Salir</a>
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