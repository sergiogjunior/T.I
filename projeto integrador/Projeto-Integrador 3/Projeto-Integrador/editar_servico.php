<?php
// Inclui o guardião de acesso e a conexão com o banco
require_once 'validador_acesso.php';
require_once 'config.php';

// Garante que apenas administradores acessem
if ($_SESSION['perfil'] !== 'adm') {
    header('Location: index.php');
    exit();
}

// Pega o ID do serviço da URL
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header('Location: servicos.php');
    exit();
}

// Variáveis para mensagens e dados
$message = '';
$servico = null;

// LÓGICA PARA ATUALIZAR (quando o formulário é enviado)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_servico = trim($_POST['nome_servico']);
    $descricao = trim($_POST['descricao']);
    $duracao_minutos = trim($_POST['duracao_minutos']);
    $preco = trim($_POST['preco']);
    $servico_id = $_POST['id'];

    if (empty($nome_servico) || empty($duracao_minutos) || empty($preco)) {
        $message = "Nome, Duração e Preço são obrigatórios.";
    } else {
        $preco_db = str_replace(',', '.', $preco);
        $sql = "UPDATE Servicos SET nome_servico = ?, descricao = ?, duracao_minutos = ?, preco = ? WHERE id = ?";
        if ($stmt = $conexao->prepare($sql)) {
            $stmt->bind_param("ssidi", $nome_servico, $descricao, $duracao_minutos, $preco_db, $servico_id);
            if ($stmt->execute()) {
                header('Location: servicos.php?status=editado');
                exit();
            } else {
                $message = "Erro ao atualizar o serviço.";
            }
            $stmt->close();
        }
    }
}

// LÓGICA PARA BUSCAR OS DADOS (quando a página é carregada)
$sql_select = "SELECT id, nome_servico, descricao, duracao_minutos, preco FROM Servicos WHERE id = ?";
if ($stmt_select = $conexao->prepare($sql_select)) {
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    if ($result->num_rows === 1) {
        $servico = $result->fetch_assoc();
    } else {
        header('Location: servicos.php?status=nao_encontrado');
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
    <title>Editar Serviço - Blackelis</title>
    <link rel="stylesheet" href="src/CSS/painel_dark.css">
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="logo"><img src="src/image/LOGO - offwhite 1.png" alt="Blackelis Logo"></div>
        <nav>
            <ul>
                <li><a href="painel.php"><ion-icon name="grid"></ion-icon>Painel</a></li>
                <li class="active"><a href="servicos.php"><ion-icon name="cut"></ion-icon>Serviços</a></li>
                <li><a href="agendamentos.php"><ion-icon name="calendar-outline"></ion-icon>Agendamentos</a></li>
                <li><a href="clientes.php"><ion-icon name="people-outline"></ion-icon>Clientes</a></li>
                <li><a href="#"><ion-icon name="settings-outline"></ion-icon>Configurações</a></li>
            </ul>
        </nav>
        <a href="logout.php" class="logout-button">Sair <ion-icon name="log-out-outline"></ion-icon></a>
    </aside>
    <main class="main-content">
        <header class="main-header">
            <h1>Editar Serviço</h1>
        </header>

        <section class="form-section">
            <?php if (!empty($message)): ?>
                <div class="alert error"><?= htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <form action="editar_servico.php?id=<?= $id; ?>" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($servico['id']); ?>">
                
                <div class="form-group">
                    <label for="nome_servico">Nome do Serviço</label>
                    <input type="text" id="nome_servico" name="nome_servico" value="<?= htmlspecialchars($servico['nome_servico']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição (Opcional)</label>
                    <textarea id="descricao" name="descricao"><?= htmlspecialchars($servico['descricao']); ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="duracao_minutos">Duração (em minutos)</label>
                        <input type="number" id="duracao_minutos" name="duracao_minutos" value="<?= htmlspecialchars($servico['duracao_minutos']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="preco">Preço (ex: 150.00)</label>
                        <input type="text" id="preco" name="preco" value="<?= number_format($servico['preco'], 2, ',', '.'); ?>" required>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="servicos.php" class="btn-cancel">Cancelar</a>
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