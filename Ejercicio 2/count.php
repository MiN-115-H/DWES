<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Perfil de desarrollador</title>  
    </head>
    <body>
        <?php include('cabecera.inc.php') ?>
        <section>
        <br>
        <a href="rrss.php">Mis redes sociales.</a>
        <br>
        <a href="tecnologias.php">Las tecnologias que utilizo.</a>
        <br>
        <?php
            for($a = 0; $a <= 30 ; $a++){
                echo $a ;
                echo "<br>";
            } 

            $num = 5;
            $resultado = 1;
            for($i = 1; $i <= $num; $i++){
                echo $resultado . "x" . $i . " = ";
                echo $resultado *= $i;
                echo "<br>";
            }
        ?>
        </section>
        <footer>
            <?php include('footer.inc.php') ?>
        </footer>
    </body>
</html>