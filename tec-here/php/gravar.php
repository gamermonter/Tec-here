<?php
include("../php/conexao.php");

$email=$_POST["email"];
$cpf=$_POST["cpf"];
$senha=$_POST["senha"];
$nome=$_POST["nome"];

mysqli_query($conexao,"UPDATE aluno SET nome=$nome '");
echo "<button onclick=window.location.href=>Voltar</a><br>";

?>