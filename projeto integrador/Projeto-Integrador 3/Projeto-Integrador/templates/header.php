<?php
// =======================================================
// CABEÇALHOS DE SEGURANÇA PARA IMPEDIR O CACHE
// =======================================================
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Agora, o resto do seu código do header começa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/CSS/index.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="src/FavIcon/ÍCONE-transp-1-_1_.ico" type="image/x-icon">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap" rel="stylesheet">
    
    <title>O Poder das Tranças</title>
</head>
<body>

<section class="hero-section">

    <header>
        <div class="div-header">
            <img class="Logo" src="src/image/LOGO - offwhite 1.png" alt="Logo O Poder das Tranças">
            
            <nav>
                <ul class="menu-principal">
                    <li class="item-menu"><a href="#">Produto</a></li>
                    <li class="item-menu"><a href="agendamento.php">Serviços</a></li>
                    <li class="item-menu"><a href="#">Parcerias</a></li>
                    <li class="item-menu"><a href="servicos.php">Contato</a></li>
                </ul>
            </nav>
            
            <section class="sec-botao">
                <?php if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === 'sim'): ?>
                    
                    <a href="src/PHP/painel.php" class="botao">
                        Olá, <?= htmlspecialchars(explode(' ', $_SESSION['usuario_nome'])[0]); ?>
                    </a>
                    <a href="logout.php" class="botao botao-destaque">Sair</a>
                
                <?php else: ?>
                
                    <a href="src/PHP/painel.php" class="botao">Gerenciamento</a>
                    <a href="login.php" class="botao botao-destaque">Entrar</a>

                <?php endif; ?>
            </section>
        </div>
    </header>

    <div class="hero-title">
        <h2>O PODER DAS TRANÇAS</h2>
    </div>

</section>

<main>