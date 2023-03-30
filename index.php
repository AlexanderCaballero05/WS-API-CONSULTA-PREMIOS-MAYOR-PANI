<?php
require_once "clases/conexion/conexion.php";
require_once "clases/ws_getPremiosSorteo.class.php";
echo "todo bien";

$_obtenerPremio= new getPremioSorteo;
//$query  = "SELECT * FROM sorteos_menores";

$sorteo = 1256;
$datos = $_obtenerPremio->obtenerPremiosSorteo($sorteo);

print_r($datos);

//print_r($_conexion->obtenerDatos($query));
//$datos = $_conexion->obtenerDatos($query);

//$print = $datos[1]["no_sorteo_men"];

//print_r($print);
?>