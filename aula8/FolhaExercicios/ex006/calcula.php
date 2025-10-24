<?php
$produtos = ["Maçã", "Melancia", "Laranja", "Repolho", "Cenoura", "Batatinha"];
$dinheiroDisponivel = 50.0;

$precos = $_POST['preco'] ?? [];
$quantidades = $_POST['quantidade'] ?? [];
$totalCompra = 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado da Compra</title>
</head>
<body>
    <h1>Resumo da Compra</h1>
    <ul>
        <?php foreach ($produtos as $index => $produto): 
            $subtotal = $precos[$index] * $quantidades[$index];
            $totalCompra += $subtotal;
        ?>
            <li><?= $produto ?>: R$ <?= number_format($subtotal, 2, ',', '.') ?></li>
        <?php endforeach; ?>
    </ul>

    <h3>Total da compra: R$ <?= number_format($totalCompra, 2, ',', '.') ?></h3>

    <?php
    if ($totalCompra > $dinheiroDisponivel) {
        $faltou = $totalCompra - $dinheiroDisponivel;
        echo "<p style='color:red; font-weight:bold;'>Faltaram R$ " . number_format($faltou, 2, ',', '.') . " para pagar a compra.</p>";
    } elseif ($totalCompra < $dinheiroDisponivel) {
        $sobrou = $dinheiroDisponivel - $totalCompra;
        echo "<p style='color:blue; font-weight:bold;'>Sobrou R$ " . number_format($sobrou, 2, ',', '.') . " que Joãozinho ainda poderia gastar.</p>";
    } else {
        echo "<p style='color:green; font-weight:bold;'>O saldo para compras foi esgotado. Joãozinho gastou exatamente R$ 50,00.</p>";
    }
    ?>
    <br>
</body>
</html>
