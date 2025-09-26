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
        <section>
            <Fieldset>
                <legend>Calculadora</legend>
                <form action="calculadora.php" method="post">
                    <select name="operacion">
                    <option value="suma">Suma</option>
                    <option value="division">Division</option>
                    </select>
                    <br>
                    Numero 1: <input type="text" name="n1" id="n1"><br>
                    Numero 2: <input type="text" name="n2" id="n2"><br>
                    <input type="submit" value="Calcular">
                </form>
            </Fieldset>
        </section>
        <footer>
            <?php include('footer.inc.php') ?>
        </footer>
    </body>
</html>