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
                <form action="consulta.php" method="post">
                    Tipo de pregunta:
                    <select name="tp">
                        <option value="sobremi">Sobre mi</option>
                        <option value="sobretecnologia">Sobre las tecnologias</option>
                        <option value="sobreredes">Sobre las RRSS</option>
                    </select>
                    <br>
                    <fieldset>
                    <legend>Datos personales</legend>
                    Nombre: <input type="text" name="nom" id="nom">
                    <br>
                    Apellidos: <input type="text" name="ap" id="ap">
                    <br>
                    email: <input type="text" name="email">
                    </fieldset>
                    <br>
                    Introduce tu pregunta:
                    <br>
                    <input type="text" name="pregunta" id="pregunta">
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