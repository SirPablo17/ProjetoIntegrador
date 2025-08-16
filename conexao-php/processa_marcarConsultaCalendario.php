<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['cliente_logado'])) {
    header('Location: login.php');
    exit;
}

// Dados do formulário (higienizados)
$dataConsulta        = isset($_POST['dataConsulta']) ? trim($_POST['dataConsulta']) : '';
$horarioConsulta     = isset($_POST['horarioConsulta']) ? trim($_POST['horarioConsulta']) : '';
$procedimentosSelecionados = $_POST['procedimentos'] ?? [];

if (empty($procedimentosSelecionados)) {
    $_SESSION['mensagem_erro'] = "Por favor, selecione ao menos um procedimento para marcar a consulta.";
    header('Location: /ProjetoIntegrador/PHP/marcarConsulta.php');
    exit;
}

$usuarioID = $_SESSION['cliente_id'];

try {
    // Garante um dateformat previsível na sessão (opcional, ajuda em ambientes locais)
    $conn->exec("SET DATEFORMAT ymd;");

    // Monta e valida data/hora do formulário
    $dataHoraBruta = $dataConsulta . ' ' . $horarioConsulta;

    // Tenta com segundos e sem segundos (ISO) e fallback BR
    $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $dataHoraBruta)
            ?: DateTime::createFromFormat('Y-m-d H:i',    $dataHoraBruta)
            ?: DateTime::createFromFormat('d/m/Y H:i:s',  $dataHoraBruta)
            ?: DateTime::createFromFormat('d/m/Y H:i',    $dataHoraBruta);

    if (!$dateTime) {
        $_SESSION['mensagem_erro'] = "Formato de data/hora inválido.";
        header('Location: /ProjetoIntegrador/PHP/marcarConsulta.php');
        exit;
    }

    // Formato que combinaremos com estilo 120 no SQL (yyyy-mm-dd hh:mi:ss)
    $dataHoraConsulta = $dateTime->format('Y-m-d H:i:s');

    // Verifica conflito exato no mesmo dia+hora
    // CONVERT(..., 120) evita ambiguidade de locale
    $sqlVerifica = "
        SELECT COUNT(*) 
        FROM tblConsulta 
        WHERE dataConsulta = CONVERT(datetime, :dataHoraConsulta, 120)
    ";
    $stmtVerifica = $conn->prepare($sqlVerifica);
    $stmtVerifica->bindParam(':dataHoraConsulta', $dataHoraConsulta, PDO::PARAM_STR);
    $stmtVerifica->execute();

    if ((int)$stmtVerifica->fetchColumn() > 0) {
        $_SESSION['mensagem_erro'] = "Já existe uma consulta marcada nesse dia e horário. Escolha outro horário.";
        header('Location: /ProjetoIntegrador/PHP/marcarConsulta.php');
        exit;
    }

    // Soma valores dos procedimentos
    $valorTotal = 0.0;
    if (!empty($procedimentosSelecionados)) {
        $placeholders = implode(',', array_fill(0, count($procedimentosSelecionados), '?'));
        $stmtValores = $conn->prepare("SELECT valorProcedimento FROM tblProcedimentos WHERE procedimentoID IN ($placeholders)");
        $stmtValores->execute($procedimentosSelecionados);
        while ($row = $stmtValores->fetch(PDO::FETCH_ASSOC)) {
            $valorTotal += (float)$row['valorProcedimento'];
        }
    }

    // Insere a consulta (conversão explícita da data no SQL)
    $sqlConsulta = "
        INSERT INTO tblConsulta (usuarioID, valorConsulta, dataConsulta, consultaConfirmada)
        VALUES (:usuarioID, :valorConsulta, CONVERT(datetime, :dataConsulta, 120), 0)
    ";
    $stmtConsulta = $conn->prepare($sqlConsulta);
    $stmtConsulta->bindParam(':usuarioID', $usuarioID, PDO::PARAM_INT);
    // Envie como string com ponto decimal para evitar problemas de locale com MONEY
    $valorTotalStr = number_format($valorTotal, 2, '.', '');
    $stmtConsulta->bindParam(':valorConsulta', $valorTotalStr, PDO::PARAM_STR);
    $stmtConsulta->bindParam(':dataConsulta', $dataHoraConsulta, PDO::PARAM_STR);
    $stmtConsulta->execute();

    // Obtém o ID da consulta (se seu driver não suportar lastInsertId, use SELECT SCOPE_IDENTITY())
    $consultaID = $conn->lastInsertId();
    if (!$consultaID) {
        $consultaID = $conn->query("SELECT CAST(SCOPE_IDENTITY() AS INT)")->fetchColumn();
    }

    // Vincula procedimentos
    $sqlConsultaProc = "INSERT INTO tblConsultaProcedimento (consultaID, procedimentoID) VALUES (:consultaID, :procedimentoID)";
    $stmtConsultaProc = $conn->prepare($sqlConsultaProc);
    foreach ($procedimentosSelecionados as $procedimentoID) {
        $stmtConsultaProc->bindParam(':consultaID', $consultaID, PDO::PARAM_INT);
        $stmtConsultaProc->bindParam(':procedimentoID', $procedimentoID, PDO::PARAM_INT);
        $stmtConsultaProc->execute();
    }

    $_SESSION['mensagem_sucesso'] = "Consulta marcada com sucesso!";
    header('Location: /ProjetoIntegrador/PHP/painelCliente.php');
    exit;

} catch (PDOException $e) {
    $_SESSION['mensagem_erro'] = "Erro ao marcar consulta: " . $e->getMessage();
    header('Location: /ProjetoIntegrador/PHP/calendario.php');
    exit;
}
