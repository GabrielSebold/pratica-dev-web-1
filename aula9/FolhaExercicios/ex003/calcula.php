
<?php
    function calcularAreaQuadrado($lado) {
        return $lado * $lado;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $lado = $_POST["lado"];

        if ($lado === "" || !is_numeric($lado)) {
            echo "<p>Por favor, insira um valor numérico válido.</p>";
        } elseif ($lado == 0) {
            echo "<p>O lado não pode ser zero. Informe um valor maior que zero.</p>";
        } elseif ($lado < 0) {
            echo "<p>O lado não pode ser negativo.</p>";
        } else {
            $area = calcularAreaQuadrado($lado);
            echo "<p>A área do quadrado com lados de {$lado} metros tem {$area} metros quadrados.</p>";
        }
    }
?>