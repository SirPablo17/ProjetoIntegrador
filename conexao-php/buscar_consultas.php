<?php
session_start();
header('Content-Type: application/json');
require_once('conexao.php');

try {
    // Verifica se o cliente está logado
    if (isset($_SESSION['cliente_logado']) && $_SESSION['cliente_logado'] === true) {
        $usuarioID = $_SESSION['cliente_id'];  // Usuário logado como cliente
    } elseif (isset($_SESSION['admin_logado']) && $_SESSION['admin_logado'] === true) {
        $usuarioID = $_SESSION['admin_id'];  // Administrador logado, se necessário
    } else {
        echo json_encode(['error' => 'Usuário não está logado']);
        exit;
    }

    // Consulta SQL para buscar apenas as consultas do usuário logado (cliente ou admin)
    $sql = "SELECT tu.nome, tc.valorConsulta, tc.dataConsulta, tp.descrisaoProcedimento
            FROM tblConsulta tc
            INNER JOIN tblConsultaProcedimento tpp ON tpp.consultaID = tc.consultaID
            INNER JOIN tblProcedimentos tp ON tp.procedimentoID = tpp.procedimentoID
            INNER JOIN tblUsuario tu ON tu.usuarioID = tc.usuarioID
            WHERE tc.usuarioID = :usuarioID"; // Filtro pelo ID do usuário logado

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':usuarioID', $usuarioID);
    $stmt->execute();
    $consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $eventos = [];

    foreach ($consultas as $consulta) {
        $data = new DateTime($consulta['dataConsulta']);
        $day = (int)$data->format('d');
        $month = (int)$data->format('m');
        $year = (int)$data->format('Y');
        $hora = $data->format('H:i');

        // Cria uma chave única por data
        $key = $day . '-' . $month . '-' . $year;

        if (!isset($eventos[$key])) {
            $eventos[$key] = [
                'day' => $day,
                'month' => $month,
                'year' => $year,
                'events' => []
            ];
        }

        // Monta a descrição do evento com todos os dados
        $tituloEvento = $consulta['nome'] . ' - ' . $consulta['descrisaoProcedimento'];
        $valor = 'R$ ' . number_format($consulta['valorConsulta'], 2, ',', '.');

        $eventos[$key]['events'][] = [
            'title' => $tituloEvento,
            'time' => $hora,
            'valor' => $valor,
            'procedimento' => $consulta['descrisaoProcedimento']
        ];
    }

    // Reindexa os eventos para um array simples e retorna em formato JSON
    echo json_encode(array_values($eventos));

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
