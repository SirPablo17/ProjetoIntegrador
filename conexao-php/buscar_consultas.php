<?php
session_start();
header('Content-Type: application/json');
require_once('conexao.php');

try {
    // Identifica quem está logado
    if (isset($_SESSION['cliente_logado']) && $_SESSION['cliente_logado'] === true) {
        $usuarioID = $_SESSION['cliente_id'];
    } elseif (isset($_SESSION['admin_logado']) && $_SESSION['admin_logado'] === true) {
        $usuarioID = $_SESSION['admin_id'];
    } else {
        echo json_encode(['error' => 'Usuário não está logado']);
        exit;
    }

    // Garante que o ID é um número
    $usuarioID = (int)$usuarioID;

    // Consulta: pega consultas SOMENTE do usuário logado
    $sql = "SELECT tu.nome, tc.valorConsulta, tc.dataConsulta, tp.descrisaoProcedimento
            FROM tblConsulta tc
            INNER JOIN tblConsultaProcedimento tpp ON tpp.consultaID = tc.consultaID
            INNER JOIN tblProcedimentos tp ON tp.procedimentoID = tpp.procedimentoID
            INNER JOIN tblUsuario tu ON tu.usuarioID = tc.usuarioID
            WHERE tc.usuarioID = :usuarioID";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':usuarioID', $usuarioID, PDO::PARAM_INT);
    $stmt->execute();
    $consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verificação extra: ignora qualquer consulta "bugada" que não é do usuário
    $eventos = [];
    foreach ($consultas as $consulta) {
        if (!$consulta['dataConsulta']) {
            continue; // pula se não tiver data
        }

        $data = new DateTime($consulta['dataConsulta']);
        $day = (int)$data->format('d');
        $month = (int)$data->format('m');
        $year = (int)$data->format('Y');
        $hora = $data->format('H:i');

        $key = $day . '-' . $month . '-' . $year;

        if (!isset($eventos[$key])) {
            $eventos[$key] = [
                'day' => $day,
                'month' => $month,
                'year' => $year,
                'events' => []
            ];
        }

        $tituloEvento = $consulta['nome'] . ' - ' . $consulta['descrisaoProcedimento'];
        $valor = 'R$ ' . number_format($consulta['valorConsulta'], 2, ',', '.');

        $eventos[$key]['events'][] = [
            'title' => $tituloEvento,
            'time' => $hora,
            'valor' => $valor,
            'procedimento' => $consulta['descrisaoProcedimento']
        ];
    }

    echo json_encode(array_values($eventos));

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
