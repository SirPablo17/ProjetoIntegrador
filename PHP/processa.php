<?php 

require_once(conexao.php);

$nome = $_POST['email'];
$senha = $_POST['senha'];

$sql= "SELECT * FROM tblUsuario WHERE Email = :email AND Senha = :senha";

$query = $pdo->prepare($sql);
$query->bindParam(':nome',$nome, PDO::PARAM_STR);
$query->bindParam(':senha',$senha, PDO::PARAM_STR);

$query->execute();

if ($query->rowCount()>0) {
    $_SESSION['admin_logado'] = true;
    header('Location: painelUsuario.html');
}else {
    header('Location:login.html?erro');
}

?>