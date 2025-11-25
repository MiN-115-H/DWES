<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Verificar que se ha iniciado sesión
if (!isset($_SESSION['nombre'])) {
    header("Location: login.php");
    exit;
}

$opc = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];
try {
    $dwes = new PDO('mysql:host=localhost;dbname=tareas', 'usr_tareas', 'usr_tareas', $opc);
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
        $usuario = $_SESSION['nombre'];
        $consulta = "SELECT nombre, correo FROM usuarios WHERE nombre = :nombre";
        $stmt = $dwes->prepare($consulta);
        $stmt->bindParam(':nombre', $usuario, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if ($user) {
            echo "<h1>Usuario: " . $usuario . "</h1>";
            echo "<h2>Correo: ". $user->correo ."</h2>";
        } else {
            echo "<p>Usuario no encontrado.</p>";
        }
        ?>
        <p><a href="index.php">Volver</a></p>

    </section>
</body>
</html>
