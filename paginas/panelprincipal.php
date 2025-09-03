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

NOVELA::setDB($db);
$novelas = NOVELA::listarNovela();

$sesionSeccion = SESIONES::listarSesionesPorIdentificacorUsuario('2', $id_user);
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
        <?php include 'templates/saludoinicadmin.php'; ?>
    </div>
    <main class="principal">
        <div class="contenido">
            <div class="contenedor panel">
                <h3>Novelas y producciones</h3>
                <?php if ($sesionSeccion->estado_sesion == '1') { ?>
                    <a href="nuevaprod"><button class="boton-agregar">+ Agregar Nueva</button></a>
                <?php
                }
                if ($novelas) {
                ?>
                    <div class="contenedor options">
                        <?php
                        foreach ($novelas as $novela) : ?>
                            <div class="option">
                                <div class="negro"></div>
                                <a href="pautas?novela=<?php echo $novela->id_novela; ?>">
                                    <h2><?php echo $novela->novela; ?></h2>
                                </a>
                                <a href="pautas?novela=<?php echo $novela->id_novela; ?>">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="32"
                                        height="32"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="#000000"
                                        stroke-width="1"
                                        stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M7 4v16l13 -8z" />
                                    </svg>
                                </a>
                                <?php if ($sesionSeccion->estado_sesion == '1') { ?>
                                    <a href="editprod?novela=<?php echo $novela->id_novela; ?>"><button class="edit-button" title="Editar">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#1e88e5" stroke-width="2">
                                                <path d="M12 20h9" />
                                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                                            </svg>
                                        </button>
                                    </a>
                                    <a href="elimprod?novela=<?php echo $novela->id_novela; ?>"><button class="btn-eliminar" title="Eliminar">
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
                                <?php } ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php } else {
                    echo '<div class="eliminar">
                        <p><span>No hay novelas ni producciones registradas</span></p></div>';
                } ?>
            </div>
        </div>
    </main>
    <?php
    include 'templates/footer.php';
    ?>
    <script src="paginas/build/js/bundle.min.js"></script>
</body>

</html>