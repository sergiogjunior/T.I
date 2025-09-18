<?php
// Inclui o guardião de acesso e a conexão com o banco
require_once 'validador_acesso.php';
require_once 'config.php';

// Garante que apenas administradores acessem
if ($_SESSION['perfil'] !== 'adm') {
    header('Location: index.php');
    exit();
}

// --- LÓGICA DE PROCESSAMENTO DO FORMULÁRIO (ADICIONAR, EDITAR, EXCLUIR) ---
$message = '';
$message_type = ''; // 'success' ou 'error'

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $profissional_id = $_POST['profissional_id'] ?? null;

    try {
        if ($action === 'add' && $profissional_id) {
            $dia_semana = $_POST['dia_semana'];
            $hora_inicio = $_POST['hora_inicio'];
            $hora_fim = $_POST['hora_fim'];
            $stmt = $conexao->prepare("INSERT INTO HorariosTrabalho (profissional_id, dia_semana, hora_inicio, hora_fim) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiss", $profissional_id, $dia_semana, $hora_inicio, $hora_fim);
            $stmt->execute();
            $message = "Novo turno de trabalho adicionado com sucesso!";
            $message_type = 'success';
        }

        if ($action === 'delete') {
            $horario_id = $_POST['horario_id'];
            $stmt = $conexao->prepare("DELETE FROM HorariosTrabalho WHERE id = ?");
            $stmt->bind_param("i", $horario_id);
            $stmt->execute();
            $message = "Turno de trabalho excluído com sucesso!";
            $message_type = 'success';
        }
    } catch (Exception $e) {
        $message = "Ocorreu um erro: " . $e->getMessage();
        $message_type = 'error';
    }

    // Redireciona para a mesma página para evitar reenvio do formulário, mantendo o profissional selecionado
    header('Location: configuracoes.php?profissional_id=' . $profissional_id . '&status=' . $message_type);
    exit();
}

// Mensagem de status vinda do redirecionamento
if (isset($_GET['status']) && $_GET['status'] === 'success') {
    $message = "Operação realizada com sucesso!";
    $message_type = 'success';
}

// --- LÓGICA PARA BUSCAR DADOS ---

// 1. Buscar todos os profissionais para o dropdown
$sql_profissionais = "SELECT u.id, u.nome FROM Usuarios u JOIN Profissionais p ON u.id = p.id WHERE u.tipo_usuario = 'adm' ORDER BY u.nome";
$result_profissionais = $conexao->query($sql_profissionais);
$profissionais = $result_profissionais->fetch_all(MYSQLI_ASSOC);

// 2. Pegar o ID do profissional selecionado (se houver)
$profissional_selecionado_id = $_GET['profissional_id'] ?? null;
$horarios_trabalho = [];
$nome_profissional_selecionado = '';

// 3. Se um profissional foi selecionado, buscar seus horários
if ($profissional_selecionado_id) {
    // Busca o nome
    foreach ($profissionais as $p) {
        if ($p['id'] == $profissional_selecionado_id) {
            $nome_profissional_selecionado = $p['nome'];
            break;
        }
    }

    // Busca os horários
    $stmt_horarios = $conexao->prepare("SELECT * FROM HorariosTrabalho WHERE profissional_id = ? ORDER BY dia_semana, hora_inicio");
    $stmt_horarios->bind_param("i", $profissional_selecionado_id);
    $stmt_horarios->execute();
    $result_horarios = $stmt_horarios->get_result();
    $horarios_trabalho = $result_horarios->fetch_all(MYSQLI_ASSOC);
}

// Mapeamento dos dias da semana para exibição
$dias_semana_map = [
    1 => 'Segunda-feira', 2 => 'Terça-feira', 3 => 'Quarta-feira',
    4 => 'Quinta-feira', 5 => 'Sexta-feira', 6 => 'Sábado', 7 => 'Domingo'
];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações - Horários - Blackelis</title>
    <link rel="stylesheet" href="src/CSS/painel_dark.css">
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="logo"><img src="src/image/LOGO - offwhite 1.png" alt="Blackelis Logo"></div>
        <nav>
            <ul>
                <li><a href="./src/PHP/painel.php"><ion-icon name="grid"></ion-icon>Painel</a></li>
                <li><a href="servicos.php"><ion-icon name="cut"></ion-icon>Serviços</a></li>
                <li><a href="painel_agendamentos.php"><ion-icon name="calendar-outline"></ion-icon>Agendamentos</a></li>
                <li><a href="clientes.php"><ion-icon name="people-outline"></ion-icon>Clientes</a></li>
                <li class="active"><a href="configuracoes.php"><ion-icon name="settings-outline"></ion-icon>Configurações</a></li>
            </ul>
        </nav>
        <a href="logout.php" class="logout-button">Sair <ion-icon name="log-out-outline"></ion-icon></a>
    </aside>

    <main class="main-content">
        <header class="main-header">
            <h1>Configurações de Horário</h1>
        </header>

        <?php if ($message): ?>
            <div class="alert <?= $message_type === 'success' ? 'success' : 'error' ?>"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="settings-container">
            <form method="GET" action="configuracoes.php" class="professional-selector-form">
                <div class="form-group">
                    <label for="profissional_id">Selecione o Profissional para Gerenciar:</label>
                    <select name="profissional_id" id="profissional_id" onchange="this.form.submit()">
                        <option value="">-- Selecione --</option>
                        <?php foreach ($profissionais as $profissional): ?>
                            <option value="<?= $profissional['id'] ?>" <?= ($profissional['id'] == $profissional_selecionado_id) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($profissional['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>

            <?php if ($profissional_selecionado_id): ?>
                <hr>
                <h2 class="professional-name-header">Agenda de <?= htmlspecialchars($nome_profissional_selecionado) ?></h2>

                <div class="horarios-list">
                    <h3>Turnos Atuais</h3>
                    <?php if (!empty($horarios_trabalho)): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Dia da Semana</th>
                                    <th>Início</th>
                                    <th>Fim</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($horarios_trabalho as $horario): ?>
                                    <tr>
                                        <td><?= $dias_semana_map[$horario['dia_semana']] ?></td>
                                        <td><?= date('H:i', strtotime($horario['hora_inicio'])) ?></td>
                                        <td><?= date('H:i', strtotime($horario['hora_fim'])) ?></td>
                                        <td>
                                            <form action="configuracoes.php" method="POST" style="display:inline;">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="horario_id" value="<?= $horario['id'] ?>">
                                                <input type="hidden" name="profissional_id" value="<?= $profissional_selecionado_id ?>">
                                                <button type="submit" class="btn-delete" onclick="return confirm('Tem certeza que deseja excluir este turno?');">Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Nenhum turno de trabalho cadastrado para este profissional.</p>
                    <?php endif; ?>
                </div>

                <div class="add-horario-form">
                    <h3>Adicionar Novo Turno</h3>
                    <form action="configuracoes.php" method="POST">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="profissional_id" value="<?= $profissional_selecionado_id ?>">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="dia_semana">Dia da Semana</label>
                                <select name="dia_semana" id="dia_semana" required>
                                    <?php foreach ($dias_semana_map as $num => $nome): ?>
                                        <option value="<?= $num ?>"><?= $nome ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="hora_inicio">Hora de Início</label>
                                <input type="time" name="hora_inicio" id="hora_inicio" required>
                            </div>
                            <div class="form-group">
                                <label for="hora_fim">Hora de Fim</label>
                                <input type="time" name="hora_fim" id="hora_fim" required>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn-save">Adicionar Turno</button>
                        </div>
                    </form>
                </div>

            <?php endif; ?>
        </div>
    </main>
</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>