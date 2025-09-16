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
                <form action="#" method="get">
                    Tipo de pregunta:
                    <select name="tp">
                        <option value="sobremi">Sobre mi</option>
                        <option value="sobretecnologia">Sobre las tecnologias</option>
                        <option value="sobreredes">Sobre las RRSS</option>
                    </select>
                    <br>
                    <fieldset>
                    <legend>Datos personales</legend>
                    Nombre: <input type="text" name="nom">
                    <br>
                    Apellidos: <input type="text" name="ap">
                    <br>
                    email: <input type="text" name="email">
                    </fieldset>
                    <br>
                    <form action="#" method="get">
                    Introduce tu pregunta:
                    <br>
                    <textarea name="pregunta"></textarea>
                    <br>
                    <input type="reset" value="Borrar formulario">
                    <br>
                    <input type="submit" value="Enviar formulario">
                </form>  
        </section>
        <footer>
            <?php include('footer.inc.php') ?>
        </footer>
    </body>
</html>