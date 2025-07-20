<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style/cadastrarAdm.css">
  <link rel="stylesheet" href="../style/global.css">
  <title>Cadastro</title>
</head>

<body>
  <header>
      <h1>Cadastrar Administrador</h1>
  </header>

  <main>
    <div class="cadastro">
      <form class="cadastro_form" action="../conexao-php/processa_cadastro.php" method="POST">
        <div class="form_group">
          <label for="nome">Nome</label>
          <input type="text" id="nome" name="nomeCompleto" placeholder="Seu nome">
        </div>

        <div class="form_group">
          <label for="cpf">CPF</label>
          <input type="text" id="cpf" name="cpfUsuario" placeholder="000.000.000-00" oninput="CPF(this)">
        </div>

        <div class="form_group">
          <label for="dataNascimento">Data de Nascimento</label>
          <input type="date" id="dataNascimento" name="dataNascimento">
        </div>

        <div class="form_group">
          <label for="telefone">Telefone</label>
          <input type="text" id="telefone" name="telefoneUsuario" placeholder="(99) 99999-9999"  oninput="TEL(this)">
        </div>

        <div class="form_group">
          <label for="cep">CEP</label>
          <input type="text" id="cep" name="cepUsuario" placeholder="00000000" onblur="buscarCEP()">
        </div>

        <div class="form_group">
          <label for="endereco">Endereço</label>
          <input type="text" id="endereco" name="enderecoUsuario" placeholder="Rua...">
        </div>

        <div class="form_group">
          <label for="endereco">Número</label>
          <input type="text" id="Numero" name="numeroCasa" placeholder="Número...">
        </div>

        <div class="form_group">
          <label for="emailUsuario">Email</label>
          <input type="email" id="emailUsuario" name="emailUsuario" placeholder="email@exemplo.com">
        </div>

        <div class="form_group">
          <label for="senhaUsuario">Senha</label>
          <input type="password" id="senhaUsuario" name="usuarioSenha" placeholder="Digite sua senha">
        </div>

        <div class="form_group">
          <label for="senhaUsuario">Confirmar Senha</label>
          <input type="password" id="ConfirmarsenhaUsuario" placeholder="Confirme sua senha">
        </div>

        <div class="centralizar_botao">
          <button type="submit" class="botao_acao" onclick="return confirmarSenha(event)">Cadastrar</button>
        </div>

        <div class="btn-voltar">
          <a href="painelAdministrador.php">Voltar para Menu Principal</a>
        </div>
      </form>

    </div>
  </main>
  <script src="../js/mascaras.js"></script>
  <script src="../js/buscarCep.js"></script>

</body>

</html>