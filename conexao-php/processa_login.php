<?php
session_start();

try {
    require_once('conexao.php');

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sqlAdm = "SELECT * FROM tblUsuario WHERE emailUsuario = :email AND senhaUsuario = :senha AND UsuarioAtivoInativo = 1 AND roleUsuario = 'adm'";
    $sqlCliente = "SELECT * FROM tblUsuario WHERE emailUsuario = :email AND senhaUsuario = :senha AND UsuarioAtivoInativo = 1 AND roleUsuario = 'cliente'";

    $query = $conn->prepare($sqlAdm);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':senha', $senha, PDO::PARAM_STR);
    
    $queryCliente = $conn->prepare($sqlCliente);
    $queryCliente->bindParam(':email', $email, PDO::PARAM_STR);
    $queryCliente->bindParam(':senha', $senha, PDO::PARAM_STR);

    if ($query->execute()) {
        //echo "<p>Consulta executada com sucesso.</p>";
        $resultados = $query->fetchAll(PDO::FETCH_ASSOC);
        // echo "<pre>"; print_r($resultados); echo "</pre>";

        if ($query->rowCount() > 0 && $query == true) {
            //echo "<p>Usuário encontrado. Redirecionando...</p>";
            $_SESSION['admin_logado'] = true;
            header('Location: /Projeto-PI---TSI---2--semestre--main/PHP/painelUsuario.php');
            exit;
        }
        elseif ($queryCliente->execute()) {
            //echo "<p>Consulta executada com sucesso.</p>";
            $resultados = $queryCliente->fetchAll(PDO::FETCH_ASSOC);
            // echo "<pre>"; print_r($resultados); echo "</pre>";
    
            if ($queryCliente->rowCount() > 0) {
                //echo "<p>Usuário encontrado. Redirecionando...</p>";
                $_SESSION['admin_logado'] = true;
                header('Location: /Projeto-PI---TSI---2--semestre--main/PHP/painelCliente.php');
                exit;
            }
            else {
                $_SESSION['mensagem_erro'] = "Usuário sem permissão";
                header('Location: /Projeto-PI---TSI---2--semestre--main/PHP/login.php?erro');
                exit;
            }
        }
        else {
            $_SESSION['mensagem_erro'] = "Nome de usuário ou senha incorreto";
            header('Location: /Projeto-PI---TSI---2--semestre--main/PHP/login.php?erro');
            exit;
        }
    }
    else {
        echo "<p>Erro na execução da query:</p>";
        print_r($query->errorInfo());
    }

} catch (Exception $e) {
    echo "<p>Erro de conexão: " . $e->getMessage() . "</p>";
}
?>
