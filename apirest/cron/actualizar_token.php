<?php
function cors()
{
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin, Authorization, X-Requested-With, Content-Type, Accept, lastActivityTime, id_participante, token");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin, Authorization, X-Requested-With, Content-Type, Accept, lastActivityTime, id_participante, token");

        exit(0);
    }
}
cors();
require_once '../clases/token.class.php';
$_token = new Token;
$fecha = date('Y-m-d H:i:s', strtotime('-5 minutes'));
$actualizacion = $_token->actualizarToken($fecha);

$logFile = '../logs/cron_log.txt';
$logMessage = date('Y-m-d H:i:s') . " - Script executed. Tokens updated: " . $actualizacion . "\n";
file_put_contents($logFile, $logMessage, FILE_APPEND);

echo $actualizacion;
