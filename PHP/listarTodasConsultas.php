<?php

require_once('C:\xampp\htdocs\Projeto-PI---TSI---2--semestre-\conexao-php\conexao.php');

// Verifica se o cliente está logado
if (!isset($_SESSION['admin_logado']) || !isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

try {
    // Seleciona as consultas com os procedimentos associados
    $stmt = $conn->prepare("SELECT c.consultaID, tc.usuarioID, tc.nome, c.dataConsulta, p.descrisaoProcedimento, p.valorProcedimento, c.consultaConfirmada
                            FROM tblConsulta c
                            LEFT JOIN tblConsultaProcedimento cp ON c.consultaID = cp.consultaID
                            LEFT JOIN tblProcedimentos p ON cp.procedimentoID = p.procedimentoID
                            LEFT JOIN tblUsuario tc ON tc.usuarioID = c.usuarioID");
    $stmt->execute();
    $consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao listar consultas: " . $e->getMessage() . "</p>";
    return;
}
?>

<section class="listar-consultas">
    <h2>Listar Todas Consultas</h2>

    <?php if (empty($consultas)): ?>
        <p>Não há consultas agendadas.</p>
    <?php else: ?>
        <table>
            <thead>
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
            </thead>
            <tbody>
            <?php foreach ($consultas as $consulta): ?>
                <tr>
                    <td><?= $consulta['consultaID']; ?></td>
                    <td><?= $consulta['usuarioID']; ?></td>
                    <td><?= $consulta['nome']; ?></td>
                    <td><?= $consulta['descrisaoProcedimento']; ?></td>
                    <td><?= 'R$ ' . number_format($consulta['valorProcedimento'], 2, ',', '.'); ?></td>
                    <td><?= (new DateTime($consulta['dataConsulta']))->format('d/m/Y H:i'); ?></td>
                    <td><?= $consulta['consultaConfirmada'] ? 'Consulta Confirmada' : 'Consulta não confirmada'; ?></td>
                    <td>
                        <a href="#?id=<?= $consulta['consultaID']; ?>" class="action-btn" onclick="return confirm('Você deseja APROVAR esta consulta?');">Aprovar</a>
                        <a href="#?id=<?= $consulta['consultaID']; ?>" class="action-btn" onclick="return confirm('Você deseja CANCELAR esta consulta?');">Cancelar</a>
                        <a href="#?id=<?= $consulta['consultaID']; ?>" class="action-btn delete-btn" onclick="return confirm('Deseja realmente EXCLUIR esta consulta?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
