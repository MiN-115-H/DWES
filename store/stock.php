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
    SELECT t.cod AS tienda_id, t.nombre AS tienda_nombre, s.unidades
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
    echo '<form method="post" action="">';
    echo '<input type="hidden" name="producto" value="'.$id.'">';
    while ($row = $resultado->fetch_object()) {
        echo "Tienda: " . $row->tienda_nombre .
            ' - Unidades: <input type="number" name="unidades['.$row->tienda_id.']" 
            style="width: 50px" value="' . $row->unidades . '"> <br>';
    }
    echo '<br><button type="submit">Guardar cambios</button>';
    echo '</form>';
} else {
    echo "No hay stock para ese producto.";
}

// Actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['unidades'])) {
    $producto = $_POST['producto'];
    $con->autocommit(false);

    try {
        foreach ($_POST['unidades'] as $tiendaId => $valor) {
            $unidades = intval($valor);
            $tiendaId = intval($tiendaId);

            $sql = "UPDATE stock SET unidades=$unidades 
                    WHERE producto='$producto' AND tienda=$tiendaId";
            $con->query($sql);

            if ($con->affected_rows === 0) {
                $sql = "INSERT INTO stock (producto, tienda, unidades) 
                        VALUES ('$producto', $tiendaId, $unidades)";      
                $con->query($sql);
            }
        }
        $con->commit();
        echo "Stock actualizado correctamente.";
    }
    catch (Exception $e) {
        $con->rollback();
        echo "Error: " . $e->getMessage();
    }
}

$con->close();
?>
