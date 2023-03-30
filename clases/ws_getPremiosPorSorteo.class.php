<?php
require_once "respuestas.class.php"; 
require_once "conexion/conexion.php";


class getPremioSorteo extends conexion{

  /*  function obtenerPremiosSorteo($sorteo){
        $query = "SELECT desc_premio, monto, numero_premiado_mayor FROM sorteos_mayores_premios where sorteos_mayores_id = $sorteo; ";
        $datos =parent::obtenerDatos($query);
        return $datos;
    }*/

//obtener informacion de los sorteos mayores del PANI, enviando como parametro un sorteo

    function getinfosorteo_mayor($sorteo){
			$_conexion = new conexion;
			$conn = $_conexion->__construct();
			if($sorteo==0)
			{
				 //obtengo el ID del ultimo sorteo capturado          
				 $query_ultimo_sorteo = mysqli_query($conn, "SELECT sorteos_mayores_id FROM sorteos_mayores_premios WHERE numero_premiado_mayor is not null order by sorteos_mayores_id desc limit 1;"); 
				 // $query_ultimo_sorteo = parent::obtenerDatos($query);
				  $obj_ultimo_sorteo=mysqli_fetch_object($query_ultimo_sorteo);
				  $sorteo=$obj_ultimo_sorteo->sorteos_mayores_id;	

			}
			  

			$sorteos = array();
					//obtengo el MONTO a pagar de los premios del sorteo y los agrego al array() premios
			$query_sorteos_premios=mysqli_query($conn, "(SELECT tipo_premio tipo, numero_premiado_mayor numero, decimos,  format(monto,2)         as pago_premio , monto FROM sorteos_mayores_premios WHERE sorteos_mayores_id=$sorteo AND tipo_premio='EFECTIVO' AND respaldo<>'terminacion')
			                                             UNION 
			                                            (SELECT tipo_premio tipo, numero_premiado_mayor numero, decimos, desc_premio  as pago_premio, monto FROM sorteos_mayores_premios WHERE sorteos_mayores_id=$sorteo AND tipo_premio='ESPECIES') ORDER BY monto desc;");       
					   	   
			$premios= array();
			while ($row_sorteos_premios =mysqli_fetch_assoc($query_sorteos_premios)) 
			{
				unset($row_sorteos_premios['monto']);//con unset se destruye y no muestra el monto
				array_push($premios, $row_sorteos_premios);
			}       
					//obtengo el numero de sorteo, fecha de captura, fecha de vencimiento y los agrego al array() sorteos
			$query_sorteos = mysqli_query($conn, "SELECT a.id sorteo, a.fecha_sorteo, a.fecha_vencimiento vencimiento_sorteo
					                              FROM sorteos_mayores a  
					                              WHERE id = $sorteo;");

			$ob_info_sorteos     = mysqli_fetch_object($query_sorteos);
			$sorteo              = $ob_info_sorteos->sorteo;
			$fecha_sorteo        = $ob_info_sorteos->fecha_sorteo;
			$vencimiento_sorteo  = $ob_info_sorteos->vencimiento_sorteo;    
					                                  
			$sorteos =       array( "sorteo"             => $sorteo, 
			                        "fecha_sorteo"       => $fecha_sorteo,
			                        "vencimiento_sorteo" => $vencimiento_sorteo,
			                        "premios"            => $premios
			                      );               
			return $sorteos; 

    }

//obtener informacion de los sorteos mayores del PANI, sin enviar como parametro un sorteo

	function getinfoUltimoSorteo_mayor(){
		$_conexion = new conexion;
		$conn = $_conexion->__construct();
	
		   //obtengo el ID del ultimo sorteo capturado          
				   $query_ultimo_sorteo = mysqli_query($conn, "SELECT sorteos_mayores_id FROM sorteos_mayores_premios WHERE numero_premiado_mayor is not null order by sorteos_mayores_id desc limit 1;"); 
				  // $query_ultimo_sorteo = parent::obtenerDatos($query);
				   $obj_ultimo_sorteo=mysqli_fetch_object($query_ultimo_sorteo);
				   $sorteo=$obj_ultimo_sorteo->sorteos_mayores_id;
		  
				 

		$sorteos = array();
				//obtengo el MONTO a pagar de los premios del sorteo y los agrego al array() premios
		$query_sorteos_premios=mysqli_query($conn, "(SELECT tipo_premio tipo, numero_premiado_mayor numero, decimos,  format(monto,2)         as pago_premio , monto FROM sorteos_mayores_premios WHERE sorteos_mayores_id=$sorteo AND tipo_premio='EFECTIVO' AND respaldo<>'terminacion')
													 UNION 
													(SELECT tipo_premio tipo, numero_premiado_mayor numero, decimos, desc_premio  as pago_premio, monto FROM sorteos_mayores_premios WHERE sorteos_mayores_id=$sorteo AND tipo_premio='ESPECIES') ORDER BY monto desc;");       
						  
		$premios= array();
		while ($row_sorteos_premios =mysqli_fetch_assoc($query_sorteos_premios)) 
		{
			unset($row_sorteos_premios['monto']);//con unset se destruye y no muestra el monto
			array_push($premios, $row_sorteos_premios);
		}       
				//obtengo el numero de sorteo, fecha de captura, fecha de vencimiento y los agrego al array() sorteos
		$query_sorteos = mysqli_query($conn, "SELECT a.id sorteo, a.fecha_sorteo, a.fecha_vencimiento vencimiento_sorteo
											  FROM sorteos_mayores a  
											  WHERE id = $sorteo;");

		$ob_info_sorteos     = mysqli_fetch_object($query_sorteos);
		$sorteo              = $ob_info_sorteos->sorteo;
		$fecha_sorteo        = $ob_info_sorteos->fecha_sorteo;
		$vencimiento_sorteo  = $ob_info_sorteos->vencimiento_sorteo;    
												  
		$sorteos =       array( "sorteo"             => $sorteo, 
								"fecha_sorteo"       => $fecha_sorteo,
								"vencimiento_sorteo" => $vencimiento_sorteo,
								"premios"            => $premios
							  );               
		return $sorteos; 

}

//obtener un premio enviando como parametro el numero y el sorteo 

function info_premio_mayor($sorteo, $numero){
	$_conexionClass = new conexion;
	$conn = $_conexionClass->__construct();		
				
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

?>