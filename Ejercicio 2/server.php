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
        <br>
        <table>
            <tr>
                <th></th>
                <th></th>
            </tr>
        <?php

        foreach($_SERVER as $servidor => $valor){
            echo "<tr>";
            echo "<td>$servidor</td>";
            echo "<td>$valor</td>";
            echo "</tr>";
        }
        ?>
        </table>
        </section>
        <footer>
            <?php include('footer.inc.php') ?>
        </footer>
    </body>
</html>