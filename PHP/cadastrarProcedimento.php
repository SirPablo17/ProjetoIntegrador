<?php
session_start();
require_once('C:\xampp\htdocs\Projeto-PI---TSI---2--semestre-\conexao-php\conexao.php');

// Verifica se o cliente está logado
if (!isset($_SESSION['admin_logado'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/cadastroAdm.css">
    <link rel="stylesheet" href="../style/global.css">
    <title>Cadastro</title>
</head>

<body>
    <header>
        <h1>Cadastro de Procedimento</h1>
    </header>

    <main>
        <div class="cadastro">


            <h2>Cadastrar Procedimento</h2>
            <form action="../conexao-php/cadastrarProcedimento.php" method="POST" class="cadastro_form">
                
                <div class="campo">
                    <label for="nome">Nome Do Procedimento:</label>
                    <input type="text" name="nomeProcedimento" required>
                </div>

                <div class="campo">
                    <label for="nascimento">Valor do Procedimento</label>
                    <input type="text" name="valorProcedimento" required>
                </div>

                <div class="campo">
                    <label for="nascimento">Tempo Gasto no Procedimento</label>
                    <input type="time" name="tempoProcedimento" required>
                </div>

                <div class="centralizar_botao">
                    <button type="submit" class="botao_acao">Cadastrar</button>
                </div>
                    
                <a href="painelAdministrador.php">Voltar a página</a>
            </form>

        </div>
    </main>
    
    <script src="../js/mascaras.js"></script>
</body>

</html>