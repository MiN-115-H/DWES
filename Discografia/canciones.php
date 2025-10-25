<?php
$opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

try {
    $dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);
} catch (PDOException $e) {
    die('Falló la conexión: ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['tituloCancion']);
    $busqueda = $_POST['tipo'] ?? '';
    $formato = $_POST['formatoCancion'] ?? '';

    if (empty($titulo)) {
        echo "<p style='color:red;'>Por favor, escribe algo para buscar.</p>";
        exit;
    }

    $sql = "";
    switch ($busqueda) {
        case 'cancion':
            $sql = "SELECT c.titulo AS cancion, a.titulo AS album, a.formato
                    FROM cancion c
                    JOIN album a ON c.album = a.codigo
                    WHERE c.titulo LIKE :titulo";
            break;

        case 'album':
            $sql = "SELECT c.titulo AS cancion, a.titulo AS album, a.formato
                    FROM cancion c
                    JOIN album a ON c.album = a.codigo
                    WHERE a.titulo LIKE :titulo";
            break;

        case 'ambos':
            $sql = "SELECT c.titulo AS cancion, a.titulo AS album, a.formato
                    FROM cancion c
                    JOIN album a ON c.album = a.codigo
                    WHERE c.titulo LIKE :titulo OR a.titulo LIKE :titulo";
            break;

        default:
            echo "<p style='color:red;'>Selecciona una opción de búsqueda.</p>";
            exit;
    }

    if (!empty($formato)) {
        $sql .= " AND a.formato = :formato";
    }

    $stmt = $dwes->prepare($sql);
    $tituloLike = "%" . $titulo . "%";
    $stmt->bindParam(':titulo', $tituloLike, PDO::PARAM_STR);

    if (!empty($formato)) {
        $stmt->bindParam(':formato', $formato, PDO::PARAM_STR);
    }

    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        echo "<p>No se encontraron resultados.</p>";
    } else {
        echo "<h2>Resultados de la búsqueda:</h2>";
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<p><strong>Canción:</strong> " . htmlspecialchars($fila['cancion']) .
                 " — <strong>Álbum:</strong> " . htmlspecialchars($fila['album']);
        }
    }
}
?>
