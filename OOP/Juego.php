<?php
require_once "Soporte.php";

class Juego extends Soporte{
        public $consola;
        public $minNumJugadores;
        public $maxNumJugadores;

       public function __construct(string $titulo, int $numero, float $precio, string $consola, int $minNumJugadores ,int $maxNumJugadores) {
        parent::__construct($titulo, $numero, $precio); 
        $this->consola = $consola;
        $this->minNumJugadores = $minNumJugadores;
        $this->maxNumJugadores = $maxNumJugadores;
    }

    public function muestraResumen() {
        echo "<br>";
        echo "Juego para consola: " . $this->consola;
        echo "<br>";
        echo "Precio con IVA: " . $this->getPrecioConIva() . " €";
        echo "<br>";
        if($this->maxNumJugadores === 1 && $this->minNumJugadores === 1){
            echo "Para un jugador";
        }else{
            echo "Para minimo ".$this->minNumJugadores." y maximo ".$this->maxNumJugadores;
        }
        
    }
    }
?>