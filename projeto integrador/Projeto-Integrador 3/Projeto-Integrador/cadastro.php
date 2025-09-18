<?php
// ===================================================================
// INÍCIO DA LÓGICA PHP PARA PROCESSAMENTO DO CADASTRO
// ===================================================================
 
// 1. Inclui o arquivo de configuração do banco de dados
// Certifique-se que este arquivo existe e o caminho está correto.
require_once "config.php";
 
// Variáveis para armazenar mensagens e dados do formulário
$message = '';
$message_class = ''; // Será 'success' ou 'error'
$nome = '';
$email = '';
$telefone = ''; // Adicionando a variável para o telefone
 
// 2. Verifica se o formulário foi enviado (método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Coleta e limpa os dados do formulário
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $senha = $_POST['senha'];
 
    // Define o tipo de usuário padrão para quem se cadastra
    $tipo_usuario = 'cliente';
 
    // 3. Validação dos dados
    if (empty($nome) || empty($email) || empty($senha) || empty($telefone)) {
        $message = "Por favor, preencha todos os campos.";
        $message_class = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "O formato do e-mail é inválido.";
        $message_class = "error";
    } else {
        // 4. Verifica se o e-mail já existe no banco
        $sql_check_email = "SELECT id FROM usuarios WHERE email = ?";
 
        if ($stmt_check = $conexao->prepare($sql_check_email)) {
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();
            $stmt_check->store_result();
 
            if ($stmt_check->num_rows > 0) {
                $message = "Este e-mail já está cadastrado. Tente fazer login.";
                $message_class = "error";
            } else {
                // 5. O e-mail não existe, prosseguir com o cadastro
 
                // ** SEGURANÇA: Criptografa a senha com o método mais seguro **
                $senha_hash = password_hash($senha, PASSWORD_BCRYPT);
 
                // 6. Prepara a query de inserção para evitar SQL Injection
                $sql_insert = "INSERT INTO usuarios (nome, email, telefone, senha, tipo_usuario) VALUES (?, ?, ?, ?, ?)";
 
                if ($stmt_insert = $conexao->prepare($sql_insert)) {
                    // Associa os parâmetros com as variáveis
                    $stmt_insert->bind_param("sssss", $nome, $email, $telefone, $senha_hash, $tipo_usuario);
 
                    // Executa a query
                    if ($stmt_insert->execute()) {
                        $message = "Cadastro realizado com sucesso! Bem-vindo(a)!";
                        $message_class = "success";
                        // Limpa os campos após o sucesso para um novo cadastro
                        $nome = '';
                        $email = '';
                        $telefone = '';
                    } else {
                        $message = "Ops! Algo deu errado. Tente novamente mais tarde.";
                        $message_class = "error";
                    }
                    // Fecha o statement de inserção
                    $stmt_insert->close();
                }
            }
            // Fecha o statement de verificação
            $stmt_check->close();
        }
    }
    // 7. Fecha a conexão com o banco de dados
    $conexao->close();
}
 
// ===================================================================
// FIM DA LÓGICA PHP - INÍCIO DO HTML
// ===================================================================
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Blackelis</title>
    <link rel="stylesheet" href="src/CSS/cadastro.css">
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
 
                <?php if (!empty($message)): ?>
                    <div class="alert <?php echo ($message_class == 'success') ? 'alert-success' : 'alert-danger'; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
               
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="main-form" novalidate>
                   
                    <div class="input-group">
                        <i class="bi bi-person"></i>
                        <input name="nome" type="text" placeholder="Nome Completo" value="<?php echo htmlspecialchars($nome); ?>" required>
                    </div>
 
                    <div class="input-group">
                        <i class="bi bi-envelope"></i>
                        <input name="email" type="email" placeholder="E-mail" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
 
                    <div class="input-group">
                        <i class="bi bi-telephone"></i>
                        <input name="telefone" type="tel" placeholder="Telefone / WhatsApp" value="<?php echo htmlspecialchars($telefone); ?>" required>
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