<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>

    <link rel="stylesheet" href="src/CSS/login.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <div class="main-container">

        <div class="form-container">
            
            <div class="form-header">
                <h2>Login</h2>
            </div>

            <form class="login-form">
                <div class="input-group">
                    <i class="bi bi-person-fill"></i>
                    <input type="text" placeholder="Nome" required>
                </div>

                <div class="input-group">
                    <i class="bi bi-envelope-fill"></i>
                    <input type="email" placeholder="Email" required>
                </div>

                <button type="submit" class="btn-login">ENTRAR</button>
            </form>

            <div class="separator">
                <span>ou</span>
            </div>

            <button type="button" class="btn-google">
                <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google Logo">
                Entrar com Google
            </button>

        </div>

        <div class="welcome-container">
            <h3>Olá</h3>
            <h1>Seja Bem-Vindo</h1>
            <a href="cadastro.php" class="btn-register">CADASTRAR-SE</a>
        </div>

    </div>

</body>
</html>