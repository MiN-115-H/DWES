<?php
session_start();
$opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

try {
    $dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);
} catch (PDOException $e) {
    die('Falló la conexión: ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $album = $_POST['album'];
    $duracion = $_POST['duracion'];
    $genero = $_POST['genero'];

    $sql = "INSERT INTO cancion (titulo, album, duracion, genero)
            VALUES (:titulo, :album, :duracion, :genero)";

    $stmt = $dwes->prepare($sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':album', $album);
    $stmt->bindParam(':duracion', $duracion);
    $stmt->bindParam(':genero', $genero);

    try {
        $stmt->execute();
        header("Location: album.php?codigo={$album}&mensaje=ok");
        exit;
    } catch (PDOException $e) {
        header("Location: album.php?codigo={$album}&mensaje=error");
        exit;
    }
}
?>
