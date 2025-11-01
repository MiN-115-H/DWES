<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Verificar sesión 
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Conexión a la base de datos
$opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
try {
    $dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);
    $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Falló la conexión: ' . $e->getMessage());
}

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['tituloCancion'] ?? '');
    $busqueda = $_POST['tipo'] ?? '';
    $genero = $_POST['genero'] ?? '';

    if (empty($titulo)) {
        echo "<p style='color:red;'>Por favor, escribe algo para buscar.</p>";
        exit;
    }

    echo "<h1>Resultados de la búsqueda</h1>";

    //Buscar solo canciones
    if ($busqueda === 'cancion') {
        $sql = "SELECT c.titulo AS cancion, c.duracion, c.genero, a.titulo AS album
                FROM cancion c
                JOIN album a ON c.album = a.codigo
                WHERE c.titulo = :titulo";

        if (!empty($genero)) {
            $sql .= " AND c.genero = :genero";
        }

        $stmt = $dwes->prepare($sql);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        if (!empty($genero)) {
            $stmt->bindParam(':genero', $genero, PDO::PARAM_STR);
        }

        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            echo "<p>No se encontraron canciones.</p>";
        } else {
            echo "<h2>Canciones encontradas</h2>";
            echo "<table border='1' cellpadding='8'>
                    <tr>
                        <th>Canción</th>
                        <th>Álbum</th>
                        <th>Duración</th>
                        <th>Género</th>
                    </tr>";
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>" . htmlspecialchars($fila['cancion']) . "</td>
                        <td>" . htmlspecialchars($fila['album']) . "</td>
                        <td>" . htmlspecialchars($fila['duracion']) . "</td>
                        <td>" . htmlspecialchars($fila['genero']) . "</td>
                      </tr>";
            }
            echo "</table>";
        }
    }

    //Buscar solo álbumes
    elseif ($busqueda === 'album') {
        $sql = "SELECT DISTINCT a.titulo AS album, a.formato, a.codigo
                FROM album a
                WHERE a.titulo = :titulo";

        $stmt = $dwes->prepare($sql);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            echo "<p>No se encontraron álbumes.</p>";
        } else {
            echo "<h2>Álbumes encontrados</h2>";
            echo "<table border='1' cellpadding='8'>
                    <tr>
                        <th>Álbum</th>
                        <th>Formato</th>
                    </tr>";
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td><a href='album.php?codigo=" . htmlspecialchars($fila['codigo']) . "'>"
                             . htmlspecialchars($fila['album']) . "</a></td>
                        <td>" . htmlspecialchars($fila['formato']) . "</td>
                      </tr>";
            }
            echo "</table>";
        }
    }

    //Buscar ambos
    elseif ($busqueda === 'ambos') {

        $sqlAlbum = "SELECT DISTINCT a.titulo AS album, a.formato, a.codigo
                     FROM album a
                     WHERE a.titulo = :titulo";
        $stmtAlbum = $dwes->prepare($sqlAlbum);
        $stmtAlbum->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmtAlbum->execute();

        echo "<h2>Álbumes encontrados</h2>";
        if ($stmtAlbum->rowCount() === 0) {
            echo "<p>No se encontraron álbumes.</p>";
        } else {
            echo "<table border='1' cellpadding='8'>
                    <tr>
                        <th>Álbum</th>
                        <th>Formato</th>
                    </tr>";
            while ($fila = $stmtAlbum->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td><a href='album.php?codigo=" . htmlspecialchars($fila['codigo']) . "'>"
                             . htmlspecialchars($fila['album']) . "</a></td>
                        <td>" . htmlspecialchars($fila['formato']) . "</td>
                      </tr>";
            }
            echo "</table>";
        }

        $sqlCancion = "SELECT c.titulo AS cancion, c.duracion, c.genero, a.titulo AS album
                       FROM cancion c
                       JOIN album a ON c.album = a.codigo
                       WHERE c.titulo = :titulo";
        if (!empty($genero)) {
            $sqlCancion .= " AND c.genero = :genero";
        }

        $stmtCancion = $dwes->prepare($sqlCancion);
        $stmtCancion->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        if (!empty($genero)) {
            $stmtCancion->bindParam(':genero', $genero, PDO::PARAM_STR);
        }
        $stmtCancion->execute();

        echo "<h2>Canciones encontradas</h2>";
        if ($stmtCancion->rowCount() === 0) {
            echo "<p>No se encontraron canciones.</p>";
        } else {
            echo "<table border='1' cellpadding='8'>
                    <tr>
                        <th>Canción</th>
                        <th>Álbum</th>
                        <th>Duración</th>
                        <th>Género</th>
                    </tr>";
            while ($fila = $stmtCancion->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>" . htmlspecialchars($fila['cancion']) . "</td>
                        <td>" . htmlspecialchars($fila['album']) . "</td>
                        <td>" . htmlspecialchars($fila['duracion']) . "</td>
                        <td>" . htmlspecialchars($fila['genero']) . "</td>
                      </tr>";
            }
            echo "</table>";
        }
    }

    else {
        echo "<p style='color:red;'>Selecciona una opción de búsqueda válida.</p>";
    }

    echo "<br><a href='index.php'>⬅ Volver al inicio</a>";

} else {
    echo "<p style='color:red;'>Acceso no permitido directamente. Usa el formulario del index.</p>";
}
?>
