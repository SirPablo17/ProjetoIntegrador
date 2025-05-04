<?php
session_start();

try {
    require_once('conexao.php');

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM tblUsuario WHERE emailUsuario = :email AND senhaUsuario = :senha AND UsuarioAtivoInativo = 1";

    $query = $conn->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':senha', $senha, PDO::PARAM_STR);

    if ($query->execute()) {
        //echo "<p>Consulta executada com sucesso.</p>";
        $resultados = $query->fetchAll(PDO::FETCH_ASSOC);
        // echo "<pre>"; print_r($resultados); echo "</pre>";

        if ($query->rowCount() > 0) {
            //echo "<p>Usuário encontrado. Redirecionando...</p>";
            $_SESSION['admin_logado'] = true;
            header('Location: /Projeto-PI---TSI---2--semestre-/PHP/painelUsuario.php');
            exit;
        } else {
            $_SESSION['mensagem_erro'] = "Nome de usuário ou senha incorreto";
            header('Location:login.php?erro');
            exit;
        }
    } else {
        echo "<p>Erro na execução da query:</p>";
        print_r($query->errorInfo());
    }

} catch (Exception $e) {
    echo "<p>Erro de conexão: " . $e->getMessage() . "</p>";
}
?>
