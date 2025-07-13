<?php
session_start();
require_once ('C:\xampp\htdocs\ProjetoIntegrador\conexao-php\conexao.php');

// Verifica se o cliente está logado
if (!isset($_SESSION['cliente_logado'])) {
    header('Location: login.php');
    exit;
}

// Buscar procedimentos disponíveis no banco
try {
    $stmt = $conn->query("SELECT procedimentoID, descricaoProcedimento, valorProcedimento FROM tblProcedimentos");
    $procedimentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar procedimentos: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Marcar Consulta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../style/marcarConsulta.css"> <!-- Pode ser o mesmo estilo -->
</head>

<body>

    <header>
        <h1>Marcar Consulta</h1>
    </header>

    <main>
        <div class="marcar-consulta">
            <h2>Selecione a data e os procedimentos</h2>

            <form action="../conexao-php/processa_marcarConsulta.php" method="POST">
                <label for="dataConsulta">Data da Consulta:</label>
                <input type="date" id="dataConsulta" name="dataConsulta" min="<?php echo date('Y-m-d'); ?>" required>

                <label for="horarioConsulta">Hora da Consulta:</label>
                <input type="time" id="horarioConsulta" name="horarioConsulta" required>


                <div class="procedimentos-container">
                    <p><strong>Procedimentos Disponíveis:</strong></p>
                    <?php foreach ($procedimentos as $proc): ?>
                    <label>
                        <input type="checkbox" name="procedimentos[]" value="<?php echo $proc['procedimentoID']; ?>">
                        <?php echo htmlspecialchars($proc['descricaoProcedimento']); ?> — R$
                        <?php echo number_format($proc['valorProcedimento'], 2, ',', '.'); ?>
                    </label>
                    <?php endforeach; ?>
                </div>

                <div class="centralizar_botao">
                    <button type="submit" class="botao_acao">Marcar Consulta</button>
                </div>
                <?php
                if (isset($_SESSION['mensagem_erro'])) {
                 echo "<p style='color:white;'>" . $_SESSION['mensagem_erro'] . "</p>";
                unset($_SESSION['mensagem_erro']); // Limpa a mensagem após exibi-la
                }
                ?>
            </form>


            <a href="painelCliente.php" class="voltar-link">Voltar ao painel</a>
        </div>
    </main>


</body>

</html>