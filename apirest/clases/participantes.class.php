<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";



class participantes extends conexion
{

    private $table = "participantes";
    private $id_participante = "";
    private $cedula = "";
    private $nombre = "";
    private $apellido = "";
    private $fecha_nacimiento = "";
    private $telefono = "";
    private $direccion = "";
    private $carrera = "";
    private $u_c_acumuladas = "";
    private $sexo = "";
    private $correo = "";
    private $token = "";
    private $imagen = "";

    public function listaParticipantes($pagina = 1)
    {
        $inicio = 0;
        $cantidad = 50;
        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }
        $query = "SELECT id_participante, cedula, nombre, apellido,fecha_nacimiento, telefono, direccion, carrera, u_c_acumuladas, sexo, correo FROM " . $this->table . " limit $inicio,  $cantidad ";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    public function obtenerParticipante($id)
    {
        $query = "select * from " . $this->table . " where id_participante='$id'";
        return parent::obtenerDatos($query);
    }
    public function obtenerParticipanteCedula($cedula)
    {
        $query = "select * from " . $this->table . " where cedula='$cedula'";
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
        if (!isset($datos['nombre']) || !isset($datos['cedula']) || !isset($datos['correo'])) {
            return $_respuestas->error_400();
        } else {
            $this->cedula = $datos['cedula'];
            $this->nombre = $datos['nombre'];
            $this->correo = $datos['correo'];
            if (isset($datos['apellido'])) {
                $this->apellido = $datos['apellido'];
            };
            if (isset($datos['carrera'])) {
                $this->carrera = $datos['carrera'];
            };
            if (isset($datos['u_c_acumuladas'])) {
                $this->u_c_acumuladas = $datos['u_c_acumuladas'];
            };
            if (isset($datos['fecha_nacimiento'])) {
                $this->fecha_nacimiento = $datos['fecha_nacimiento'];
            };
            if (isset($datos['telefono'])) {
                $this->telefono = $datos['telefono'];
            };
            if (isset($datos['direccion'])) {
                $this->direccion = $datos['direccion'];
            };
            if (isset($datos['sexo'])) {
                $this->sexo = $datos['sexo'];
            }
            if (isset($datos['imagen'])) {
                $resp = $this->procesarImagen($datos['imagen']);
                $this->imagen = $resp;
            }
            $resp = $this->insertarParticipante();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_participante" => $resp
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

    private function insertarParticipante()
    {
        $query = "insert into " . $this->table . " (cedula,nombre,apellido,fecha_nacimiento,telefono,direccion,sexo,correo,carrera,u_c_acumuladas,imagen) 
        values
        ('" . $this->cedula . "','" . $this->nombre . "','" . $this->apellido . "','" . $this->fecha_nacimiento . "','" . $this->telefono . "','" . $this->direccion  . "','" . $this->sexo . "','" . $this->correo . "','" . $this->carrera . "','" . $this->u_c_acumuladas . "','" . $this->imagen . "')";

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
        if (!isset($datos['id_participante'])) {
            return $_respuestas->error_400();
        } else {
            $this->id_participante = $datos['id_participante'];
            if (isset($datos['cedula'])) {
                $this->cedula = $datos['cedula'];
            };
            if (isset($datos['nombre'])) {
                $this->nombre = $datos['nombre'];
            };
            if (isset($datos['apellido'])) {
                $this->apellido = $datos['apellido'];
            };
            if (isset($datos['fecha_nacimiento'])) {
                $this->fecha_nacimiento = $datos['fecha_nacimiento'];
            };
            if (isset($datos['telefono'])) {
                $this->telefono = $datos['telefono'];
            };
            if (isset($datos['direccion'])) {
                $this->direccion = $datos['direccion'];
            };
            if (isset($datos['sexo'])) {
                $this->sexo = $datos['sexo'];
            }
            if (isset($datos['correo'])) {
                $this->correo = $datos['correo'];
            }
            if (isset($datos['u_c_acumuladas'])) {
                $this->u_c_acumuladas = $datos['u_c_acumuladas'];
            }



            $resp = $this->modificarParticipante();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_participante" => $this->id_participante
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function modificarParticipante()
    {
        $query = "UPDATE " . $this->table . " SET cedula ='" . $this->cedula . "',nombre ='" . $this->nombre . "',apellido ='" . $this->apellido . "',fecha_nacimiento ='" . $this->fecha_nacimiento . "',telefono ='" . $this->telefono . "',direccion ='" . $this->direccion . "',sexo ='" . $this->sexo . "',correo ='" . $this->correo . "',u_c_acumuladas ='" . $this->u_c_acumuladas .
            "'WHERE id_participante = '" . $this->id_participante . "'";

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
                if (!isset($datos['id_participante'])) {
                    return $_respuestas->error_400();
                } else {
                    $this->id_participante = $datos['id_participante'];
                    $resp = $this->eliminarParticipante();
                    if ($resp) {
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "id_participante" => $this->id_participante
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

    private function eliminarParticipante()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id_participante = '" . $this->id_participante . "'";
        $resp = parent::nonQuery($query);
        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }

    private function buscarToken()
    {
        $query = "select token_id,id_usuario,estado from usuarios_token where token = '" . $this->token . "' and estado='Activo'";
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
