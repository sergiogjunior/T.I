<?php
session_start(); // Inicia a sessão para poder manipulá-la
session_unset(); // Limpa todas as variáveis da sessão (nome, id, etc.)
session_destroy(); // Destrói completamente a sessão
header('Location: index.php'); // Redireciona o usuário para a página inicial
exit();
?>