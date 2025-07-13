


<?php
/* Conexão com o SQLEXPRESS */ 
$serverName = "localhost\\SQLEXPRESS";
$database = "ProjetoIntegrador2";

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;", null, null);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage(); 
}



/* Conexão com AZURE
try {
    $conn = new PDO("sqlsrv:server=tcp:pi2semestre.database.windows.net,1433;Database=PI", "senac", "#Lolzinhotodasexta");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conexão bem-sucedida";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
*/
?>

