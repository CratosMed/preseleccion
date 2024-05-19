<?php
require_once 'conexion/conexion.php';

class Token extends conexion
{
    public function actualizarToken($fecha)
    {
        // $fecha es la hora actual menos 5 minutos
        $query = "UPDATE usuarios_token 
                  SET estado = 'Inactivo' 
                  WHERE ultima_actividad < '$fecha' AND estado = 'Activo'";

        $verificar = parent::nonQuery($query);
        if ($verificar > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function crearTxt($direccion)
    {
        $archivo = fopen($direccion, 'w') or die("error al crear el archivo de registros");
        $texto = "------------------------------------ Registros del CRON JOB ------------------------------------ \n";
        fwrite($archivo, $texto) or die("no pudimos escribir el registro");
        fclose($archivo);
    }

    function escribirEntrada($registros)
    {
        $direccion = "../cron/registros/registros.txt";
        if (!file_exists($direccion)) {
            $this->crearTxt($direccion);
        }
        $this->escribirTxt($direccion, $registros);
    }

    function escribirTxt($direccion, $registros)
    {
        $date = date("Y-m-d H:i");
        $archivo = fopen($direccion, 'a') or die("error al abrir el archivo de registros");
        $texto = "Se modificaron $registros registro(s) el dia [$date] \n";
        fwrite($archivo, $texto) or die("no pudimos escribir el registro");
        fclose($archivo);
    }
}
