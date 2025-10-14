<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Perfil de desarrollador</title>  
    </head>
    <body>
        <section>
           <?php 
           $dwes = new mysqli('localhost', 'root', '', 'tienda');
            if ($dwes->connect_errno != null) {
                echo 'Error conectando a la base de datos: ';
                echo '$dwes->connect_error';
                exit();
            }
            $consulta = 'SELECT DISTINCT cod, nombre_corto, pvp FROM producto';
                $resultado = $dwes->query($consulta);
                while ($stock = $resultado->fetch_object()) {
                echo '<a href ="stock.php?producto='. $stock->cod . '"> '. $stock->nombre_corto . " " . $stock->pvp. '€ </a>';
                echo '<br>';
                }
 ?>
        </section>
    </body>
</html>