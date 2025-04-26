<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSS -->
    <link rel="stylesheet" href="./style/login.css">
    <link rel="stylesheet" href="./style/global.css">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
</head>
<body>
    <header>
        <nav>
            <a class="logo"> <img src="img/LogoPNG.png" height="71"></a>
            <div class="mobile-menu">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
            <ul class="nav-list">
                <li><a href="index.html">Início</a></li>
                <li><a href="index.html">Serviços</a></li>
                <li><a href="index.html">Sobre Mim</a></li>
            </ul>
            <div class="login-button">
                <button onclick="location.href='login.html'">Entrar</button>
            </div>
        </nav>
    </header>
    <main >
        <body>
            <h2>Login do ADMINISTRADOR</h2>

            <?php if (isset($_GET['erro'])): ?>
            <p style="color: red;">Usuário ou senha inválidos. Tente novamente.</p>
            <?php endif; ?>

                    <form action="processa_login.php" method="post">                    
                    <label for="nome">Nome:</label>
                    <input type="text" id="email" name = "email" required>
    
                    <br><br>
    
                    <label for="nome">Senha:</label>
                    <input type="password" id="senha" name = "senha" required>
    
                    <br><br>
    
                    <input type="submit" Value="Entrar">
                </form>    
    </main>

    <script src="./PHP/processa_login.php"></script>
</body>
</html>