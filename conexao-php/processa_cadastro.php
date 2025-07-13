<?php
session_start();

try {
    require_once('conexao.php');

    // Coletando os dados do formulário
    $nome = $_POST['nomeCompleto'];
    $cpf = $_POST['cpfUsuario'];
    $endereco = $_POST['enderecoUsuario'];
    $numeroCasa = $_POST ['numeroCasa'];
    $email = $_POST['emailUsuario'];
    $senha = $_POST['usuarioSenha'];
    $cep = $_POST['cepUsuario'];
    $telefone = $_POST['telefoneUsuario'];
    $dataNascimento = $_POST['dataNascimento'];

    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    $telefone = preg_replace('/[^0-9]/', '', $telefone);
    $cep = preg_replace('/[^0-9]/', '', $cep);

    // Definindo a role, status e endereço (exemplo de valor padrão, ajuste se necessário)
    $role = 'cliente';
    $status = 1;

    $sql = "INSERT INTO tblUsuario (roleUsuario, nome, CPF, endereco, numeroCasa, emailUsuario, senhaUsuario, CEP, telefoneUsuario, dataNascimento, usuarioAtivoInativo)
            VALUES (:roleUsuario, :nomeCompleto, :cpfUsuario, :endereco, :numeroCasa, :emailUsuario, :usuarioSenha, :cepUsuario, :telefoneUsuario, :dataNascimento, :status)";

    $query = $conn->prepare($sql);

    // Fazendo o bind de TODOS os parâmetros corretamente
    $query->bindParam(':roleUsuario', $role, PDO::PARAM_STR);
    $query->bindParam(':nomeCompleto', $nome, PDO::PARAM_STR);
    $query->bindParam(':cpfUsuario', $cpf, PDO::PARAM_STR);
    $query->bindParam(':endereco', $endereco, PDO::PARAM_STR);
    $query->bindParam(':numeroCasa', $numeroCasa, PDO::PARAM_STR);
    $query->bindParam(':emailUsuario', $email, PDO::PARAM_STR);
    $query->bindParam(':usuarioSenha', $senha, PDO::PARAM_STR);
    $query->bindParam(':cepUsuario', $cep, PDO::PARAM_STR);
    $query->bindParam(':telefoneUsuario', $telefone, PDO::PARAM_STR);
    $query->bindParam(':dataNascimento', $dataNascimento, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_INT);

    if ($query->execute()) {
        $_SESSION['mensagem_sucesso'] = "Usuário cadastrado com sucesso!";
        header('Location: /ProjetoIntegrador/PHP/Login.php');
        exit;
    } else {
        echo "<p>Erro na execução da query:</p>";
        print_r($query->errorInfo());
    }

} catch (Exception $e) {
    echo "<p>Erro de conexão: " . $e->getMessage() . "</p>";
}
?>
