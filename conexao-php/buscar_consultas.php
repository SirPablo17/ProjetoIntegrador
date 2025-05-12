<?php
header('Content-Type: application/json');
require_once('conexao.php');

try {
    // Buscando todas as consultas com JOINs
    $sql = "SELECT tu.nome, tc.valorConsulta, tc.dataConsulta, tp.descrisaoProcedimento
            FROM tblConsulta tc
            INNER JOIN tblConsultaProcedimento tpp ON tpp.consultaID = tc.consultaID
            INNER JOIN tblProcedimentos tp ON tp.procedimentoID = tpp.procedimentoID
            INNER JOIN tblUsuario tu ON tu.usuarioID = tc.usuarioID";

    $stmt = $conn->prepare($sql);
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

        // Se ainda não existe esse dia no array, cria
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

    // Reindexa os eventos para um array simples
    echo json_encode(array_values($eventos));

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
