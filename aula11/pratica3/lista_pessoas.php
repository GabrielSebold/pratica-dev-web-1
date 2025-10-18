<?php
    require_once 'config.php';

    $conn = getConnection();

    if (!$conn) {
        echo "Erro ao conectar ao banco de dados.";
    } else {
        $result = pg_query($conn, "SELECT * FROM TBPESSOA");

        if ($result) {
            echo "<h2>Lista de Pessoas Cadastradas</h2>";
            echo "<table border='1'>
                    <tr>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>Email</th>
                        <th>Cidade</th>
                        <th>Estado</th>
                    </tr>";

            while ($row = pg_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['pesnome']}</td>
                        <td>{$row['pessobrenome']}</td>
                        <td>{$row['pesemail']}</td>
                        <td>{$row['pescidade']}</td>
                        <td>{$row['pesestado']}</td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "Erro ao recuperar dados.";
        }
    }