<?php
require_once 'clases/conexion/conexion.php';
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

class Activity extends conexion
{
    public function actualizarActividad($token, $lastActivityTime)
    {
        $query = "UPDATE usuarios_token SET ultima_actividad = '$lastActivityTime' WHERE token = '$token'";
        $verificar = parent::nonQuery($query);
        return $verificar;
    }
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['token']) && isset($data['lastActivityTime'])) {
    $token = $data['token'];
    $lastActivityTime = $data['lastActivityTime'];

    // Debugging output
    error_log("Received data: token = $token, lastActivityTime = $lastActivityTime");

    $activity = new Activity();
    $resultado = $activity->actualizarActividad($token, $lastActivityTime);

    if ($resultado > 0) {
        echo json_encode(["success" => true, "updated_records" => $resultado]);
    } else {
        echo json_encode(["success" => false]);
    }
} else {
    // Debugging output
    error_log("Datos incompletos: " . json_encode($data));

    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
}
