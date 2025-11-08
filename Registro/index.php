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
        <h1>Bienvenido</h1>
        <h2>Hola, <?php echo htmlspecialchars($_SESSION['usuario']); ?><br><?php echo "<img src='" . $_SESSION['img_thumb'] . "' alt='Imagen de usuario' style='max-width:200px;'>"; ?></h2>
        <p><a href="perfil.php">Ver perfil</a></p>
        <p><a href="logout.php">Cerrar sesión</a></p>

    </section>
</body>
</html>
