<?php
require_once 'clases/auth.class.php';
require_once 'clases/respuestas.class.php';
require_once 'clases/conexion/conexion.php';


function cors()
{
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");

        exit(0);
    }
}
cors();

$_auth = new auth;
$_respuestas = new respuestas;
$_conexion = new conexion;
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET["token"])) {
        $token = $_GET["token"];
        $estatus = $_auth->obtenerEstatus($token);
        header("Content-Type: application/json");
        echo json_encode($estatus);
        http_response_code(200);
    } elseif (isset($_GET["correo"]) && isset($_GET["pass"])) {
        $correo = $_GET["correo"];
        $pass = $_GET["pass"];
        $clave = $_conexion->encriptar($pass);
        $datosCorreo = $_auth->obtenerDatosUsuarios($correo);
        header("Content-Type: application/json");
        if ($datosCorreo[0]["clave"] == $clave) {
            echo json_encode($datosCorreo);
            http_response_code(200);
        } else {
            json_encode($_respuestas->error_200("Clave anterior no coincide"));
            http_response_code(400);
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['forgot'])) {
    // Recibir datos del cuerpo de la solicitud
    $postBody = file_get_contents("php://input");
    $datosArray = json_decode($postBody, true);

    // Verificar si se proporcionó un correo electrónico
    if (!isset($datosArray['correo'])) {
        echo json_encode($_respuestas->error_400("El correo electrónico es obligatorio."));

        exit;
    }

    // Recibir el correo electrónico del usuario
    $correo = $datosArray['correo'];

    // Verificar si el correo electrónico está asociado a una cuenta
    $datosUsuario = $_auth->obtenerDatosUsuarios($correo);

    if ($datosUsuario) {
        $response = $_respuestas->response;
        $response["message"] = "Correo encontrado";
        echo json_encode($response);
        http_response_code(200);
        // Generar un token único
        //     $token = $_auth->insertaToken($datosUsuario[0]['id_usuario']);

        //     // Enviar correo electrónico con el enlace de restablecimiento
        //     $subject = "Restablecer contraseña";
        //     $message = "Hola,\n\nPara restablecer tu contraseña, haz clic en el siguiente enlace: http://localhost/preseleccion/sistemaapi/apirest/restablecer?token=$token";
        //     $headers = "From: tuemail@tudominio.com";
        //     mail($correo, $subject, $message, $headers);

        //     // Respuesta exitosa
        //     $response = $_respuestas->response;
        //     $response["message"] = "Se ha enviado un correo electrónico con instrucciones para restablecer tu contraseña.";
        //     echo json_encode($response);
        //     http_response_code(200);
        // } else {
        //     // Correo electrónico no encontrado
        //     echo json_encode($_respuestas->error_400("El correo electrónico proporcionado no está asociado a ninguna cuenta."));
        //     http_response_code(400);
    } else {
        // Correo electrónico no encontrado
        echo json_encode($_respuestas->error_400("El correo electrónico proporcionado no está asociado a ninguna cuenta."));
        http_response_code(400);
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //recibir datos
    $postBody = file_get_contents("php://input");

    //enviamos los datos al manejador
    $datosArray = $_auth->login($postBody);

    //devolver una respuesta
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
    $datosArray = $_auth->put($postBody);
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

// if ($_SERVER['REQUEST_METHOD'] == "GET") {
//     if (isset($_GET["token"])) {
//         $token = $_GET["token"];
//         $estatus = $_auth->obtenerEstatus($token);
//         header("Content-Type: application/json");
//         echo json_encode($estatus);
//         http_response_code(200);
//     }
// } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {


//     //recibir datos
//     $postBody = file_get_contents("php://input");

//     //enviamos los datos al manejador
//     $datosArray = $_auth->login($postBody);

//     //devolver una respuesta
//     header('Content-Type: application/json');
//     if (isset($datosArray["result"]["error_id"])) {
//         $responseCode = $datosArray["result"]["error_id"];
//         http_response_code($responseCode);
//     } else {
//         http_response_code(200);
//     }
//     echo json_encode($datosArray);
// } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['forgot'])) {

//     // Recibir el correo electrónico del usuario
//     $datosArray = json_decode($postBody, true);
//     $correo = $datosArray['correo'];

//     // Verificar si el correo electrónico está asociado a una cuenta
//     $datosUsuario = $_auth->obtenerDatosUsuarios($correo);


//     if ($datosUsuario) {
//         // Generar un token único
//         $token = $_auth->insertaToken($datosUsuario[0]['id_usuario']);

//         // Enviar correo electrónico con el enlace de restablecimiento
//         $subject = "Restablecer contraseña";
//         $message = "Hola,\n\nPara restablecer tu contraseña, haz clic en el siguiente enlace: http://tudominio.com/restablecer?token=$token";
//         $headers = "From: tuemail@tudominio.com";
//         mail($correo, $subject, $message, $headers);

//         // Respuesta exitosa
//         $response = $_respuestas->response;
//         $response["message"] = "Se ha enviado un correo electrónico con instrucciones para restablecer tu contraseña.";
//         echo json_encode($response);
//         http_response_code(200);
//     } else {
//         // Correo electrónico no encontrado
//         echo json_encode($_respuestas->error_400("El correo electrónico proporcionado no está asociado a ninguna cuenta."));
//         http_response_code(400);
//     }
// } else {
//     header('Content-Type: application/json');
//     $datosArray = $_respuestas->error_405();
//     echo json_encode($datosArray);
// }