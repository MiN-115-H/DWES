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
    $titulo = $_POST['titulo'];
    $discografica = $_POST['discografica'];
    $formato = $_POST['formato'];
    $fechaLanzamiento = $_POST['fechaLanzamiento'];
    $fechaCompra = $_POST['fechaCompra'];
    $precio = $_POST['precio'];

    $sql = "INSERT INTO album(titulo, discografica, formato, fechaLanzamiento, fechaCompra, precio)
            VALUES (:titulo, :discografica, :formato, :fechaLanzamiento, :fechaCompra, :precio)";
    
    $stmt = $dwes->prepare($sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':discografica', $discografica);
    $stmt->bindParam(':formato', $formato);
    $stmt->bindParam(':fechaLanzamiento', $fechaLanzamiento);
    $stmt->bindParam(':fechaCompra', $fechaCompra);
    $stmt->bindParam(':precio', $precio);

    try {
        $stmt->execute();
        $_SESSION['mensaje'] = ['texto' => 'Álbum insertado correctamente.', 'tipo' => 'exito'];
    } catch (PDOException $e) {
        $_SESSION['mensaje'] = ['texto' => 'Error al añadir el álbum.', 'tipo' => 'error'];
    }

    header("Location: index.php");
    exit;
}
?>
