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
    $dwes = new PDO('mysql:host=localhost;dbname=registro', 'root', '', $opc);
    $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Falló la conexión: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Perfil de Usuario</title>  
</head>
<body>
    <section>
        <?php
        $usuario = $_SESSION['id'];
        $consulta = "SELECT usuario, img FROM users WHERE id = :id";
        $stmt = $dwes->prepare($consulta);
        $stmt->bindParam(':id', $usuario, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if ($user) {
            echo "<h1>Usuario: " . htmlspecialchars($user->usuario) . "</h1>";
            echo "<h3>Ruta imagen: " . htmlspecialchars($user->img) . "</h3>";

            if (!empty($user->img) && file_exists($user->img)) {
                echo "<img src='" . htmlspecialchars($user->img) . "' alt='Imagen de usuario' style='max-width:200px;'>";
            } else {
                echo "<p><em>Sin imagen disponible o ruta incorrecta.</em></p>";
            }
        } else {
            echo "<p>Usuario no encontrado.</p>";
        }
        ?>
        <p><a href="index.php">Volver</a></p>

    </section>
</body>
</html>
