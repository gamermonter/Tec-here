<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chamada de Presença</title>
    <link rel="stylesheet" href="../css/chamada.css"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="container">
            <nav>
                <a href="index.html">
                    <img src="../img/LOGO.png" alt="Logo" class="img_logo"> <!-- Logo do site -->
                </a>
                <ul>
                    <li><a href="index.html">INÍCIO</a></li>
                    <li>
                        <a href="aluno.html">ALUNO</a>
                        <ul>
                            <li><a href="boletim_a.html">BOLETIM</a></li>
                            <li><a href="presença.html">PRESENÇA</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="professores.html">PROFESSORES</a>
                        <ul>
                            <li><a href="boletim_p.html">BOLETIM</a></li>
                            <li><a href="chamada.html">CHAMADA</a></li>
                        </ul>
                    </li>
                    <li><a href="login.html" class="btn">LOGIN</a></li>
                </ul>
            </nav>
            <br>
        </div>
    </header>
    <br>
    
    <div class="content">
        <div class="title">
            <h1>Chamada de Presença</h1>
        </div>

        <h2>Lista de Presença</h2>

        <!-- Inclui o arquivo PHP que gera a tabela de presença -->
        <?php include 'tabela_presenca.php';?>
    </div>

    <!-- Script para atualizar a tabela de presença automaticamente -->
    <script>
        function atualizarTabela() {
            // Faz uma requisição AJAX para obter os dados atualizados da tabela
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "tabela_presenca.php", true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Atualiza a tabela na página com os novos dados
                    document.getElementById("tabela-presenca").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        // Atualiza a tabela automaticamente a cada 2,5 segundos
        setInterval(atualizarTabela, 2500);
    </script>
</body>

</html>
