<!-- <?php
session_start();

//Se a variável de sessão com a mensagem de erro estiver definida
if(isset($_SESSION['mensagem de erro'])){
    echo"<p class='error-message'>".$_SESSION['mensagem_erro']."</p>";//Exibe a mensagem de erro
    unset($_SESSION['mensagem_erro']); //Descarta a variável de sessão
}

?> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/login.css">
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../style/style.css">
    <title>Login</title>
</head>
<body>
    <header>
        <nav>
            <a class="logo"> <img src="../img/LogoPNG.png" height="71"></a>
            <div class="mobile-menu">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
            <ul class="nav-list">
                <li><a href="index.php">Início</a></li>
                <li><a href="index.php">Serviços</a></li>
                <li><a href="index.php">Sobre Mim</a></li>
            </ul>
            <div class="login-button">
                <button onclick="location.href='login.html'">Entrar</button>
            </div>
        </nav>
    </header>
    <main >
        <div class="login">
            <form id="login_usuario" class="forms" action="processa_login.php" method="POST"> <!-- id para jogar pro php-->
                <div class="login_logo_position">
                    <img class="login_logo_logo" src="../img/LogoPNG.png">
                </div>
                <div class="login_usuario_forms">
                    <label for="email"> E-mail</label>
                    <input type="email" name="email">
                    <label for="email"> Senha</label>
                    <input type="password" name="senha">
                    <?php
                    if(isset($_GET['erro'])){
                    echo '<p style="color: white">E-mail ou senha inválidos</p';
                    }
                    ?> 
                </div>
                <div class="login_usuario_senhaEcadastro">
                    <a href="https://support.google.com/accounts/answer/7682439?hl=pt-BR">Esqueci a senha</a>
                    <div class="criar_conta">
                        <p>Não possui conta?</p>
                        <a href="cadastro.php">Cadastre-se</a>
                    </div>
                </div>
                <div class="centralizar_botao">
                    <button class="botao_acao">
                        <submit onclick="Logarconta()">Entrar</submit>
                    </button>    
                </div>
            </form>
        </div>
    </main>

    <script src="../js/teste.js"></script>
</body>
</html>