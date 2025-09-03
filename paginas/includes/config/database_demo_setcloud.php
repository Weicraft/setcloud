<?php

function conectarDB(): mysqli
{
    $mysqli = new mysqli('localhost', 'demo_setclo_usr', '9VC39UCC40rZFNAZ', 'demo_setcloud_bd');
    $mysqli->set_charset("utf8");

    if (!$mysqli) {
        echo "Error, no se pudo conectar al servidor";
        exit;
    } 
    return $mysqli;
}
