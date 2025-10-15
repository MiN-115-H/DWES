<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Tienda 2</title>  
    </head>
    <body>
        <section>
            <h2>Stock del producto en tiendas:</h2>
           <?php 
           $dwes = new mysqli('localhost', 'root', '', 'tienda');
            if ($dwes->connect_errno != null) {
                echo 'Error conectando a la base de datos: ';
                echo '$dwes->connect_error';
                exit();
            }
            $consulta = 'SELECT DISTINCT nombre FROM tienda';
                $resultado = $dwes->query($consulta);
                while($row = $resultado->fetch_object()){
                    echo 'Tienda '.$row->nombre. ' <input type="number" id='.$row->nombre.' style="width: 30px"> unidades.';
                    echo '<br>';
                    echo '<br>';
                }
 ?>
        </section>
    </body>
</html>