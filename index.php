<?php
include './php/ClaseSession.php';
$usuario_sesion = new ClaseSession();
?>
<html>
 <head>
  <title>Exportar dbf a mysql</title>
 </head>
 <body>
 <?php echo '<p>Hola Mundo</p>';
    echo '<pre>';
    print_r($usuario_sesion);
    echo '</pre>';
?>
 </body>
</html>
