<?php
session_start();

try {
    require_once('conexao.php');

    if (!isset($_SESSION['admin_logado'])) {
        header('Location: login.php');
        exit;
    }
    
    // Coletando os dados do formulário
    $nome = $_POST['nomeProcedimento'];
    $valorProcedimento = $_POST['valorProcedimento'];
    $tempo = $_POST['tempoProcedimento'];


    $sql = "INSERT INTO tblProcedimentos (descricaoProcedimento, valorProcedimento, tempoProcedimento)
            VALUES (:nomeProcedimento, :valorProcedimento, :tempoProcedimento)";

    $query = $conn->prepare($sql);

    // Fazendo o bind de TODOS os parâmetros corretamente
    $query->bindParam(':nomeProcedimento', $nome, PDO::PARAM_STR);
    $query->bindParam(':valorProcedimento', $valorProcedimento, PDO::PARAM_STR);
    $query->bindParam(':tempoProcedimento', $tempo, PDO::PARAM_STR);

    if ($query->execute()) {
        $_SESSION['mensagem_sucesso'] = "Procedimento cadastrado com sucesso!";
        header('Location: /Projeto-PI---TSI---2--semestre-/PHP/cadastrarProcedimento.php');
        exit;
    } else {
        echo "<p>Erro na execução da query:</p>";
        print_r($query->errorInfo());
    }

} catch (Exception $e) {
    echo "<p>Erro de conexão: " . $e->getMessage() . "</p>";
}
?>
