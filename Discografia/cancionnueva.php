<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// 🔐 Verificar sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// 📦 Conexión BD
$opc = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];
try {
    $dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);
    $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}

// 🧾 Recoger datos
$album     = $_POST['album'] ?? null;
$titulo    = trim($_POST['titulo'] ?? '');
$duracion  = $_POST['duracion'] ?? '';
$genero    = $_POST['genero'] ?? '';

// ✅ Validar campos
if (empty($album) || empty($titulo) || empty($duracion) || empty($genero)) {
    $_SESSION['mensaje'] = ['texto' => 'Por favor, rellena todos los campos.', 'tipo' => 'error'];
    header("Location: album.php?codigo=" . urlencode($album));
    exit;
}

// 🧮 Calcular posición (última + 1)
$stmt = $dwes->prepare("SELECT COALESCE(MAX(posicion), 0) + 1 AS nueva_pos FROM cancion WHERE album = :album");
$stmt->execute([':album' => $album]);
$nuevaPos = $stmt->fetchColumn();

// 💾 Insertar canción
try {
    $sql = "INSERT INTO cancion (titulo, album, posicion, duracion, genero)
            VALUES (:titulo, :album, :posicion, :duracion, :genero)";
    $stmt = $dwes->prepare($sql);
    $stmt->execute([
        ':titulo'   => $titulo,
        ':album'    => $album,
        ':posicion' => $nuevaPos,
        ':duracion' => $duracion,
        ':genero'   => $genero
    ]);

    $_SESSION['mensaje'] = ['texto' => 'Canción añadida correctamente.', 'tipo' => 'exito'];

} catch (PDOException $e) {
    $_SESSION['mensaje'] = ['texto' => 'Error al insertar la canción: ' . $e->getMessage(), 'tipo' => 'error'];
}

// 🔁 Redirigir de nuevo al álbum
header("Location: album.php?codigo=" . urlencode($album));
exit;
?>
