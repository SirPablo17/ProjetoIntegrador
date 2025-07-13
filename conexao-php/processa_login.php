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
        $user = $query->fetchAll(PDO::FETCH_ASSOC);
        // echo "<pre>"; print_r($resultados); echo "</pre>";

        if ($query->rowCount() > 0) {
            //echo "<p>Usuário encontrado. Redirecionando...</p>";
            $_SESSION['admin_logado'] = true;
            $_SESSION['admin_id'] = $user[0]['usuarioID'];;
            $_SESSION['admin_nome'] = $user[0]['nome'];
            header('Location: /ProjetoIntegrador/PHP/painelAdministrador.php');
            exit;
        }
        elseif ($queryCliente->execute()) {
            //echo "<p>Consulta executada com sucesso.</p>";
            $user = $queryCliente->fetchAll(PDO::FETCH_ASSOC);
            // echo "<pre>"; print_r($resultados); echo "</pre>";
    
            if ($queryCliente->rowCount() > 0) {
                //echo "<p>Usuário encontrado. Redirecionando...</p>";
                $_SESSION['cliente_logado'] = true;
                $_SESSION['cliente_id'] = $user[0]['usuarioID'];
                $_SESSION['cliente_nome'] = $user[0]['nome'];
                header('Location: /ProjetoIntegrador/PHP/painelCliente.php');
                exit;
            }
            else {
                $_SESSION['mensagem_erro'] = "Usuário sem permissão";
                header('Location: /ProjetoIntegrador/PHP/login.php?erro');
                exit;
            }
        }
        else {
            $_SESSION['mensagem_erro'] = "Nome dp usuário ou senha incorreto";
            header('Location: /ProjetoIntegrador/PHP/login.php?erro');
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