<?php
include_once ('ClaseModeloP.php');
Class ExportarDbf extends ModeloP {
    //~ public function __construct(){
        //~ parent::__construct();
    //~ }
    public function registroExportar($datos){
        // @objetivo
        // Registrar fichero y sesion que lo realiza.
        // @Parametros
        // $datos -> array con 
        //
        // @Devolvemos
        // id creado para que puede el usuario verlo y anotarlo por si cierra session.
        $tabla = 'registro_exportacion';
        
        $id = parent::insert($tabla, $datos);

        return $id;
    }

    public function crearEstructura($fichero){
        // @ Objetivo
        // Es obtener y crear estructura  Sql de la tabla dbf
        $respuesta = $this->obtenerEstructuraDbf($fichero);
        $nombreTabla =basename($fichero, ".dbf");
        if ($respuesta['Estado']===0){
            $strCampos = array();
            $i = 0;
            $resultado = array();
            foreach ($respuesta['datos'] as $campo){
                $campo = json_decode($campo);
                if (isset($campo->campo)){
                    $tipo = '';
                    switch ($campo->tipo){
                        case 'C':
                            $tipo = 'varchar('.$campo->longitud.')';
                            break;
                        case 'N':
                            $tipo = 'decimal('.$campo->longitud.','.$campo->decimal.')';
                            break;
                        case 'D':
                            $tipo = 'date';
                            break;
                        case 'L':
                            $tipo = 'tinyint(1)';
                            break;
                    }

                    $strCampos[$i] = $campo->campo.' '.$tipo;
                    $i++;
                }
            }
            $strSql = implode(",",$strCampos);
            $sql = 'CREATE TABLE '.$nombreTabla.' ('.$strSql.')';
            $resultado = parent::query($sql,'CREATE');
            
        }

	
        return $resultado;
    }

    public function obtenerEstructuraDbf($fichero){
        // @ Objetivo
        // Obtener campos que tiene el fichero dbf
        // @ Parametro
        // $fichero = Ruta y nombre del fichero dbf
        // @ Devuelve.
        // $Estado = 1 si es un error, 0 si fue correcto.
        // $datos 0 $errores
       	$instruccion = "python ./py/leerEstrucDbf2.py 2>&1 -f ".$fichero;
        $resultado = array();
        $output = array(); 


        // Recuerda que esto lo mostramos gracias a que ponemos parametro 2>&1 en exec... 
        // No permitimos continuar.
        exec($instruccion, $output, $entero);
        $resultado['Estado'] = $entero;
        if ($entero >0 ){
            $resultado['errores'] = $output;
        } else {
            $resultado['datos'] = $output;

        }
        //~ echo '<pre>';
        //~ print_r($resultado);    
        //~ echo '</pre>';
        return $resultado;

    }

    public function getAvisosHtml($id,$tipo,$parametro=array()){
        //@ Objetivo
        // Obtener los mensajes maquetados bootstrap.
        //@ Parametros
        // $id          -> (int) Indice mensaje.
        // $tipo        -> (string) Donde indicamos si es: info, danger o warning
        // $parametros  -> (array) Podemos mandar los parametros que necesite el mensaje.

        // Array de mensajes

        $mensaje = array(
                        0  =>'Su fichero es válido y se subió con éxito.<br/>Realizamos registro en base datos correctamente,su id es '.$parametro[0],
                        1  =>'Error a la hora mover el fichero.',
                        2  =>'El fichero ya existe, por lo que si no lo subiste tú , cambiale el nombre.',
                        3  =>'El directorio upload no es correcto',
                        4  =>'No subiste ficheros',
                        // Errores $_FILES ver manual php (en vez empezar 1 empezamos 5)
                        5  =>'El fichero subido excede la directiva upload_max_filesize de php.ini.',
                        6  =>'El fichero subido excede la directiva MAX_FILE_SIZE especificada en el formulario HTM',
                        7  =>'El fichero fue sólo parcialmente subido.',
                        8  =>'No se subió ningún fichero',
                        9  => 'Falta la carpeta temporal',
                        10 => 'No se pudo escribir el fichero en el disco',
                        11 => 'PHP detuvo la subida de ficheros' 
                   
                    );
        
        $html = '<div class="alert alert-'.$tipo.'">'
                .$mensaje[$id]
                .'</div>';

        return $html;
                    

    }



}
