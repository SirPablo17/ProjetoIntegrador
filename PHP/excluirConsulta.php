<?php
session_start();
require_once('C:\xampp\htdocs\Projeto-PI---TSI---2--semestre-\conexao-php\conexao.php');

if (!isset($_SESSION['cliente_logado'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null; // pega o consultaID da URL

if (!$id) {
    header('Location: painelCliente.php');
    exit();
}

try {
    // 1️⃣ Exclui os procedimentos vinculados na tblConsultaProcedimento
    $stmtProc = $conn->prepare("DELETE FROM tblConsultaProcedimento WHERE consultaID = :id");
    $stmtProc->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtProc->execute();

    // 2️⃣ Exclui a consulta na tblConsulta
    $stmtConsulta = $conn->prepare("DELETE FROM tblConsulta WHERE consultaID = :id");
    $stmtConsulta->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtConsulta->execute();

    $_SESSION['mensagem_sucesso'] = "Consulta excluída com sucesso!";
    header('Location: painelCliente.php');
    exit();

} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao excluir consulta: " . $e->getMessage() . "</p>";
}
?>
