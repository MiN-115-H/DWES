<?php
session_start();

// Opciones de conexión
$opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

try {
    $dwes = new PDO('mysql:host=localhost;dbname=tareas', 'usr_tareas', 'usr_tareas', $opc);
    $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Falló la conexión: ' . htmlspecialchars($e->getMessage()));
}

echo "<h1>Registro de usuario:</h1>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = isset($_POST['user']) ? trim($_POST['user']) : '';
    $pass = isset($_POST['passwd']) ? $_POST['passwd'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $rutaImg = isset($_POST['archivo']) ? $_POST['archivo'] : '';

    if ($user === '' || $pass === '') {
        echo '<p style="color:red">Usuario y contraseña son obligatorios.</p>';
        exit;
    }

    try {
        //Comprobar si ya existe el usuario
        $stmt = $dwes->prepare('SELECT id FROM usuarios WHERE nombre = :user LIMIT 1');
        $stmt->execute([':user' => $user]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            echo '<p style="color:red">El usuario "' . htmlspecialchars($user) . '" ya se encuentra en la base de datos.</p>';
            echo '<a href="./registro.php">Volver</a>';
            exit;
        }

        //Generar hash
        if (defined('PASSWORD_ARGON2ID')) {
            $hash = password_hash($pass, PASSWORD_ARGON2ID);
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
        }
        if ($hash === false) {
            echo '<p style="color:red">Error al generar hash.</p>';
            exit;
        }

        $sql = "INSERT INTO usuarios (nombre, correo, contrasena, ruta_img) VALUES (:user, :email, :hash, :img)";
        $stmt = $dwes->prepare($sql);
        $stmt->execute([':user' => $user, ':email' => $email, ':hash' => $hash, ":img" => $rutaImg]);

        echo '<p style="color:green">Usuario registrado correctamente.</p>';
        echo '<a href="login.php">Inicio de sesión</a>';
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { 
            echo '<p style="color:red">El usuario "' . htmlspecialchars($user) . '" ya está registrado (duplicado).</p>';
        } else {
            echo '<p style="color:red">Error al registrar usuario: ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
    }

    exit;
}
?>

<form action="" method="post">
    <label>Usuario:</label>
    <input type="text" name="user" required><br><br>
    <label>Email:</label>
    <input type="text" name="email" required><br><br>
    <label>Contraseña:</label>
    <input type="password" name="passwd" required><br><br>
    <input type="file" name="archivo" id="archivo" accept="image/*" required><br><br>
    <input type="submit" value="Registrar usuario">
    <br><br>
    <a href="./login.php">Login</a>
</form>
