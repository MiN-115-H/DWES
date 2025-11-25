<?php
    echo "<h1>Libros</h1>";
    echo "<br>";

    $xml=simplexml_load_file("books.xml");
    foreach($xml->children() as $books){
        echo "<em>Titulo: " . $books->title . "</em>";
        echo "<br>";
        foreach($books->author as $author){
            echo "Autor: " . $author;
            echo "<br>";
        }
        echo "Año de publicación: " . $books->year;
        echo "<br>";
        echo "Precio:" . $books->price . "€";
        echo "<br>";
        echo "<br>";

    }
?>