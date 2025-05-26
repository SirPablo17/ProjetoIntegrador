<?php
session_start();

if (!isset($_SESSION['admin_logado'])) {
    header("Location: login.php");
    exit();
}

$consultaID = $_GET['id'] ?? null;

if (!$consultaID) {
    echo "<p>ID da consulta inválido.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cancelar Consulta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h2 {
            margin-bottom: 10px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        button {
            padding: 8px 16px;
            background-color: #c0392b;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: fit-content;
        }

        button:hover {
            background-color: #922b21;
        }
    </style>
</head>
<body>
    <h2>Cancelar Consulta</h2>
    <p>Escolha o motivo do cancelamento:</p>

    <form action="../conexao-php/processa_cancelamento_consulta.php" method="POST">
        <input type="hidden" name="consultaID" value="<?php echo htmlspecialchars($consultaID); ?>">

        <label>
            <input type="radio" name="motivos" value="Cliente não compareceu" required>
            Cliente não compareceu
        </label>

        <label>
            <input type="radio" name="motivos" value="Não quero mais realizar a consulta">
            Cliente Informou que desistiu da consulta
        </label>

        <label>
            <input type="radio" name="motivos" value="Outro compromisso">
            Outro compromisso
        </label>

        <button type="submit">Confirmar Cancelamento</button>
    </form>
</body>
</html>
