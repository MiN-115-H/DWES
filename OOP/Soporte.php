<?php
    class Soporte{
        public $titulo;
        public $numero;
        public $precio;

        public function __construct(String $titulo, int $numero, float $precio){
            $this->titulo = $titulo;
            $this->numero = $numero;
            $this->precio = $precio;

        }

        public function setTitulo(){
            $this->titulo = $titulo;
        }

        public function setPrecio(){
            $this->precio = $precio;
        }

        public function getPrecio(){
            return $this->precio;
        }

        public function getPrecioConIva(){
            return $this->precio * 0.21 + $this->precio;
        }

        public function getNumero(){
            return $this->numero;
        }

        public function muestraResumen(){
            echo "<br>";
            echo "Tenet";
            echo "<br>";
            echo  $this->precio."€ (IVA no incluido)";
        }
    }

?>