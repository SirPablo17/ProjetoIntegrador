<?php

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="export_usuarios.csv"');

// Força o BOM no início do arquivo (excel-friendly)
echo "\xEF\xBB\xBF";

require_once('C:\xampp\htdocs\ProjetoIntegrador\conexao-php\conexao.php');

try {
    $sql = "
        SELECT * FROM tblProcedimentos ORDER BY procedimentoID;
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($dados) === 0) {
        die("Nenhum dado encontrado para exportação.");
    }

    // Criar arquivo CSV
    $nomeArquivo = 'export_procedimento.csv';
    $arquivo = fopen('php://output', 'w');

    // Cabeçalhos
    fputcsv($arquivo, array_keys($dados[0]), ';');

    // Dados
    foreach ($dados as $linha) {
        fputcsv($arquivo, $linha, ';');
    }

    fclose($arquivo);

} catch (PDOException $e) {
    echo "Erro ao exportar: ".$e->getMessage();
}
?>
