
<?php
    function calcularAreaRetangulo($a, $b) {
        return $a * $b;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $a = $_POST["ladoA"];
        $b = $_POST["ladoB"];

        if ($a === "" || $b === "" || !is_numeric($a) || !is_numeric($b)) {
            echo "<p>Por favor, insira valores numéricos válidos.</p>";
        } elseif ($a <= 0 || $b <= 0) {
            echo "<p>Os lados devem ser maiores que zero.</p>";
        } else {
            $area = calcularAreaRetangulo($a, $b);
            $mensagem = "A área do retângulo com lados de {$a} e {$b} metros tem {$area} metros quadrados.";

            if ($area > 10) {
                echo "<h1>$mensagem</h1>";
            } else {
                echo "<h3>$mensagem</h3>";
            }
        }
    }
?>