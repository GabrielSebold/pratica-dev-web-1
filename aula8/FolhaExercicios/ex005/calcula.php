<?php
    function calcularAreaTriangulo($base, $altura) {
        return ($base * $altura) / 2;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $base = $_POST["base"];
        $altura = $_POST["altura"];

        if ($base === "" || $altura === "" || !is_numeric($base) || !is_numeric($altura)) {
            echo "<p>Por favor, insira valores numéricos válidos.</p>";
        } elseif ($base <= 0 || $altura <= 0) {
            echo "<p>A base e a altura devem ser maiores que zero.</p>";
        } else {
            $area = calcularAreaTriangulo($base, $altura);
            echo "<p>A área do triângulo retângulo com base {$base} e altura {$altura} é {$area}.</p>";
        }
    }
?>