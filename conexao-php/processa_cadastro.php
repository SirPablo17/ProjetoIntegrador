<?php
session_start();

try {
    require_once('conexao.php');

    // Coletando os dados do formulário
    $nome = $_POST['nomeCompleto'];
    $dataNascimento = $_POST['dataNascimento'];
    $cpf = $_POST['cpfUsuario'];
    $telefone = $_POST['telefoneUsuario'];
    $cep = $_POST['cepUsuario'];
    $email = $_POST['emailUsuario'];
    $senha = $_POST['usuarioSenha']; // Estou assumindo que aqui é a senha
    $endereco = $_POST['enderecoUsuario'];

    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    $telefone = preg_replace('/[^0-9]/', '', $telefone);
    $cep = preg_replace('/[^0-9]/', '', $cep);

    // Definindo a role, status e endereço (exemplo de valor padrão, ajuste se necessário)
    $role = 'cliente';
    $status = 1;

    $sql = "INSERT INTO tblUsuario (roleUsuario, nome, CPF, endereco, emailUsuario, senhaUsuario, CEP, telefoneUsuario, dataNascimento, usuarioAtivoInativo)
            VALUES (:roleUsuario, :nome, :cpf, :endereco, :email, :senha, :cep, :telefone, :dataNascimento, :status)";

    $query = $conn->prepare($sql);

    // Fazendo o bind de TODOS os parâmetros corretamente
    $query->bindParam(':roleUsuario', $role, PDO::PARAM_STR);
    $query->bindParam(':nome', $nome, PDO::PARAM_STR);
    $query->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $query->bindParam(':endereco', $endereco, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':senha', $senha, PDO::PARAM_STR);
    $query->bindParam(':cep', $cep, PDO::PARAM_STR);
    $query->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $query->bindParam(':dataNascimento', $dataNascimento, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_INT);

    if ($query->execute()) {
        $_SESSION['mensagem_sucesso'] = "Usuário cadastrado com sucesso!";
        header('Location: /Projeto-PI---TSI---2--semestre-/PHP/Login.php');
        exit;
    } else {
        echo "<p>Erro na execução da query:</p>";
        print_r($query->errorInfo());
    }

} catch (Exception $e) {
    echo "<p>Erro de conexão: " . $e->getMessage() . "</p>";
}
?>
