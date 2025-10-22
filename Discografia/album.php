<?php 
$id = $_GET['codigo'] ?? null;

if (!$id) {
    die("No se recibió ningún producto.");
}

$opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

      try {
          $dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);
      } catch (PDOException $e) {
          echo 'Falló la conexión: ' . $e->getMessage();
      }

$consulta = "SELECT * FROM album WHERE codigo = '$id'";
$resultado = $dwes->query($consulta);
while($album = $resultado->fetchObject()){
  echo"
  <h1>Informacion sobre el album</h1>
  <p>".$album->titulo."</p>
";
}
?>
