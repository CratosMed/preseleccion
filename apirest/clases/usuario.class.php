<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";



class usuario extends conexion
{

    private $table = "usuarios";
    private $id_usuario = "";
    private $nombre = "";
    private $apellido = "";
    private $cedula = "";
    private $estado = "";
    private $estatus = "";
    private $token = "";
    private $usuario = "";
    private $clave = "";
    private $imagen = "";

    public function listaUsuario($pagina = 1)
    {
        $inicio = 0;
        $cantidad = 50;
        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }
        $query = "SELECT id_usuario, cedula, nombre, apellido, usuario, estado, estatus FROM " . $this->table . " limit $inicio,  $cantidad ";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    public function obtenerUsuario($id)
    {
        $query = "select * from " . $this->table . " where id_usuario='$id'";
        return parent::obtenerDatos($query);
    }

    public function post($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos['token'])) {
            return $_respuestas->error_401();
        } else {
        }
        if (!isset($datos['nombre']) || !isset($datos['cedula']) || !isset($datos['usuario'])) {
            return $_respuestas->error_400();
        } else {
            $this->cedula = $datos['cedula'];
            $this->nombre = $datos['nombre'];
            $this->usuario = $datos['usuario'];
            if (isset($datos['apellido'])) {
                $this->apellido = $datos['apellido'];
            };
            if (isset($datos['estado'])) {
                $this->estado = $datos['estado'];
            };
            if (isset($datos['estatus'])) {
                $this->estatus = $datos['estatus'];
            };
            if (isset($datos['clave'])) {
                $this->clave = $datos['clave'];
                $this->clave = parent::encriptar($this->clave);
            };

            $resp = $this->insertarUsuario();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_usuario" => $resp
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function procesarImagen($img)
    {
        $direccion = dirname(__DIR__) . "\public\imagenes\\";
        $partes = explode(";base64,", $img);
        $extencion = explode('/', mime_content_type($img))[1];
        $imagen_base64 = base64_encode($partes[1]);
        $file = $direccion . uniqid() . "." . $extencion;
        file_put_contents($file, $imagen_base64);
        $nuevadireccion = str_replace('\\', '/', $file);

        return $nuevadireccion;
    }

    private function insertarUsuario()
    {
        $query = "insert into " . $this->table . " (cedula,nombre,apellido,usuario,estatus,estado,clave,imagen) 
        values
        ('" . $this->cedula . "','" . $this->nombre . "','" . $this->apellido . "','" . $this->usuario . "','" . $this->estatus . "','" . $this->estado .  "','" . $this->clave . "','" . $this->imagen . "')";

        $resp = parent::nonQueryId($query);

        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }


    public function put($json)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        if (!isset($datos['id_usuario'])) {
            return $_respuestas->error_400();
        } else {
            $this->id_usuario = $datos['id_usuario'];
            if (isset($datos['cedula'])) {
                $this->cedula = $datos['cedula'];
            };
            if (isset($datos['nombre'])) {
                $this->nombre = $datos['nombre'];
            };
            if (isset($datos['apellido'])) {
                $this->apellido = $datos['apellido'];
            };

            if (isset($datos['usuario'])) {
                $this->usuario = $datos['usuario'];
            };
            if (isset($datos['estatus'])) {
                $this->estatus = $datos['estatus'];
            };
            if (isset($datos['estado'])) {
                $this->estado = $datos['estado'];
            }

            $resp = $this->modificarUsuario();
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

    private function modificarUsuario()
    {
        $query = "UPDATE " . $this->table . " SET cedula ='" . $this->cedula . "',nombre ='" . $this->nombre . "',apellido ='" . $this->apellido .  "',usuario ='" . $this->usuario . "',estatus ='" . $this->estatus . "',estado ='" . $this->estado .
            "'WHERE id_usuario = '" . $this->id_usuario . "'";

        $resp = parent::nonQuery($query);
        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }

    public function delete($json)
    {

        $_respuestas = new respuestas;
        $datos = json_decode($json, true);

        if (!isset($datos['token'])) {
            return $_respuestas->error_401();
        } else {
            $this->token = $datos['token'];
            $arrayToken = $this->buscarToken();
            if ($arrayToken) {
                if (!isset($datos['id_usuario'])) {
                    return $_respuestas->error_400();
                } else {
                    $this->id_usuario = $datos['id_usuario'];
                    $resp = $this->eliminarUsuario();
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
            } else {
                return $_respuestas->error_401("El token que envio es invalido o ha caducado");
            }
        }
    }

    private function eliminarUsuario()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id_usuario = '" . $this->id_usuario . "'";
        $resp = parent::nonQuery($query);
        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }

    private function buscarToken()
    {
        $query = "select u_t.token_id, u_t.id_usuario, u.estatus, u_t.estado from usuarios_token as u_t, usuarios as u where token = '" . $this->token . "' and estado='Activo'";
        $resp = parent::obtenerDatos($query);
        if ($resp) {
            return $resp;
        } else {
            return 0;
        }
    }


    private function actualizarToken($tokenid)
    {
        $date = date("Y-m-d H:i");
        $query = "UPDATE usuarios_token SET Fecha = '$date' WHERE TokenId = '$tokenid' ";
        $resp = parent::nonQuery($query);
        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }
}
