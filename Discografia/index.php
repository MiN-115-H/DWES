<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Discografia</title>  
    </head>
    <body>
        <section>
    <h1>Listado de álbumes</h1>
    <?php 
      $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

      try {
          $dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);
      } catch (PDOException $e) {
          echo 'Falló la conexión: ' . $e->getMessage();
      }

      $consulta = "SELECT * FROM album;";
      $resultado = $dwes->query($consulta);

      while ($album = $resultado->fetchObject()) {
            echo '<a href ="album.php?codigo='. $album->codigo . '"> '. $album->titulo .'</a>
            <br>';
      }
    ?>

    <form action="albumnuevo.php" method="post">
        <h2>Añadir álbum</h2>
        <label>Título:</label>
        <input type="text" name="titulo" required><br>
        <label>Discográfica:</label>
        <input type="text" name="discografica" required><br>
        <label>Formato:</label>
        <select name="formato" required>
          <option value="">--Selecciona un formato--</option>
          <option value="vinilo">Vinilo</option>
          <option value="cd">CD</option>
          <option value="dvd">DVD</option>
          <option value="mp3">MP3</option>
        </select><br>
        <label>Fecha lanzamiento:</label>
        <input type="date" name="fechaLanzamiento" required><br>
        <label>Fecha compra:</label>
        <input type="date" name="fechaCompra" required><br>
        <label>Precio:</label>
        <input type="number" name="precio" step="0.01" required><br>
        <input type="submit" value="Agregar disco">
    </form>

    <?php
    if (isset($_GET['mensaje'])) {
        if ($_GET['mensaje'] === 'ok') {
            echo "<p style='color:green;'>Album insertado correctamente.</p>";
        } elseif ($_GET['mensaje'] === 'error') {
            echo "<p style='color:red;'>Error al insertar el álbum.</p>";
        }
    }
    ?>
</section>

        </section>
    </body>
</html>