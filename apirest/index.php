<?php
require_once "clases/conexion/conexion.php";
$conexion = new conexion;



$query =  "select * from participantes";

print_r($conexion->obtenerDatos($query));