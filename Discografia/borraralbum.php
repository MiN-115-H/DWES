<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

//Verificar sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
$opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

try {
    $dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);
} catch (PDOException $e) {
    die('Falló la conexión: ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['codigo'];

    try {
        $stmt = $dwes->prepare("SELECT titulo FROM album WHERE codigo = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $titulo = $stmt->fetchColumn();

        $dwes->beginTransaction();

        $sqlCanciones = "DELETE FROM cancion WHERE album = :id";
        $stmt1 = $dwes->prepare($sqlCanciones);
        $stmt1->bindParam(':id', $id);
        $stmt1->execute();

        $sqlAlbum = "DELETE FROM album WHERE codigo = :id";
        $stmt2 = $dwes->prepare($sqlAlbum);
        $stmt2->bindParam(':id', $id);
        $stmt2->execute();

        $dwes->commit();

        $_SESSION['mensaje'] = ['texto' => 'Álbum borrado correctamente.', 'tipo' => 'exito'];
    } catch (Exception $e) {
        $dwes->rollBack();
        $_SESSION['mensaje'] = ['texto' => 'Error al borrar el álbum.', 'tipo' => 'error'];
    }

    header("Location: index.php");
    exit;
}
?>
