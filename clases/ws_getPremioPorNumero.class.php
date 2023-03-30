<?php
require_once "respuestas.class.php"; 
require_once "conexion/conexion.php";

class getPremioPorNumero extends conexion{

    function info_premio_mayor($sorteo, $numero){
        require ('./conexion.php');		
								//$query_audit = mysqli_query($conn_local, "INSERT INTO audit_app (action_description) values ('CONSULTA DE PREMIO MAYOR SORTEO NO. ".$sorteo." , NUMERO ".$numero."')");		
								
								$query_premio   =  mysqli_query($conn, "SELECT total, decimo, estado_especies, tipo_pago  FROM archivo_pagos_mayor WHERE sorteo=$sorteo and numero=$numero");
								
								if (mysqli_num_rows($query_premio)>0) 
								{
									while ($row_premios= mysqli_fetch_assoc($query_premio)) 
									{
								   			$status=1;
								  			$valor_premio      = $row_premios['total'];	
								  			$decimo   		   = $row_premios['decimo'];	
								  			$estado_especies   = $row_premios['estado_especies'];	
								  			$tipo_pago         = $row_premios['tipo_pago'];		
								  			
								  			if ($tipo_pago=='E') 
								  			{
								  			  	$query_especies= mysqli_query($conn, "SELECT desc_premio FROM sorteos_mayores_premios where sorteos_mayores_id=$sorteo and numero_premiado_mayor=$numero;");
								  			  	while ($row_especie= mysqli_fetch_assoc($query_especies)) 
												{
													$valor_premio= $row_especie['desc_premio'];
													$message='Decimo Premiado '.$decimo;
												}


								  			 }
								  			 else
								  			 {		  			 		
													$message='L. '.(number_format(($valor_premio/10),2)).' por decimo';
													$valor_premio=number_format($valor_premio,2);
								  			 }  			
									}
								}
								else
								{
									$status			=	0;
								  	$valor_premio	=	0;
								  	$message		=	"No tiene premio";
								}
								
								 $array_premios= array(	
								 						'status'		 => $status,
								 						'valor_premio'	 => $valor_premio,
								 						'mensaje'	 	 => $message
								 				 	  );

								 return $array_premios;

    }


}