<?php
require_once __DIR__.'/lib/api-common.php';


if ($metodo == "GET") {
    if (!isset($usuario)) {
        http_response_code(400);
        die("Sin cabecera X-Auth");
    }
    echo json_encode($usuario);
}
else if ($metodo == "POST") {
    $existente = Usuario::cargaLogin($data->email, $apiKey->idApiKey);
    if ($existente) {
        http_response_code(409);
        die("Ya existe un usuario con el mismo email");
    }
    $usuario = new Usuario();
    $usuario->nombre = $data->nombre;
    $usuario->email = $data->email;
    $usuario->pwd = password_hash($data->pwd, PASSWORD_DEFAULT);
    $usuario->idApiKey = $apiKey->idApiKey;
    $usuario->authkey = uuid();
    $usuario->insertar();
    echo json_encode($usuario);
}
else if ($metodo == "PUT") {
    if (!isset($usuario)) {
        http_response_code(400);
        die("Sin cabecera X-Auth");
    }
    $usuario->nombre = $data->nombre;
    $usuario->email = $data->email;
    if ($data->pwd) {
        $usuario->pwd = password_hash($data->pwd, PASSWORD_DEFAULT);
    }
    $usuario->actualizar();
    echo json_encode($usuario);
}
