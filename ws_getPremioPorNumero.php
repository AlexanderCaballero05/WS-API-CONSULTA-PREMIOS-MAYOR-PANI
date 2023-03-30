<?php
    require_once "clases/respuestas.class.php";
    require_once "clases/ws_getPremioPorNumero.class.php";

    $_respuesta = new respuestas;
    $_obtenerPremios = new getPremioPorNumero;

    if($_SERVER['REQUEST_METHOD'] == "GET"){
        $sorteo = $_GET['sorteo'];
        $numero = $_GET['numero'];

         
        $jsonBody = $_obtenerPremios->info_premio_mayor($sorteo, $numero);
        header("content-type: application/json");
        echo json_encode($jsonBody);
        http_response_code(200);
    
    }else{
        header('Content-Type: application/json');
        $datosArray = $_respuestas->error_405();
        echo json_encode($jsonBody);
    }


?>