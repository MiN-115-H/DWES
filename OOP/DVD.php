<?php
require_once "Soporte.php";

class DVD extends Soporte{
        public $idiomas;
        public $formatPantalla;

       public function __construct(string $titulo, int $numero, float $precio, string $idiomas, string $formatPantalla) {
        parent::__construct($titulo, $numero, $precio); 
        $this->idiomas = $idiomas;
        $this->formatPantalla = $formatPantalla;
    }

    public function muestraResumen() {
        parent::muestraResumen();
        echo "<br>";
        echo "Duración: " . $this->duracion . " minutos";
    }
    }
?>