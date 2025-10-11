<?php
session_start();

if (!isset($_SESSION['username'])){
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['sessionStart'] = date("d/m/Y H:i:m");
    $_SESSION['lastRequest'] = date("d/m/Y H:i:m");
    
    echo "Usario " . $_SESSION['username'] . " Logado";
} else {
    $_SESSION['lastRequest'] = date("d/m/Y H:i:m");
    echo "Usario " . $_SESSION['username'] . " já estava Logado";
}

$tempoAtivo = strtotime($_SESSION['lastRequest']) - strtotime($_SESSION['sessionStart']);

if ($tempoAtivo < 2000) {
    $horas = floor($tempoAtivo / 3600);
    $minutos = floor(($tempoAtivo % 3600) / 60);
    $segundos = $tempoAtivo % 60;    
    echo '<br>';
    echo $_SESSION['username'];
    echo '<br>';
    echo $_SESSION['sessionStart'];
    echo '<br>';
    echo $_SESSION['lastRequest'];
    echo '<br>';
    echo "Tempo Ativo = {$horas}h {$minutos}m {$segundos}s";
} else {
    session_destroy();
    echo 'Sessão expirada, favor logar de novo<br>';
    echo "<a href='pratica1_index.html'>Recarregar</a>";
}
?>