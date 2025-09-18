<?php 
// 1. Inicia a sessão UMA ÚNICA VEZ e de forma segura
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Chama o validador de acesso
require_once 'validador_acesso.php';
include 'config.php'; // Inclui sua conexão com o banco

// 3. Pega o ID do serviço da URL
$servico_id_selecionado = isset($_GET['servico_id']) ? (int)$_GET['servico_id'] : 0;
$nome_servico_selecionado = "Serviço não encontrado";

// 4. Busca o nome do serviço no banco de dados
if ($servico_id_selecionado > 0) {
    $stmt = $conexao->prepare("SELECT nome_servico FROM Servicos WHERE id = ?");
    $stmt->bind_param("i", $servico_id_selecionado);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $servico = $result->fetch_assoc();
        $nome_servico_selecionado = $servico['nome_servico'];
    }
    $stmt->close();
}
// 5. A conexão só será fechada ao final do script, se necessário. Removido o close() daqui.
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento - <?= htmlspecialchars($nome_servico_selecionado) ?></title>
    
    <link rel="stylesheet" href="src/CSS/agendamento.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="src/FavIcon/ÍCONE-transp-1-_1_.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <div class="header-content">
            <a href="index.php"><img class="logo" src="src/image/LOGO%20-%20offwhite%201.png" alt="Logo Black Lelis"></a>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php">Início</a></li>
                    <li><a href="#">Serviços</a></li>
                    <li><a href="#">Parcerias</a></li>
                    <li><a href="#">Contato</a></li>
                </ul>
            </nav>
            <div class="header-right">
                <a href="#" class="btn-header-secondary">Sobre nós</a>
                <div class="user-profile">
                    <img src="src/image/Ellipse 7.png" alt="Foto do Usuário">
                    <span>Olá, <?= htmlspecialchars(explode(' ', $_SESSION['usuario_nome'])[0]) ?></span>
                </div>
                <a href="logout.php" class="btn-header-logout">Sair</a>
            </div>
        </div>
    </header>

    <main class="agendamento-main">
        <div class="agendamento-container">
            <div class="servico-header">
                <div class="profissionais-icones" id="profissionais-icones"></div>
                <h1><?= htmlspecialchars($nome_servico_selecionado) ?></h1>
                <div class="placeholder-div"></div>
            </div>

            <div class="agendamento-body">
                <aside class="profissional-card">
                    <img src="" alt="Foto do Profissional" class="profissional-foto" id="profissional-foto">
                    <div class="profissional-info">
                        <h2 id="profissional-nome"></h2>
                        <p id="profissional-especialidade"></p>
                    </div>
                </aside>

                <form class="agendamento-form" id="form-agendamento">
                    <div class="form-group-validacao">
                        <label>Seu cabelo passou por processos químicos recentemente?</label>
                        <div class="radio-group">
                            <input type="radio" id="quimica-sim" name="validacao_quimica" value="sim">
                            <label for="quimica-sim">Sim</label>
                            <input type="radio" id="quimica-nao" name="validacao_quimica" value="nao">
                            <label for="quimica-nao">Não</label>
                        </div>
                    </div>
                    <div id="mensagem-validacao" class="mensagem-validacao-erro" style="display: none;">
                        Seus cabelos não estão fortes o bastante para fazer o procedimento das tranças, volte daqui a 1 mês.
                    </div>
                    <div id="conteudo-agendamento" class="hidden">
                        <div class="form-layout">
                            <div class="form-col-calendario">
                                <div class="calendario-container" id="calendario"></div>
                            </div>
                            <div class="form-col-inputs">
                                <div class="form-group">
                                    <label for="quimica_tipo">Se fez, qual tipo?</label>
                                    <input type="text" id="quimica_tipo" name="quimica_tipo" placeholder="Ex: Descoloração, progressiva...">
                                </div>
                                <div class="form-group">
                                    <label for="horario">Horário</label>
                                    <select id="horario" name="horario" required>
                                        <option value="">Selecione uma data</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn-agendar">AGENDAR</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="data-selecionada" name="data_selecionada">
                    <input type="hidden" id="id-profissional" name="id_profissional" value="">
                    <input type="hidden" id="id-servico" name="id_servico" value="<?= $servico_id_selecionado ?>">
                </form>
            </div>
        </div>
    </main>
    
    <footer class="main-footer">
        <p>&copy; <?= date('Y') ?> Black Lélis. Todos os direitos reservados.</p>
    </footer>

    <script src="src/JS/agendamento.js"></script>
</body>
</html>