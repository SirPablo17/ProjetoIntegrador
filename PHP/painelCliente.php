<?php   
session_start();
// Verificar se o usuário está cadastrado como administrador. Se não estiver, redirecionamos para a página de login novamente.
if(!isset($_SESSION['cliente_logado'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Usuário</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../style/painelAdministrador.css">
    <link rel="stylesheet" href="../style/listarConsultas.css">
</head>
<body>

<div class="admin-container">
    <aside class="sidebar">
        <h2>Painel Admin</h2>
        <div class="usuarioNome"><h3>Bem-vindo, <?php echo htmlspecialchars($_SESSION['cliente_nome']);?></h3></div>
        <a href="marcarConsulta.php" class="botao-acao">Marcar consulta</a>
        <a href="calendario.php" class="botao-acao">Calendário</a>
        <a href="logout.php" class="botao-acao sair">Sair</a> 
    </aside>
</div>

<div class="main-content">
    <div class="section-consultas">
        <?php include 'listarConsulta.php'; ?>
    </div>
</div>

<script>
function abrirModal(consultaID) {
  document.getElementById('modal-cancelar').style.display = 'block';
  document.getElementById('consultaID').value = consultaID;
}

function fecharModal() {
  document.getElementById('modal-cancelar').style.display = 'none';
}
</script>

</body>
</html>

