<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Perfil de desarrollador</title>  
    </head>
    <body>
        <?php include __DIR__ ."/../Ejercicio 2/cabecera.inc.php"; ?>
        <header>
        <h2>Tecnologías.</h2>
        <h3>En esta página encontraras una lista de tecnologias que uso para desarrollas webs.</h3>
        </header>

        <section>
        <ul>
            <li>HTML</li>
            <li>CSS</li>
            <li>JavaScript</li>
            <li>PHP</li>
        </ul>
        </section>

        <br>
       
        <a href="principal.php">Atrás</a>
        <?php
        include "Soporte.php";
        
        echo "<br>";

        $soporte1 = new Soporte("Tenet", 22, 3);
        echo "<br>";
        echo "<strong>" . $soporte1->titulo . "</strong>";
        echo "<br>Precio: " . $soporte1->getPrecio() . " euros";
        echo "<br>Precio IVA incluido: " . $soporte1->getPrecioConIVA() . " euros";
        $soporte1->muestraResumen();

        echo "<br>";
        echo "<br>";

        include "CintaVideo.php";

        $miCinta = new CintaVideo("Los cazafantasmas", 23, 3.5, 107);
        echo "<strong>" . $miCinta->titulo . "</strong>";
        echo "<br>Precio: " . $miCinta->getPrecio() . " euros";
        echo "<br>Precio IVA incluido: " . $miCinta->getPrecioConIva() . " euros";
        $miCinta->muestraResumen();

        echo "<br>";
        echo "<br>";

        include "Juego.php";
        $miJuego = new Juego("The Last of Us Part II", 26, 49.99, "PS4", 1, 1);
        echo "<strong>" . $miJuego->titulo . "</strong>";
        echo "<br>Precio: " . $miJuego->getPrecio() . " euros";
        echo "<br>Precio IVA incluido: " . $miJuego->getPrecioConIva() . " euros";
        $miJuego->muestraResumen();
        ?>
        <footer>
            <?php include __DIR__ ."/../Ejercicio 2/footer.inc.php"; ?>
        </footer>
    </body>
</html>