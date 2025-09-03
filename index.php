<?php
// Carpeta base de tu proyecto
$basePath = '/setcloud';

// Ruta solicitada
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Quitar el prefijo del proyecto si existe
if (strpos($uri, ltrim($basePath, '/')) === 0) {
    $uri = substr($uri, strlen(ltrim($basePath, '/')));
    $uri = trim($uri, '/');
}

// Mapa de rutas
$rutas = [
    ''                => 'paginas/login.php',
    'login'           => 'paginas/login.php',
    'panelprincipal'  => 'paginas/panelprincipal.php',
    'usuarios'        => 'paginas/gestuser.php',
    'cerrar-sesion'   => 'paginas/cerrar-sesion.php',
    'nuevouser'       => 'paginas/nuevoUser.php',
    'permisos'        => 'paginas/gestPermisos.php',
    'nomoreuser'      => 'paginas/nomoreuser.php',
    'edituser'        => 'paginas/editUser.php',
    'editpass'        => 'paginas/editPassword.php',
    'elimuser'        => 'paginas/elimUser.php',
    'nomoreuser'      => 'paginas/nomoreuser.php',
    'nuevaprod'       => 'paginas/nuevaProd.php',
    'editprod'        => 'paginas/editProd.php',
    'elimprod'        => 'paginas/eliminarNov.php',
    'pautas'          => 'paginas/hojasPautas.php',
    'fechas'          => 'paginas/fechas.php',
    'capitulos'       => 'paginas/capitulos.php',
    'nuevapauta'      => 'paginas/nuevaHojaPauta.php',
    'pauta'           => 'paginas/hojapauta.php',
    'registro'        => 'paginas/nuevapauta.php',
    'editregistro'    => 'paginas/editpauta.php',
    'elimregistro'    => 'paginas/elimpauta.php',
    'nota'            => 'paginas/nota.php',
    'editpauta'       => 'paginas/edithpauta.php',
    'elimpauta'       => 'paginas/elimhpauta.php',
    'pautasfechas'    => 'paginas/hojasPautasFechas.php',
    'pautascapitulos' => 'paginas/hojasPautasCapitulos.php',
    
];

// Verificar si la ruta existe
if (array_key_exists($uri, $rutas)) {
    require $rutas[$uri];
} else {
    http_response_code(404);
    echo "Página no encontrada";
}
