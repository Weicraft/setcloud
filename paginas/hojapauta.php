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

$hpauta = $_GET['hpauta'];
$novela = $_GET['novela'];
$indice = $_GET['indice'];
$fecha = $_GET['fecha'] ?? null;
$capitulo = $_GET['capitulo'] ?? null;
$destino = asignarDestino($indice, $novela, $fecha, $capitulo, $hpauta);

NOVELA::setDB($db);
HOJASPAUTA::setDB($db);
REGISTROPAUTAS::setDB($db);
$novelaConsulta = NOVELA::listarNovelaId($novela);
$hojaPauta = HOJASPAUTA::listarHojaPautaId($hpauta);
$registroPautas = REGISTROPAUTAS::listarRegistroPautas($hpauta);
$regCam4 = REGISTROPAUTAS::listarHpautaCam4($hpauta);
$regCam5 = REGISTROPAUTAS::listarHpautaCam5($hpauta);

$sesionSeccion = SESIONES::listarSesionesPorIdentificacorUsuario('4', $id_user);
$sesionSeccionNotas = SESIONES::listarSesionesPorIdentificacorUsuario('5', $id_user);
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="paginas/build/js/ajax.js"></script>
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
            <h3>HOJA DE PAUTA N° <?php echo $hojaPauta->num_hpauta; ?></h3>

            <div class="diseño_tablas">
                <table>
                    <tr>
                        <th colspan=2>Ubicación</th>
                        <td colspan=2>
                            <?php
                            if ($hojaPauta->id_ubic_rodaje == "1") {
                                echo "Exterior";
                            } else {
                                echo "Interior";
                            }
                            ?>
                    </tr>
                    <tr>
                        <th colspan=2>Momento</th>
                        <td colspan=2>
                            <?php
                            if ($hojaPauta->id_momento_dia == "1") {
                                echo "Día";
                            } else {
                                echo "Noche";
                            }
                            ?>
                    </tr>
                    <tr>
                        <th colspan=2>Fecha</th>
                        <td colspan=2><?php echo date("d-m-Y", strtotime("$hojaPauta->fecha")); ?></td>
                    </tr>
                    <tr>
                        <th>Director</th>
                        <td><?php echo $hojaPauta->director; ?></td>
                        <th>Dia Ficción</th>
                        <td><?php echo $hojaPauta->dia_ficcion; ?></td>
                    </tr>
                    <tr>
                        <th>DF</th>
                        <td><?php echo $hojaPauta->df; ?></td>
                        <th>Locación</th>
                        <td><?php echo $hojaPauta->locacion; ?></td>
                    </tr>
                    <tr>
                        <th>Script</th>
                        <td><?php echo $hojaPauta->script; ?></td>
                        <th rowspan=2>Personajes</th>
                        <td rowspan=2><?php echo $hojaPauta->personajes; ?></td>
                    </tr>
                    <tr>
                        <th>Sonido</th>
                        <td><?php echo $hojaPauta->sonido; ?></td>
                    </tr>
                </table>
            </div>
            <?php if ($sesionSeccion->estado_sesion == '1') { ?>
                <a href="registro?hpauta=<?php echo $hpauta; ?>&novela=<?php echo $novela; ?>&indice=<?php echo $indice; ?>&fecha=<?php echo $fecha; ?>&capitulo=<?php echo $capitulo; ?>"><button class="margin-top boton-agregar">+ Agregar Nueva Pauta</button></a>
            <?php }
            if ($registroPautas) { ?>
                <table class="formulario diseño_tablas">
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
                        <?php if ($regCam4) { ?>
                            <th>Clip Cam 4</th>
                            <th>Time Cam 4</th>
                        <?php }
                        if ($regCam5) { ?>
                            <th>Clip Cam 5</th>
                            <th>Time Cam 5</th>
                        <?php } ?>
                        <th>VB</th>
                        <th>Observaciones</th>
                        <?php if ($sesionSeccion->estado_sesion == '1') { ?>
                        <th>Editar</th>
                        <th>Eliminar</th>
                        <?php } ?>
                    </tr>
                    <?php
                    foreach ($registroPautas as $rpauta) :
                    ?>
                        <tr>
                            <td><?php if ($rpauta->capitulo != '0') { echo $rpauta->capitulo; } else { echo ''; } ?></td>
                            <td><?php if ($rpauta->escena != '0') { echo $rpauta->escena; } else { echo ''; }  ?></td>
                            <td><?php if ($rpauta->plano != '0') { echo $rpauta->plano; } else { echo ''; }  ?></td>
                            <td><?php if ($rpauta->toma != '0') { echo $rpauta->toma; } else { echo ''; }  ?></td>
                            <td><?php if ($rpauta->retoma != '0') { echo $rpauta->retoma; } else { echo ''; }  ?></td>
                            <td><?php if ($rpauta->clip_cam1 != '0') { echo $rpauta->clip_cam1; } else { echo ''; }  ?></td>
                            <td><?php if ($rpauta->time_cam1 != '0') { echo $rpauta->time_cam1; } else { echo ''; }  ?></td>
                            <td><?php if ($rpauta->clip_cam2 != '0') { echo $rpauta->clip_cam2; } else { echo ''; }  ?></td>
                            <td><?php if ($rpauta->time_cam2 != '0') { echo $rpauta->time_cam2; } else { echo ''; }  ?></td>
                            <td><?php if ($rpauta->clip_cam3 != '0') { echo $rpauta->clip_cam3; } else { echo ''; }  ?></td>
                            <td><?php if ($rpauta->time_cam3 != '0') { echo $rpauta->time_cam3; } else { echo ''; } ?></td>
                            <?php if ($regCam4) { ?>
                                <td><?php if ($rpauta->clip_cam4 != '0') { echo $rpauta->clip_cam4; } else { echo ''; }  ?></td>
                                <td><?php if ($rpauta->time_cam4 != '0') { echo $rpauta->time_cam4; } else { echo ''; }  ?></td>
                            <?php }
                            if ($regCam5) { ?>
                                <td><?php if ($rpauta->clip_cam5 != '0') { echo $rpauta->clip_cam5; } else { echo ''; }  ?></td>
                                <td><?php if ($rpauta->time_cam5 != '0') { echo $rpauta->time_cam5; } else { echo ''; }  ?></td>
                            <?php } ?>
                            <td class="vb-cell" data-id="<?= $rpauta->id_registro_pauta ?>" data-valor="<?= $rpauta->vb ?>">
                                <?php
                                if ($rpauta->vb == '1') { ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="green" viewBox="0 0 24 24">
                                        <path d="M20.285 6.709a1 1 0 0 0-1.414-1.418l-9.19 9.203-4.55-4.544a1 1 0 1 0-1.414 1.414l5.256 5.25a1 1 0 0 0 1.414 0l9.898-9.905z" />
                                    </svg>
                                <?php } elseif ($rpauta->vb == '0') { ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="red" viewBox="0 0 24 24">
                                        <path d="M18.364 5.636a1 1 0 0 0-1.414 0L12 10.586 7.05 5.636A1 1 0 0 0 5.636 7.05L10.586 12l-4.95 4.95a1 1 0 1 0 1.414 1.414L12 13.414l4.95 4.95a1 1 0 0 0 1.414-1.414L13.414 12l4.95-4.95a1 1 0 0 0 0-1.414z" />
                                    </svg>
                                <?php }; ?>
                            </td>
                            <td id="miDiv"><?php echo $rpauta->obs; ?></td>
                            <?php if ($sesionSeccion->estado_sesion == '1') { ?>
                            <td>
                                <div class="flex-simple-center">
                                    <a href="editregistro?pauta=<?php echo $rpauta->id_registro_pauta; ?>&novela=<?php echo $novela; ?>&indice=<?php echo $indice; ?>&fecha=<?php echo $fecha; ?>&capitulo=<?php echo $capitulo; ?>">
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
                                    <a href="elimregistro?pauta=<?php echo $rpauta->id_registro_pauta; ?>&novela=<?php echo $novela; ?>&indice=<?php echo $indice; ?>&fecha=<?php echo $fecha; ?>&capitulo=<?php echo $capitulo; ?>">
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
                <!-- Menú contextual -->
                <div class="menu-contextual" id="menuContextual">
                    <svg data-value="1" fill="green" viewBox="0 0 24 24">
                        <path d="M20.285 6.709a1 1 0 0 0-1.414-1.418l-9.19 9.203-4.55-4.544a1 1 0 1 0-1.414 1.414l5.256 5.25a1 1 0 0 0 1.414 0l9.898-9.905z" />
                    </svg>
                    <svg data-value="0" fill="red" viewBox="0 0 24 24">
                        <path d="M18.364 5.636a1 1 0 0 0-1.414 0L12 10.586 7.05 5.636A1 1 0 0 0 5.636 7.05L10.586 12l-4.95 4.95a1 1 0 1 0 1.414 1.414L12 13.414l4.95 4.95a1 1 0 0 0 1.414-1.414L13.414 12l4.95-4.95a1 1 0 0 0 0-1.414z" />
                    </svg>
                </div>
            <?php } else { ?>
                <div class="margin-top-mayor">
                    <div class="eliminar">
                        <p><span>No existen Registros de pautas</span></p>
                    </div>
                </div>
            <?php }
            if ($registroPautas) { ?>
                <div class="flex-simple">
                    <div class="bold margin-right">Nota: <?php echo $hojaPauta->nota; ?></div>
                    <?php if ($sesionSeccionNotas->estado_sesion == '1') { ?>
                    <a href="nota?hpauta=<?php echo $rpauta->id_hpauta; ?>&novela=<?php echo $novela; ?>&indice=<?php echo $indice; ?>&fecha=<?php echo $fecha; ?>&capitulo=<?php echo $capitulo; ?>">
                        <button class="btn-editar" title="Editar">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12 20h9" />
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                            </svg>
                        </button>
                    </a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <div class="cont-boton">
            <a href="<?php echo $destino; ?>"><input class="boton" type="submit" value="Volver"></a>
        </div>
    </main>
    <?php
    include 'templates/footer.php';
    ?>
    <script src="paginas/build/js/bundle.min.js"></script>
</body>

</html>