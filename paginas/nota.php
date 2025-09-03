<?php
require __DIR__ . '/includes/funciones.php';
require __DIR__ . '/includes/config/database.php';
require __DIR__ . '/clases/cls.php';

$identificador = '5';

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

$novelaConsulta = NOVELA::listarNovelaId($novela);
$hojaPauta = HOJASPAUTA::listarHojaPautaId($hpauta);
$notaAnterior = $hojaPauta->nota ?? null;

$nuevaNota = new HOJASPAUTA();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nota = mysqli_real_escape_string($db, $_POST['nota']) ?? null;

        //Guardar los datos en BD
        $nuevaNota->nuevaNota($hpauta, $nota)
        ;
        //Redirigir a lista
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
                <h3>Agregar NOTA a Hoja de Pauta N° <?php echo $hojaPauta->num_hpauta; ?></h3>
                <div class="diseño_form formulario">
                    <form method="POST">
                        <table>
                            <tr>
                                <td>
                                    <div>Nota:</div>
                                    <div class="input">
                                        <textarea name="nota" id="editor" rows="4"><?php echo $notaAnterior; ?></textarea>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="cont-boton">
                            <input class="boton-grabar" type="submit" value="Grabar">
                    </form>
                    <a class="boton-salir" href="pauta?hpauta=<?php echo $hpauta;?>&novela=<?php echo $novela; ?>&indice=<?php echo $indice; ?>&fecha=<?php echo $fecha; ?>&capitulo=<?php echo $capitulo; ?>">Salir</a>
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