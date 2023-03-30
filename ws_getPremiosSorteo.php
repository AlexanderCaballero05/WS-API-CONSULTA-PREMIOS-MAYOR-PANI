<?php
    require_once "clases/respuestas.class.php";
    require_once "clases/ws_getPremiosSorteo.class.php";

    $_respuesta = new respuestas;
    $_obtenerPremios = new getPremioSorteo;

    if($_SERVER['REQUEST_METHOD'] == "GET"){
        $sorteo = $_GET['sorteo'];
         
        $jsonBody = $_obtenerPremios->getinfosorteo_mayor($sorteo);
        header("content-type: application/json");
        echo json_encode($jsonBody);
        http_response_code(200);
    
    }else{
        header('Content-Type: application/json');
        $datosArray = $_respuestas->error_405();
        echo json_encode($jsonBody);
    }


?>