<?php
require_once 'clases/auth.class.php';
require_once 'clases/respuestas.class.php';

$_auth = new auth;
$_respuestas = new respuestas;

// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si se recibió un token y una nueva contraseña
    if (isset($_POST['token']) && isset($_POST['nueva_contrasena'])) {
        $token = $_POST['token'];
        $nueva_contrasena = $_POST['nueva_contrasena'];

        // Verificar si el token es válido
        $datosToken = $_auth->verificarToken($token);

        if ($datosToken) {
            // Token válido, restablecer la contraseña
            $id_usuario = $datosToken['id_usuario'];
            $resultado = $_auth->restablecerContrasena($id_usuario, $nueva_contrasena);

            if ($resultado) {
                // Contraseña restablecida con éxito
                echo "Contraseña restablecida con éxito.";
            } else {
                // Error al restablecer la contraseña
                echo "Error al restablecer la contraseña. Por favor, inténtalo de nuevo.";
            }
        } else {
            // Token inválido
            echo "El token proporcionado no es válido.";
        }
    } else {
        // Datos incompletos en la solicitud
        echo "Datos incompletos en la solicitud.";
    }
} else {
    // Método de solicitud incorrecto
    echo "Solicitud no válida.";
}
