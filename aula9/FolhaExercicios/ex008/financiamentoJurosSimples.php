<?php
$valorAVista = 8654.00;

$parcelas = [24, 36, 48, 60];

$taxaInicial = 0.015;
$incremento = 0.005;

echo "Cálculo das parcelas com juros simples<br><br>";

foreach ($parcelas as $index => $n) {
    $taxa = $taxaInicial + ($incremento * $index);

    $juros = $valorAVista * $taxa * $n;

    $valorParcela = ($valorAVista + $juros) / $n;

    echo "Parcelas: $n vezes<br>";
    echo "Taxa de juros: " . ($taxa * 100) . "%<br>";
    echo "Valor de cada parcela: R$ " . number_format($valorParcela, 2, ',', '.') . "<br>";
    echo "-----------------------------<br>";
}
