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
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../style/painelAdministrador.css">
    <link rel="stylesheet" href="../style/listarConsultas.css">
</head>
<body>

<div class="admin-container">
    <aside class="sidebar">
        <h2>Painel Admin</h2>
        <div class="usuarioNome"><h3>Bem-vindo, <?php echo htmlspecialchars($_SESSION['admin_nome']);?></h3></div>
        <a href="cadastrar_administrador.php">Cadastrar Usuário</a>
        <a href="listarUsuarios.php">Listar Usuários</a>
        <a href="cadastrarProcedimento.php">Cadastrar Procedimento</a>
        <a href="listarProcedimento.php">Listar Procedimentos</a>
        <a href="logout.php" class="sair">Sair</a>
    </aside>
</div>

<div class="main-content">
    <div class="section-consultas">
        <?php include 'listarTodasConsultas.php'; ?>
    </div>
</div>

</body>
</html>
