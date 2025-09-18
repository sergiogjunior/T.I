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
$nome_servico = '';
$descricao = '';
$duracao_minutos = '';
$preco = '';

// Verifica se o formulário foi enviado (método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Coleta os dados do formulário
    $nome_servico = trim($_POST['nome_servico']);
    $descricao = trim($_POST['descricao']);
    $duracao_minutos = trim($_POST['duracao_minutos']);
    $preco = trim($_POST['preco']);

    // Validação dos dados
    if (empty($nome_servico) || empty($duracao_minutos) || empty($preco)) {
        $message = "Por favor, preencha todos os campos obrigatórios (Nome, Duração e Preço).";
    } elseif (!is_numeric($duracao_minutos) || !is_numeric(str_replace(',', '.', $preco))) {
        $message = "Duração e Preço devem ser valores numéricos.";
    } else {
        // Converte o preço para o formato do banco de dados (ex: 150,00 -> 150.00)
        $preco_db = str_replace(',', '.', $preco);

        // Prepara a query de inserção para evitar SQL Injection
        $sql_insert = "INSERT INTO Servicos (nome_servico, descricao, duracao_minutos, preco) VALUES (?, ?, ?, ?)";
        
        if ($stmt_insert = $conexao->prepare($sql_insert)) {
            // "ssdi" = string, string, double, integer (tipos dos parâmetros)
            $stmt_insert->bind_param("ssdi", $nome_servico, $descricao, $duracao_minutos, $preco_db);
            
            // Executa a query
            if ($stmt_insert->execute()) {
                // Redireciona para a lista de serviços com uma mensagem de sucesso
                header('Location: servicos.php?status=adicionado');
                exit();
            } else {
                $message = "Ops! Algo deu errado ao salvar no banco. Tente novamente.";
            }
            $stmt_insert->close();
        }
    }
    $conexao->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Serviço - Blackelis</title>
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
            <h1>Adicionar Novo Serviço</h1>
        </header>

        <section class="form-section">
            <?php if (!empty($message)): ?>
                <div class="alert error"><?= htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <form action="adicionar_servico.php" method="POST">
                <div class="form-group">
                    <label for="nome_servico">Nome do Serviço</label>
                    <input type="text" id="nome_servico" name="nome_servico" value="<?= htmlspecialchars($nome_servico); ?>" required>
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição (Opcional)</label>
                    <textarea id="descricao" name="descricao"><?= htmlspecialchars($descricao); ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="duracao_minutos">Duração (em minutos)</label>
                        <input type="number" id="duracao_minutos" name="duracao_minutos" value="<?= htmlspecialchars($duracao_minutos); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="preco">Preço (ex: 150,00)</label>
                        <input type="text" id="preco" name="preco" value="<?= htmlspecialchars($preco); ?>" required>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="servicos.php" class="btn-cancel">Cancelar</a>
                    <button type="submit" class="btn-save">Salvar Serviço</button>
                </div>
            </form>
        </section>
    </main>
</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>