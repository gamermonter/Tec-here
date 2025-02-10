<?php
include '../php/config.php';


$sql = "SELECT * FROM aluno";
$result = $conn->query($sql);


if ($result->num_rows > 0) { 
    // Caso existam alunos, cria a tabela com os dados
    echo "<table class='table table-striped table-bordered'>
        <thead>
            <tr>
                <th>Nome</th> <!-- Cabeçalho para o nome do aluno -->
                <th>Presença</th> <!-- Cabeçalho para o status de presença -->
            </tr>
        </thead>
        <tbody>";

    while ($row = $result->fetch_assoc()) { 
        // Verifica o status de presença do aluno
        $presenca = $row["presente"] ? "checked" : ""; // Marca o checkbox se o aluno estiver presente
        $disabled = $row["presente"] ? "disabled" : ""; // Desativa o checkbox se o aluno já foi marcado como presente

        // Exibe uma linha com o nome do aluno e o checkbox para presença
        echo "<tr>
            <td>" . $row["nome"] . "</td> <!-- Nome do aluno -->
            <td>
                <!-- Checkbox para marcar a presença -->
                <input type='checkbox' name='Presenca[" . $row["id"] . "]' id='Presenca_" . $row["id"] . "' $presenca $disabled>
            </td>
        </tr>";
    }

    echo "</tbody>
    </table>";
} else {
    echo "<p>Nenhum aluno encontrado.</p>";
}

$conn->close();
?>
