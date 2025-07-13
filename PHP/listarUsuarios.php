<?php

//Nesse arquivo, que pode ser chamado na página painel_administrador, primeiro selecionamos através de um script php todos os administradores ativos do banco de dados. Armazenamos esse resultado na variável $administradores
//A seguir, através de uma tabela no html, puxamos esses dados selecionados (através de um foreach, usando a variável $administradores e uma variável $adm, criada no foreach) e os apresentamos.
//Também criamos dois links em cada linha da tabela para editar (quando clicado, direciona o usuário para a página editar_administrador.php, passando o ID do administrador como um parâmetro GET na URL) ou excluir o administrador (quando clicado, chama a function confirmDeletion(), que cria uma janela que é apresentada ao usuário para confirmar a exclusão ou não do administrador)

session_start();

require_once ('C:\xampp\htdocs\ProjetoIntegrador\conexao-php\conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}
$administradores = []; // Inicializa como array vazio

try {
    /*sem usar declarações preparadas (Executa a consulta diretamente):
     $result = $pdo->query("SELECT * FROM ADMINISTRADOR");
    // Busca todos os registros retornados
    $administradores = $result->fetchAll(PDO::FETCH_ASSOC); */

    //Usando declarações preparadas (recomendado):
    $stmt = $conn->prepare("SELECT * FROM tblUsuario"); //vai buscar todas as colunas da tabela ADMINISTRADOR
    $stmt->execute();  //***vide explicações sobre a dinâmica desses comandos no final do arquivo
    $administradores = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetch = recuperar, buscar
    
    /*Para efeitos de depuração, se quisesse ver a variável $administradores, poderia mandar escrevê-la:
    echo '<pre>';
    print_r($administradores);
    echo '</pre>';  */

} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao listar administradores: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Listar Usuários</title>
    <link rel="stylesheet" href="../style/listarUsuario.css">
    <link rel="stylesheet" href="../style/global.css">
<script>
function confirmDeletion() {
    return confirm('Tem certeza que deseja DELETAR este administrador?'); //o método confirm() é um método embutido (nativo) do JavaScript. Ele exibe uma caixa de diálogo com uma mensagem e dois botões: "OK" e "Cancelar". Este método é comumente usado para solicitar uma confirmação do usuário antes de realizar uma ação importante, como deletar um item. confirm(...) mostra uma janela modal com “OK” e “Cancelar”. Se o usuário clicar em OK, confirm(...) retorna true → o link é seguido. Se clicar em Cancelar, retorna false → nada acontece.
}

function confirmEdition(){
    return confirm('Tem certeza que deseja EDITAR este administrador?')
}
</script>

</head>
<body>

<section class="section-consultas" >
<h2>Usuários Cadastrados</h2>
<table>
    <tr>
        <th>Código</th>
        <th>Tipo de Permissões</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Telefone</th>
        <th>CPF</th>
        <th>Data de nascimento</th>
        <th>Ativo</th>
        <th>Ações</th>
        <!-- <th>Imagem</th> -->
    </tr>
    <?php foreach($administradores as $adm): ?>
    <tr>
        <td><?php echo $adm['usuarioID']; ?></td>
        <td><?php echo $adm['roleUsuario']; ?></td>
        <td><?php echo $adm['nome']; ?></td>
        <td><?php echo $adm['emailUsuario']; ?></td>
        <td class ="tel"><?php echo $adm['telefoneUsuario']; ?></td>
        <td class ="cpf"><?php echo $adm['CPF']; ?></td>
        <td> <?php echo $adm['dataNascimento']; ?></td>
        <td><?php echo ($adm['usuarioAtivoInativo'] == 1 ? 'Sim' : 'Não'); ?></td>
        
        <td>
            <a href="editarUsuario.php?id=<?php echo $adm['usuarioID']; ?>" class="action-btn" onclick="return confirmEdition()">Editar</a>
            <!-- A linha de código HTML acima, cria um link que, quando clicado, direciona o usuário para a página editar_administrador.php, passando o ID do administrador como um parâmetro GET na URL. Além disso, o link é estilizado com uma classe CSS chamada action-btn. 
            ?id=< ?php echo $adm['ADM_ID']; ?>: Esta parte é um parâmetro de query na URL. Após o nome do arquivo PHP (editar_administrador.php), o ? inicia a string de query. id= define uma variável de query chamada id, cujo valor é definido pelo trecho PHP < ?php echo $adm['ADM_ID']; ?>. Este código PHP insere dinamicamente o ID do administrador no link, pegando o valor da chave ADM_ID do array $adm. Isso significa que, para cada administrador listado, será gerado um link único que inclui seu respectivo ID como parte da URL. Essa técnica é comumente usada para passar informações entre páginas via URL
            
            Como funciona o <a href="…?id=< ?php echo $adm['ADM_ID']; ?>">
            O browser renderiza esse trecho em HTML puro. Por exemplo, para o administrador de ID 2:

            <a href="editar_administrador.php?id=2" class="action-btn">Editar</a>
            Quando o usuário clica, o navegador faz uma requisição GET para
            editar_administrador.php?id=2.

            Em editar_administrador.php, você acessa $_GET['id'] (aqui, o valor 2) e pode usá-lo para carregar o registro correto do banco de dados ou apenas confirmar que recebeu o parâmetro.

            Dessa forma, usando query strings (?chave=valor), você passa informações entre páginas sem formulários, só com links dinâmicos.
                -->

            <a href="excluirUsuario.php?id=<?php echo $adm['usuarioID']; ?>" class="action-btn delete-btn" onclick="return confirmDeletion();">Excluir</a>
            <!-- O atributo onclick em um elemento HTML define um handler (ou “ouvinte”) de evento JavaScript que será executado quando o usuário clicar naquele elemento. Antes de seguir a URL (excluir_administrador.php?id=...), o navegador vai executar a função JavaScript confirmDeletion().O return é fundamental. Se confirmDeletion() retornar true, o clique prossegue normalmente e o navegador carrega a página apontada em href.Se retornar false, a ação padrão (navegar para href) é cancelada.-->
        </td>
</tr>

    <?php endforeach; ?>
</table>
    <br>
    <a class="btn-export" href="exportarUsuarios.php">Exportar dados em Excel</a>
    <br><br>
    <a class="btn-voltar" href="painelAdministrador.php">Voltar ao Painel do Administrador</a>
    <script src="../js/mascaras.js"></script>
</section>


</body>
</html>
