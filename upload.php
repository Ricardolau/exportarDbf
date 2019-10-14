<?php
include './php/ClaseSession.php';
include './php/claseModeloP.php';
$usuario_sesion = new ClaseSession();
$db = new ModeloP();

$mensage_error = array(
                        1 =>'El fichero subido excede la directiva upload_max_filesize de php.ini.',
                        2 =>'El fichero subido excede la directiva MAX_FILE_SIZE especificada en el formulario HTM',
                        3 =>'El fichero fue sólo parcialmente subido.',
                        4 =>'No se subió ningún fichero',
                        6 => 'Falta la carpeta temporal',
                        7 => 'No se pudo escribir el fichero en el disco',
                        8 => 'ensión de PHP detuvo la subida de ficheros'); 
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Enviar')
{
    // Mas bien esto debería controlar que es el mismo token
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
  if (isset($_FILES['fichero']))
  {
    if ($_FILES['fichero']['error']){
        
        echo 'Error '.$_FILES['fichero']['error']. ':'.$mensage_error[$_FILES['fichero']['error']];
    } else {
        echo '<pre>';
        print_r($_FILES);
        echo '</pre>';
    }
  }
}
//~ header("Location: index.php");







