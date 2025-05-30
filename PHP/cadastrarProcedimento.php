<?php
session_start();
require_once('C:\xampp\htdocs\Projeto-PI---TSI---2--semestre-\conexao-php\conexao.php');

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
    <link rel="stylesheet" href="../style/cadastroProcedimento.css">
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
            <form action="../conexao-php/processa_cadastrarProcedimento.php" method="POST" class="cadastro_form">
                
                <div class="nomeProcedimento">
                    <label for="nome">Nome do Procedimento:</label>
                    <input type="text" name="nomeProcedimento" required placeholder="Digite o nome">
                </div>

                <div class="campo">
                    <label for="valorProcedimento">Valor do Procedimento:</label>
                    <input type="number" name="valorProcedimento" step="0.01" required placeholder="Ex: R$ 100.00">
                </div>

                <div class="campo">
                    <label for="tempoProcedimento">Tempo Gasto no Procedimento:</label>
                    <input type="time" name="tempoProcedimento" required>
                </div>

                <div class="centralizar_botao">
                    <button type="submit" class="botao_acao">Cadastrar</button>
                </div>
            </form>

            <div style="text-align: center; margin-top: 1rem;">
                <a href="painelAdministrador.php">Voltar</a>
            </div>

            <?php
                if (isset($_SESSION['mensagem_sucesso'])) {
                    echo "<div class='mensagem-sucesso'>" . $_SESSION['mensagem_sucesso'] . "</div>";
                    unset($_SESSION['mensagem_sucesso']);
                }
            ?>
        </div>
    </main>

    <script src="../js/mascaras.js"></script>
    <script src="../js/validacao.js"></script>
</body>

</html>
