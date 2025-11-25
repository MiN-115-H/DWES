<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pokemon</title>
	<link rel="stylesheet" type="text/css" href="examen.css">
</head>
<body>
 
<header> Mi blog de &nbsp;&nbsp; <img src="img/International_Pokémon_logo.svg.png"></header>

<div></div>

<nav><strong>G1 Kanto &nbsp;&nbsp; G2 Johto &nbsp;&nbsp; G3 Hoenn  &nbsp;&nbsp; G4 Sinnoh  &nbsp;&nbsp; G5 Unova  &nbsp;&nbsp; G6 Kalos  &nbsp;&nbsp; G7 Alola &nbsp;&nbsp; G8 Galar &nbsp;&nbsp; G9 Paldea &nbsp;&nbsp; Búsqueda</strong> </nav>

<div id="iniciales">

<?php
$ch = curl_init();
$url = "https://pokeapi.co/api/v2/pokemon/";
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$json_data = curl_exec($ch);
curl_close($ch);

$data = json_decode($json_data);

echo "<table border='1' cellspacing='10'><tr>";

$contador = 0;

foreach ($data->results as $pokemon) {
    
    // Obtener datos individuales
    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, $pokemon->url);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    $json_data2 = curl_exec($ch2);
    curl_close($ch2);

    $poke_data = json_decode($json_data2);

    echo "<td style='text-align:center; padding:10px;'>";
    echo "<img src='" . $poke_data->sprites->front_default . "' alt='imgPokemon'><br>";
    echo "<p>" . $pokemon->name . "</p>";
    echo "</td>";

    $contador++;

    if ($contador % 6 == 0) {
        echo "</tr><tr>";
    }
}

echo "</tr></table>";
?>


</div>


<div class="abajo"></div>

<footer> Trabajo &nbsp;<strong> Desarrollo Web en Entorno Servidor </strong>&nbsp; 2023/2024 IES Serra Perenxisa.</footer>

</body>
</html>