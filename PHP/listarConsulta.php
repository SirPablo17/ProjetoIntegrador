<?php
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
    $stmt = $conn->prepare("SELECT c.consultaID, c.dataConsulta, p.descricaoProcedimento, p.valorProcedimento, c.consultaConfirmada
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

<h2>Minhas Consultas</h2>

<section class="listar-consultas">
<?php if (empty($consultas)): ?>
    <p>Você ainda não possui nenhuma consulta cadastrada.</p>
<?php else: ?>
<table>
    <tr>
        <th>Consulta ID</th>
        <th>Descrição do Procedimento</th>
        <th>Valor do Procedimento</th>
        <th>Data da Consulta</th>
        <th>Status Da Consulta</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($consultas as $consulta): ?>
        <tr>
            <td><?php echo $consulta['consultaID']; ?></td>
            <td><?php echo htmlspecialchars($consulta['descricaoProcedimento']); ?></td>
            <td><?php echo 'R$ ' . number_format($consulta['valorProcedimento'], 2, ',', '.'); ?></td>
            <?php $data = new DateTime($consulta['dataConsulta']);?>
            <td><?php echo $data->format('d/m/Y H:i');?></td>
            <td><?php $status = $consulta['consultaConfirmada'];
            if($status == 0){
                echo "Consulta não confirmada";
            } elseif ($status == 1){
                echo "Consulta confirmada";
            } elseif ($status == 2) {
                echo "Consulta cancelada";
            } else {
                echo "consulta finalizada";
            }
            ?></td>
            <td>
                <a href="cancelarConsulta.php?id=<?php echo $consulta['consultaID']; ?>" 
                class="action-btn delete-btn" 
                target="_blank"
                onclick="return abrirPopup(this.href);">
                Cancelar
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>
</section>

<div class="excel">
<a class="btn-export" href="exportarConsultasCliente.php">Exportar dados em Excel</a>
</div>

<script>
function abrirPopup(url) {
    window.open(url, 'popupCancelar', 'width=500,height=500');
    return false; // impede o link de seguir normalmente
}
</script>
