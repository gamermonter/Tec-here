<?php
// configurações do banco de dados
$servidor="localhost";
$usuario="root";
$senhabanco="";
$banco="techere";

// usando os dados
$conn=mysqli_connect($servidor,$usuario,$senhabanco,$banco);

if($conn->connect_errno){
    echo "Erro";
}

?>