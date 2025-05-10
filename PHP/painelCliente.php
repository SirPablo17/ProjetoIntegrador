<?php   
session_start();
// Verificar se o usuário está cadastrado como administrador. Se não estiver, redirecionamos para a página de login novamente.
if(!isset($_SESSION['admin_logado'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Administrador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../style/painelAdminstrador.css"> <!-- Link para o CSS -->
</head>
<body>

<header>
    <h1>Painel do Usuário</h1>
</header>

<main class="painel-admin">
    <h2>Seja Bem-Vindo, <?php echo htmlspecialchars($_SESSION['cliente_nome']); ?></h2>

    <div class="botoes-painel">
        <a href="#" class="botao-acao">Marcar consulta</a>
        <a href="#" class="botao-acao">Confirmar consulta</a>
        <a href="logout.php" class="botao-acao sair">Sair</a> 
    </div>
</main>

</body>
</html>

