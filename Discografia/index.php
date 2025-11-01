<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Verificar que se ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$opc = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];
try {
    $dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);
    $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Falló la conexión: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Discografía</title>  
</head>
<body>
    <section>
        <h1>Discografía</h1>
        <h2>Hola, <?php echo htmlspecialchars($_SESSION['usuario']); ?></h2>
        <p><a href="logout.php">Cerrar sesión</a></p>

        <h2>Listado de álbumes</h2>
        <?php
        $consulta = "SELECT * FROM album";
        $resultado = $dwes->query($consulta);

        while ($album = $resultado->fetchObject()) {
            echo '<a href="album.php?codigo=' . $album->codigo . '">' . htmlspecialchars($album->titulo) . '</a><br>';
        }
        ?>

        <hr>
        <h2>Añadir álbum</h2>
        <form action="albumnuevo.php" method="post">
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

        <hr>
        <h2>Búsqueda de canciones</h2>
        <form action="canciones.php" method="post">
            <label>Título de la canción:</label>
            <input type="text" name="tituloCancion" id="tituloCancion" required>
            <br><br>

            <label>Buscar en:</label>
            <input type="radio" name="tipo" id="opcion1" value="cancion" required>
            <label for="opcion1">Título de canción</label>

            <input type="radio" name="tipo" id="opcion2" value="album">
            <label for="opcion2">Nombres de álbum</label>

            <input type="radio" name="tipo" id="opcion3" value="ambos">
            <label for="opcion3">Ambos</label>
            <br><br>

            <label>Género:</label>
            <select name="genero">
                <option value="">--Selecciona un género--</option>
                <option value="clasica">Clásica</option>
                <option value="bso">BSO</option>
                <option value="blues">Blues</option>
                <option value="electronica">Electrónica</option>
                <option value="jazz">Jazz</option>
                <option value="metal">Metal</option>
                <option value="pop">Pop</option>
                <option value="rock">Rock</option>
            </select>
            <br><br>

            <input type="submit" value="Buscar">
        </form>
    </section>
</body>
</html>
