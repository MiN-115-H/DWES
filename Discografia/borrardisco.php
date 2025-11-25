<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php
		include("datos.ini.php");
        include("conexion.ini.php");
        include("album.ini.php");
	?>
    <title>Document</title>
</head>
<body>
    <?php
        echo '<button  onclick=location.href="./index.php">Volver</button>';
        $conectar = new Conexion('localhost','discografia','discografia','discografia');
		$conexion = $conectar->conectionPDO();
        $album = new Album($_GET['codigo'],'','','','','','');
        $album->borrarDisco($conexion,$_GET['TC']);
    ?>
</body>
</html>