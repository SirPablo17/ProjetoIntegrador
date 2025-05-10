<?php
session_start(); // Inicia a sessão

// Destruir todas as variáveis de sessão
session_unset();

// Destruir a sessão
session_destroy();

// Redireciona o usuário para a página inicial
header("Location: index.php");
exit();
?>