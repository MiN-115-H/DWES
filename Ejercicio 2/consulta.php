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
        <?php
            echo $_POST['nom'].' '.$_POST['ap']." pregunta:";
            echo "<br>";
            echo $_POST['pregunta'];
        ?>
        </section>
        <footer>
            <?php include('footer.inc.php') ?>
        </footer>
    </body>
</html>