<?php
require '../includes/funciones.php';
require '../includes/config/database.php';

$identificador = '0';

$auth = estaAutenticado();
$db = conectarDB();


//SESIONES::setDB($db);

if (!$auth) {
    header('location: login');
}


// Recibe los datos enviados por AJAX

$id = mysqli_real_escape_string($db, $_POST['id']);
$newValue = mysqli_real_escape_string($db, $_POST['nuevo_valor']);

/*$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$newValue = isset($_POST['value']) ? intval($_POST['value']) : 0;*/

// Valida que exista un ID válido
if ($id > 0) {

    $qry = "UPDATE registro_pautas SET vb = $newValue WHERE id_registro_pauta = $id"; 
    $result = mysqli_query($db, $qry);
    if (!$result) {
        die('Query failed');
    }
}

