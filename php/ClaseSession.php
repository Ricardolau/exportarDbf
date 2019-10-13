<?php
/* Propiedades en minuscula.
 * Metodos en UpperCamelCase
 * */
include ('ClaseConexion.php');
class ClaseSession extends ClaseConexion{
	private $session ;					// (array) Datos de $_SESSION actuales.
    public $estado; // indica el estado en el que esta la session al comprobarEstado.
    public function __construct()
	{
		parent::__construct();
		parent::getConexion();
		$this->estado = $this->comprobarEstado(); 
	}
	
	public function GetSession(){
		// Objetivo devolver la session
		return $this->session;
	}
	
	
		
	public function comprobarEstado(){
		// @ Objetivo :
		// Comprobar si hay session para exportarDbf y devolvermos $respuesta :
        //    -Nueva -> nueva session.
        //    -Actual-> Sesion actual
        //    -Error -> hubo un error no se puede continuar.
        $respuesta = 'Error';
        $inicio_unix = time();
		if (!isset($_SESSION)){
			// Hay que tener en cuenta que la session no tenemos porque iniciar nosotros, 
			// otra api del servidor la puede abrir, por eso no debemos reiniciarla nunca
			// si no esta abierta.
			session_start();
		}
        if ( !isset ($_SESSION['idSesion'])){
            // Si no existe idSesion , lo creamos
            $session_id = session_id();
            
            $token = hash('sha256', $inicio_unix.$session_id);
            $_SESSION['idSesion']= $session_id;
            $_SESSION['token'] = $token;
            $_SESSION['inicio'] = date('Y-m-d H:i:s',$inicio_unix);
            $this->session = $_SESSION;
            $respuesta='Nueva';
            
        } else {
            // Si existe idSesion, comprobamos que es el mismo.
            if ($_SESSION['idSesion'] === session_id()){
                $respuesta='Actual';
            } else {
                $respuesta='Error no coinciden los id de session';
            }
            
        }
        $this->session = $_SESSION;
        return $respuesta;
	}

    
	
        function cerrarSession(){
            //~ session_start();
            session_unset();
            session_destroy();
            // NO puedo hacer header si ya envie informacion de imprimir, por lo que lo descarto.
            //header('Location:./../../index.php');
            
            
        }
	 
}
?>
