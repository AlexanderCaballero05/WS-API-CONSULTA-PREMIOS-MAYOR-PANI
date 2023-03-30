<?php
require_once "respuestas.class.php"; 
require_once "conexion/conexion.php";

class getPremioSorteo extends conexion{

    function obtenerPremiosSorteo($sorteo){
        $query = "SELECT desc_premio, monto, numero_premiado_mayor FROM sorteos_mayores_premios where sorteos_mayores_id = $sorteo; ";
        $datos =parent::obtenerDatos($query);
        return $datos;
    }

//obtener informacion de los sorteos mayores del PANI
    function getinfosorteo_mayor($sorteo){
        if ($sorteo==0)  
			{
					   $query= "SELECT sorteos_mayores_id FROM sorteos_mayores_premios WHERE numero_premiado_mayor is not null order by sorteos_mayores_id desc limit 1 ";
                       $query_ultimo_sorteo = parent::obtenerDatos($query);
					   $obj_ultimo_sorteo=mysqli_fetch_object($query_ultimo_sorteo);
					   $sorteo=$obj_ultimo_sorteo->sorteos_mayores_id;
	  	    }
				     

			$sorteos = array();
	        $conn = mysqli_connect('localhost', 'APANI', '*Myaccountpani*', 'pani2');

			$query_sorteos_premios=mysqli_query($conn, "(SELECT tipo_premio tipo, numero_premiado_mayor numero, decimos,  format(monto,2)         as pago_premio , monto FROM sorteos_mayores_premios WHERE sorteos_mayores_id=$sorteo AND tipo_premio='EFECTIVO' AND respaldo<>'terminacion')
			                                             UNION 
			                                            (SELECT tipo_premio tipo, numero_premiado_mayor numero, decimos, desc_premio  as pago_premio, monto FROM sorteos_mayores_premios WHERE sorteos_mayores_id=$sorteo AND tipo_premio='ESPECIES') ORDER BY monto desc;");       
					   	   
			$premios= array();
			while ($row_sorteos_premios =mysqli_fetch_assoc($query_sorteos_premios)) 
			{
				unset($row_sorteos_premios['monto']);
				array_push($premios, $row_sorteos_premios);
			}       

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







}

?>