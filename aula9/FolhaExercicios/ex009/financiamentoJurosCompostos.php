<?php
$valorAVista = 8654.00;

$parcelas = [24, 36, 48, 60];

$taxaInicial = 0.02;
$incremento = 0.003;

echo "Cálculo das parcelas com juros compostos<br><br>";

foreach ($parcelas as $index => $n) {
    $taxa = $taxaInicial + ($incremento * $index);

    $montante = $valorAVista * pow(1 + $taxa, $n);

    $valorParcela = $montante / $n;

    echo "Parcelas: $n vezes<br>";
    echo "Taxa de juros: " . ($taxa * 100) . "%<br>";
    echo "Valor de cada parcela: R$ " . number_format($valorParcela, 2, ',', '.') . "<br>";
    echo "Montante total pago: R$ " . number_format($montante, 2, ',', '.') . "<br>";
    echo "-----------------------------<br>";
}
