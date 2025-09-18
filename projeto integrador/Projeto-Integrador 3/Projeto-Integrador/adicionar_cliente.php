<?php
// Inclui o guardião de acesso e a conexão com o banco
require_once 'validador_acesso.php';
require_once 'config.php';

// Garante que apenas administradores acessem
if ($_SESSION['perfil'] !== 'adm') {
    header('Location: index.php');
    exit();
}

// --- LÓGICA PARA PROCESSAR O FORMULÁRIO ---

// Variáveis para mensagens e para repopular o formulário em caso de erro
$message = '';
$nome = '';
$email = '';
$telefone = '';

// Verifica se o formulário foi enviado (método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Coleta os dados do formulário
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $senha = $_POST['senha'];
    $tipo_usuario = 'cliente'; // Perfil é sempre 'cliente' aqui

    // Validação dos dados
    if (empty($nome) || empty($email) || empty($senha)) {
        $message = "Por favor, preencha todos os campos obrigatórios (Nome, E-mail e Senha).";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "O formato do e-mail é inválido.";
    } else {
        // Verifica se o e-mail já existe no banco
        $sql_check = "SELECT id FROM Usuarios WHERE email = ?";
        $stmt_check = $conexao->prepare($sql_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $message = "Este e-mail já está em uso por outro usuário.";
        } else {
            // Se o e-mail não existe, prossegue com a inserção
            $senha_hash = password_hash($senha, PASSWORD_BCRYPT);

            $sql_insert = "INSERT INTO Usuarios (nome, email, telefone, senha, tipo_usuario) VALUES (?, ?, ?, ?, ?)";
            
            if ($stmt_insert = $conexao->prepare($sql_insert)) {
                $stmt_insert->bind_param("sssss", $nome, $email, $telefone, $senha_hash, $tipo_usuario);
                
                if ($stmt_insert->execute()) {
                    header('Location: clientes.php?status=adicionado');
                    exit();
                } else {
                    $message = "Ops! Algo deu errado ao salvar no banco. Tente novamente.";
                }
                $stmt_insert->close();
            }
        }
        $stmt_check->close();
    }
    $conexao->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Cliente - Blackelis</title>
    <link rel="stylesheet" href="src/CSS/painel_dark.css">
</head>
<body>

<div class="dashboard">
    <aside class="sidebar">
        <div class="logo">
            <img src="src/image/LOGO - offwhite 1.png" alt="Blackelis Logo">
        </div>
        <nav>
            <ul>
                <li><a href="painel.php"><ion-icon name="grid"></ion-icon>Painel</a></li>
                <li><a href="servicos.php"><ion-icon name="cut"></ion-icon>Serviços</a></li>
                <li><a href="agendamentos.php"><ion-icon name="calendar-outline"></ion-icon>Agendamentos</a></li>
                <li class="active"><a href="clientes.php"><ion-icon name="people-outline"></ion-icon>Clientes</a></li>
                <li><a href="#"><ion-icon name="settings-outline"></ion-icon>Configurações</a></li>
            </ul>
        </nav>
        <a href="logout.php" class="logout-button">Sair <ion-icon name="log-out-outline"></ion-icon></a>
    </aside>

    <main class="main-content">
        <header class="main-header">
            <h1>Adicionar Novo Cliente</h1>
        </header>

        <section class="form-section">
            <?php if (!empty($message)): ?>
                <div class="alert error"><?= htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <form action="adicionar_cliente.php" method="POST">
                <div class="form-group">
                    <label for="nome">Nome do Cliente</label>
                    <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($nome); ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="telefone">Telefone / WhatsApp</label>
                        <input type="tel" id="telefone" name="telefone" value="<?= htmlspecialchars($telefone); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" required>
                </div>

                <div class="form-actions">
                    <a href="clientes.php" class="btn-cancel">Cancelar</a>
                    <button type="submit" class="btn-save">Salvar Cliente</button>
                </div>
            </form>
        </section>
    </main>
</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>