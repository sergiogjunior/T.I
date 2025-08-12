<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Blackelis</title>

    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <header>
        <div class="header-content">
            <img class="logo-header" src="src/image/LOGO - offwhite 1.png" alt="Logo da Empresa">
            
            <nav class="main-nav">
                <ul>
                    <li><a href="#">Produto</a></li>
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

            <div class="info-panel">
                <h1>Já é de casa?</h1>
                <a href="login.php" class="btn-secondary-action">FAZER LOGIN</a>
            </div>

            <div class="form-panel">
                <div class="form-header">
                    <h2>Cadastrar-se</h2>
                </div>

                <?php
                    if (isset($_GET['erro'])) {
                        $mensagem_erro = '';
                        switch ($_GET['erro']) {
                            case 'campos_vazios':
                                $mensagem_erro = 'Por favor, preencha todos os campos.';
                                break;
                            case 'email_existente':
                                $mensagem_erro = 'Este e-mail já está cadastrado. Tente fazer login.';
                                break;
                            default:
                                $mensagem_erro = 'Ocorreu um erro inesperado. Tente novamente.';
                                break;
                        }
                        echo '<div class="alert alert-danger">' . htmlspecialchars($mensagem_erro) . '</div>';
                    }
                ?>
                
                <form action="processa_cadastro.php" method="POST" class="main-form">
                    <div class="input-group">
                        <i class="bi bi-person"></i>
                        <input name="nome" type="text" placeholder="Nome Completo" required>
                    </div>
                    <div class="input-group">
                        <i class="bi bi-envelope"></i>
                        <input name="email" type="email" placeholder="E-mail" required>
                    </div>
                    <div class="input-group">
                        <i class="bi bi-telephone"></i>
                        <input name="telefone" type="tel" placeholder="Telefone / WhatsApp" required>
                    </div>
                    <div class="input-group">
                        <i class="bi bi-lock"></i>
                        <input name="senha" type="password" placeholder="Senha" required>
                    </div>
                    <button type="submit" class="btn-primary-action">CADASTRAR</button>
                </form>

                <div class="separator">
                    <span>ou</span>
                </div>
                <button type="button" class="btn-google">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google Logo">
                    Entrar com Google
                </button>
            </div>

        </div>
    </main>

</body>
</html>