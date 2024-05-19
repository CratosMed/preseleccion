<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';


class auth extends conexion
{
    private $table = "usuarios";
    private $id_usuario = "";
    private $clave = "";
    private $estatus = "";
    private $estado = "";
    private $usuario = "";
    private $nombre = "";
    private $apellido = "";
    private $cedula = "";
    private $correo = "";
    private $imagen = "";
    private $token = "";

    public function login($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos['usuario']) || !isset($datos["clave"])) {
            return $_respuestas->error_400();
        } else {
            $usuario = $datos['usuario'];
            $clave = $datos['clave'];
            $clave = parent::encriptar($clave);
            $datos = $this->obtenerDatosUsuarios($usuario);
            if ($datos) {
                //si existe
                if ($clave == $datos[0]['clave']) {
                    if ($datos[0]['estado'] == "Activo") {
                        //crear el token
                        $verificar = $this->insertaToken($datos[0]['id_usuario']);
                        if ($verificar) {
                            // si se guardo
                            $result = $_respuestas->response;
                            $result["result"] = array(
                                "token" => $verificar
                            );
                            return $result;
                        } else {
                            // error al guardar
                            return $_respuestas->error_500("error interno, no hemos podido guardar ");
                        }
                    } else {
                        return $_respuestas->error_200("el usuario esta inactivo");
                    }
                } else {
                    // la contraseña no es igual
                    return $_respuestas->error_200("la clave no es correcta ");
                }
            } else {
                //no existe
                return $_respuestas->error_200("el usuario $usuario no existe");
            }
        }
    }

    public function obtenerDatosUsuarios($correo)
    {
        $query = "select id_usuario, clave, estado, cedula, estatus, usuario, nombre, apellido, correo, imagen from usuarios where usuario='$correo'";
        $datos = parent::obtenerDatos($query);
        if (isset($datos[0]['id_usuario'])) {
            return $datos;
        } else {
            return 0;
        }
    }
    public function obtenerEstatus($token)
    {
        $query = "SELECT u.estatus,u.estado, u_t.id_usuario, u.cedula  FROM usuarios_token as u_t, usuarios as u WHERE u.id_usuario=u_t.id_usuario AND token='$token'";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }
    public function put($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (!isset($datos['id_usuario'])) {
            return $_respuestas->error_400();
        } else {
            $this->id_usuario = $datos['id_usuario'];
            if (isset($datos['clave'])) {
                $this->clave = parent::encriptar($datos['clave']);
            };
            if (isset($datos['estatus'])) {
                $this->estatus = $datos['estatus'];
            };
            if (isset($datos['estado'])) {
                $this->estado = $datos['estado'];
            };
            if (isset($datos['usuario'])) {
                $this->usuario = $datos['usuario'];
            };
            if (isset($datos['nombre'])) {
                $this->nombre = $datos['nombre'];
            };
            if (isset($datos['apellido'])) {
                $this->apellido = $datos['apellido'];
            };
            if (isset($datos['cedula'])) {
                $this->cedula = $datos['cedula'];
            }
            if (isset($datos['correo'])) {
                $this->correo = $datos['correo'];
            }
            if (isset($datos['imagen'])) {
                $this->imagen = $datos['imagen'];
            }

            $resp = $this->modificarPass();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_usuario" => $this->id_usuario
                );
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function modificarPass()
    {
        $query = "UPDATE " . $this->table . " SET clave ='" . $this->clave . "',estatus ='" . $this->estatus . "',estado ='" . $this->estado .
            "',usuario ='" . $this->usuario . "',nombre ='" . $this->nombre . "',apellido ='" . $this->apellido .
            "',cedula ='" . $this->cedula . "',correo ='" . $this->correo . "',imagen ='" . $this->imagen .
            "'WHERE id_usuario = '" . $this->id_usuario . "'";

        $resp = parent::nonQuery($query);
        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }

    public function insertaToken($id_usuario)
    {
        $val = true;
        $token = bin2hex(openssl_random_pseudo_bytes(16, $val));
        $date = date("Y-m-d H:i:s");
        $estado = "Activo";
        $query = "insert into usuarios_token(id_usuario, token, estado, fecha)values('$id_usuario', '$token', '$estado', '$date')";
        $verifica = parent::nonQuery($query);

        if ($verifica) {
            return $token;
        } else {
            return 0;
        }
    }
}
