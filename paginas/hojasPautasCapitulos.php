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
$cap = $_GET['capitulo'];
$indice = '3';

HOJASPAUTA::setDB($db);
NOVELA::setDB($db);
$hpautas = HOJASPAUTA::listarHojaPautaCapitulo($cap, $novela);
$novelaConsulta = NOVELA::listarNovelaId($novela);

$sesionSeccion = SESIONES::listarSesionesPorIdentificacorUsuario('3', $id_user);
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
        <h3>HOJAS DE PAUTA DEL CAPÍTULO <?php echo $cap; ?></h3>
        <?php include 'templates/barranav.php'; ?>            
            <?php if ($hpautas) { ?>
                <table class="formulario diseño_tablas">
                    <tr>
                        <th width=10%>Número Hoja</th>
                        <th>Fecha</th>
                        <th>Día Ficción</th>
                        <th>Locación</th>
                        <th>Ver</th>
                        <?php if ($sesionSeccion->estado_sesion == '1') { ?>
                        <th>Editar</th>
                        <th>Eliminar</th>
                        <?php } ?>
                    </tr>
                    <?php
                    foreach ($hpautas as $hpauta) :
                    ?>
                        <tr>
                            <td><?php echo $hpauta->num_hpauta; ?></td>
                            <td><?php echo date("d-m-Y", strtotime("$hpauta->fecha")); ?></td>
                            <td><?php echo $hpauta->dia_ficcion; ?></td>
                            <td><?php echo $hpauta->locacion; ?></td>
                            <td>
                                <div class="flex-simple-center">
                                    <a href="pauta?hpauta=<?php echo $hpauta->id_hpauta; ?>&novela=<?php echo $novela; ?>&capitulo=<?php echo $cap; ?>&indice=<?php echo $indice; ?>">
                                        <button class="boton-icono-ver">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                                <path stroke-width="2" d="M14 3h7v7m0-7L10 14m-7 7h11a2 2 0 0 0 2-2V10a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v11z" />
                                            </svg>
                                        </button>
                                    </a>
                                </div>
                            </td>
                            <?php if ($sesionSeccion->estado_sesion == '1') { ?>
                            <td>
                                <div class="flex-simple-center">
                                    <a href="editpauta?hpauta=<?php echo $hpauta->id_hpauta; ?>&novela=<?php echo $novela; ?>&capitulo=<?php echo $cap; ?>&indice=<?php echo $indice; ?>">
                                        <button class="btn-editar" title="Editar">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path d="M12 20h9" />
                                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                                            </svg>
                                        </button>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="flex-simple-center">
                                    <a href="elimpauta?hpauta=<?php echo $hpauta->id_hpauta; ?>&novela=<?php echo $novela; ?>&capitulo=<?php echo $cap; ?>&indice=<?php echo $indice; ?>">
                                        <button class="btn-eliminar" title="Eliminar">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                viewBox="0 0 24 24">
                                                <polyline points="3 6 5 6 21 6" />
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                                <path d="M10 11v6M14 11v6" />
                                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                            </svg>
                                        </button>
                                    </a>
                                </div>
                            </td>
                            <?php } ?>
                        </tr>
                    <?php endforeach; ?>
                </table>
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