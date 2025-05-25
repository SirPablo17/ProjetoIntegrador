<?php

require_once('C:\xampp\htdocs\Projeto-PI---TSI---2--semestre-\conexao-php\conexao.php');

session_start();

// Verifica se o cliente está logado
if (!isset($_SESSION['admin_logado']) && !isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

try {
    // Seleciona as consultas com os consultas associados
    $stmt = $conn->prepare("SELECT * FROM tblProcedimentos");
    $stmt->execute();
    $consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao listar consultas: " . $e->getMessage() . "</p>";
    return;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/listarConsultas.css">
    <link rel="stylesheet" href="../style/global.css">
    <title>Login</title>
</head>
<body>

<section class="section-consultas">
    <h2>Listar todos procedimentos</h2>

    <?php if (empty($consultas)): ?>
        <p>Não há procedimentos adicionados.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>procecimento ID</th>
                    <th>Descrição do procecimento</th>
                    <th>Valor do procecimento</th>
                    <th>Duração do procecimento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($consultas as $consulta): ?>
                <tr>
                    <td><?= $consulta['procedimentoID']; ?></td>
                    <td><?= $consulta['descricaoProcedimento']; ?></td>
                    <td><?= 'R$ ' . number_format($consulta['valorProcedimento'], 2, ',', '.'); ?></td>
                    <?php $data = new DateTime($consulta['tempoProcedimento']);?>
                    <td><?php echo $data->format('H:i');?></td>   
                    <td>
                        <a href="#?id=<?= $consulta['procedimentoID']; ?>" class="action-btn" onclick="return confirm('Você deseja EDITAR esse procedimento?');">Editar</a>
                        <a href="excluirProcedimento.php?id=<?= $consulta['procedimentoID']; ?>" class="action-btn delete-btn" onclick="return confirm('Deseja realmente EXCLUIR este consulta?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <br>
    <a class="btn-voltar" href="painelAdministrador.php">Voltar ao Painel do Administrador</a>
    <script src="../js/mascaras.js"></script>
</section>

    
</body>
</html>