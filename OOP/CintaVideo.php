<?php
require_once "Soporte.php";

class CintaVideo extends Soporte{
        public $duracion;

       public function __construct(string $titulo, int $numero, float $precio, int $duracion) {
        parent::__construct($titulo, $numero, $precio); 
        $this->duracion = $duracion;
    }

    public function muestraResumen() {
        echo "<br>";
        echo "Duración: " . $this->duracion . " minutos";
    }
    }
?>