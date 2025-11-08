<?php
session_start();

// Opciones de conexión
$opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

try {
    $dwes = new PDO('mysql:host=localhost;dbname=registro', 'root', '', $opc);
    $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Falló la conexión: ' . htmlspecialchars($e->getMessage()));
}

echo "<h1>Registro de usuario:</h1>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 📂 Directorios de destino
    $target_dir = "img/users/";
    $target_large = $target_dir . "large/";
    $target_small = $target_dir . "small/";

    // 📁 Nombre único para las imágenes
    $nombreArchivo = uniqid() . ".jpg";
    $rutaOriginal = $target_dir . $nombreArchivo;
    $rutaLarge = $target_large . $nombreArchivo;
    $rutaSmall = $target_small . $nombreArchivo;

    $tipo = $_FILES['archivo']['type'];
    if ($tipo != 'image/png' && $tipo != 'image/jpeg') {
        echo '<p>Formato no válido (solo PNG o JPG).</p>';
        return;
    }

    switch ($_FILES['archivo']['error']) {
        case UPLOAD_ERR_OK:
            $tmp_name = $_FILES['archivo']['tmp_name'];

            // Mover el archivo original temporalmente
            if (!move_uploaded_file($tmp_name, $rutaOriginal)) {
                die('<p>Error al subir el archivo.</p>');
            }

            echo '<p>Archivo subido correctamente.</p>';

            // 📏 Crear versiones redimensionadas
            redimensionarImagen($rutaOriginal, $rutaLarge, 360, 480);
            redimensionarImagen($rutaOriginal, $rutaSmall, 72, 96);

            // Puedes eliminar el original si no lo necesitas
            // unlink($rutaOriginal);

            break;

        case UPLOAD_ERR_NO_FILE:
            die('No se envió ningún archivo.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            die('El archivo supera el tamaño permitido.');
        default:
            die('Error desconocido al subir la imagen.');
    }

    // 📦 Datos del usuario
    $user = isset($_POST['user']) ? trim($_POST['user']) : '';
    $pass = isset($_POST['passwd']) ? $_POST['passwd'] : '';

    try {
        // Verificar si ya existe el usuario
        $stmt = $dwes->prepare('SELECT id FROM users WHERE usuario = :user LIMIT 1');
        $stmt->execute([':user' => $user]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            echo '<p style="color:red">El usuario "' . htmlspecialchars($user) . '" ya existe.</p>';
            exit;
        }

        // Generar hash de la contraseña
        $hash = defined('PASSWORD_ARGON2ID')
            ? password_hash($pass, PASSWORD_ARGON2ID)
            : password_hash($pass, PASSWORD_DEFAULT);

        if ($hash === false) {
            echo '<p style="color:red">Error al generar el hash de la contraseña.</p>';
            exit;
        }

        // Guardar en la base de datos la imagen principal (360x480)
        $sql = "INSERT INTO users (usuario, password, img, img_thumb) VALUES (:user, :hash, :img, :img_thumb)";
        $stmt = $dwes->prepare($sql);
        $stmt->execute([':user' => $user, ':hash' => $hash, ':img' => $rutaLarge, ':img_thumb' => $rutaSmall]);

        echo '<p style="color:green">Usuario registrado correctamente.</p>';
        echo '<a href="login.php">Iniciar sesión</a>';

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { 
            echo '<p style="color:red">El usuario "' . htmlspecialchars($user) . '" ya está registrado.</p>';
        } else {
            echo '<p style="color:red">Error al registrar: ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
    }

    exit;
}

/**
 * 📸 Función para redimensionar imágenes
 */
function redimensionarImagen($rutaOrigen, $rutaDestino, $anchoNuevo, $altoNuevo) {
    list($anchoOriginal, $altoOriginal, $tipo) = getimagesize($rutaOrigen);

    // Crear recurso según tipo
    switch ($tipo) {
        case IMAGETYPE_JPEG:
            $imagenOriginal = imagecreatefromjpeg($rutaOrigen);
            break;
        case IMAGETYPE_PNG:
            $imagenOriginal = imagecreatefrompng($rutaOrigen);
            break;
        default:
            die("Tipo de imagen no soportado");
    }

    // Crear lienzo nuevo
    $imagenNueva = imagecreatetruecolor($anchoNuevo, $altoNuevo);

    // Mantener transparencia si es PNG
    if ($tipo == IMAGETYPE_PNG) {
        imagealphablending($imagenNueva, false);
        imagesavealpha($imagenNueva, true);
        $transparente = imagecolorallocatealpha($imagenNueva, 0, 0, 0, 127);
        imagefill($imagenNueva, 0, 0, $transparente);
    }

    // Redimensionar
    imagecopyresampled(
        $imagenNueva,
        $imagenOriginal,
        0, 0, 0, 0,
        $anchoNuevo, $altoNuevo,
        $anchoOriginal, $altoOriginal
    );

    // Guardar imagen
    switch ($tipo) {
        case IMAGETYPE_JPEG:
            imagejpeg($imagenNueva, $rutaDestino, 90);
            break;
        case IMAGETYPE_PNG:
            imagepng($imagenNueva, $rutaDestino);
            break;
    }

    // Liberar memoria
    imagedestroy($imagenOriginal);
    imagedestroy($imagenNueva);
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <label>Usuario:</label>
    <input type="text" name="user" required><br><br>

    <label>Contraseña:</label>
    <input type="password" name="passwd" required><br><br>

    <input type="file" name="archivo" id="archivo" accept="image/*" required><br><br>

    <input type="submit" value="Registrar usuario">
</form>
