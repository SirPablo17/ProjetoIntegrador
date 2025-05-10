<?php
session_start();

try {
    require_once('conexao.php');

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Busca UM usuário (seja adm ou cliente)
    $sql = "SELECT * FROM tblUsuario WHERE emailUsuario = :email AND senhaUsuario = :senha AND UsuarioAtivoInativo = 1";
    $query = $conn->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':senha', $senha, PDO::PARAM_STR);

    $query->execute();
    $usuario = $query->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Se encontrou o usuário, agora verificamos o papel (role)
        if ($usuario['roleUsuario'] == 'adm') {
            $_SESSION['admin_logado'] = true;
            $_SESSION['admin_id'] = $usuario['usuarioID'];
            $_SESSION['admin_nome'] = $usuario['nome'];

            header('Location: /Projeto-PI---TSI---2--semestre-/PHP/painelAdministrador.php');
            exit;
        } elseif ($usuario['roleUsuario'] == 'cliente') {
            $_SESSION['cliente_logado'] = true;
            $_SESSION['cliente_id'] = $usuario['usuarioID'];
            $_SESSION['cliente_nome'] = $usuario['nome'];

            header('Location: /Projeto-PI---TSI---2--semestre-/PHP/painelCliente.php');
            exit;
        } else {
            $_SESSION['mensagem_erro'] = "Usuário sem permissão";
            echo 'Usuário sem permissão';
            header('Location: /Projeto-PI---TSI---2--semestre-n/PHP/login.php?erro');
            exit;
        }

    } else {
        $_SESSION['mensagem_erro'] = "Nome de usuário ou senha incorreto";
        header('Location: /Projeto-PI---TSI---2--semestre-/PHP/login.php?erro');
        exit;
    }

} catch (Exception $e) {
    echo "<p>Erro de conexão: " . $e->getMessage() . "</p>";
}
?>
