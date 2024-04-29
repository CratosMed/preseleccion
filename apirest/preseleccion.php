<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/preseleccion.class.php';

function cors()
{
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin, Authorization, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin, Authorization, X-Requested-With, Content-Type, Accept, id_preseleccion, token");

        exit(0);
    }
}
cors();

$_respuestas = new respuestas;
$_preseleccion = new preseleccion;

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET["page"])) {
        $pagina = $_GET["page"];
        $listaPreseleccion = $_preseleccion->listaPreseleccion($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaPreseleccion);
        http_response_code(200);
    } elseif (isset($_GET["id"])) {
        $preseleccionId = $_GET["id"];
        $datosPreseleccion = $_preseleccion->obtenerPreseleccion($preseleccionId);
        header("Content-Type: application/json");
        echo json_encode($datosPreseleccion);
        http_response_code(200);
    } elseif (isset($_GET["id_participante"])) {
        $preseleccionId = $_GET["id_participante"];
        $datosPreseleccion = $_preseleccion->obtenerPreseleccionId($preseleccionId);
        header("Content-Type: application/json");
        echo json_encode($datosPreseleccion);
        http_response_code(200);
    } elseif (isset($_GET["grap"])) {
        $grap = $_GET["grap"];
        $graficosPreseleccion = $_preseleccion->graficosPreseleccion($grap);
        header("Content-Type: application/json");
        echo json_encode($graficosPreseleccion);
        http_response_code(200);
    } elseif (isset($_GET["preselecciones"])) {
        $preselecciones = isset($_GET["preselecciones"]) ? $_GET["preselecciones"] : null;
        $fechaInicio = isset($_GET["fechaInicio"]) ? $_GET["fechaInicio"] : null;
        $fechaFin = isset($_GET["fechaFin"]) ? $_GET["fechaFin"] : null;

        if ($preselecciones !== null) {
            $preseleccionesview = $_preseleccion->preseleccionesview($preselecciones, $fechaInicio, $fechaFin);
            header("Content-Type: application/json");
            echo json_encode($preseleccionesview);
            http_response_code(200);
        } else {
            // Manejar el caso en el que no se proporciona la variable $preselecciones en la URL
            header("Content-Type: application/json");
            echo json_encode(array("error" => "Falta el parámetro 'preselecciones' en la URL"));
            http_response_code(400);
        }
    }
    //elseif (isset($_GET["preselecciones"])) {
    //     $preselecciones = $_GET["preselecciones"];
    //     $preseleccionesview = $_preseleccion->preseleccionesview($preselecciones, $fechaInicio, $fechaFin);
    //     header("Content-Type: application/json");
    //     echo json_encode($preseleccionesview);
    //     http_response_code(200);
    // }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //enviamos los datos al manejador
    $datosArray = $_preseleccion->post($postBody);
    //devolvemos una respuesta
    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} else if ($_SERVER['REQUEST_METHOD'] == "PUT") {
    //recibimos los datos enviados

    $postBody = file_get_contents("php://input");
    //enviamos los datos al manejador
    $datosArray = $_preseleccion->put($postBody);
    //devolvemos una respuesta
    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    $headers = getallheaders();

    if (isset($headers["token"]) && isset($headers["id_preseleccion"])) {
        //recibimos los datos por el header
        $send = [
            "token" => $headers["token"],
            "id_preseleccion" => $headers["id_preseleccion"]
        ];
        $postBody = json_encode($send);
    } else {
        //recibimos los datos enviados
        $postBody = file_get_contents("php://input");
    }

    //enviamos los datos al manejador
    $datosArray = $_preseleccion->delete($postBody);
    //devolvemos una respuesta
    header('Content-Type: application/json');
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} else {
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}
