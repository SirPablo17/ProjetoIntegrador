<?php
session_start();

//Se a variável de sessão com a mensagem de erro estiver definida
if(isset($_SESSION['mensagem de erro'])){
    echo"<p class='error-message'>".$_SESSION['mensagem_erro']."</p>";//Exibe a mensagem de erro
    unset($_SESSION['mensagem_erro']); //Descarta a variável de sessão
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="../style/login.css">
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../style/style.css">
    <title>Login</title>
</head>
<body>
    <header>
        <nav>
            <a class="logo"> <img src="../img/LogoPNG.png" height="71" alt="Logo"></a>
            <div class="mobile-menu">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
            <ul class="nav-list">
                <li><a href="./index.php">Início</a></li>
                <li><a href="./index.php">Serviços</a></li>
                <li><a href="./index.php">Sobre Mim</a></li>
            </ul>
            <div class="login-button">
                <button onclick="location.href='login.html'">Entrar</button>
            </div>
        </nav>
    </header>
    <main>
        <h2>Login do ADMINISTRADOR</h2>
        <div>
        <form action="processa_login.php" method="POST">
                <label for="email">Email:</label>
                <input type="text" id="email" name = "email" required>

                <br><br>

                <label for="nome">Senha:</label>
                <input type="password" id="senha" name = "senha" required>

                <br><br>

                <input type="submit" Value="Entrar">
            </form>
        </div>
        <?php
        if(isset($_GET['erro'])){
            echo '<p style="color: red";>Nome de usuário ou senha incorretos!</p';
        }
    ?>
    </main>
</body>
</html>
