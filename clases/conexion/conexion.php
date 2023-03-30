<?php


class conexion {
//atributos de la clase
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $conexion;

//construcc es la primer metodo que se ejecuta de este archivo con solo instanciar la funcion conexion se manda a llamar el metodo contructor
function __construct(){
    $listadatos = $this->datosConexion(); // en esta variable guardo los datos de la funcion datosConexion.

    foreach ($listadatos as $key => $value){
        $this->server = $value['server'];//aqui igualo los atributos de la clase a los valores
        $this->user = $value['user'];
        $this->password = $value['password'];
        $this->database = $value['database'];
        $this->port = $value['port'];
    }

    $conexion_success = $this->conexion = new mysqli($this->server, $this->user, $this->password, $this->database, $this->port);
    if($conexion_success->connect_errno){
        echo "algo va mal con la conexion";
            die();
    }else{
        return $conexion_success;
    
    }
}


//con esta funcion obtenemos los datos de config que estan en formato json y los convertimos a un array
    private function datosConexion(){
        $direccion = dirname(__FILE__);
        $jsondata = file_get_contents($direccion. "/". "config");//le enviamos como parametro el archivo que queremos abrir que es config sin extension
        return json_decode($jsondata, true);

    }
    /*---------------------------------------------------- Fin de codigo de la conexion -----------------------------------------------*/

     /*FUNCION PARA 
    Convertir los registros que nos develve la base de datos a UTP8, PARA EVITATR PROBLEMAS DE LEGIBILIDAD COMO UNA TILDE*/
    private function convertirUTF8($array){
        array_walk_recursive($array,function(&$item,$key){
            if(!mb_detect_encoding($item,'utf-8',true)){
                $item = utf8_encode($item);
            }
        });
        return $array;
    }

   public function obtenerDatos($sqlstring){
    $results = $this->conexion->query($sqlstring);
    $resultArray= array();
    foreach ($results as $key){//$la variable $key es la que tiene la fila del result, en donde esta fila es un registro de una tabla;
        $resultArray[] = $key;
    }
    return $this->convertirUTF8($resultArray);
    }
    public function nonQuery($sqlstr){
        $results = $this->conexion->query($sqlstr);
        return $this->conexion->affected_rows;
    }

    //INSERT 
    public function nonQueryId($sqlstr){
        $results = $this->conexion->query($sqlstr);
         $filas = $this->conexion->affected_rows;
         if($filas >= 1){
            return $this->conexion->insert_id;
         }else{
             return 0;
         }
    }
     
    //encriptar

    protected function encriptar($string){//Solo la podemos usar si heredamos esta clase a la clase en donde se quiera utilizar y utilizamos parent::encriptar
        return md5($string);
    }
   }




?>