<?php
session_start();

require_once('conexao.php'); // <- adicione aspas

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql= "SELECT * FROM tblUsuario WHERE Email = :email AND Senha = :senha";   

$query = $conn->prepare($sql); // <- troque $pdo para $conn
$query->bindParam(':email',$email, PDO::PARAM_STR);
$query->bindParam(':senha',$senha, PDO::PARAM_STR);

$query->execute();

if ($query->rowCount()>0) {
    $_SESSION['admin_logado'] = true;
    header('Location: painelUsuario.html');
} else {
    header('Location: login.html?erro');
}
?>