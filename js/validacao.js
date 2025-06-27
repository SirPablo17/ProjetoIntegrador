function verificaCPF(strCPF) {
    var Soma;
    var Resto;
    Soma = 0;
  if (strCPF == "00000000000") return false;

  for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
  Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;

  Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
    return true;
}

document.getElementById('cpfForm').addEventListener('submit', function(e) {
    var cpf = document.getElementById('cpf').value;
    if (!verificaCPF(cpf)) {
      e.preventDefault(); // Impede o envio do formulário
      alert('CPF inválido. Verifique o número digitado.');
      document.getElementById('cpf').focus(); // Foca no campo de CPF após o erro
    }
  });


function confirmarSenha(e) {
    const senha = document.getElementById("senhaUsuario").value;
    const confirmarSenha = document.getElementById("ConfirmarsenhaUsuario").value;

    if (senha !== confirmarSenha) {
        alert("As senhas não coincidem.");
        return false; // Cancela o envio do formulário
    }

    return true;
}
