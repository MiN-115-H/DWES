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