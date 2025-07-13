<?php
session_start();
require_once('conexao.php');

// Verifica login
if (!isset($_SESSION['cliente_logado'])) {
    header('Location: login.php');
    exit;
}

$dataConsulta = $_POST['dataConsulta'] ?? '';
$horarioConsulta = $_POST['horarioConsulta'] ?? '';
$procedimentos = $_POST['procedimentos'] ?? [];

if (!$dataConsulta || !$horarioConsulta || empty($procedimentos)) {
    $_SESSION['mensagem_erro'] = "Preencha todos os campos e selecione ao menos um procedimento.";
    header('Location: /Projeto-PI---TSI---2--semestre-/PHP/calendario.php');
    exit;
}

$usuarioID = $_SESSION['cliente_id'];
$dataHoraConsulta = $dataConsulta . ' ' . $horarioConsulta . ':00';

try {
    // Verifica se já há consulta nesse horário
    $stmt = $conn->prepare("SELECT COUNT(*) FROM tblConsulta WHERE dataConsulta = :dataHoraConsulta");
    $stmt->bindParam(':dataHoraConsulta', $dataHoraConsulta);
    $stmt->execute();
    if ($stmt->fetchColumn() > 0) {
        $_SESSION['mensagem_erro'] = "Já existe uma consulta nesse horário.";
        header('Location: /ProjetoIntegrador/PHP/marcarConsulta.php');
        exit;
    }

    // Somar valores dos procedimentos
    $placeholders = implode(',', array_fill(0, count($procedimentos), '?'));
    $stmt = $conn->prepare("SELECT valorProcedimento FROM tblProcedimentos WHERE procedimentoID IN ($placeholders)");
    $stmt->execute($procedimentos);

    $valorTotal = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $valorTotal += $row['valorProcedimento'];
    }

    // Inserir consulta
    $stmt = $conn->prepare("INSERT INTO tblConsulta (usuarioID, valorConsulta, dataConsulta, consultaConfirmada) VALUES (:usuarioID, :valor, :dataHora, 0)");
    $stmt->bindParam(':usuarioID', $usuarioID);
    $stmt->bindParam(':valor', $valorTotal);
    $stmt->bindParam(':dataHora', $dataHoraConsulta);
    $stmt->execute();

    $consultaID = $conn->lastInsertId();

    // Inserir procedimentos vinculados
    $stmt = $conn->prepare("INSERT INTO tblConsultaProcedimento (consultaID, procedimentoID) VALUES (:consultaID, :procedimentoID)");
    foreach ($procedimentos as $procID) {
        $stmt->bindParam(':consultaID', $consultaID);
        $stmt->bindParam(':procedimentoID', $procID);
        $stmt->execute();
    }

    $_SESSION['mensagem_sucesso'] = "Consulta marcada com sucesso!";
    header('Location: /ProjetoIntegrador/PHP/calendario.php');
    exit;

} catch (PDOException $e) {
    echo "Erro ao marcar consulta: " . $e->getMessage();
}
