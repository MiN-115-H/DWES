<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Discografia</title>  
    </head>
    <body>
        <h1>Álbumes</h1>
        <section>
           <?php
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Pragma: no-cache");

            //Verificar sesión
            if (!isset($_SESSION['usuario'])) {
                header("Location: login.php");
                exit;
            }
            $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
            $dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);

            $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
                try {
            $dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);
                } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
                }

            include('album.php');
?>
        </section>
    </body>
</html>