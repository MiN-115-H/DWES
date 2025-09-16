<!DOCTYPE html>
<html>
<footer>
    <p>Minda Huang</p>
    <?php
// Establecer la zona horaria por omisión
date_default_timezone_set('UTC');

    $dias["Monday"] = "Lunes";
    $dias["Tuesday"] = "Martes";
    $dias["Wednesday"] = "Miercoles";
    $dias["Thursday"] = "Jueves";
    $dias["Friday"] = "Viernes";
    $dias["Saturday"] = "Sabado";
    $dias["Sunday"] = "Domingo";

    $mes["January"] = "Enero";
    $mes["February"] = "Febrero";
    $mes["March"] = "Marzo";
    $mes["April"] = "Abril";
    $mes["May"] = "Mayo";
    $mes["June"] = "Junio";
    $mes["July"] = "Julio";
    $mes["August"] = "Agosto";
    $mes["September"] = "Septiembre";
    $mes["October"] = "Octubre";
    $mes["November"] = "Noviembre";
    $mes["December"] = "Diciembre";


echo ($dia = $dias[date("l")]) . date(" j") . " de " . ($m = $mes[date("F")]) . " de " . date("Y H:i:s");

?>
</footer>
</html>