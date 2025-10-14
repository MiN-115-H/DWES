<?php
$id = $_GET['producto'] ?? null;

if (!$id) {
    die("No se recibió ningún producto.");
}

echo "Producto recibido: $id<br>";

$con = new mysqli('localhost', 'root', '', 'tienda');
if ($con->connect_errno) {
    die("Error conectando a la base de datos: " . $con->connect_error);
}

// Consulta
$consulta = "
    SELECT t.nombre AS tienda_nombre, s.unidades
    FROM tienda t
    JOIN stock s ON t.cod = s.tienda
    JOIN producto p ON p.cod = s.producto
    WHERE p.cod = '$id'
";

// Ejecutar consulta
$resultado = $con->query($consulta);

if (!$resultado) {
    die("Error en la consulta: " . $con->error);
}

// Mostrar resultados
if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_object()) {
        echo "Tienda: " . $row->tienda_nombre . " - Unidades: " . $row->unidades . "<br>";
    }
} else {
    echo "No hay stock para ese producto.";
}

$con->close();
?>
