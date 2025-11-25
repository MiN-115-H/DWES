<?php

    $string = 'marvel_characters.json';
    
    $json = file_get_contents($string);

    $data = json_decode($json);
    
    foreach($data as $nombre){
        echo "<strong>Nombre superheroe: </strong>".$nombre->name;
        echo "<br>";
        echo "<strong>Comics en los que aparece:</strong>";
        echo "<br>";
        foreach($nombre->comics->items as $comic){
            echo $comic->name;
            echo "<br>";
        };
        echo "<br>";
    };
    
?>