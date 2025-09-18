<?php
// Verifica se a sessão AINDA NÃO foi iniciada
if (session_status() === PHP_SESSION_NONE) {
    // Se não foi, então a gente inicia a sessão
    session_start();
}

// Agora, com a sessão garantida, o resto da lógica de verificação continua igual
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== 'sim') {
    
    // Se o usuário não estiver autenticado, redireciona para a página de login
    // com uma mensagem de erro.
    header('Location: login.php?erro=login_necessario');
    exit(); // Garante que o resto do script não seja executado
}
?>