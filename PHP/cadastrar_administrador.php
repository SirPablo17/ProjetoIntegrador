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
    <link rel="stylesheet" href="../style/cadastrarAdm.css">
    <link rel="stylesheet" href="../style/global.css">
    <title>Cadastro</title>
</head>

<body>
    <header>
        <h1>Cadastro de Administrador</h1>
    </header>

    <main>
        <div class="cadastro">


            <h2>Cadastrar Administrador</h2>
            <form action="../conexao-php/processa_cadastroAdm.php" method="POST" class="cadastro_form">
                
                <div class="campo">
                    <label for="nome">Nome completo:</label>
                    <input type="text" id="nome" placeholder="digite seu nome" name="nomeCompleto" required>
                </div>

                <div class="campo">
                    <label for="nascimento">Data de nascimento:</label>
                    <input type="date" id="nascimento" name="dataNascimento" required>
                </div>

                <div class="CPFcampo">
                    <label for="cpf">CPF:</label>
                    <input type="text" id="cpf" oninput="CPF(this)" placeholder="000.000.000-00" name="cpfUsuario" required>
                </div>

                <div class="campo">
                    <label for="telefone">Telefone</label>
                    <input type="text" id="telefone" oninput="TEL(this)" name="telefoneUsuario" placeholder="(xx) xxxxx-xxxx">
                </div>

                <div class="campo">
                    <label for="cep">CEP</label>
                    <input type="text" id="cep" oninput="CEP(this)" name="cepUsuario" placeholder="00000-000">
                </div>

                <div class="campo">
                    <label for="endereco">Endereço</label>
                    <input type="text" id="endereco" name="enderecoUsuario">
                </div>

                <div class="campo">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="emailUsuario" placeholder="digite seu email" required>
                </div>

                <div class="campo">
                    <label for="confirm_email">Confirme seu e-mail</label>
                    <input type="email" id="confirm_email" name="confirmEmailUsuario" placeholder="confirme seu email"
                    required>
                </div>

                <div class="campo">
                    <label for="senha">Escolha uma senha</label>
                    <input type="password" id="senha" name="usuarioSenha" placeholder="digite sua senha" required>
                </div>

                <div class="campo">
                    <label for="confirm_senha">Confirme sua senha</label>
                    <input type="password" id="confirm_senha" name="confirmUsuarioSenha" placeholder="confirme sua senha"
                    required>
                </div>

                <div class="centralizar_botao">
                    <button type="submit" class="botao_acao">Cadastrar</button>
                </div>
                    
                <a class="btn-voltar" href="painelAdministrador.php">Voltar a página</a>
            </form>
            
            <?php
                if (isset($_SESSION['mensagem_sucesso'])) {
                    echo "<div style='color: white; font-weight: bold; text-align: center; margin-top: 15px;'>" . $_SESSION['mensagem_sucesso'] . "</div>";
                unset($_SESSION['mensagem_sucesso']);
                }
            ?>

        </div>
    </main>
    
    <script src="../js/mascaras.js"></script>
</body>

</html>