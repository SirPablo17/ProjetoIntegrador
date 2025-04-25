<?php
$serverName = "tcp:pi2semestre.database.windows.net,1433"; 
$database = "PI";                                        
$username = "senac";                                       
$password = "#Lolzinhotodasexta";   

try {
    $conn = new PDO("sqlsrv:server = tcp:pi2semestre.database.windows.net,1433; Database = PI", "senac", "#Lolzinhotodasexta");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo"conexão bem sucedida"
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}
