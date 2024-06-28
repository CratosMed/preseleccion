<?php
require_once "conexion/conexion.php";
require_once "respuestas.class.php";



class preseleccion extends conexion
{

    private $table = "preselecciones";

    private $id_preseleccion = "";
    private $participante_id = "";
    private $fecha = "";
    private $seccion = "";
    private $turno = "";
    private $curso = "";
    private $curso_dos = "";
    private $curso_tres = "";
    private $curso_cuatro = "";
    private $curso_cinco = "";
    private $curso_seis = "";
    private $t_u_c = "";
    private $plataforma = "";
    private $estatus_participante = "";
    private $token = "";


    public function listaPreseleccion($pagina = 1)
    {
        $inicio = 0;
        $cantidad = 50;
        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }
        $query = "SELECT * FROM " . $this->table  . " limit $inicio,  $cantidad ";

        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    // public function graficosPreseleccion($grap = 1)
    // {

    //     // $query = "SELECT c.nombre, c.codigo, COUNT(p.curso)as curso from preselecciones as p, cursos as c WHERE c.nombre = p.curso GROUP by p.curso HAVING COUNT(p.curso)>=1";
    //     $query = "SELECT c.codigo, c.nombre, COUNT(*) as cantidad
    //     FROM (
    //         SELECT curso FROM preselecciones WHERE curso IS NOT NULL AND curso != ''
    //         UNION ALL
    //         SELECT curso_dos FROM preselecciones WHERE curso_dos IS NOT NULL AND curso_dos != ''
    //         UNION ALL
    //         SELECT curso_tres FROM preselecciones WHERE curso_tres IS NOT NULL AND curso_tres != ''
    //         UNION ALL
    //         SELECT curso_cuatro FROM preselecciones WHERE curso_cuatro IS NOT NULL AND curso_cuatro != ''
    //         UNION ALL
    //         SELECT curso_cinco FROM preselecciones WHERE curso_cinco IS NOT NULL AND curso_cinco != ''
    //         UNION ALL
    //         SELECT curso_seis FROM preselecciones WHERE curso_seis IS NOT NULL AND curso_seis != ''
    //     ) as cursos_totales
    //     JOIN cursos c ON cursos_totales.curso = c.nombre
    //     WHERE c.nombre IS NOT NULL AND c.nombre != ''
    //     GROUP BY c.codigo, c.nombre";
    //     $datos = parent::obtenerDatos($query);
    //     return $datos;
    // }
    public function graficosPreseleccion($grap = 1)
    {
        $fechaInicio = '2023-06-09';
        $fechaFin = date('Y-m-d');  // Obtener la fecha actual

        $query = "SELECT c.codigo, c.nombre, COUNT(*) as cantidad
        FROM (
            SELECT curso FROM preselecciones WHERE curso IS NOT NULL AND curso != '' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'
            UNION ALL
            SELECT curso_dos FROM preselecciones WHERE curso_dos IS NOT NULL AND curso_dos != '' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'
            UNION ALL
            SELECT curso_tres FROM preselecciones WHERE curso_tres IS NOT NULL AND curso_tres != '' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'
            UNION ALL
            SELECT curso_cuatro FROM preselecciones WHERE curso_cuatro IS NOT NULL AND curso_cuatro != '' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'
            UNION ALL
            SELECT curso_cinco FROM preselecciones WHERE curso_cinco IS NOT NULL AND curso_cinco != '' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'
            UNION ALL
            SELECT curso_seis FROM preselecciones WHERE curso_seis IS NOT NULL AND curso_seis != '' AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'
        ) as cursos_totales
        JOIN cursos c ON cursos_totales.curso = c.nombre
        WHERE c.nombre IS NOT NULL AND c.nombre != ''
        GROUP BY c.codigo, c.nombre";

        $datos = parent::obtenerDatos($query);
        return $datos;
    }


    // public function preseleccionesview($preselecciones = 1)
    // {

    //     $query = "SELECT p.nombre, p.cedula, pre.curso, pre.curso_dos,pre.curso_tres,pre.curso_cuatro, pre.curso_cinco, pre.curso_seis, pre.t_u_c, pre.estatus_participante,
    //      pre.plataforma, pre.turno FROM preselecciones as pre INNER JOIN participantes p ON pre.participante_id = p.id_participante";
    //     $datos = parent::obtenerDatos($query);
    //     return $datos;
    // }
    public function preseleccionesview($preselecciones = 1, $fechaInicio, $fechaFin)
    {

        if ($fechaFin === null) {
            $fechaFin = date('Y-m-d');
        }

        $query = "SELECT pre.id_preseleccion, pre.fecha, p.nombre, p.apellido, p.cedula, pre.curso, pre.curso_dos, pre.curso_tres, pre.curso_cuatro, pre.curso_cinco, pre.curso_seis, pre.t_u_c, pre.estatus_participante,
        pre.plataforma, pre.turno FROM preselecciones as pre INNER JOIN participantes p ON pre.participante_id = p.id_participante
        WHERE pre.fecha BETWEEN '$fechaInicio' AND '$fechaFin'";

        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    public function obtenerPreseleccion($id)
    {
        $query = "select * from " . $this->table . " where id_preseleccion='$id'";
        return parent::obtenerDatos($query);
    }
    public function obtenerPreseleccionId($id_participante)
    {
        $query = "select * from " . $this->table . " where participante_id='$id_participante'";
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
        if (!isset($datos['participante_id'])) {
            return $_respuestas->error_400();
        } else {
            $this->participante_id = $datos['participante_id'];
            $this->fecha = date('Y-m-d');
            $this->seccion = $datos['seccion'];
            $this->turno = $datos['turno'];
            $this->curso = $datos['curso'];
            $this->curso_dos = $datos['curso_dos'];
            $this->curso_tres = $datos['curso_tres'];
            $this->curso_cuatro = $datos['curso_cuatro'];
            $this->curso_cinco = $datos['curso_cinco'];
            $this->curso_seis = $datos['curso_seis'];
            $this->t_u_c = $datos['t_u_c'];
            $this->plataforma = $datos['plataforma'];
            $this->estatus_participante = $datos['estatus_participante'];
            $resp = $this->insertarPreseleccion();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_preseleccion" => $resp
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function insertarPreseleccion()
    {
        $query = "insert into " . $this->table . " (participante_id, curso, curso_dos, curso_tres, curso_cuatro, curso_cinco, curso_seis, t_u_c, fecha, seccion, turno, plataforma, estatus_participante  ) 
        values
        ('" . $this->participante_id . "','" . $this->curso . "','" . $this->curso_dos . "','" . $this->curso_tres . "','" . $this->curso_cuatro . "','" .
            $this->curso_cinco . "','" . $this->curso_seis . "','" . $this->t_u_c . "','" . $this->fecha . "','" . $this->seccion . "','" .
            $this->turno . "','" . $this->plataforma . "','" . $this->estatus_participante .  "')";
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
        if (!isset($datos['id_preseleccion'])) {
            return $_respuestas->error_400();
        } else {
            $this->id_preseleccion = $datos['id_preseleccion'];
            if (isset($datos['participante_id'])) {
                $this->participante_id = $datos['participante_id'];
            };
            if (isset($datos['fecha'])) {
                $this->fecha = $datos['fecha'];
            };
            if (isset($datos['seccion'])) {
                $this->seccion = $datos['seccion'];
            };
            if (isset($datos['turno'])) {
                $this->turno = $datos['turno'];
            };
            if (isset($datos['curso'])) {
                $this->curso = $datos['curso'];
            };
            if (isset($datos['plataforma'])) {
                $this->plataforma = $datos['plataforma'];
            };
            if (isset($datos['estatus_participante'])) {
                $this->estatus_participante = $datos['estatus_participante'];
            };

            $resp = $this->modificarPreseleccion();
            if ($resp) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_preselecciones" => $this->id_preseleccion
                );

                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }

    private function modificarPreseleccion()
    {
        $query = "UPDATE " . $this->table . " SET participante_id ='" . $this->participante_id . "',fecha ='" . $this->fecha .
            "',seccion='" . $this->seccion . "', turno ='"  . $this->turno . "', plataforma ='"  . $this->plataforma . "', estatus_participante ='"  . $this->estatus_participante . "', curso ='"  . $this->curso .
            "'WHERE id_preselecciones = '" . $this->id_preseleccion . "'";

        $resp = parent::nonQuery($query);
        if ($resp >= 1) {
            return $resp;
        } else {
            return 0;
        }
    }

    private function eliminarPreseleccion()
    {
        $id_preseleccion = "";
        $query = "DELETE FROM " . $this->table . " WHERE id_preseleccion = '" . $this->$id_preseleccion . "'";
        $resp = parent::nonQuery($query);

        if ($resp >= 1) {
            return $resp;  // Se eliminó correctamente
        } else {
            return 0;  // No se pudo eliminar o no se encontró la fila
        }
    }
    public function delete($json)
    {

        $_respuestas = new respuestas;
        $datos = json_decode($json, true);
        $id = "";

        if (!isset($datos['token'])) {
            return $_respuestas->error_401();
        } else {
            $this->token = $datos['token'];
            $arrayToken = $this->buscarToken();

            if ($arrayToken) {
                if (!isset($datos['id_preseleccion'])) {
                    return $_respuestas->error_400();
                } else {
                    $this->$id = $datos['id_preseleccion'];
                    $resp = $this->eliminarPreseleccion($id);
                    if ($resp) {
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "id_preseleccion" => $this->id_preseleccion
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
    public function obtenerlParticipantesPorCarrera()
    {
        $query = "SELECT carrera, COUNT(*) as total_participantes
                  FROM participantes
                  GROUP BY carrera";

        $datos = parent::obtenerDatos($query);
        return $datos;
    }
    // private function eliminarParticipante()
    // {
    //     $query = "DELETE FROM " . $this->table . " WHERE id_preseleccion = '" . $this->id_preseleccion . "'";
    //     $resp = parent::nonQuery($query);
    //     if ($resp >= 1) {
    //         return $resp;
    //     } else {
    //         return 0;
    //     }
    // }

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


    // private function actualizarToken($tokenid)
    // {
    //     $date = date("Y-m-d H:i");
    //     $query = "UPDATE usuarios_token SET Fecha = '$date' WHERE TokenId = '$tokenid' ";
    //     $resp = parent::nonQuery($query);
    //     if ($resp >= 1) {
    //         return $resp;
    //     } else {
    //         return 0;
    //     }
    //}
}
