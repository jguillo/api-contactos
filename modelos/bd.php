<?php

function abrirBD() {
    $bd = new mysqli(
            "localhost",   // Servidor
            "<USUARIO>",   // Usuario
            "<PASSWORD>",     // Contraseña
            "api_contactos");        // Esquema
    if ($bd->connect_errno) {
        die("Error de conexión: " . $bd->connect_error);
    }
    $bd->set_charset("utf8mb4");
    return $bd;
}

