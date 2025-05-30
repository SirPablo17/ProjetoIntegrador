<?php

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="export_usuarios.csv"');

require_once('C:\xampp\htdocs\Projeto-PI---TSI---2--semestre-\conexao-php\conexao.php');

try {
    $sql = "
        SELECT * FROM tblUsuario ORDER BY nome;
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($dados) === 0) {
        die("Nenhum dado encontrado para exportação.");
    }

    // Criar arquivo CSV
    $nomeArquivo = 'export_usuarios.csv';
    $arquivo = fopen($nomeArquivo, 'w');

    // Cabeçalhos
    fputcsv($arquivo, array_keys($dados[0]));

    // Dados
    foreach ($dados as $linha) {
        fputcsv($arquivo, $linha);
    }

    fclose($arquivo);

    echo "Exportação concluída com sucesso: <a href='$nomeArquivo'>Download do CSV</a>";

} catch (PDOException $e) {
    echo "Erro ao exportar: ".$e->getMessage();
}
?>
