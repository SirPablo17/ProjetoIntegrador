<?php
session_start();
require_once('C:\xampp\htdocs\Projeto-PI---TSI---2--semestre-\conexao-php\conexao.php');

// Verifica se o cliente está logado
if (!isset($_SESSION['admin_logado']) || !isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Pega o ID do cliente da sessão
$clienteID = $_SESSION['admin_id'];

try {
    // Seleciona as consultas desse cliente com os procedimentos associados
    $stmt = $conn->prepare("SELECT c.consultaID, tc.usuarioID, tc.nome, c.dataConsulta, p.descrisaoProcedimento, p.valorProcedimento, c.consultaConfirmada
                            FROM tblConsulta c
                            LEFT JOIN tblConsultaProcedimento cp ON c.consultaID = cp.consultaID
                            LEFT JOIN tblProcedimentos p ON cp.procedimentoID = p.procedimentoID
                            LEFT JOIN tblUsuario tc ON tc.usuarioID = c.usuarioID");
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
    <p>Não há consultas agendadas.</p>
<?php else: ?>
<table>
    <tr>
        <th>Consulta ID</th>
        <th>Usuário ID</th>
        <th>Nome do Paciente</th>
        <th>Descrição do Procedimento</th>
        <th>Valor do Procedimento</th>
        <th>Data da Consulta</th>
        <th>Status da Consulta</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($consultas as $consulta): ?>
        <tr>
            <td><?php echo $consulta['consultaID']; ?></td>
            <td><?php echo $consulta['usuarioID']; ?></td>
            <td><?php echo $consulta['nome']; ?></td>
            <td><?php echo $consulta['descrisaoProcedimento'];?></td>
            <td><?php echo 'R$ ' . number_format($consulta['valorProcedimento'], 2, ',', '.'); ?></td>
            <?php $data = new DateTime($consulta['dataConsulta']);?>
            <td><?php echo $data->format('d/m/Y H:i');?></td>
            <td><?php$confirmado = $consulta['consultaConfirmada'];
            if($confirmado == 0){
                echo "Consulta não confirmada";
            } else {
                echo "Consulta Confirmada";
            }?>
            <td></td>
            <td>
                <a href="#?id=<?php echo $consulta['consultaID']; ?>" class="action-btn"onclick="return confirm('Você deseja APROVAR está consulta?');">Aprovar</a>
                <a href="#?id=<?php echo $consulta['consultaID']; ?>" class="action-btn"onclick="return confirm('Você deseja CANCELAR está consulta?');">Cancelar</a>
                <a href="#?id=<?php echo $consulta['consultaID']; ?>" class="action-btn delete-btn" onclick="return confirm('Deseja realmente EXCLUIR esta consulta?');">Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>

<br>

<a href="painelAdministrador.php">Voltar ao Painel do Administrador</a>

</body>
</html>
