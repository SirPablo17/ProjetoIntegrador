<?php
session_start();
require_once ('C:\xampp\htdocs\ProjetoIntegrador\conexao-php\conexao.php');

// Verifica se o cliente está logado
if (!isset($_SESSION['admin_logado']) && !isset($_SESSION['cliente_logado'])) {
    header('Location: login.php');
    exit;
}

// Buscar procedimentos disponíveis no banco
try {
  $stmt = $conn->prepare("SELECT * FROM tblProcedimentos");
  $stmt->execute();
  $consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar procedimentos: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description"
    content="Stay organized with our user-friendly Calendar featuring events, reminders, and a customizable interface. Built with HTML, CSS, and JavaScript. Start scheduling today!" />
  <meta name="keywords" content="calendar, events, reminders, javascript, html, css, open source coding" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../style/styleCalen.css" />
  <title>Calendar with Events</title>
</head>

<body>
  <div class="container">
    <div class="left">
      <div class="calendar">
        <div class="month">
          <i class="fas fa-angle-left prev"></i>
          <div class="date">Dezembro de 2015</div>
          <i class="fas fa-angle-right next"></i>
        </div>
        <div class="weekdays">
          <div>Dom</div>
          <div>Seg</div>
          <div>Ter</div>
          <div>Quar</div>
          <div>Quin</div>
          <div>Sex</div>
          <div>Sab</div>
        </div>
        <div class="days"></div>
        <div class="goto-today">
          <div class="goto">
            <input type="text" placeholder="mm/aaaa" class="date-input" />
            <button class="goto-btn">Ir</button>
          </div>
          <button class="today-btn">Hoje</button>
        </div>
      </div>
    </div>
    <div class="right">
      <div class="today-date">
        <div class="event-day">Quarta</div>
        <div class="event-date">12 de Dezembro de 2022</div>
      </div>
      <div class="events"></div>

      <div class="add-event-wrapper">
        <div class="add-event-header">
          <div class="title">Marcar consulta</div>
          <i class="fas fa-times close"></i>
        </div>
        <form action="../conexao-php/processa_marcarConsultaCalendario.php" method="POST">
          <div class="add-event-body">
            <div class="add-event-input">
              <input type="date" name="dataConsulta" placeholder="Data da Consulta" min="<?php echo date('Y-m-d'); ?>"
                required />
            </div>
            <div class="add-event-input">
              <input type="time" name="horarioConsulta" placeholder="Horário da Consulta" required />
            </div>
            <div class="add-event-input">
              <select name="procedimentos[]" multiple required>
                <option disabled>Selecione os procedimentos</option>
                <?php foreach ($consultas as $proc): ?>
                <option value="<?= htmlspecialchars($proc['procedimentoID']) ?>">
                  <?= htmlspecialchars($proc['descricaoProcedimento']) ?>
                </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="add-event-footer">
            <button class="add-event-btn" type="submit">Marcar Consulta</button>
          </div>
        </form>

      </div>
      <div class="botoes__finais">
        <a href="painelCliente.php" class="sair">Voltar</a>
        <button class="add-event">
          <i class="fas fa-plus"></i>
        </button>
      </div>
    </div>



  </div>
  <script src="../js/scriptCalen.js"></script>
  <script src="js/main.js?v=<?php echo time(); ?>"></script>
</body>

</html>