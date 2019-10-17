<?php

/*
 * @Copyright 2018, Alagoro Software.
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción
 */

include_once 'ClaseConexion.php';


class ModeloP {

//    protected static $instance = null;
    public $db = null;
//    protected static $tabla;

    public function __construct()
	{
		// Solo realizamos asignamos 
        $conexion = new ClaseConexion();
		$this->db = $conexion->conexion;
        $this->ruta_upload = $conexion->ruta_upload;
        $this->ruta_proyecto = $conexion->ruta_proyecto;
        $this->estado = $conexion->estado;
	}

    public function insert($tabla, $datos, $soloSQL = false) {
        $respuesta = false;
        $updateStr = [];
        if (is_array($datos)) {
            foreach ($datos as $key => $value) {
                $updateStr[] = $key . ' = \'' . $value . '\'';
            }
        } else {
            $updateStr[] = $datos;
        }
        $updateString = implode(', ', $updateStr);

        $sql = 'INSERT ' . $tabla
                . ' SET ' . $updateString;

        if ($soloSQL) {
            $respuesta = ($sql !== '');
        } else {
            $respuesta = $this->query($sql,'INSERT');
         
        }
        
        return $respuesta;
    }

    
    public function query($sql,$tipo) {
        $db = $this->db;
        if ($db->query($sql)) {;
                // No hubo error
                $respuesta = $tipo; // Devolver algo si el tipo no existe en los if.
                if ($tipo ==='INSERT'){
                    $respuesta =$db->insert_id;
                }
                
        } else {
            $respuesta = array( 'Error' =>$db->connect_errno,
                                'mensaje' =>$db->error
                            );
        }
        return $respuesta;
    }


 
}
