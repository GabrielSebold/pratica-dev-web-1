<?php
    function ehDivisivelPorDois($num) {
        return $num % 2 == 0;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $numero = $_POST["numero"];

        if (ehDivisivelPorDois($numero)) {
            echo "<p>Valor divisível por 2</p>";
        } else {
            echo "<p>O valor não é divisível por 2</p>";
        }
    }
?>