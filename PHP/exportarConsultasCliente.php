<?php

// Força o BOM no início do arquivo (excel-friendly)
echo "\xEF\xBB\xBF";
require_once('C:\xampp\htdocs\Projeto-PI---TSI---2--semestre-\conexao-php\conexao.php');

session_start();

if (!isset($_SESSION['cliente_logado']) || !isset($_SESSION['cliente_id'])) {
    die("Acesso negado. Apenas clientes podem exportar suas consultas.");
}

$usuarioID = $_SESSION['cliente_id'];

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
        WHERE u.usuarioID = :usuarioID
        ORDER BY c.dataConsulta DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':usuarioID', $usuarioID, PDO::PARAM_INT);
    $stmt->execute();
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($dados) === 0) {
        die("Nenhum dado encontrado para exportar.");
    }

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="minhas_consultas.csv"');

    $arquivo = fopen('php://output', 'w');
    fputcsv($arquivo, array_keys($dados[0]), ';');

    foreach ($dados as $linha) {
        fputcsv($arquivo, $linha, ';');
    }

    fclose($arquivo);

} catch (PDOException $e) {
    echo "Erro ao exportar: " . $e->getMessage();
}
?>
