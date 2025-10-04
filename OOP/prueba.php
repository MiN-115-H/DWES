<?php
echo "Directorio actual: " . __DIR__ . "<br>";
$ruta = __DIR__ . "/../Ejercicio2/cabecera.inc.php";
echo "Ruta buscada: $ruta<br>";
if (file_exists($ruta)) {
    echo "✅ El archivo existe.";
} else {
    echo "❌ No se encuentra el archivo.";
}
