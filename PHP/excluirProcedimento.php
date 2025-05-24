<?php

require_once('C:\xampp\htdocs\Projeto-PI---TSI---2--semestre-\conexao-php\conexao.php');

session_start();

if (!isset($_SESSION['admin_logado']) && !isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Verifica se o cliente está logado

$id = $_GET['id'] ?? null; // pega o consultaID da URL

if (!$id) {
    header('Location: painelAdministrador.php');
    exit();
}

try {
    // 1️⃣ Exclui os procedimentos vinculados na tblProcedimentos
    $stmtProc = $conn->prepare("DELETE FROM tblProcedimentos WHERE procedimentoID = :id");
    $stmtProc->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtProc->execute();

    // 2️⃣ Exclui a consulta na tblConsulta

    $_SESSION['mensagem_sucesso'] = "Procedimento excluída com sucesso!";
    header('Location: listarProcedimento.php');
    exit();

} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao excluir consulta: " . $e->getMessage() . "</p>";
}
?>
