<?php 

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $data = $_POST['data'];
    $senha = $_POST['senha'];
    $foto = $_POST['foto'];

    $sql = "INSERT INTO aluno (nome, email, cpf, data, senha, foto) Values ('$nome','$email','$cpf','$data','$senha', '$foto')";

    if ($conn ->query($sql) === TRUE) {
        echo "<p>conectado</p>";
    }
    else{
        echo "erro: " . $sql . "<br>" . $conn->error; 
    }

    $conn->close();
    header('Location: ../templates/index.html'); 
}
?>