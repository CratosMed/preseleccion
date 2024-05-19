<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";



class periodos_academicos extends conexion
{

    private $table = "periodos_academicos";
    private $id_periodo = "";
    private $nombre = "";
    private $fechaInicio = "";
    private $fechaFin = "";
    private $token = "";

    public function listaperiodos_academicos($pagina = 1)
    {
        $inicio = 0;
        $cantidad = 50;
        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }
        $query = "SELECT id_periodo, nombre, fechaInicio, fechaFin FROM " . $this->table . " limit $inicio,  $cantidad ";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    public function obtenerPeriodo($id)
    {
        $query = "select * from " . $this->table . " where id_periodo='$id'";
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
        if (!isset($datos['nombre']) || !isset($datos['fechaInicio'])) {
            return $_respuestas->error_400();
        } else {
            $this->nombre = $datos['nombre'];
            $this->fechaInicio = $datos['fechaInicio'];
            if (isset($datos['fechaFin'])) {
                $this->fechaFin = $datos['fechaFin'];
            };
            $resp = $this->insertarPeriodo();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_periodo" => $resp
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function insertarPeriodo()
    {
        $query = "insert into " . $this->table . " (nombre,fechaInicio,fechaFin) 
        values
        ('" . $this->nombre . "','" . $this->fechaInicio . "','" . $this->fechaFin . "')";

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
        if (!isset($datos['id_periodo'])) {
            return $_respuestas->error_400();
        } else {
            $this->id_periodo = $datos['id_periodo'];
            if (isset($datos['nombre'])) {
                $this->nombre = $datos['nombre'];
            };
            if (isset($datos['fechaInicio'])) {
                $this->fechaInicio = $datos['fechaInicio'];
            };
            if (isset($datos['fechaFin'])) {
                $this->fechaFin = $datos['fechaFin'];
            };

            $resp = $this->modificarPeriodo();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_periodo" => $this->id_periodo
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function modificarPeriodo()
    {
        $query = "UPDATE " . $this->table . " SET nombre ='" . $this->nombre . "',fechaInicio ='" . $this->fechaInicio  . "',fechaFin ='" . $this->fechaFin .
            "'WHERE id_periodo = '" . $this->id_periodo . "'";

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
                if (!isset($datos['id_periodo'])) {
                    return $_respuestas->error_400();
                } else {
                    $this->id_periodo = $datos['id_periodo'];
                    $resp = $this->eliminarPeriodo();
                    if ($resp) {
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "id_periodo" => $this->id_periodo
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

    private function eliminarPeriodo()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id_periodo = '" . $this->id_periodo . "'";
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
