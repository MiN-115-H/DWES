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
    <a href="index.php?offset=9" style="text-decoration: none; color: inherit">G1 Kanto</a>
    <a href="index.php?offset=160" style="text-decoration: none; color: inherit">G2 Johto</a>
    <a href="index.php?offset=260" style="text-decoration: none; color: inherit">G3 Hoenn</a>
    <a href="index.php?offset=395" style="text-decoration: none; color: inherit">G4 Sinnoh</a>
    <a href="index.php?offset=503" style="text-decoration: none; color: inherit">G5 Unova</a>
    <a href="index.php?offset=658" style="text-decoration: none; color: inherit">G6 Kalos</a>
    <a href="index.php?offset=730" style="text-decoration: none; color: inherit">G7 Alola</a>
    <a href="index.php?offset=818" style="text-decoration: none; color: inherit">G8 Galar</a>
    <a href="index.php?offset=914" style="text-decoration: none; color: inherit">G9 Paldea</a>
</strong>
</nav>
</strong> </nav>

<?php
if(isset($_GET['id'])){
    $id = intval($_GET["id"]);
    $data = file_get_contents("https://pokeapi.co/api/v2/pokemon/$id");
    $pokemon = json_decode($data);
}else{
    echo "No se ha recibido ningún Pokemon";
    exit;
}

echo "<div id='pokemon'>";

echo "<img id='pokemonImg' src='". $pokemon->sprites->front_default . "' alt='pokemonImg'>";

echo "<div class='info'>";
echo "<h1>". ucfirst($pokemon->name) ."</h1>";
echo "<p>Indice en la Pokédex: " .$pokemon->id . "</p>";
echo "<p>Peso: ". $pokemon->weight ."</p>";
echo "<p>Altura: ". $pokemon->height ."</p>";
echo "</div>";

echo "</div>";


?>
<div class="abajo"></div>

<footer> Trabajo &nbsp;<strong> Desarrollo Web en Entorno Servidor </strong>&nbsp; 2023/2024 IES Serra Perenxisa.</footer>

</body>
</html>