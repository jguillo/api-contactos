<?php
require_once __DIR__.'/lib/api-common.php';

$usuario = Usuario::cargaLogin($data->email, $apiKey->idApiKey);
if ($usuario == false) {
    http_response_code(400);
    die("Usuario o contraseña incorrectos");
}
else if (!password_verify($data->pwd, $usuario->pwd)) {
    http_response_code(400);
    die("Usuario o contraseña incorrectos");
}

echo json_encode(['auth' => $usuario->authkey]);