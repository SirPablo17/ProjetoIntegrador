
<?php
session_start();
require_once ('C:\xampp\htdocs\Projeto-PI---TSI---2--semestre-\conexao-php\conexao.php');

// Verifica se o cliente está logado
if (!isset($_SESSION['admin_logado']) && !isset($_SESSION['cliente_logado'])) {
    header('Location: login.php');
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
          <div class="title">Adicionar Evento</div>
          <i class="fas fa-times close"></i>
        </div>
        <div class="add-event-body">
          <div class="add-event-input">
            <input type="text" placeholder="Nome da Consulta" class="event-name" />
          </div>
          <div class="add-event-input">
            <input type="text" placeholder="Event Time From" class="event-time-from" id="event-time-from" />
          </div>
          <div class="add-event-input">
            <input type="text" placeholder="Event Time To" class="event-time-to" id="event-time-to" />
          </div>
        </div>
        <div class="add-event-footer">
          <button class="add-event-btn">Adicionar Evento</button>
        </div>
       
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
</body>

</html>