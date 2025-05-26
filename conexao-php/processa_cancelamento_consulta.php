<?php
require_once('conexao.php');
session_start();

if (!isset($_SESSION['admin_logado']) && !isset($_SESSION['cliente_logado'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Se entrar sem POST, redireciona para o painel adequado
    if (isset($_SESSION['admin_logado'])) {
        header('Location: painelAdministrador.php');
    } else {
        header('Location: painelCliente.php');
    }
    exit();
}

$consultaID = $_POST['consultaID'] ?? null;
$motivosStr = $_POST['motivos'] ?? null;

if (!$consultaID || !$motivosStr) {
    echo "<script>alert('Por favor, selecione um motivo de cancelamento.'); window.history.back();</script>";
    exit();
}

try {
    $stmt = $conn->prepare("
        UPDATE tblConsulta 
        SET consultaConfirmada = 2, motivoCancelamento = :motivos 
        WHERE consultaID = :id
    ");
    $stmt->bindParam(':motivos', $motivosStr, PDO::PARAM_STR);
    $stmt->bindParam(':id', $consultaID, PDO::PARAM_INT);
    $stmt->execute();

    // Aqui o segredo para atualizar o painel após fechar popup:
    echo "<script>
        alert('Consulta cancelada com sucesso!');
        window.opener.location.reload(); // Recarrega a página que abriu o popup (painelCliente ou painelAdministrador)
        window.close(); // Fecha o popup
    </script>";
    exit();

} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao cancelar: " . $e->getMessage() . "</p>";
}
