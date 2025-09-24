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
        <form action="" method="post">
                <fieldset>
                    <legend>Datos </legend>
                    Nombre: <input type="text" name="nom" id="nom" required>
                    <br>
                    Apellidos: <input type="text" name="ap" id="ap" required>
                    <br>
                    Nombre de usuario: <input type="text" name="user" id="user" required>
                    <br>
                    email: <input type="email" name="email" id="email" required>
                    <br>
                    Fecha de nacimiento: <input type="date" name="fnac" id="fnac" required>
                    <br>
                    Genero: <select name="genero" id="genero" required>
                                <option value="hombre">Hombre</option>
                                <option value="mujer">Mujer</option>
                            </select>
                    <br>
                    Contraseña: <input type="password" name="passwd" id="passwd" required>
                    <br>
                    Confirme la contraseña: <input type="password" name="passwd2" id="passwd2" required>
                    <br>
                    <input type="checkbox" name="conditions" id="conditions" required>
                    <label for="conditions">Acepto las condiciones</label>
                    <input type="checkbox" name="ads" id="ads">
                    <label for="conditions">Acepto recibir publicidad</label>
                    <br>
                    <input type="submit" value="Enviar">
                </fieldset>
                </form>  
        <?php

        $valido = true;
        $error = '';
        if ($_SERVER["REQUEST_METHOD"] === "POST") { 
            if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $error = "Correo inválido";
                $valido = false;
        }

            if (!isset($_POST['passwd'], $_POST['passwd2']) || $_POST['passwd'] !== $_POST['passwd2']) {
                $error = "Las contraseñas no coinciden, inténtalo de nuevo";
                $valido = false;
            }

            if ($valido) {
                echo "<p>Registro correcto</p>";
            } else {
                echo "<p>$error</p>";
            }
        }

        ?>

        </section>
        <footer>
            <?php include('footer.inc.php') ?>
        </footer>
    </body>
</html>