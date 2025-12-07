<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pokemon</title>
	<link rel="stylesheet" type="text/css" href="examen.css?v=1">
</head>
<body>
 
<header> Mi blog de &nbsp;&nbsp; <img src="img/International_Pokémon_logo.svg.png"></header>

<div></div>

<nav><strong><nav>
<strong>
    <a href="?offset=9" style="text-decoration: none; color: inherit">G1 Kanto</a>
    <a href="?offset=160" style="text-decoration: none; color: inherit">G2 Johto</a>
    <a href="?offset=260" style="text-decoration: none; color: inherit">G3 Hoenn</a>
    <a href="?offset=395" style="text-decoration: none; color: inherit">G4 Sinnoh</a>
    <a href="?offset=503" style="text-decoration: none; color: inherit">G5 Unova</a>
    <a href="?offset=658" style="text-decoration: none; color: inherit">G6 Kalos</a>
    <a href="?offset=730" style="text-decoration: none; color: inherit">G7 Alola</a>
    <a href="?offset=818" style="text-decoration: none; color: inherit">G8 Galar</a>
    <a href="?offset=914" style="text-decoration: none; color: inherit">G9 Paldea</a>
</strong>
</nav>
</strong> </nav>

<h1 id="tituloIniciales">Iniciales</h1>

<div id="iniciales">

<br><br>
<?php

$region = "kanto"; 

if (isset($_GET["offset"])) {
    $o = intval($_GET["offset"]);

    if ($o >= 0 && $o < 151) $region = "kanto";
    else if ($o >= 151 && $o < 251) $region = "johto";
    else if ($o >= 251 && $o < 386) $region = "hoenn";
    else if ($o >= 386 && $o < 494) $region = "sinnoh";
    else if ($o >= 494 && $o < 649) $region = "unova";
    else if ($o >= 649 && $o < 721) $region = "kalos";
    else if ($o >= 721 && $o < 809) $region = "alola";
    else if ($o >= 809 && $o < 905) $region = "galar";
    else $region = "paldea";
}


$starter_lines = [
    "kanto" => [
        ["bulbasaur", "ivysaur", "venusaur"],
        ["charmander", "charmeleon", "charizard"],
        ["squirtle", "wartortle", "blastoise"]
    ],
    "johto" => [
        ["chikorita", "bayleef", "meganium"],
        ["cyndaquil", "quilava", "typhlosion"],
        ["totodile", "croconaw", "feraligatr"]
    ],
    "hoenn" => [
        ["treecko", "grovyle", "sceptile"],
        ["torchic", "combusken", "blaziken"],
        ["mudkip", "marshtomp", "swampert"]
    ],
    "sinnoh" => [
        ["turtwig", "grotle", "torterra"],
        ["chimchar", "monferno", "infernape"],
        ["piplup", "prinplup", "empoleon"]
    ],
    "unova" => [
        ["snivy", "servine", "serperior"],
        ["tepig", "pignite", "emboar"],
        ["oshawott", "dewott", "samurott"]
    ],
    "kalos" => [
        ["chespin", "quilladin", "chesnaught"],
        ["fennekin", "braixen", "delphox"],
        ["froakie", "frogadier", "greninja"]
    ],
    "alola" => [
        ["rowlet", "dartrix", "decidueye"],
        ["litten", "torracat", "incineroar"],
        ["popplio", "brionne", "primarina"]
    ],
    "galar" => [
        ["grookey", "thwackey", "rillaboom"],
        ["scorbunny", "raboot", "cinderace"],
        ["sobble", "drizzile", "inteleon"]
    ],
    "paldea" => [
        ["sprigatito", "floragato", "meowscarada"],
        ["fuecoco", "crocalor", "skeledirge"],
        ["quaxly", "quaxwell", "quaquaval"]
    ]
];

$starters = $starter_lines[$region];

echo "<table border='1' width='100%'><tr>";

foreach ($starters as $line) {

    foreach ($line as $pokeName) {

        $data = file_get_contents("https://pokeapi.co/api/v2/pokemon/$pokeName");
        $poke = json_decode($data);

        $id = $poke->id;

        echo "<td class='entrada'>";
        echo "<img src='{$poke->sprites->front_default}'><br>";
        echo "<a href='pokemon.php?id=$id' class='titulo' style='text-decoration: none; color: inherit; color: orange;
	    text-shadow: 1px 1px 2px black, 0 0 1em orange, 0 0 0.2em orange;'>" . ucfirst($pokeName) . "</a>";
        echo "</td>";
    }

    echo "</tr><tr>";
}

echo "</tr></table>";
?>
</div>


<?php
$limit = 21;

if (isset($_GET['offset'])) {
    $offset = intval($_GET['offset']);
} else {
    $offset = intval($offset) - 9;
}

$url = "https://pokeapi.co/api/v2/pokemon/?offset=$offset&limit=$limit";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$json_data = curl_exec($ch);
curl_close($ch);

$data = json_decode($json_data);

echo "<table border='1' cellspacing='10'><tr>";

$contador = 0;

foreach ($data->results as $pokemon) {

    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, $pokemon->url);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    $json_data2 = curl_exec($ch2);
    curl_close($ch2);

    $poke_data = json_decode($json_data2);

    $id = $poke_data->id;

    echo "<td class='entrada'>";
    echo "<img src='" . $poke_data->sprites->front_default . "' alt='imgPokemon'><br>";
    echo "<a href='pokemon.php?id=$id' class='titulo' style='text-decoration: none; color: inherit; color: orange;
	text-shadow: 1px 1px 2px black, 0 0 1em orange, 0 0 0.2em orange;'>" . ucfirst($pokemon->name) . "</a>";
    echo "</td>";

    $contador++;

    if ($contador % 3 == 0) {
        echo "</tr><tr>";
    }
}

echo "</tr></table>";


echo "<div id='paginador'>";
if ($data->previous) {
    $prevUrl = parse_url($data->previous);
    parse_str($prevUrl['query'], $prevParams);
    $prevOffset = $prevParams['offset'];
    echo "<a href='?offset=$prevOffset'>Anterior</a> ";
}

echo "&nbsp;&nbsp;";

if ($data->next) {
    $nextUrl = parse_url($data->next);
    parse_str($nextUrl['query'], $nextParams);
    $nextOffset = $nextParams['offset'];
    echo "<a href='?offset=$nextOffset'>Siguiente</a>";
}
echo "</div>";

?>
<div class="abajo"></div>

<footer> Trabajo &nbsp;<strong> Desarrollo Web en Entorno Servidor </strong>&nbsp; 2023/2024 IES Serra Perenxisa.</footer>

</body>
</html>