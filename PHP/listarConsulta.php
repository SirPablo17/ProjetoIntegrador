<?php
session_start();
require_once('C:\xampp\htdocs\Projeto-PI---TSI---2--semestre-\conexao-php\conexao.php');

// Verifica se o cliente está logado
if (!isset($_SESSION['cliente_logado']) || !isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit();
}

// Pega o ID do cliente da sessão
$clienteID = $_SESSION['cliente_id'];

try {
    // Seleciona as consultas desse cliente com os procedimentos associados
    $stmt = $conn->prepare("SELECT c.consultaID, c.dataConsulta, p.descrisaoProcedimento, p.valorProcedimento, c.consultaConfirmada
                            FROM tblConsulta c
                            LEFT JOIN tblConsultaProcedimento cp ON c.consultaID = cp.consultaID
                            LEFT JOIN tblProcedimentos p ON cp.procedimentoID = p.procedimentoID
                            WHERE c.usuarioID = :clienteID");
    $stmt->bindParam(':clienteID', $clienteID, PDO::PARAM_INT);
    $stmt->execute();
    $consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao listar consultas: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Minhas Consultas</title>
    <link rel="stylesheet" href="../style/listarConsultas.css">
    <link rel="stylesheet" href="../style/global.css">
</head>
<body>
<h2>Minhas Consultas</h2>

<?php if (empty($consultas)): ?>
    <p>Você ainda não possui nenhuma consulta cadastrada.</p>
<?php else: ?>
<table>
    <tr>
        <th>Consulta ID</th>
        <th>Descrição do Procedimento</th>
        <th>Valor do Procedimento</th>
        <th>Data da Consulta</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($consultas as $consulta): ?>
        <tr>
            <td><?php echo $consulta['consultaID']; ?></td>
            <td><?php echo htmlspecialchars($consulta['descrisaoProcedimento']); ?></td>
            <td><?php echo 'R$ ' . number_format($consulta['valorProcedimento'], 2, ',', '.'); ?></td>
            <td><?php echo htmlspecialchars($consulta['dataConsulta']); ?></td>
            <td>
                <a href="editarConsulta.php?id=<?php echo $consulta['consultaID']; ?>" class="action-btn">Editar</a>
                <a href="excluirConsulta.php?id=<?php echo $consulta['consultaID']; ?>" class="action-btn delete-btn" onclick="return confirm('Deseja realmente excluir esta consulta?');">Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>

<br>

<a href="painelCliente.php">Voltar ao Painel do Cliente</a>

</body>
</html>
