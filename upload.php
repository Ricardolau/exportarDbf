<?php
include './php/ClaseSession.php';
include './php/ClaseExportarDbf.php';
$usuario_sesion = new ClaseSession();
$exportarDbf = new ExportarDbf();
$mensaje='';
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Enviar')
{
    // Mas bien esto debería controlar que es el mismo token
    if (isset($_FILES['fichero']))
    {
        if ($_FILES['fichero']['error']){
            // El numero que indice le sumamos 4 para que nos de el texto correcto.
            $i = $_FILES['fichero']['error']+4;
            $mensaje = $exportarDbf->getAvisosHtml($i,'dander');
        } else {
            // Subio ficheros ahora comprobamos formato.
            if ($_FILES['fichero']['type']==="application/x-dbf"){
                // El formato de fichero es correcto.
                $dir_subida = $exportarDbf->ruta_upload;
                // Comprobamos si existe la ruta donde guardar el fichero subido.
                if (file_exists($dir_subida)) {
                    $fichero_subido = $dir_subida . basename($_FILES['fichero']['name']);
                    // Ahora comprobamos que ya no exista el fichero , para que evitar que lo sobreescriba
                    if (!file_exists($fichero_subido)){
                        // Ahora lo movemos.
                        if (move_uploaded_file($_FILES['fichero']['tmp_name'], $fichero_subido)) {
                            // Todo es correcto , entonces registramos sesion y el fichero subido.
                            $datos_fichero =json_encode($_FILES['fichero']);
                            $datos = array( 'datos_registro' =>$datos_fichero,
                                            'token'=>$usuario_sesion->getToken(),
                                            'type' =>$_FILES['fichero']['type'],
                                            'name' =>$_FILES['fichero']['name']
                                            );
                            $id = $exportarDbf->registroExportar($datos);
                            if (gettype($id) === 'integer'){
                                if ($id >0){
                                    // Es correcto el registro.
                                    $fichero = $exportarDbf->ruta_upload.$_FILES['fichero']['name'];
                                    $respuesta = $exportarDbf->crearEstructura($fichero);
                                    $mensaje =$exportarDbf->getAvisosHtml(0,'info',array($id));
                                                                               
                                }
                            } else {
                                // hubo un error al inserta
                                echo '<pre>';
                                print_r($id);
                                echo '</pre>';

                            }

                        } else {
                            $mensaje = $exportarDbf->getAvisosHtml(1,'dannger');
                        }
                    } else {
                        // Ya existe el fichero por lo que no movemos ( lo ideal seria generar un numero al final nombre... )
                        $mensaje = $exportarDbf->getAvisosHtml(2,'danger');
                    }
                } else {
                        $mensaje = $exportarDbf->getAvisosHtml(3,'warning');
                       
                }
            }
            
        }
    }  else {
        $mensaje = $exportarDbf->getAvisosHtml(4,'warning');
        
    }

} else {
   // Aquí redireccionamos a index.php vino directamente y no envio nada.
   header("Location: index.php");
}
?>
<html>
 <head>
  <title>Exportar dbf a mysql</title>
  <link href="css/bootstrap431/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/template.css" rel="stylesheet">

 </head>
 <body>
<div class="col-md-12">
    <?php echo $mensaje; ?>
</div>
 </body>
</html>





