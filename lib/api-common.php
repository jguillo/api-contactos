<?php
require_once __DIR__.'/../modelos/apikey.php';
require_once __DIR__.'/../modelos/usuario.php';

/**
 * Este fichero implementa el código común para todos los endpoint de API.
 * Valida las cabeceras X-ClaveApi y X-Auth y configura el Content-Type application/json
 * Este fichero define las siguientes variables que quedan disponibles para la página principal:
 *  - $headers - Lista de cabeceras de la petición
 *  - $metodo - Método HTTP de la petición (GET, POST, PUT, DELETE)
 *  - $claveApi - Valor de la cabecera X-ClaveApi
 *  - $apiKey - Objeto ApiKey asociado a la clave de API
 *  - $data - Objeto con el contenido JSON de la petición en caso de POST o PUT
 *  - $auth - Valor de la cabecera X-Auth si se recibe
 *  - $usuario - Usuario autorizado si se ha recibido cabecera X-Auth 
 */

$headers = getallheaders();
$metodo = $_SERVER['REQUEST_METHOD'];
header("Content_Type: application/json");

if (!isset($headers['X-ClaveApi'])) {
    http_response_code(400);
    die("Sin cabecera X-ClaveApi");
}
$claveApi = $headers['X-ClaveApi'];
$apiKey = ApiKey::carga($claveApi);
if (!$apiKey) {
    http_response_code(400);
    die("Cabecera X-ClaveApi no válida");
}

if ($metodo == 'POST' || $metodo == 'PUT') {
    $data = json_decode(file_get_contents('php://input'), false);
}
if (isset($headers['X-Auth'])) {
    $auth = $headers['X-Auth'];
    $usuario = Usuario::cargaAuth($auth, $apiKey->idApiKey);
    if ($usuario == false) {
        http_response_code(400);
        die("Cabecera X-Auth no válida");
    }
}
header("Content_Type: application/json");
