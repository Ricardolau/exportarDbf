<?php
include './php/ClaseSession.php';
include './php/ClaseExportarDbf.php';
$usuario_sesion = new ClaseSession();
$exportarDbf = new ExportarDbf();
?>
<html>
 <head>
  <title>Exportar dbf a mysql</title>
  <link href="css/bootstrap431/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/template.css" rel="stylesheet">

 </head>
 <body>
<div class="col-md-12">
    <h1>Exportar DBF a Mysql / MariaDB</h1>
    <p>Subimos fichero dbf no puede exceder lo indica tu php.ini</p>
    <form method="POST" action="upload.php" enctype="multipart/form-data" type="application/x-dbf"><p>Subir ficheros:
    <input type="file" name="fichero" />
    <input type="hidden" name="token" value="<?php echo $usuario_sesion->getToken();?>">
    <?php
    $dir_subida = $exportarDbf->ruta_upload;
    // Comprobamos si existe la ruta donde guardar el fichero subido.
    if (file_exists($dir_subida)) {
        // Solo muestro btn enviar si existe ruta upload
        ?>
        <input type="submit" name="uploadBtn" value="Enviar" />
    <?php
    } else {
        ?>
        <div class="alert alert-danger">
            No existe ruta upload o no tengo acceso.
        </div>
    <?php    
    }
    ?>
    </form>
</div>
</body>
</html>
