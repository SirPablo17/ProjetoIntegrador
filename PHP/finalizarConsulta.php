<?php

require_once('C:\xampp\htdocs\Projeto-PI---TSI---2--semestre-\conexao-php\conexao.php');

session_start();

if (!isset($_SESSION['admin_logado'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null; // pega o consultaID da URL

if (!$id) {
    header('Location: painelAdministrador.php');
    exit();
}

try {
    // 1️⃣ Consulta finalizada = 2
    $stmtProc = $conn->prepare("UPDATE tblConsulta SET consultaConfirmada = 3 WHERE consultaID = :id");
    $stmtProc->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtProc->execute();

    // 2️⃣ Exclui a consulta na tblConsulta

    $_SESSION['mensagem_sucesso'] = "Consulta finalizada com sucesso!";
    header('Location: painelAdministrador.php');
    exit();

} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao excluir consulta: " . $e->getMessage() . "</p>";
}
?>
