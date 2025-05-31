<?php
session_start();
require_once('conexao.php');

// Verifica se o cliente está logado
if (!isset($_SESSION['cliente_logado'])) {
    header('Location: login.php');
    exit;
}

// Dados do formulário
$dataConsulta = $_POST['dataConsulta']; // formato yyyy-mm-dd
$horarioConsulta = $_POST['horarioConsulta']; // formato HH:MM
$procedimentosSelecionados = $_POST['procedimentos'] ?? []; // array de procedimentosID

// ✅ Validação: impede seguir sem selecionar procedimentos
if (empty($procedimentosSelecionados)) {
    $_SESSION['mensagem_erro'] = "Por favor, selecione ao menos um procedimento para marcar a consulta.";
    header('Location: /Projeto-PI---TSI---2--semestre-/PHP/marcarConsulta.php');
    exit;
}


$usuarioID = $_SESSION['cliente_id'];

try {
    // 1️⃣ Verifica se já existe uma consulta no mesmo dia e horário
    $dataHoraConsulta = $dataConsulta . ' ' . $horarioConsulta . ':00'; // concatena data + hora + segundos

    $sqlVerifica = "SELECT COUNT(*) FROM tblConsulta WHERE dataConsulta = :dataHoraConsulta";
    $stmtVerifica = $conn->prepare($sqlVerifica);
    $stmtVerifica->bindParam(':dataHoraConsulta', $dataHoraConsulta);
    $stmtVerifica->execute();

    $existeConsulta = $stmtVerifica->fetchColumn();

    // Se já existe uma consulta para o mesmo dia e horário
    if ($existeConsulta > 0) {
        $_SESSION['mensagem_erro'] = "Já existe uma consulta marcada nesse dia e horário. Escolha outro horário.";
        header('Location: /Projeto-PI---TSI---2--semestre-/PHP/marcarConsulta.php');
        exit;
    }

    // 2️⃣ Calcula o valor total da consulta com base nos procedimentos selecionados
    $valorTotal = 0;

    if (count($procedimentosSelecionados) > 0) {
        $placeholders = implode(',', array_fill(0, count($procedimentosSelecionados), '?'));
        $stmtValores = $conn->prepare("SELECT valorProcedimento FROM tblProcedimentos WHERE procedimentoID IN ($placeholders)");
        $stmtValores->execute($procedimentosSelecionados);

        while ($row = $stmtValores->fetch(PDO::FETCH_ASSOC)) {
            $valorTotal += $row['valorProcedimento'];
        }
    }

    // 3️⃣ Insere a consulta na tblConsulta
    $sqlConsulta = "INSERT INTO tblConsulta (usuarioID, valorConsulta, dataConsulta, consultaConfirmada) VALUES (:usuarioID, :valorConsulta, :dataConsulta, 0)";
    $stmtConsulta = $conn->prepare($sqlConsulta);
    $stmtConsulta->bindParam(':usuarioID', $usuarioID, PDO::PARAM_INT);
    $stmtConsulta->bindParam(':valorConsulta', $valorTotal);
    $stmtConsulta->bindParam(':dataConsulta', $dataHoraConsulta);
    $stmtConsulta->execute();

    $consultaID = $conn->lastInsertId();

    // 4️⃣ Insere os procedimentos na tblConsultaProcedimento
    $sqlConsultaProc = "INSERT INTO tblConsultaProcedimento (consultaID, procedimentoID) VALUES (:consultaID, :procedimentoID)";
    $stmtConsultaProc = $conn->prepare($sqlConsultaProc);

    foreach ($procedimentosSelecionados as $procedimentoID) {
        $stmtConsultaProc->bindParam(':consultaID', $consultaID, PDO::PARAM_INT);
        $stmtConsultaProc->bindParam(':procedimentoID', $procedimentoID, PDO::PARAM_INT);
        $stmtConsultaProc->execute();
    }

    // Mensagem de sucesso
    $_SESSION['mensagem_sucesso'] = "Consulta marcada com sucesso!";
    header('Location: /Projeto-PI---TSI---2--semestre-/PHP/painelCliente.php');
    exit;

} catch (PDOException $e) {
    echo "Erro ao marcar consulta: " . $e->getMessage();
}
?>
