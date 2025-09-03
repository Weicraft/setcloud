<?php

function mostrarFecha()
{
    date_default_timezone_set('America/Lima');

    $diassemana = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

    echo $diassemana[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
}

function estaAutenticado(): bool
{
    session_start();

    $auth = $_SESSION['login'];

    if ($auth) {
        return true;
    }
    return false;
}

function debuguear($variable)
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

function generarCodigoPauta($id) {
    if ($id < 10) {
        return 'P000' . $id;
    } elseif ($id < 100) {
        return 'P00' . $id;
    } elseif ($id < 1000) {
        return 'P0' . $id;
    } else {
        return 'P' . $id;
    }
}

function asignarDestino($indice, $novela, $fecha, $capitulo, $hpauta)
{
    $destino = 0; // Valor inicial de y

    switch ($indice) {
        case 1:
            $destino = 'pautas?novela=' . $novela;
            break;
        case 2:
            $destino = 'pautasfechas?fecha=' . $fecha . '&novela=' . $novela;
            break;
        case 3:
            $destino = 'pautascapitulos?capitulo=' . $capitulo . '&novela=' . $novela;
            break;
            // Agrega más casos según sea necesario
        default:
            // Valor predeterminado si x no coincide con ningún caso
            break;
    }
    return $destino;
}

?>