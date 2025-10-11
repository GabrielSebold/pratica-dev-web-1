<?php
$notas = [10, 8, 5];
$faltas = [0, 0, 1, 0, 0, 0];

function CalculaMedia($notas) {
    $soma = array_sum($notas);
    return $soma / count($notas);
}

function frequencia($faltas) {
    $totalAulas = count($faltas);
    $presencas = 0;

    foreach ($faltas as $falta) {
        if ($falta == 0) {
            $presencas++;
        }
    }

    return ($presencas / $totalAulas) * 100;
}

function AvaliaAluno($notas, $faltas) {
    $nota = CalculaMedia($notas);
    $frequencia = frequencia($faltas);

    if ($nota < 7) {
        return "Reprovado por Nota: $nota";
    }

    if ($frequencia < 70) {
        return "Reprovado por Frequência: $frequencia%";
    }

    return "Aprovado com Nota: $nota e Frequência: $frequencia%";
}

$teste = AvaliaAluno($notas, $faltas);
echo $teste;
?>
