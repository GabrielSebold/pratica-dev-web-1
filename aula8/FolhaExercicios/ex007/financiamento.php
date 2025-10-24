<?php
$valorAVista = 22500.00;
$parcelas = 60;
$valorParcela = 489.65;

$totalFinanciamento = $parcelas * $valorParcela;

$juros = $totalFinanciamento - $valorAVista;

echo "Financiamento do Carro<br>";
echo "------------------------<br>";
echo "Valor do carro à vista: R$ " . number_format($valorAVista, 2, ',', '.') . "<br>";
echo "Número de parcelas: $parcelas x de R$ " . number_format($valorParcela, 2, ',', '.') . "<br>";
echo "Total pago no financiamento: R$ " . number_format($totalFinanciamento, 2, ',', '.') . "<br>";
echo "Valor gasto apenas com juros: R$ " . number_format($juros, 2, ',', '.') . "<br>";