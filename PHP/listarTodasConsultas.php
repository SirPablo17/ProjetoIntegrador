<?php

require_once('C:\xampp\htdocs\Projeto-PI---TSI---2--semestre-\conexao-php\conexao.php');

// Verifica se o cliente está logado
if (!isset($_SESSION['admin_logado']) || !isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

try {
   
    $stmt = $conn->prepare(
        "SELECT c.consultaID, tc.usuarioID, tc.nome, c.dataConsulta, p.descricaoProcedimento, p.valorProcedimento, c.consultaConfirmada
        FROM tblConsulta c
        LEFT JOIN tblConsultaProcedimento cp ON c.consultaID = cp.consultaID
        LEFT JOIN tblProcedimentos p ON cp.procedimentoID = p.procedimentoID
        LEFT JOIN tblUsuario tc ON tc.usuarioID = c.usuarioID
        ORDER BY c.dataConsulta DESC");
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
                <td>
                    <?= $consulta['consultaID']; ?>
                </td>
                <td>
                    <?= $consulta['usuarioID']; ?>
                </td>
                <td>
                    <?= $consulta['nome']; ?>
                </td>
                <td>
                    <?= $consulta['descricaoProcedimento']; ?>
                </td>
                <td>
                    <?= 'R$ ' . number_format($consulta['valorProcedimento'], 2, ',', '.'); ?>
                </td>
                <td>
                    <?= (new DateTime($consulta['dataConsulta']))->format('d/m/Y H:i'); ?>
                </td>
                <td>
                    <?php $status = $consulta['consultaConfirmada'];
                     if($status == 0){
                        echo "Consulta não confirmada";
                     } elseif ($status == 1){
                       echo "Consulta Confirmada";
                     } elseif ($status == 2) {
                      echo "Consulta cancelada";
                     } else {
                       echo "consulta finalizada";
                     }
                    ?>
                </td>
                <td>
                    <a href="confirmarConsulta.php?id=<?= $consulta['consultaID']; ?>" class="action-btn"
                        onclick="return confirm('Você deseja APROVAR esta consulta?');">Confirmar</a>
                    <a href="cancelarConsultaAdm.php?id=<?php echo $consulta['consultaID']; ?>"
                        class="action-btn delete-btn" target="_blank" onclick="return abrirPopup(this.href);">
                        Cancelar
                    </a>
                    <a href="finalizarConsulta.php?id=<?= $consulta['consultaID']; ?>" class="action-btn"
                        onclick="return confirm('Você deseja marcar essa consulta como FINALIZADA?');">Finalizar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</section>

<div class="excel">
    <a class="btn-export" href="exportarConsultasAdm.php">Exportar dados em Excel</a>
</div>

<script>
function abrirPopup(url) {
    window.open(url, 'popupCancelar', 'width=500,height=500');
    return false; // impede o link de seguir normalmente
}
</script>
