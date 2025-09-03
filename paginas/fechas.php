<?php
require __DIR__ . '/includes/funciones.php';
require __DIR__ . '/includes/config/database.php';
require __DIR__ . '/clases/cls.php';

$identificador = '0';

$auth = estaAutenticado();
$db = conectarDB();

include 'templates/user.php';

//SESIONES::setDB($db);

if (!$auth) {
    header('location: login');
}

$novela = $_GET['novela'];

HOJASPAUTA::setDB($db);
NOVELA::setDB($db);
$hpautas = HOJASPAUTA::listarFechas();
$novelaConsulta = NOVELA::listarNovelaId($novela);
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
        <div class="contenedor tablas">
            <h2>PRODUCCIÓN: <?php echo $novelaConsulta->novela; ?></h2>
            <h3>HOJAS DE PAUTA CLASIFICADAS POR FECHAS</h3>
            <?php include 'templates/barranav.php'; ?>
            
            <?php if ($hpautas) { ?>
                <div class="contenedor-fechas">
                    <?php
                    foreach ($hpautas as $hpauta) :
                        $fecha = $hpauta->fecha;
                        echo '<a class="fecha-item" href="pautasfechas?fecha=' . urlencode($fecha) . '&novela=' . $novela .'">
            <svg fill="#a6c8ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M10 4H2v16h20V6H12l-2-2z"/>
            </svg>
            <span class="fecha-texto">' . date("d-m-Y", strtotime("$hpauta->fecha")) . '</span>
        </a>';
                    endforeach;
                    ?>
                </div>


            <?php } else { ?>
                <div class="margin-top-mayor">
                    <div class="eliminar">
                        <p><span>No existen Hojas de Pauta</span></p>
                    </div>
                </div>
            <?php } ?>
            <div class="cont-boton">
                <a href="panelprincipal"><input class="boton" type="submit" value="Volver a Novelas y Producciones"></a>
            </div>
        </div>
    </main>
    <?php
    include 'templates/footer.php';
    ?>
    <script src="paginas/build/js/bundle.min.js"></script>
</body>

</html>