<?php
// Inclui o guardião de acesso e a conexão com o banco
require_once 'validador_acesso.php';
require_once 'config.php';

// Garante que apenas administradores acessem
if ($_SESSION['perfil'] !== 'adm') {
    header('Location: index.php');
    exit();
}

// Pega o ID do usuário da URL
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header('Location: clientes.php');
    exit();
}

// Variáveis para mensagens e dados
$message = '';
$usuario = null;

// --- LÓGICA PARA ATUALIZAR (quando o formulário é enviado) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $tipo_usuario = $_POST['tipo_usuario']; // NOVO: Coleta o tipo de usuário
    $usuario_id = $_POST['id'];

    // Validação dos dados
    if ($tipo_usuario !== 'cliente' && $tipo_usuario !== 'adm') {
        $message = "O tipo de usuário selecionado é inválido.";
    } elseif (empty($nome) || empty($email)) {
        $message = "Nome e E-mail são obrigatórios.";
    } else {
        // ATUALIZADO: Query agora inclui a atualização do tipo_usuario
        $sql = "UPDATE Usuarios SET nome = ?, email = ?, telefone = ?, tipo_usuario = ? WHERE id = ?";
        
        if ($stmt = $conexao->prepare($sql)) {
            // ATUALIZADO: Adicionado 's' para o novo campo string (tipo_usuario)
            $stmt->bind_param("ssssi", $nome, $email, $telefone, $tipo_usuario, $usuario_id);
            
            if ($stmt->execute()) {
                // Redireciona para a lista de clientes com status de sucesso
                header('Location: clientes.php?status=editado');
                exit();
            } else {
                $message = "Erro ao atualizar o usuário.";
            }
            $stmt->close();
        }
    }
}

// --- LÓGICA PARA BUSCAR OS DADOS (quando a página é carregada) ---
// ATUALIZADO: Query agora busca também o tipo_usuario e não restringe a busca apenas para 'cliente'
$sql_select = "SELECT id, nome, email, telefone, tipo_usuario FROM Usuarios WHERE id = ?";
if ($stmt_select = $conexao->prepare($sql_select)) {
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    
    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();
    } else {
        // Se não encontrar o usuário, volta para a lista
        header('Location: clientes.php?status=nao_encontrado');
        exit();
    }
    $stmt_select->close();
}
$conexao->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário - Blackelis</title>
    <link rel="stylesheet" href="src/CSS/painel_dark.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="logo"><img src="src/image/LOGO - offwhite 1.png" alt="Blackelis Logo"></div>
        <nav>
            <ul>
                <li><a href="painel.php"><ion-icon name="grid"></ion-icon>Painel</a></li>
                <li><a href="servicos.php"><ion-icon name="cut"></ion-icon>Serviços</a></li>
                <li><a href="#"><ion-icon name="calendar-outline"></ion-icon>Agendamentos</a></li>
                <li class="active"><a href="clientes.php"><ion-icon name="people-outline"></ion-icon>Clientes</a></li>
                <li><a href="#"><ion-icon name="settings-outline"></ion-icon>Configurações</a></li>
            </ul>
        </nav>
        <a href="logout.php" class="logout-button">Sair <ion-icon name="log-out-outline"></ion-icon></a>
    </aside>
    <main class="main-content">
        <header class="main-header">
            <h1>Editar Usuário</h1>
        </header>

        <section class="form-section">
            <?php if (!empty($message)): ?>
                <div class="alert error"><?= htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <form action="editar_cliente.php?id=<?= $id; ?>" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']); ?>">
                
                <div class="form-group">
                    <label for="nome">Nome do Usuário</label>
                    <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome']); ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="telefone">Telefone / WhatsApp</label>
                        <input type="tel" id="telefone" name="telefone" value="<?= htmlspecialchars($usuario['telefone']); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="tipo_usuario">Cargo / Tipo de Usuário</label>
                    <select id="tipo_usuario" name="tipo_usuario" required>
                        <option value="cliente" <?= ($usuario['tipo_usuario'] === 'cliente') ? 'selected' : '' ?>>
                            Cliente
                        </option>
                        <option value="Administrador" <?= ($usuario['tipo_usuario'] === 'Administrador') ? 'selected' : '' ?>>
                            Administrador
                        </option>
                    </select>
                </div>
                <div class="form-actions">
                    <a href="clientes.php" class="btn-cancel">Cancelar</a>
                    <button type="submit" class="btn-save">Salvar Alterações</button>
                </div>
            </form>
        </section>
    </main>
</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>