<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";



class cursos extends conexion
{

    private $table = "cursos";
    private $id_curso = "";
    private $codigo = "";
    private $nombre = "";
    private $u_c = "";
    private $token = "";

    public function listacursos($pagina = 1)
    {
        $inicio = 0;
        $cantidad = 50;
        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }
        $query = "SELECT id_curso, codigo, nombre, u_c FROM " . $this->table . " limit $inicio,  $cantidad ";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    public function obtenerCurso($id)
    {
        $query = "select * from " . $this->table . " where id_curso='$id'";
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
        if (!isset($datos['nombre']) || !isset($datos['u_c']) || !isset($datos['codigo'])) {
            return $_respuestas->error_400();
        } else {
            $this->codigo = $datos['codigo'];
            $this->nombre = $datos['nombre'];
            $this->u_c = $datos['u_c'];

            $resp = $this->insertarCurso();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_curso" => $resp
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function insertarCurso()
    {
        $query = "insert into " . $this->table . " (codigo,nombre,u_c) 
        values
        ('" . $this->codigo . "','" . $this->nombre . "','" . $this->u_c . "')";

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
        if (!isset($datos['id_curso'])) {
            return $_respuestas->error_400();
        } else {
            $this->codigo = $datos['id_curso'];
            if (isset($datos['codigo'])) {
                $this->codigo = $datos['codigo'];
            };
            if (isset($datos['nombre'])) {
                $this->nombre = $datos['nombre'];
            };
            if (isset($datos['u_c'])) {
                $this->u_c = $datos['u_c'];
            };

            $resp = $this->modificarCurso();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_curso" => $this->id_curso
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function modificarCurso()
    {
        $query = "UPDATE " . $this->table . " SET nombre ='" . $this->nombre . "',codigo ='" . $this->codigo  . "',u_c ='" . $this->u_c  .
            "'WHERE id_curso = '" . $this->id_curso . "'";

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
                if (!isset($datos['id_curso'])) {
                    return $_respuestas->error_400();
                } else {
                    $this->id_curso = $datos['id_curso'];
                    $resp = $this->eliminarCurso();
                    if ($resp) {
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "id_curso" => $this->id_curso
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

    private function eliminarCurso()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id_curso = '" . $this->id_curso . "'";
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
