<?php
// Inicia a sessão para poder acessar variáveis de erro, se houver
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - O Poder das Tranças</title>
    <link rel="stylesheet" href="src/CSS/login.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <header>
        <div class="header-content">
            <img class="logo-header" src="src/image/LOGO - offwhite 1.png" alt="Logo da Empresa">
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php">Produto</a></li>
                    <li><a href="#">Serviços</a></li>
                    <li><a href="#">Parcerias</a></li>
                    <li><a href="#">Contato</a></li>
                </ul>
            </nav>
            <div class="header-buttons">
                <a href="#" class="btn-header">Sobre nós</a>
                <a href="login.php" class="btn-header">Entrar</a>
            </div>
        </div>
    </header>

    <main>
        <div class="main-container">
            <div class="form-container">
                <div class="form-header">
                    <h2>Login</h2>
                </div>

                <?php
                // Mostra uma mensagem de erro se a URL contiver ?erro=...
                if (isset($_GET['erro'])) {
                    $erro = $_GET['erro'];
                    $mensagem = '';
                    if ($erro == 'login_invalido') {
                        $mensagem = 'E-mail ou senha inválidos. Tente novamente.';
                    } else if ($erro == 'campos_vazios') {
                        $mensagem = 'Por favor, preencha todos os campos.';
                    } else if ($erro == 'login_necessario') {
                        $mensagem = 'Você precisa fazer login para acessar esta página.';
                    }
                    echo '<p class="mensagem-erro">' . $mensagem . '</p>';
                }
                ?>
                
                <form class="login-form" action="valida_login.php" method="POST">
                    <div class="input-group">
                        <i class="bi bi-envelope-fill"></i>
                        <input type="email" name="email" placeholder="Email" required autocomplete="off">
                    </div>

                    <div class="input-group">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" name="senha" placeholder="Senha" required autocomplete="off">
                    </div>

                    <button type="submit" class="btn-login">ENTRAR</button>
                </form>
                <div class="separator">
                    <span>ou</span>
                </div>
                <a href="<?php echo $google_login_url; ?>" class="btn-google">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google Logo">
                    Entrar com Google
                </a>
            </div>
            <div class="welcome-container">
                <h3>Olá</h3>
                <h1>Seja Bem-Vindo</h1>
                <a href="cadastro.php" class="btn-register">CADASTRAR-SE</a>
            </div>
        </div>
    </main> 
</body>
</html>