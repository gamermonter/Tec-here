<?php
include("conexao.php");
$nome=$_POST["nome"];
$cpf=$_POST["cpf"];
$faceid=$_POST["faceid"];
$telefone=$_POST["telefone"];
$id=$_POST["id"];

switch($botao){
	case "Enviar":
		mysqli_query($conexao, "inset into aluno(nome,cpf,telefone) values('$nome', '$cpf','$telefone')");
		break;

		case "Exibir":
			$consulta=mysqli_query($conexao,"select * from aluno");
			echo "<h1>Dados de usuario</h1>";
			while($dados=mysqli_fetch_array($consulta)){
				echo $dados["id"]."<br>";
				echo $dados["nome"]."<br>";
				echo $dados["cpf"]."<br>";
				echo $dados["telefone"]."<br>";
				echo "<button onclick=windows.location.href='excluir.php?id=", $dados
			}
}
?>