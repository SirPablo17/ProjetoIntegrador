<?php
session_start();

require_once ('C:\xampp\htdocs\ProjetoIntegrador\conexao-php\conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location: login.php");
    exit();
}

// 1. Recupera o id do administrador
$adm_id = $_GET['id'] ?? null;
if (!$adm_id) {
    echo "<p style='color:red;'>ID do administrador não informado.</p>";
    exit();
}

// Busca as informações do administrador no BD
$stmt_adm = $conn->prepare("SELECT * FROM tblUsuario WHERE usuarioID = :adm_id");
$stmt_adm->bindParam(':adm_id', $adm_id, PDO::PARAM_INT);
$stmt_adm->execute();
$adm = $stmt_adm->fetch(PDO::FETCH_ASSOC);

if (!$adm) {
    echo "<p style='color:red;'>Administrador não encontrado.</p>";
    exit();
}

// 2. Se enviou o formulário, atualiza os dados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $emailUsuario = $_POST['emailUsuario'];
    $senhaUsuario = $_POST['senhaUsuario'];
    $usuarioAtivoInativo = isset($_POST['usuarioAtivoInativo']) ? 1 : 0;
    $CPF = $_POST['CPF'];
    $endereco = $_POST['endereco'];
    $numeroCasa = $_POST['numeroCasa'];
    $CEP = $_POST['CEP'];
    $telefoneUsuario = $_POST['telefoneUsuario'];
    $dataNascimento = $_POST['dataNascimento'];
    $roleUsuario = $_POST['roleUsuario'];  // Será 'adm' ou 'cliente'

    try {
        $stmt_update_adm = $conn->prepare("
            UPDATE tblUsuario
                SET [nome] = :nome,
                [emailUsuario] = :emailUsuario,
                [senhaUsuario] = :senhaUsuario,
                [usuarioAtivoInativo] = :usuarioAtivoInativo,
                [CPF] = :CPF,
                [endereco] = :endereco,
                [numeroCasa] = :numeroCasa,
                [CEP] = :CEP,
                [telefoneUsuario] = :telefoneUsuario,
                [dataNascimento] = :dataNascimento,
                [roleUsuario] = :roleUsuario
                WHERE [usuarioID] = :adm_id
        ");
        $stmt_update_adm->bindParam(':nome', $nome);
        $stmt_update_adm->bindParam(':emailUsuario', $emailUsuario);
        $stmt_update_adm->bindParam(':senhaUsuario', $senhaUsuario);
        $stmt_update_adm->bindParam(':usuarioAtivoInativo', $usuarioAtivoInativo);
        $stmt_update_adm->bindParam(':CPF', $CPF);
        $stmt_update_adm->bindParam(':endereco', $endereco);
        $stmt_update_adm->bindParam(':numeroCasa', $numeroCasa);
        $stmt_update_adm->bindParam(':CEP', $CEP);
        $stmt_update_adm->bindParam(':telefoneUsuario', $telefoneUsuario);
        $stmt_update_adm->bindParam(':dataNascimento', $dataNascimento);
        $stmt_update_adm->bindParam(':adm_id', $adm_id);
        $stmt_update_adm->bindParam(':roleUsuario', $roleUsuario);

        $stmt_update_adm->execute();

        echo "<p style='color:green;'>Usuário atualizado com sucesso!</p>";

        // Atualiza o array $adm com os novos valores
        $adm = array_merge($adm, $_POST);
        $adm['usuarioAtivoInativo'] = $usuarioAtivoInativo;
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao atualizar administrador: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Editar Administrador</title>
    <link rel="stylesheet" href="../style/editar.css">
    <link rel="stylesheet" href="../style/global.css">
</head>

<body>
    <div class="editar">
        <div class="h1-title"><h1>Editar Administrador</h1></div>
        <form action="" method="POST" class="editar_form">

            <div class = "campo"> 
                <label for="nome">Nome completo:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($adm['nome']); ?>" required>
            </div>

            <div class = "campo"> 
                <label for="roleUsuario">Role:</label>
                <select id="roleUsuario" name="roleUsuario">
                    <option value="adm" <?php echo ($adm['roleUsuario']=='adm' ) ? 'selected' : '' ; ?>>Administrador
                    </option>
                    <option value="cliente" <?php echo ($adm['roleUsuario']=='cliente' ) ? 'selected' : '' ; ?>>Cliente
                    </option>
                </select>
            </div>

            <div class = "campo"> 
                <label for="dataNascimento">Data de nascimento:</label>
                <input type="date" id="dataNascimento" name="dataNascimento"
                value="<?php echo htmlspecialchars($adm['dataNascimento']); ?>" required>
            </div>

            <div class = "campo"> 
                <label for="CPF">CPF:</label>
                <input type="text" id="CPF" oninput="CPF(this)" name="CPF" value="<?php echo htmlspecialchars($adm['CPF']); ?>" required>
            </div>

            <div class = "campo">
                <label for="telefoneUsuario">Telefone:</label>
                <input type="text" id="telefoneUsuario" oninput="TEL(this)"  name="telefoneUsuario"
                value="<?php echo htmlspecialchars($adm['telefoneUsuario']); ?>">

            </div>

            <div class = "campo"> 
                <label for="CEP">CEP:</label>
                <input type="text" id="CEP" oninput="CEP(this)" name="CEP" value="<?php echo htmlspecialchars($adm['CEP']); ?>">
            </div>
            <div class = "campo"> 
                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" name="endereco" value="<?php echo htmlspecialchars($adm['endereco']); ?>">
            </div>

            <div class = "campo"> 
                <label for="numero">Endereço:</label>
                <input type="text" id="numeroCasa" name="numeroCasa" value="<?php echo htmlspecialchars($adm['numeroCasa']); ?>">
            </div>

            <div class = "campo">
                <label for="emailUsuario">E-mail:</label>
                <input type="email" id="emailUsuario" name="emailUsuario"
                value="<?php echo htmlspecialchars($adm['emailUsuario']); ?>" required>
            </div>

            <div class = "campo">
                  <label for="senhaUsuario">Senha:</label>
                <input type="password" id="senhaUsuario" name="senhaUsuario"
                value="<?php echo htmlspecialchars($adm['senhaUsuario']); ?>" required>
            </div>
            <div class = "campo"> 
                <label for="usuarioAtivoInativo">Ativo:</label>
                <input type="checkbox" id="usuarioAtivoInativo" name="usuarioAtivoInativo" <?php echo
                $adm['usuarioAtivoInativo'] ? 'checked' : '' ; ?>>
            </div>
            
            <div class="centralizar_botao">
                <button type="submit" class="botao_acao">Atualizar</button>
            </div>
        </form>

        <p></p>
        <a href="listarUsuarios.php">Voltar à Lista de Administradores</a>
    </div>

    <script src="../js/mascaras.js"></script>
</body>

</html>