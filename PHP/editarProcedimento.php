<?php
session_start();

require_once('C:\xampp\htdocs\ProjetoIntegrador\conexao-php\conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location: login.php");
    exit();
}

// 1. Recupera o ID do procedimento
$adm_id = $_GET['id'] ?? null;
if (!$adm_id) {
    echo "<p style='color:red;'>ID do procedimento não informado.</p>";
    exit();
}

// 2. Se enviou o formulário, atualiza os dados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $valorProcedimento = $_POST['valorProcedimento'];
    $tempoProcedimento = $_POST['tempoProcedimento'];
    $descricaoProcedimento = $_POST['descricaoProcedimento'];

    try {
        $stmt_update_adm = $conn->prepare("
            UPDATE tblProcedimentos
            SET valorProcedimento = :valorProcedimento,
                tempoProcedimento = :tempoProcedimento,
                descricaoProcedimento = :descricaoProcedimento
            WHERE procedimentoID = :adm_id
        ");

        $stmt_update_adm->bindParam(':valorProcedimento', $valorProcedimento);
        $stmt_update_adm->bindParam(':tempoProcedimento', $tempoProcedimento);
        $stmt_update_adm->bindParam(':descricaoProcedimento', $descricaoProcedimento);
        $stmt_update_adm->bindParam(':adm_id', $adm_id, PDO::PARAM_INT);

        $stmt_update_adm->execute();

        echo "<p style='color:green; text-align:center;'>Procedimento atualizado com sucesso!</p>";

    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao atualizar procedimento: " . $e->getMessage() . "</p>";
    }
}

// 3. Carrega os dados atualizados do procedimento
$stmt_adm = $conn->prepare("SELECT * FROM tblProcedimentos WHERE procedimentoID = :adm_id");
$stmt_adm->bindParam(':adm_id', $adm_id, PDO::PARAM_INT);
$stmt_adm->execute();
$adm = $stmt_adm->fetch(PDO::FETCH_ASSOC);

if (!$adm) {
    echo "<p style='color:red;'>Procedimento não encontrado.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Editar Procedimento</title>
    <link rel="stylesheet" href="../style/cadastroProcedimento.css">
    <link rel="stylesheet" href="../style/global.css">
</head>

<body>

    <header>
        <h1>Editar Procedimento</h1>
    </header>

    <main>
        <section class="cadastro">
            <h2>Atualize as Informações</h2>
            <form method="POST" class="cadastro_form">

                <label for="descricaoProcedimento">Descrição do Procedimento:</label>
                <input type="text" name="descricaoProcedimento" id="descricaoProcedimento"
                    value="<?= htmlspecialchars($adm['descricaoProcedimento'] ?? '') ?>" required>

                <label for="valorProcedimento">Valor do Procedimento:</label>
                <input type="text" name="valorProcedimento" id="valorProcedimento"
                    value="<?= htmlspecialchars($adm['valorProcedimento'] ?? '') ?>" required>

                <label for="tempoProcedimento">Tempo do Procedimento:</label>
                <input type="time" name="tempoProcedimento" id="tempoProcedimento"
                value="<?= isset($adm['tempoProcedimento']) ? substr($adm['tempoProcedimento'], 0, 5) : '' ?>" required>

                <div class="centralizar_botao">
                    <button type="submit" class="botao_acao">Salvar Alterações</button>
                </div>
            </form>

            <div style="text-align: center;">
                <a href="listarProcedimento.php">Voltar</a>
            </div>
        </section>

    </main>

</body>

</html>