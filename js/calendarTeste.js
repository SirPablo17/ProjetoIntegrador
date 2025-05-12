document.getElementById('formConsulta').addEventListener('submit', async function(e) {
  e.preventDefault();

  const formData = new FormData(this);

  const response = await fetch('registrarConsulta.php', {
    method: 'POST',
    body: formData
  });

  const resultado = await response.json();
  alert(resultado.mensagem);

  if (resultado.status === 'success') {
    carregarConsultasDoBanco(); // Atualiza o calendário!
  }
});
