<?php
/*require_once "clases/conexion/conexion.php";
require_once "clases/ws_getPremiosPorSorteo.class.php";


$_obtenerPremio= new getPremioSorteo;
//$query  = "SELECT * FROM sorteos_menores";

$sorteo = 1256;
$datos = $_obtenerPremio->obtenerPremiosSorteo($sorteo);

print_r($datos);

//print_r($_conexion->obtenerDatos($query));
//$datos = $_conexion->obtenerDatos($query);

//$print = $datos[1]["no_sorteo_men"];

//print_r($print);*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API - Pani</title>
    <link rel="stylesheet" href="bootstrap/css/estilo.css" type="text/css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-icons.css" type="text/css">

      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
 </head>
<body>
    <div class="container">
        <nav class="navbar bg-body-tertiary">
           <div class="container-fluid">
             <a class="navbar-brand" href="#">
                <img src="pani1.png" alt="Logo" width="160px" class="d-inline-block align-text-top">
                
            </a>
            <h3 style="padding-right: 5rem; padding-left:4rem;">API-PANI consulta de premios Loteria Mayor</h3>
            </div>
        </nav>
        <div class="divbody">
            <p>Obtener los números premiados de la lotería mayor enviando un sorteo como parámetro</p>
            <code>
            GET   /ws_getPremiosPorSorteo?sorteo='numero Sorteo'
            </code>
        </div>

        <div class="divbody">
            <p>Obtener los números premiados de la lotería mayor del último sorteo jugado</p>
            <code>
            GET   /ws_getPremiosPorSorteo
            </code>
        </div>

        

        <div class="divbody">
            <p>Obtener un premio de lotería mayor enviando un sorteo y un número como parámetros </p>
            <code>
            GET  /ws_getPremioPorNumero?sorteo='numero Sorteo'&numero='numero Premiado'
            </code>
        </div>
     
    </div>
    
</body>
</html>