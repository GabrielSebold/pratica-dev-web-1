<?php
    require_once 'config.php';

    $conn = getConnection();

    if (!$conn) {
        echo "Erro seu pamonha";
    } else {
        echo "Ta jóia meu patrão";
    
        $result = pg_query($conn, "SELECT COUNT(*) AS QTDTABS FROM pg_tables");
        while ($row = pg_fetch_assoc($result)) {
            echo "<br>Quantidade de tabelas no banco de dados: " . $row['qtdtabs'];
        }

        $result = pg_query_params($conn, "INSERT INTO TBPESSOA (PESNOME, PESSOBRENOME, PESEMAIL, PESPASSWORD, PESCIDADE, PESESTADO) VALUES ($1, $2, $3, $4, $5, $6)", $aDados);

        if ($result) {
            echo "<br>Dados inseridos com sucesso!";
        } else {
            echo "<br>Erro ao inserir dados.";
        }
    }

?>