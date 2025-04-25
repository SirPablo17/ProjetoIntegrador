<?php
// PHP Data Objects(PDO) Sample Code:
try {
    $conn = new PDO("sqlsrv:server = tcp:pi2semestre.database.windows.net,1433; Database = PI", "senac", "#Lolzinhotodasexta");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo"conexão bem sucedido"
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}
