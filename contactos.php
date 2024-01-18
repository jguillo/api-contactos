<?php
require_once __DIR__.'/lib/api-common.php';
require_once __DIR__.'/modelos/contacto.php';

if (!isset($usuario)) {
    http_response_code(400);
    die("Sin cabecera X-Auth");
}

if ($metodo == "GET") {
    if (isset($_GET['id'])) {
        $contacto = Contacto::carga($_GET['id']);
        if ($contacto == false || $contacto->idUsuario != $usuario->idUsuario) {
            http_response_code(404);
            die("No encontrado");        
        }
        echo json_encode($contacto);
    }
    else {
        $contactos = Contacto::listado($usuario->idUsuario);
        echo json_encode($contactos);
    }
}
else if ($metodo == "POST") {
    $contacto = new Contacto();
    $contacto->nombre = $data->nombre;
    $contacto->email = $data->email;
    $contacto->foto = $data->foto;
    $contacto->telefono = $data->telefono;
    $contacto->direccion = $data->direccion;
    $contacto->notas = $data->notas;
    $contacto->idUsuario = $usuario->idUsuario;
    $contacto->insertar();
    echo json_encode($contacto);
}
else if ($metodo == "PUT") {
    if (!isset($_GET['id'])) {
        http_response_code(400);
        die("Indica el id del contacto");
    }        
    $contacto = Contacto::carga($_GET['id']);
    if ($contacto == false || $contacto->idUsuario != $usuario->idUsuario) {
        http_response_code(404);
        die("No encontrado");        
    }
    $contacto->nombre = $data->nombre;
    $contacto->email = $data->email;
    $contacto->foto = $data->foto;
    $contacto->telefono = $data->telefono;
    $contacto->direccion = $data->direccion;
    $contacto->notas = $data->notas;
    $contacto->actualizar();

    echo json_encode($contacto);
}
else if ($metodo == "DELETE") {
    if (!isset($_GET['id'])) {
        http_response_code(400);
        die("Indica el id del contacto");
    }        
    $contacto = Contacto::carga($_GET['id']);
    if ($contacto == false || $contacto->idUsuario != $usuario->idUsuario) {
        http_response_code(404);
        die("No encontrado");        
    }
    Contacto::borrar($_GET['id']);
}
