<?php
    function somaValores($v1, $v2, $v3) {
        return $v1 + $v2 + $v3;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $v1 = $_POST["valor1"];
        $v2 = $_POST["valor2"];
        $v3 = $_POST["valor3"];

        $soma = somaValores($v1, $v2, $v3);
        $cor = "black";

        if ($v1 > 10) {
            $cor = "blue";
        } elseif ($v2 < $v3) {
            $cor = "green";
        } elseif ($v3 < $v1 && $v3 < $v2) {
            $cor = "red";
        }

        echo "<p style='color: $cor;'>Resultado da soma: $soma</p>";
    }
?>