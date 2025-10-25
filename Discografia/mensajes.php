<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['mensaje'])) {
    $msg = $_SESSION['mensaje'];
    $color = $msg['tipo'] === 'exito' ? 'green' : 'red';
    echo "<p style='color:$color; font-weight:bold;'>{$msg['texto']}</p>";
    unset($_SESSION['mensaje']);
}
?>
