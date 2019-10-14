<?php
/* Propiedades en minuscula.
 * Metodos en UpperCamelCase
 * */
class ClaseConexion {
	public $ruta_proyecto; //(String) Ruta del proyecto.
	public $conexion ; // (object) Con la conexion...
    public $estado; //String con los valores 'Conectado','Error de conexion','Desconectado
	private $server; 
	private $base;
	private $usuario;
	private $contrasena;
	
	
	public function __construct()
	{
		$ruta_clase = __FILE__;
		// Quitamos los /php/ClaseConexion.php ( 26 caracteres),
		$ruta_proyecto = substr($ruta_clase,0,-22);
		$this->ruta_proyecto = $ruta_proyecto;
		$this->cargarConfiguracion();
		$this->conexion = $this->conectar();	
	}
	
	public function getConexion(){
		return $this->conexion;
	}
	
	public function conectar(){
		
		try{
			$db= new mysqli($this->server, $this->usuario,$this->contrasena, $this->base);
            $this->estado = "Conectado";
            if ($db->connect_errno) {   
                // Pudo haber un error
                $this->estado = 'Error '.$db->connect_errno.':'.$db->connect_error;

            }
            
 			return $db;
		}  catch (PDOException $e){
			$this->estado = "Error de conexión";
	
		}
	
	}
	
	public function cargarConfiguracion(){
		include ($this->ruta_proyecto.'/configuracion.php');
		$this->server =$server;
		$this->base = $base;
		$this->usuario = $usuario;
		$this->contrasena = $contrasena;
		return;
	}
}
 

?>
