<?php
try {
    $conn = new PDO("sqlsrv:server=tcp:pi2semestre.database.windows.net,1433;Database=PI", "senac", "#Lolzinhotodasexta");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão bem-sucedida";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>

