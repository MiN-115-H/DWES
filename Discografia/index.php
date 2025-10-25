<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Discografía</title>  
</head>
<body>
<section>
<h1>Listado de álbumes</h1>

<?php include 'mensajes.php'; ?>

<?php
$opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
try {
    $dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);
} catch (PDOException $e) {
    die('Falló la conexión: ' . $e->getMessage());
}

$consulta = "SELECT * FROM album";
$resultado = $dwes->query($consulta);

while ($album = $resultado->fetchObject()) {
    echo '<a href="album.php?codigo=' . $album->codigo . '">' . htmlspecialchars($album->titulo) . '</a><br>';
}
?>

<!-- Formulario de nuevo álbum -->
<form action="albumnuevo.php" method="post">
    <h2>Añadir álbum</h2>
    <label>Título:</label>
    <input type="text" name="titulo" required><br>
    <label>Discográfica:</label>
    <input type="text" name="discografica" required><br>
    <label>Formato:</label>
    <select name="formato" required>
        <option value="">--Selecciona un formato--</option>
        <option value="vinilo">Vinilo</option>
        <option value="cd">CD</option>
        <option value="dvd">DVD</option>
        <option value="mp3">MP3</option>
    </select><br>
    <label>Fecha lanzamiento:</label>
    <input type="date" name="fechaLanzamiento" required><br>
    <label>Fecha compra:</label>
    <input type="date" name="fechaCompra" required><br>
    <label>Precio:</label>
    <input type="number" name="precio" step="0.01" required><br>
    <input type="submit" value="Agregar disco">
</form>

<form action="canciones.php" method="post">
    <h2>Busqueda de canciones</h2>
    <label>Titulo de la cancion:</label>
    <input type="text"name="tituloCancion" id="tituloCancion">
    <br>
    <label>Buscar en: </label>
    <input type="radio" name="tipo" id="opcion1" value="cancion">
    <label for="opcion1">Titulo de canción</label>
    <input type="radio" name="tipo" id="opcion2" value="album">
    <label for="opcion2">Nombres de álbum</label>
    <input type="radio" name="tipo" id="opcion3" value="ambos">
    <label for="opcion3">Ambos</label>
    <br>
    <select name="genero" required>
        <option value="">--Selecciona un género--</option>
        <option value="clasica">Clásica</option>
        <option value="bso">BSO</option>
        <option value="blues">Blues</option>
        <option value="electronica">Electrónica</option>
        <option value="jazz">Jazz</option>
        <option value="metal">Metal</option>
        <option value="pop">Pop</option>
        <option value="rock">Rock</option>
    </select><br>
    <input type="submit" value="Buscar">
</form>
</section>
</body>
</html>
