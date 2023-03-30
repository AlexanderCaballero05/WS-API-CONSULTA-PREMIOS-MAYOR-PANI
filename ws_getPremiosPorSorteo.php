<?php
    require_once "clases/respuestas.class.php";
    require_once "clases/ws_getPremiosPorSorteo.class.php";

    $_respuesta = new respuestas;
    $_obtenerPremios = new getPremioSorteo;

    if($_SERVER['REQUEST_METHOD'] == "GET"){
        if(isset($_GET['sorteo']) && isset($_GET['numero'])){
            $sorteo = $_GET['sorteo'];
            $numero = $_GET['numero'];
    
             
            $jsonBody = $_obtenerPremios->info_premio_mayor($sorteo, $numero);
            header("content-type: application/json");
            echo json_encode($jsonBody);
            http_response_code(200);
        }else if(isset($_GET['sorteo'])){
            $sorteo = $_GET['sorteo'];

            $jsonBody = $_obtenerPremios->getinfosorteo_mayor($sorteo);
            header("content-type: application/json");
            echo json_encode($jsonBody);
            http_response_code(200);
        }else{

            $jsonBody = $_obtenerPremios->getinfoUltimoSorteo_mayor();
            header("content-type: application/json");
            echo json_encode($jsonBody);
            http_response_code(200);
        }
      
    
    }else{
        header('Content-Type: application/json');
        $datosArray = $_respuestas->error_405();
        echo json_encode($jsonBody);
    }


?>