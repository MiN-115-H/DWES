<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['operacion'])) {
    $tipo = $_POST['operacion'];
    $n1 = $_POST['n1'];
    $n2 = $_POST['n2'];

    class customException extends Exception {
        public function errorMessage() {
            return "El divisor no puede ser 0";
        }
    }

    function checkNumero($numero) {
        if (!is_numeric($numero)) {
            throw new Exception("Tienes que introducir un número.");
        }
        return true;
    }

    try {
        checkNumero($n1);
        checkNumero($n2);


        $n1 = (float)$n1;
        $n2 = (float)$n2;

        if ($tipo === 'suma') {
            $resultado = $n1 + $n2;
            echo "El resultado de $n1 + $n2 es: $resultado";
        } elseif ($tipo === 'division') {
            if ($n2 == 0) {
                throw new customException();
            }
            $resultado = $n1 / $n2;
            echo "El resultado de $n1 / $n2 es: $resultado";
        } else {
            echo "Operación no válida.";
        }

    } catch (customException $e) {
        echo $e->errorMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else {
    echo "No se recibieron datos.";
}
?>
