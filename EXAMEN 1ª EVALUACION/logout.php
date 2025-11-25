<?php
session_start();

// Vaciar variables de sesión
$_SESSION = [];

// Eliminar cookie de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Eliminar cookie personalizada "auth"
setcookie("auth", "", time() - 3600, "/");

// Destruir sesión
session_destroy();

// Evitar caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Redirigir al login
header("Location: login.php");
exit;
?>