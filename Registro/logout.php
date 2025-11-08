<?php
session_start();

// Evitar caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Vaciar variables de sesión
$_SESSION = [];

// Eliminar cookie de sesión (PHPSESSID)
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

// Eliminar cookies personalizadas del login
setcookie("auth_id", "", time() - 3600, "/");
setcookie("auth_user", "", time() - 3600, "/");
setcookie("auth", "", time() - 3600, "/");

// Destruir la sesión completamente
session_destroy();

// Redirigir al login
header("Location: login.php");
exit;
