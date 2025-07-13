<?php
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="export_consultas.csv"');

// Força o BOM no início do arquivo (excel-friendly)
echo "\xEF\xBB\xBF";

require_once('C:\xampp\htdocs\ProjetoIntegrador\conexao-php\conexao.php');

try {



    $sql = "
        SELECT 
            u.nome AS NomeUsuario,
            u.CPF,
            c.consultaID,
            c.dataConsulta,
            c.valorConsulta,
            c.consultaConfirmada,
            p.descricaoProcedimento,
            p.valorProcedimento
        FROM tblConsulta c
        JOIN tblUsuario u ON c.usuarioID = u.usuarioID
        JOIN tblConsultaProcedimento cp ON c.consultaID = cp.consultaID
        JOIN tblProcedimentos p ON cp.procedimentoID = p.procedimentoID
        ORDER BY c.dataConsulta DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($dados) === 0) {
        die("Nenhum dado encontrado para exportação.");
    }

    

    $arquivo = fopen('php://output', 'w');

    // Cabeçalhos do CSV
    fputcsv($arquivo, array_keys($dados[0]), ';');

    // Dados do CSV
    foreach ($dados as $linha) {
        fputcsv($arquivo, $linha,';');
    }

    fclose($arquivo);
    exit;

} catch (PDOException $e) {
    echo "Erro ao exportar: " . $e->getMessage();
}
?>