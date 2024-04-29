 <?php
    require_once 'clases/respuestas.class.php';
    require_once 'clases/periodos_academicos.class.php';

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
                header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin, Authorization, X-Requested-With, Content-Type, Accept, id_periodo, token");

            exit(0);
        }
    }
    cors();

    $_respuestas = new respuestas;
    $_periodos_academicos = new periodos_academicos;

    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        if (isset($_GET["page"])) {
            $pagina = $_GET["page"];
            $listaperiodos_academicos = $_periodos_academicos->listaperiodos_academicos($pagina);
            header("Content-Type: application/json");
            echo json_encode($listaperiodos_academicos);
            http_response_code(200);
        } elseif (isset($_GET["id"])) {
            $id_periodo = $_GET["id"];
            $datosperiodo = $_periodos_academicos->obtenerPeriodo($id_periodo);
            header("Content-Type: application/json");
            echo json_encode($datosperiodo);
            http_response_code(200);
        }
    } else if ($_SERVER['REQUEST_METHOD'] == "POST") {
        //recibimos los datos enviados
        $postBody = file_get_contents("php://input");
        //enviamos los datos al manejador
        $datosArray = $_periodos_academicos->post($postBody);
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
        $datosArray = $_periodos_academicos->put($postBody);
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

        if (isset($headers["token"]) && isset($headers["id_periodo"])) {
            //recibimos los datos por el header
            $send = [
                "token" => $headers["token"],
                "id_periodo" => $headers["id_periodo"]
            ];
            $postBody = json_encode($send);
        } else {
            //recibimos los datos enviados
            $postBody = file_get_contents("php://input");
        }

        //enviamos los datos al manejador
        $datosArray = $_periodos_academicos->delete($postBody);
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




    ?>