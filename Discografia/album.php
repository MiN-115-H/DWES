<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Discografía</title>  
</head>
<body>
<section>
<?php
session_start(); 
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

//Verificar sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['codigo'] ?? null;

if (!$id) {
    die("No se recibió ningún álbum.");
}

$opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

try {
    $dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);
} catch (PDOException $e) {
    die('Falló la conexión: ' . $e->getMessage());
}

$consulta = "SELECT * FROM album WHERE codigo = :id";
$stmt = $dwes->prepare($consulta);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$album = $stmt->fetch(PDO::FETCH_OBJ);

if (!$album) {
    die("No se encontró el álbum.");
}

echo "
<h1>Información sobre el álbum</h1>
<p>Título: " . htmlspecialchars($album->titulo) . "</p>
<p>Discográfica: " . htmlspecialchars($album->discografica) . "</p>
<p>Formato: " . htmlspecialchars($album->formato) . "</p>
<p>Fecha de salida: " . htmlspecialchars($album->fechaLanzamiento) . "</p>
<p>Fecha de compra: " . htmlspecialchars($album->fechaCompra) . "</p>
<p>Precio: " . htmlspecialchars($album->precio) . "€</p>
";
?>

<form action="borraralbum.php" method="post">
    <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="submit" value="Borrar álbum">
</form>

<?php

$consulta2 = $dwes->prepare("
    SELECT c.titulo 
    FROM cancion c 
    JOIN album b ON b.codigo = c.album 
    WHERE b.codigo = :id
");
$consulta2->bindParam(':id', $id, PDO::PARAM_INT);
$consulta2->execute();

echo "<h2>Listado de canciones</h2>";

if ($consulta2->rowCount() == 0) {
    echo "<p>Este álbum no tiene canciones registradas.</p>";
} else {
    while ($cancion = $consulta2->fetchObject()) {
        echo "<p>" . htmlspecialchars($cancion->titulo) . "</p>";
    }
}
?>

<form action="cancionnueva.php" method="post">
    <h2>Añadir canción</h2>
    <input type="hidden" name="album" value="<?php echo htmlspecialchars($album->codigo, ENT_QUOTES, 'UTF-8'); ?>">

    <label>Título:</label>
    <input type="text" name="titulo" required><br>

    <label>Duración:</label>
    <input type="time" name="duracion" step="1" required><br>

    <label>Género:</label>
    <select name="genero" required>
        <option value="">--Selecciona un género--</option>
        <option value="Acustica">Acústica</option>
        <option value="BSO">BSO</option>
        <option value="Blues">Blues</option>
        <option value="Folk">Folk</option>
        <option value="Jazz">Jazz</option>
        <option value="New age">New age</option>
        <option value="Pop">Pop</option>
        <option value="Rock">Rock</option>
        <option value="Electronica">Electrónica</option>
    </select><br>

    <input type="submit" value="Agregar canción">
</form>
<a href="index.php">Volver</a>
<?php
if (isset($_SESSION['mensaje'])) {
    $msg = $_SESSION['mensaje'];
    $color = $msg['tipo'] === 'exito' ? 'green' : 'red';
    echo "<p style='color:$color;'>{$msg['texto']}</p>";

    unset($_SESSION['mensaje']);
}
?>
</section>
</body>
</html>
