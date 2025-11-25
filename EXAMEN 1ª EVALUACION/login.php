<?php
session_start();

$opc = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];
try {
    $dwes = new PDO('mysql:host=localhost;dbname=tareas', 'usr_tareas', 'usr_tareas', $opc);
    $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Falló la conexión: ' . $e->getMessage());
}

// Redirigir si hay sesión
if (isset($_SESSION['nombre'])) {
    header("Location: index.php");
    exit;
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'] ?? '';
    $pass = $_POST['passwd'] ?? '';

    $stmt = $dwes->prepare('SELECT id, nombre, contrasena FROM usuarios WHERE nombre = :user');
    $stmt->execute([':user' => $user]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($pass, $row['contrasena'])) {
        $_SESSION['nombre'] = $row['nombre'];

        setcookie("user", $user, time() + 86400, "/");

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

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; 
       echo "<form action='' method='post' autocomplete='off'>";
       echo "<label>Usuario:</label>";
       if(!isset($_COOKIE['auth'])){
        echo "<input type='text' name='user' value='{$_COOKIE['user']}'required><br><br>";
       }else{
        echo "<input type='text' name='user' required><br><br>";
       }
       echo "<label>Contraseña:</label>";
       echo "<input type='password' name='passwd' required><br><br>";
       echo "<input type='submit' value='Iniciar sesión'>";
       echo "</form>";
?>

<p>¿No tienes cuenta?</p>
<a href="registro.php">Registrate</a>
</body>
</html>
