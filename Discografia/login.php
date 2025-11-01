<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

session_start();

$opc = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];
try {
    $dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);
    $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Falló la conexión: ' . $e->getMessage());
}

// Redirigir si hay sesión
if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'] ?? '';
    $pass = $_POST['passwd'] ?? '';

    $stmt = $dwes->prepare('SELECT id, usuario, password FROM tabla_usuarios WHERE usuario = :user');
    $stmt->execute([':user' => $user]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($pass, $row['password'])) {
        $_SESSION['usuario'] = $row['usuario'];

        setcookie("auth", $row['usuario'], time() + 86400, "/", "", false, true);

        header("Location: index.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>
<body>
<h1>Login</h1>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form action="" method="post" autocomplete="off">
    <label>Usuario:</label>
    <input type="text" name="user" required><br><br>
    <label>Contraseña:</label>
    <input type="password" name="passwd" required><br><br>
    <input type="submit" value="Iniciar sesión">
</form>

<p>¿No tienes cuenta?</p>
<a href="registro.php">Registrate</a>
</body>
</html>
