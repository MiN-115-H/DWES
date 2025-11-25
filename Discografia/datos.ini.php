<?php

function formularioDisco() {

    echo '<button onclick=location.href="./index.php">Volver</button>';
    echo '<h1>Crear nuevo disco</h1>';
    echo '<form action="disconuevo.php" method="post">';
    echo '<input type="text" required name="titulo" placeholder="Título"/>';
    echo '<input type="text" required name="discografica" placeholder="Discográfica"/>';
    echo '<label>Formato: </label>';
    echo '<select name="formato">
            <option>vinilo</option>
            <option>cd</option>
            <option>dvd</option>
            <option>mp3</option>
        </select>';
    echo '<label>Fecha lanzamiento: </label>';
    echo '<input type="date" name="fechaLanzamiento"/>';
    echo '<label>Fecha compra: </label>';
    echo '<input type="date" name="fechaCompra"/>';
    echo '<input type="number" step="0.01" min=0 value=0 name="precio" placeholder="Precio"/>';
    echo '<input id="reg-mod" type="submit" value="Registrar"/>';
    echo '</form>';
    
    if(isset($_POST["titulo"])){

        $conectar = new Conexion('localhost','discografia','discografia','discografia');
        $conexion = $conectar->conectionPDO();

        $album = new Album(
            '',
            $_POST['titulo'],
            $_POST['discografica'],
            $_POST['formato'],
            $_POST['fechaLanzamiento'],
            $_POST['fechaCompra'],
            $_POST['precio']
        );

        $album->registrarDisco($conexion);
    }
}


function formularioCancion($cancion){

    echo '<button onclick=location.href="./index.php">Volver</button>';
    echo '<h1>Crear nueva canción</h1>';

    echo '<form action="cancionnueva.php?codigo='.$cancion->getAlbum().'&titulo='.$cancion->getTitulo().'" method="post">';
    echo '<input type="text" required name="titulo" placeholder="Título" />';
    echo '<label>Álbum: </label>';
    echo '<input type="text" required name="album" value="'.$cancion->getTitulo().'" readonly />';
    echo '<label>Posición: </label>';
    echo '<input type="number" min=0 name="posicion" value=0 />';
    echo '<label>Duración: </label>';
    echo '<input type="time" name="duracion" step="1"/>';
    echo '<label>Género: </label>';
    echo '<select name="genero">
            <option>Acustica</option>
            <option>BSO</option>
            <option>Blues</option>
            <option>Folk</option>
            <option>Jazz</option>
            <option>New age</option>
            <option>Pop</option>
            <option>Rock</option>
            <option>Electronica</option>
        </select>';
    echo '<input id="reg-mod" type="submit" value="Registrar"/>';
    echo '</form>';

    if(isset($_POST["titulo"])){

        $conectar = new Conexion('localhost','discografia','discografia','discografia');
        $conexion = $conectar->conectionPDO();

        $c = new Cancion(
            $_POST['titulo'],
            $cancion->getAlbum(),
            $_POST['posicion'],
            $_POST['duracion'],
            $_POST['genero']
        );

        $c->registrarCancion($conexion);
    }
}



function formularioBuscarCancion(){

    echo '<button onclick=location.href="./index.php">Volver</button>';
    echo '<h1>Búsqueda de canciones</h1>';

    echo '<form action="canciones.php" method="post">';
    echo 'Texto a buscar: ';
    echo '<input type="text" required name="textoBuscar"/>';

    echo '<div>Buscar en: 
            <input type="radio" id="tc" name="select" checked value="cancion.titulo"/>
            <label for="tc">Títulos canción </label>

            <input type="radio" id="na" name="select" value="album.titulo"/>
            <label for="na">Nombres álbum </label>

            <input type="radio" id="ca" name="select" value="cancion.titulo OR album.titulo"/>
            <label for="ca">Ambos campos </label>
        </div>';

    echo '<div>Género musical: 
            <select name="genero">
                <option>Acustica</option>
                <option>BSO</option>
                <option>Blues</option>
                <option>Folk</option>
                <option>Jazz</option>
                <option>New age</option>
                <option>Pop</option>
                <option>Rock</option>
                <option>Electronica</option>
            </select>
        </div>';

    echo '<input id="reg-mod" type="submit" value="Buscar"/>';
    echo '</form>';

    if(isset($_POST["textoBuscar"])){

        datosBuscados(
            $_POST['textoBuscar'],
            $_POST['select'],
            $_POST['genero']
        );
    }
}



function datosDiscografia(){

    $conectar = new Conexion('localhost','discografia','discografia','discografia');
    $conexion = $conectar->conectionPDO();

    $resultado = $conexion->query('
        SELECT codigo, titulo, discografica, formato, fechaLanzamiento, fechaCompra, precio
        FROM album;
    ');

    echo '<button onclick=location.href="./disconuevo.php">Nuevo disco</button>';
    echo '<button onclick=location.href="./canciones.php">Buscar canciones</button>';

    echo '<table>
            <tr>
                <th>Título</th>
                <th>Discográfica</th>
                <th>Formato</th>
                <th>Fecha Lanzamiento</th>
                <th>Fecha Compra</th>
                <th>Precio</th>
            </tr>';

    while ($registro = $resultado->fetch()) {

        $album = new Album(
            $registro['codigo'],
            $registro['titulo'],
            $registro['discografica'],
            $registro['formato'],
            $registro['fechaLanzamiento'],
            $registro['fechaCompra'],
            $registro['precio']
        );

        echo '<tr>';
        echo '<td><a href="disco.php?codigo='.$album->getCod().'">'.$album->getTitulo().'</a></td>';
        echo '<td>'.$album->getDiscografia().'</td>';
        echo '<td>'.$album->getFormato().'</td>';
        echo '<td>'.$album->getFechaL().'</td>';
        echo '<td>'.$album->getFechaC().'</td>';
        echo '<td>'.$album->getPrecio().'</td>';
        echo '<th><button onclick=location.href="./cancionnueva.php?codigo='.$registro['codigo'].'&titulo='.$registro['titulo'].'">Canción Nueva</button></th>';
        echo '</tr>';
    }

    echo '</table>';
}



function datosDisco($album){

    $conectar = new Conexion('localhost','discografia','discografia','discografia');
    $conexion = $conectar->conectionPDO();

    // Número de canciones del álbum
    $resultado = $conexion->query('
        SELECT COUNT(*) AS totalCanciones 
        FROM cancion 
        WHERE album = '.$album->getCod().';
    ');

    $TC = $resultado->fetch()['totalCanciones'];

    // Datos del álbum
    $resultado = $conexion->query('
        SELECT * 
        FROM album 
        WHERE codigo = '.$album->getCod().';
    ');

    echo '<button onclick=location.href="./index.php">Volver</button>';
    echo '<h1>DATOS DEL DISCO</h1>';

    echo '<table>
            <tr>
                <th>Código</th>
                <th>Título</th>
                <th>Discográfica</th>
                <th>Formato</th>
                <th>Fecha Lanzamiento</th>
                <th>Fecha Compra</th>
                <th>Precio</th>
            </tr>';

    while ($registro = $resultado->fetch()) {

        $listaAlbum = new Album(
            $registro['codigo'],
            $registro['titulo'],
            $registro['discografica'],
            $registro['formato'],
            $registro['fechaLanzamiento'],
            $registro['fechaCompra'],
            $registro['precio']
        );

        echo '<tr>';
        echo '<td>'.$listaAlbum->getCod().'</td>';
        echo '<td>'.$listaAlbum->getTitulo().'</td>';
        echo '<td>'.$listaAlbum->getDiscografia().'</td>';
        echo '<td>'.$listaAlbum->getFormato().'</td>';
        echo '<td>'.$listaAlbum->getFechaL().'</td>';
        echo '<td>'.$listaAlbum->getFechaC().'</td>';
        echo '<td>'.$listaAlbum->getPrecio().'</td>';
        echo '<th><button onclick=location.href="./borrardisco.php?codigo='.$listaAlbum->getCod().'&TC='.$TC.'">Borrar disco</button></th>';
        echo '</tr>';
    }

    echo '</table>';

    datosCancion($album->getCod());
}



function datosCancion($codigo){

    $conectar = new Conexion('localhost','discografia','discografia','discografia');
    $conexion = $conectar->conectionPDO();

    $resultado = $conexion->query('
        SELECT * 
        FROM cancion 
        WHERE album = '.$codigo.';
    ');

    echo '<h3>CANCIONES DEL DISCO</h3>';

    echo '<table>
            <tr>
                <th>Título</th>
                <th>Álbum</th>
                <th>Posición</th>
                <th>Duración</th>
                <th>Género</th>
            </tr>';

    while ($registro = $resultado->fetch()) {

        $listaCanciones = new Cancion(
            $registro['titulo'],
            $registro['album'],
            $registro['posicion'],
            $registro['duracion'],
            $registro['genero']
        );

        echo '<tr>';
        echo '<td>'.$listaCanciones->getTitulo().'</td>';
        echo '<td>'.$listaCanciones->getAlbum().'</td>';
        echo '<td>'.$listaCanciones->getPosicion().'</td>';
        echo '<td>'.$listaCanciones->getDuracion().'</td>';
        echo '<td>'.$listaCanciones->getGenero().'</td>';
        echo '</tr>';
    }

    echo '</table>';
}



function datosBuscados($textoBuscar, $select, $genero){

    $conectar = new Conexion('localhost','discografia','discografia','discografia');
    $conexion = $conectar->conectionPDO();

    // Ajuste para los radio de búsqueda
    if ($select == "cancion.titulo OR album.titulo") {
        $cond = '(cancion.titulo LIKE "%'.$textoBuscar.'%" OR album.titulo LIKE "%'.$textoBuscar.'%")';
    } else {
        $cond = $select.' LIKE "%'.$textoBuscar.'%"';
    }

    // Comprobar resultados
    $resultado1 = $conexion->query('
        SELECT COUNT(*) AS cont
        FROM cancion
        JOIN album ON album.codigo = cancion.album
        WHERE cancion.genero = "'.$genero.'" AND '.$cond.';
    ');

    $contar = $resultado1->fetch();

    if ($contar['cont'] > 0) {

        $resultado2 = $conexion->query('
            SELECT cancion.titulo AS titulo, album.titulo AS album,
                   cancion.posicion, cancion.duracion, cancion.genero
            FROM cancion
            JOIN album ON album.codigo = cancion.album
            WHERE cancion.genero = "'.$genero.'"
            AND '.$cond.';
        ');

        echo '<table>
                <tr>
                    <th>Título</th>
                    <th>Álbum</th>
                    <th>Posición</th>
                    <th>Duración</th>
                    <th>Género</th>
                </tr>';

        while ($registro = $resultado2->fetch()) {

            echo '<tr>';
            echo '<td>'.$registro['titulo'].'</td>';
            echo '<td>'.$registro['album'].'</td>';
            echo '<td>'.$registro['posicion'].'</td>';
            echo '<td>'.$registro['duracion'].'</td>';
            echo '<td>'.$registro['genero'].'</td>';
            echo '</tr>';
        }

        echo '</table>';

    } else {

        echo '<h1>NO SE ENCONTRARON RESULTADOS!</h1>';
    }
}

?>
