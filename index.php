<?php
include './php/ClaseSession.php';
include './php/claseModeloP.php';
$usuario_sesion = new ClaseSession();
$db = new ModeloP()
?>
<html>
 <head>
  <title>Exportar dbf a mysql</title>
 </head>
 <body>
<form method="POST" action="upload.php" enctype="multipart/form-data"><p>Subir ficheros:
<input type="file" name="fichero" />
<input type="hidden" name="token" value="<?php echo $usuario_sesion->getToken();?>">
<input type="submit" name="uploadBtn" value="Enviar" />
</p>
</form>
     
 <?php echo '<p>Hola Mundo</p>';
    echo '<pre>';
    print_r($usuario_sesion);
    echo '</pre>';
?>
 </body>
</html>
