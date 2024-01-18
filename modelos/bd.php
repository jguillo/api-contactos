<?php

function abrirBD() {
    $bd = new mysqli(
            "localhost",   // Servidor
            "api_contactos",   // Usuario
            "<USUARIO>",     // Contraseña
            "<PASSWORD>");        // Esquema
    if ($bd->connect_errno) {
        die("Error de conexión: " . $bd->connect_error);
    }
    $bd->set_charset("utf8mb4");
    return $bd;
}

